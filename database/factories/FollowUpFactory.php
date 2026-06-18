<?php

namespace Database\Factories;

use App\Models\Deal;
use App\Models\FollowUp;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FollowUp>
 */
class FollowUpFactory extends Factory
{
    protected $model = FollowUp::class;

    public function definition(): array
    {
        $deal = Deal::factory()->create();

        return [
            'company_id' => $deal->company_id,
            'deal_id' => $deal->id,
            'followup_date' => $this->faker->dateTimeBetween('now', '+14 days'),
            'notes' => $this->faker->optional()->paragraph(),
            'status' => $this->faker->randomElement(['pending', 'done']),
        ];
    }

    public function pending(): static
    {
        return $this->state([
            'status' => 'pending',
        ]);
    }

    public function done(): static
    {
        return $this->state([
            'status' => 'done',
        ]);
    }
}
