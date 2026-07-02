<?php

namespace Tests\Unit;

use App\Enums\AssetStatus;
use App\Enums\AssetType;
use App\Models\Asset;
use App\Services\AssetLifecycleService;
use Tests\TestCase;

class AssetLifecycleServiceTest extends TestCase
{
    public function test_pending_custody_review_shows_property_review_guidance(): void
    {
        $asset = new Asset([
            'asset_code' => 'ASSET-100',
            'type' => AssetType::Log->value,
            'current_status' => AssetStatus::PendingCustodyReview,
            'has_ongoing_case' => false,
            'has_confiscation_order' => false,
        ]);

        $service = $this->app->make(AssetLifecycleService::class);
        $guide = $service->workflowGuide($asset);

        $this->assertSame('Property Custody Review', $guide['title']);
        $this->assertStringContainsString('reviewed and signed', $guide['summary']);
        $this->assertStringContainsString('Sign the acknowledgement receipt', $guide['nextAction']);
    }
}
