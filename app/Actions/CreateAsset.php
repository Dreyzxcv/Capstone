<?php

namespace App\Actions;

use App\Enums\AssetMode;
use App\Enums\AssetStatus;
use App\Enums\AssetType;
use App\Models\AcknowledgementReceipt;
use App\Models\Asset;
use App\Models\User;
use App\Services\AssetLifecycleService;
use App\Services\AuditLogService;
use App\Services\PdfDocumentService;
use App\Services\QrCodeService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateAsset
{
    public function __construct(
        protected QrCodeService $qrCodeService,
        protected PdfDocumentService $pdfDocumentService,
        protected AssetLifecycleService $lifecycleService,
        protected AuditLogService $auditLogService,
    ) {}

    public function execute(array $data, User $user): Asset
    {
        return DB::transaction(function () use ($data, $user) {
            $mode = AssetMode::from($data['mode']);
            $hasConfiscationOrder = $mode === AssetMode::Abandoned
                || ($data['has_confiscation_order'] ?? false);

            $asset = Asset::create([
                'asset_code' => (string) Str::uuid(),
                'type' => AssetType::from($data['type']),
                'species' => $data['species'] ?? null,
                'description' => $data['description'] ?? null,
                'municipality_of_origin' => $data['municipality_of_origin'],
                'location_apprehended' => $data['location_apprehended'],
                'apprehending_agency' => $data['apprehending_agency'],
                'mode' => $mode,
                'has_ongoing_case' => $data['has_ongoing_case'] ?? false,
                'has_confiscation_order' => $hasConfiscationOrder,
                'current_status' => AssetStatus::IntakeRecorded,
                'qr_code_token' => $this->qrCodeService->generateToken(),
                'metadata' => $data['metadata'] ?? null,
                'created_by' => $user->id,
            ]);

            $receiptNumber = 'AR-'.now()->format('Y').'-'.str_pad((string) $asset->id, 5, '0', STR_PAD_LEFT);

            $receipt = AcknowledgementReceipt::create([
                'asset_id' => $asset->id,
                'receipt_number' => $receiptNumber,
            ]);

            $this->pdfDocumentService->generateAcknowledgementReceipt($asset, $receipt);

            $this->lifecycleService->transition(
                $asset->fresh(),
                AssetStatus::PendingCustodyReview,
                $user,
                'Intake encoded by MES.',
                'asset.created',
            );

            $this->auditLogService->log('asset.intake_created', $asset, null, $asset->toArray(), $user->id);

            return $asset->fresh(['acknowledgementReceipt', 'creator']);
        });
    }
}
