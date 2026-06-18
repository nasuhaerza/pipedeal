<?php

namespace Tests\Unit;

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\Deal;
use App\Models\Client;
use App\Models\PipelineStage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantScopeTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_user_only_sees_own_company_records(): void
    {
        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();
        $clientA = Client::factory()->for($companyA)->create();
        $clientB = Client::factory()->for($companyB)->create();
        $userA = User::factory()->for($companyA)->create();

        $stageA = PipelineStage::create([
            'stage_name' => 'Qualification',
            'order_number' => 1,
        ]);

        $stageB = PipelineStage::create([
            'stage_name' => 'Proposal',
            'order_number' => 2,
        ]);

        $dealA = Deal::create([
            'company_id' => $companyA->id,
            'client_id' => $clientA->id,
            'created_by' => $userA->id,
            'stage_id' => $stageA->id,
            'deal_name' => 'Deal A',
            'deal_value' => 1000.00,
            'expected_close_date' => now()->addDays(7),
            'notes' => 'Company A deal',
        ]);

        $dealB = Deal::create([
            'company_id' => $companyB->id,
            'client_id' => $clientB->id,
            'created_by' => $userA->id,
            'stage_id' => $stageB->id,
            'deal_name' => 'Deal B',
            'deal_value' => 1200.00,
            'expected_close_date' => now()->addDays(10),
            'notes' => 'Company B deal',
        ]);

        $this->actingAs($userA);

        $deals = Deal::all();

        $this->assertCount(1, $deals);
        $this->assertTrue($deals->first()->is($dealA));
        $this->assertFalse($deals->contains('id', $dealB->id));
    }

    public function test_super_admin_can_see_all_company_data(): void
    {
        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();
        $clientA = Client::factory()->for($companyA)->create();
        $clientB = Client::factory()->for($companyB)->create();
        $companyAUser = User::factory()->for($companyA)->create();
        $companyBUser = User::factory()->for($companyB)->create();
        $superAdmin = User::factory()->for($companyA)->create([
            'role' => UserRole::SUPER_ADMIN,
        ]);

        $stageA = PipelineStage::create([
            'stage_name' => 'Qualification',
            'order_number' => 1,
        ]);

        $stageB = PipelineStage::create([
            'stage_name' => 'Proposal',
            'order_number' => 2,
        ]);

        Deal::create([
            'company_id' => $companyA->id,
            'client_id' => $clientA->id,
            'created_by' => $companyAUser->id,
            'stage_id' => $stageA->id,
            'deal_name' => 'Deal A',
            'deal_value' => 2000.00,
            'expected_close_date' => now()->addDays(5),
            'notes' => 'Company A deal',
        ]);

        Deal::create([
            'company_id' => $companyB->id,
            'client_id' => $clientB->id,
            'created_by' => $companyBUser->id,
            'stage_id' => $stageB->id,
            'deal_name' => 'Deal B',
            'deal_value' => 3000.00,
            'expected_close_date' => now()->addDays(12),
            'notes' => 'Company B deal',
        ]);

        $this->actingAs($superAdmin);

        $this->assertCount(2, Deal::all());
        $this->assertCount(3, User::all());
    }
}
