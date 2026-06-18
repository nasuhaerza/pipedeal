<?php

namespace App\Http\Controllers;

use App\Http\Requests\DealRequest;
use App\Models\Client;
use App\Models\Deal;
use App\Models\PipelineStage;
use App\Services\ActivityLogService;
use App\Services\DealService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DealWebController extends Controller
{
    public function index(): View
    {
        $deals = Deal::with(['client', 'stage'])->get();

        return view('dashboard.deals.index', compact('deals'));
    }

    public function create(): View
    {
        $clients = Client::orderBy('name')->get();
        $stages = PipelineStage::orderBy('order_number')->get();
        $clientId = request()->query('client_id');

        return view('dashboard.deals.create', compact('clients', 'stages', 'clientId'));
    }

    public function store(DealRequest $request, DealService $dealService, ActivityLogService $activityLogService): RedirectResponse
    {
        $deal = Deal::create($request->validated());

        try {
            $dealService->finalizeDeal($deal);
        } catch (\Throwable $exception) {
            return redirect()->back()->withInput()->withErrors(['deal' => $exception->getMessage()]);
        }

        $activityLogService->record($deal, 'created', "Deal {$deal->title} created", auth()->user());

        return redirect()->route('dashboard.deals.index')->with('status', 'Deal saved.');
    }

    public function show(Deal $deal): View
    {
        $this->authorize('view', $deal);

        $deal->load(['client', 'stage', 'commissionShares', 'followUps', 'documents']);

        return view('dashboard.deals.show', compact('deal'));
    }

    public function edit(Deal $deal): View
    {
        $this->authorize('view', $deal);

        $clients = Client::orderBy('name')->get();
        $stages = PipelineStage::orderBy('order_number')->get();

        return view('dashboard.deals.edit', compact('deal', 'clients', 'stages'));
    }

    public function update(DealRequest $request, Deal $deal, DealService $dealService, ActivityLogService $activityLogService): RedirectResponse
    {
        $this->authorize('update', $deal);

        $deal->update($request->validated());

        try {
            $dealService->finalizeDeal($deal);
        } catch (\Throwable $exception) {
            return redirect()->back()->withInput()->withErrors(['deal' => $exception->getMessage()]);
        }

        $activityLogService->record($deal, 'updated', "Deal {$deal->title} updated", auth()->user());

        return redirect()->route('dashboard.deals.index')->with('status', 'Deal updated.');
    }

    public function destroy(Deal $deal): RedirectResponse
    {
        $this->authorize('delete', $deal);

        $deal->delete();

        return redirect()->route('dashboard.deals.index')->with('status', 'Deal removed.');
    }
}
