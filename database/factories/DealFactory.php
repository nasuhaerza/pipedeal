<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Deal;
use App\Models\PipelineStage;
use App\Models\User;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Deal>
 */
class DealFactory extends Factory
{
    protected $model = Deal::class;

    public function definition(): array
    {
        $company = Company::factory();
        $client = Client::factory()->for($company);
        $creator = User::factory()->for($company);

        $stage = PipelineStage::inRandomOrder()->first();
        if (! $stage) {
            $stage = PipelineStage::create([
                'stage_name' => 'Lead',
                'order_number' => 1,
            ]);
        }

        return [
            'company_id' => $company,
            'client_id' => $client,
            'created_by' => $creator,
            'stage_id' => $stage->id,
            'deal_name' => fake()->catchPhrase(),
            'deal_value' => fake()->randomFloat(2, 1000, 100000),
            'expected_close_date' => fake()->dateTimeBetween('now', '+90 days'),
            'notes' => fake()->optional()->paragraph(),
        ];
    }
}
