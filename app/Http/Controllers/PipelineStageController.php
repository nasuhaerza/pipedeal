<?php

namespace App\Http\Controllers;

use App\Models\PipelineStage;
use Illuminate\Http\JsonResponse;

class PipelineStageController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(PipelineStage::orderBy('order_number')->get());
    }

    public function show(PipelineStage $pipelineStage): JsonResponse
    {
        return response()->json($pipelineStage);
    }
}
