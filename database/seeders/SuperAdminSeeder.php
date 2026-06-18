<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $company = Company::firstOrCreate(
            ['company_name' => 'PipeDeal Platform'],
            ['email' => 'platform@pipedeal.local', 'phone' => '0000000000', 'address' => 'PipeDeal HQ']
        );

        User::updateOrCreate(
            ['email' => 'superadmin@pipedeal.local'],
            [
                'company_id' => $company->id,
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => UserRole::SUPER_ADMIN,
            ]
        );
    }
}
