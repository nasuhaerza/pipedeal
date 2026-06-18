<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\PipelineStage;
use App\Services\PipelineService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PipelineController extends Controller
{
    public function index(): View
    {
        $stages = PipelineStage::orderBy('order_number')->limit(6)->get();
        $deals = Deal::with(['client', 'stage'])->orderBy('updated_at', 'desc')->get();
        $dealsByStage = $deals->groupBy('stage_id');

        return view('dashboard.pipeline.index', compact('stages', 'dealsByStage'));
    }

    public function updateStage(Request $request, Deal $deal, PipelineService $pipelineService): JsonResponse
    {
        $this->authorize('update', $deal);

        $request->validate([
            'stage_id' => ['required', 'exists:pipeline_stages,id'],
        ]);

        $stage = PipelineStage::findOrFail($request->input('stage_id'));

        $pipelineService->moveDealToStage($deal, $stage, auth()->user());

        return response()->json([
            'message' => 'Deal stage updated successfully.',
            'stage_id' => $stage->id,
            'stage_name' => $stage->stage_name,
        ]);
    }
}
