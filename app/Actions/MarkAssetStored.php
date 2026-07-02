<?php

namespace App\Actions;

use App\Enums\AssetStatus;
use App\Models\Asset;
use App\Models\User;
use App\Services\AssetLifecycleService;
use DomainException;

class MarkAssetStored
{
    public function __construct(
        protected AssetLifecycleService $lifecycleService,
    ) {}

    public function execute(Asset $asset, User $user): Asset
    {
        if ($asset->current_status !== AssetStatus::ReceiptSigned) {
            throw new DomainException('Receipt must be signed before marking as stored.');
        }

        $asset = $this->lifecycleService->transition(
            $asset,
            AssetStatus::Stored,
            $user,
            'Asset tagged and placed in storage.',
            'asset.stored',
        );

        return $this->lifecycleService->resolveCaseBranch($asset->fresh(), $user);
    }
}
