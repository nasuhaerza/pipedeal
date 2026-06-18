<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'client_name' => fake()->company(),
            'industry' => fake()->randomElement(['Technology', 'Finance', 'Healthcare', 'Retail', 'Manufacturing']),
            'contact_person' => fake()->name(),
            'email' => fake()->companyEmail(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
        ];
    }
}
