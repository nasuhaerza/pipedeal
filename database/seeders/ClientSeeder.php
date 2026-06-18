<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $company = Company::first();

        if (! $company) {
            return;
        }

        Client::firstOrCreate([
            'company_id' => $company->id,
            'client_name' => 'Acme Corporation',
        ], [
            'industry' => 'Technology',
            'contact_person' => 'Siti Rahma',
            'email' => 'contact@acme.local',
            'phone' => '+621234567891',
            'address' => 'Jl. Kemajuan No. 12, Jakarta',
        ]);

        Client::firstOrCreate([
            'company_id' => $company->id,
            'client_name' => 'Nusantara Retail',
        ], [
            'industry' => 'Retail',
            'contact_person' => 'Budi Santoso',
            'email' => 'info@nusantararetail.local',
            'phone' => '+621234567892',
            'address' => 'Jl. Niaga No. 8, Bandung',
        ]);
    }
}
