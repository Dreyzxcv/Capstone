<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentController extends Controller
{
    public function download(Request $request, string $path): StreamedResponse
    {
        abort_unless($request->user(), 403);

        $decodedPath = base64_decode($path, true);
        abort_unless($decodedPath && str_starts_with($decodedPath, 'documents/'), 404);

        abort_unless(Storage::disk('local')->exists($decodedPath), 404);

        return Storage::disk('local')->download($decodedPath);
    }
}
