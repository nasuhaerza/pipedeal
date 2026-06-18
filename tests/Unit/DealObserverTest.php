<?php

namespace Tests\Unit;

use App\Models\CommissionShare;
use App\Models\Company;
use App\Models\Deal;
use App\Models\PipelineStage;
use App\Models\User;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DealObserverTest extends TestCase
{
    use RefreshDatabase;

    public function test_commission_amount_is_calculated_when_deal_stage_changes_to_closed(): void
    {
        $company = Company::factory()->create();
        $client = Client::factory()->for($company)->create();
        $user = User::factory()->for($company)->create();

        $initialStage = PipelineStage::create([
            'stage_name' => 'Qualification',
            'order_number' => 2,
        ]);
        $closedStage = PipelineStage::create([
            'stage_name' => 'Closed',
            'order_number' => 99,
        ]);

        $deal = Deal::create([
            'company_id' => $company->id,
            'client_id' => $client->id,
            'created_by' => $user->id,
            'stage_id' => $initialStage->id,
            'deal_name' => 'Opportunity A',
            'deal_value' => 1000.00,
            'expected_close_date' => now()->addDays(30),
            'notes' => 'Test deal',
        ]);

        $share = CommissionShare::create([
            'company_id' => $company->id,
            'deal_id' => $deal->id,
            'user_id' => $user->id,
            'recipient_name' => 'Jane Doe',
            'commission_percent' => 15.00,
            'commission_amount' => 0,
        ]);

        $this->assertEquals(0.0, (float) $share->fresh()->commission_amount);

        $deal->stage_id = $closedStage->id;
        $deal->save();

        $this->assertEquals(150.00, (float) $share->fresh()->commission_amount);
    }

    public function test_commission_amount_is_calculated_when_share_is_created_for_closed_deal(): void
    {
        $company = Company::factory()->create();
        $client = Client::factory()->for($company)->create();
        $user = User::factory()->for($company)->create();

        $closedStage = PipelineStage::create([
            'stage_name' => 'Closed',
            'order_number' => 99,
        ]);

        $deal = Deal::create([
            'company_id' => $company->id,
            'client_id' => $client->id,
            'created_by' => $user->id,
            'stage_id' => $closedStage->id,
            'deal_name' => 'Opportunity B',
            'deal_value' => 2000.00,
            'expected_close_date' => now()->addDays(10),
            'notes' => 'Closed deal',
        ]);

        $share = CommissionShare::create([
            'company_id' => $company->id,
            'deal_id' => $deal->id,
            'user_id' => $user->id,
            'recipient_name' => 'John Doe',
            'commission_percent' => 10.00,
            'commission_amount' => 0,
        ]);

        $this->assertEquals(200.00, (float) $share->fresh()->commission_amount);
    }
}
