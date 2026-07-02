<?php

namespace App\Http\Controllers;

use App\Enums\AssetStatus;
use App\Enums\AssetType;
use App\Models\Asset;
use App\Models\AuditLog;
use App\Services\PdfDocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response as HttpResponse;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request): Response
    {
        $this->authorize('viewAny', Asset::class);

        return Inertia::render('Reports/Index', [
            'summary' => [
                'total' => Asset::count(),
                'inStorage' => Asset::where('current_status', AssetStatus::Stored)->count(),
                'forDisposal' => Asset::where('current_status', AssetStatus::ForDisposal)->count(),
                'underTrial' => Asset::where('current_status', AssetStatus::UnderTrial)->count(),
            ],
        ]);
    }

    public function inventory(Request $request): StreamedResponse
    {
        $this->authorize('viewAny', Asset::class);

        $assets = Asset::with(['creator', 'acknowledgementReceipt'])->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="inventory-'.now()->format('Y-m-d').'.csv"',
        ];

        return HttpResponse::stream(function () use ($assets) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Asset Code', 'Type', 'Species', 'Municipality', 'Status', 'Mode', 'Created At',
            ]);

            foreach ($assets as $asset) {
                fputcsv($handle, [
                    $asset->asset_code,
                    $asset->type->label(),
                    $asset->species,
                    $asset->municipality_of_origin,
                    $asset->current_status->label(),
                    $asset->mode->label(),
                    $asset->created_at->toDateTimeString(),
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    public function compliance(PdfDocumentService $pdfService): \Illuminate\Http\Response
    {
        $this->authorize('viewAny', Asset::class);

        $data = [
            'generatedAt' => now(),
            'byMunicipality' => Asset::query()
                ->selectRaw('municipality_of_origin, count(*) as count')
                ->groupBy('municipality_of_origin')
                ->orderBy('municipality_of_origin')
                ->get(),
            'byType' => Asset::query()
                ->selectRaw('type, count(*) as count')
                ->groupBy('type')
                ->get()
                ->map(fn ($row) => [
                    'type' => AssetType::from($row->type)->label(),
                    'count' => $row->count,
                ]),
            'byStatus' => Asset::query()
                ->selectRaw('current_status, count(*) as count')
                ->groupBy('current_status')
                ->get()
                ->map(fn ($row) => [
                    'status' => AssetStatus::from($row->current_status)->label(),
                    'count' => $row->count,
                ]),
        ];

        $path = $pdfService->generateComplianceReport($data);
        $content = \Illuminate\Support\Facades\Storage::disk('local')->get($path);

        return response($content, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="compliance-report-'.now()->format('Y-m-d').'.pdf"',
        ]);
    }

    public function auditLogs(Request $request): Response
    {
        $this->authorize('viewAny', AuditLog::class);

        $logs = AuditLog::query()
            ->with('user')
            ->latest('created_at')
            ->paginate(25);

        return Inertia::render('Reports/AuditLogs', [
            'logs' => $logs,
        ]);
    }
}
