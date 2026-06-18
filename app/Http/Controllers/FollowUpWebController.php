<?php

namespace App\Http\Controllers;

use App\Http\Requests\FollowUpRequest;
use App\Models\Deal;
use App\Models\FollowUp;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FollowUpWebController extends Controller
{
    public function index(): View
    {
        $followUps = FollowUp::with('deal')->get();

        return view('dashboard.follow-ups.index', compact('followUps'));
    }

    public function create(): View
    {
        $deals = Deal::with('client')->orderBy('deal_name')->get();
        $dealId = request()->query('deal_id');

        return view('dashboard.follow-ups.create', compact('deals', 'dealId'));
    }

    public function store(FollowUpRequest $request, ActivityLogService $activityLogService): RedirectResponse
    {
        $followUp = FollowUp::create($request->validated());
        $activityLogService->record($followUp, 'created', "Follow-up scheduled for deal {$followUp->deal->title}", auth()->user());

        return redirect()->route('dashboard.follow-ups.index')->with('status', 'Follow-up created.');
    }

    public function show(FollowUp $followUp): View
    {
        $this->authorize('view', $followUp);

        $followUp->load('deal.client');

        return view('dashboard.follow-ups.show', compact('followUp'));
    }

    public function edit(FollowUp $followUp): View
    {
        $this->authorize('view', $followUp);

        $deals = Deal::with('client')->orderBy('deal_name')->get();

        return view('dashboard.follow-ups.edit', compact('followUp', 'deals'));
    }

    public function update(FollowUpRequest $request, FollowUp $followUp, ActivityLogService $activityLogService): RedirectResponse
    {
        $this->authorize('update', $followUp);

        $followUp->update($request->validated());
        $activityLogService->record($followUp, 'updated', "Follow-up updated for deal {$followUp->deal->title}", auth()->user());

        return redirect()->route('dashboard.follow-ups.index')->with('status', 'Follow-up updated.');
    }

    public function destroy(FollowUp $followUp): RedirectResponse
    {
        $this->authorize('delete', $followUp);

        $followUp->delete();

        return redirect()->route('dashboard.follow-ups.index')->with('status', 'Follow-up removed.');
    }
}
