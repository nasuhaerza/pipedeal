<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Deal;
use App\Models\PipelineStage;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DealSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $client = Client::first();
        if (! $client) {
            return;
        }

        $company = $client->company;
        $stage = PipelineStage::orderBy('order_number')->first();
        $creator = User::where('company_id', $company->id)->first();

        if (! $company || ! $stage || ! $creator) {
            return;
        }

        Deal::firstOrCreate([
            'company_id' => $company->id,
            'client_id' => $client->id,
            'stage_id' => $stage->id,
            'deal_name' => 'Enterprise Onboarding',
        ], [
            'created_by' => $creator->id,
            'deal_value' => 75000.00,
            'expected_close_date' => now()->addDays(30),
            'notes' => 'Initial onboarding deal for enterprise customer.',
        ]);

        Deal::firstOrCreate([
            'company_id' => $company->id,
            'client_id' => $client->id,
            'stage_id' => PipelineStage::where('stage_name', 'Qualification')->first()?->id ?? $stage->id,
            'deal_name' => 'Retail Expansion',
        ], [
            'created_by' => $creator->id,
            'deal_value' => 42000.00,
            'expected_close_date' => now()->addDays(45),
            'notes' => 'Retail expansion opportunity with repeat purchase potential.',
        ]);
    }
}
