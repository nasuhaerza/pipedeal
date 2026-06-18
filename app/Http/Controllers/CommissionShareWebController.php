<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommissionShareRequest;
use App\Models\CommissionShare;
use App\Models\Deal;
use App\Services\ActivityLogService;
use App\Services\DealService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CommissionShareWebController extends Controller
{
    public function index(): View
    {
        $shares = CommissionShare::with('deal')->get();

        return view('dashboard.commission-shares.index', compact('shares'));
    }

    public function create(): View
    {
        $deals = Deal::with('client')->orderBy('deal_name')->get();

        return view('dashboard.commission-shares.create', compact('deals'));
    }

    public function store(CommissionShareRequest $request, DealService $dealService, ActivityLogService $activityLogService): RedirectResponse
    {
        $share = CommissionShare::create($request->validated());

        try {
            $dealService->finalizeDeal($share->deal);
        } catch (\Throwable $exception) {
            return redirect()->back()->withInput()->withErrors(['commission_share' => $exception->getMessage()]);
        }

        $activityLogService->record($share, 'created', "Commission share for deal {$share->deal->title} created", auth()->user());

        return redirect()->route('dashboard.commission-shares.index')->with('status', 'Commission share saved.');
    }

    public function edit(CommissionShare $commissionShare): View
    {
        $this->authorize('view', $commissionShare);

        $deals = Deal::with('client')->orderBy('deal_name')->get();

        return view('dashboard.commission-shares.edit', compact('commissionShare', 'deals'));
    }

    public function update(CommissionShareRequest $request, CommissionShare $commissionShare, DealService $dealService, ActivityLogService $activityLogService): RedirectResponse
    {
        $this->authorize('update', $commissionShare);

        $commissionShare->update($request->validated());

        try {
            $dealService->finalizeDeal($commissionShare->deal);
        } catch (\Throwable $exception) {
            return redirect()->back()->withInput()->withErrors(['commission_share' => $exception->getMessage()]);
        }

        $activityLogService->record($commissionShare, 'updated', "Commission share updated", auth()->user());

        return redirect()->route('dashboard.commission-shares.index')->with('status', 'Commission share updated.');
    }

    public function destroy(CommissionShare $commissionShare): RedirectResponse
    {
        $this->authorize('delete', $commissionShare);

        $commissionShare->delete();

        return redirect()->route('dashboard.commission-shares.index')->with('status', 'Commission share removed.');
    }
}
