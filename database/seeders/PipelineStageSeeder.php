<?php

namespace Database\Seeders;

use App\Models\PipelineStage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PipelineStageSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        foreach (PipelineStage::STAGES as $orderNumber => $stageName) {
            PipelineStage::firstOrCreate([
                'stage_name' => $stageName,
            ], [
                'order_number' => $orderNumber + 1,
            ]);
        }
    }
}
