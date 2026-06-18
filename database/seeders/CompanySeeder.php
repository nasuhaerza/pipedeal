<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $company = Company::firstOrCreate([
            'company_name' => 'PipeDeal Sample Company',
        ], [
            'email' => 'sample@pipedeal.local',
            'phone' => '+621234567890',
            'address' => 'Jl. Contoh No. 1, Jakarta',
        ]);

        User::factory()->firstOrCreate([
            'company_id' => $company->id,
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin User',
            'role' => UserRole::COMPANY_ADMIN,
        ]);
    }
}
