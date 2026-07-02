<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DashboardRoleBasedTest extends TestCase
{
    use RefreshDatabase;

    public function test_mes_dashboard_shows_intake_focused_summary(): void
    {
        $role = Role::create(['name' => 'MES Officer']);
        $permission = Permission::create(['name' => 'assets.view']);
        $role->givePermissionTo($permission);

        $user = User::factory()->create();
        $user->assignRole($role);

        Asset::create([
            'asset_code' => 'ASSET-001',
            'type' => 'log',
            'species' => 'Narra',
            'description' => 'Sample log',
            'municipality_of_origin' => 'Virac',
            'location_apprehended' => 'Barangay 1',
            'apprehending_agency' => 'DENR',
            'mode' => 'apprehended',
            'has_ongoing_case' => false,
            'has_confiscation_order' => false,
            'current_status' => 'intake_recorded',
            'qr_code_token' => 'token-1',
            'created_by' => $user->id,
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk();
        $response->assertSee('MES Intake Queue');
        $response->assertSee('Assets awaiting intake and custody follow-up');
    }
}
