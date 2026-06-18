<?php

namespace Database\Seeders;

use App\Models\PipelineStage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CompanySeeder;
use Database\Seeders\DealSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call(CompanySeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(PipelineStageSeeder::class);
        $this->call(DealSeeder::class);
    }
}
