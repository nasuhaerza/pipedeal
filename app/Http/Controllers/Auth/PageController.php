<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\CommissionShare;
use App\Models\Deal;
use App\Models\Document;
use App\Models\FollowUp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function login(Request $request): View
    {
        return view('auth.login');
    }

    public function dashboard(): View
    {
        $data = [
            'clients' => Client::count(),
            'deals' => Deal::count(),
            'closedDeals' => Deal::whereHas('stage', fn ($query) => $query->where('name', 'Closed'))->count(),
            'commissionShares' => CommissionShare::count(),
            'documents' => Document::count(),
            'followUps' => FollowUp::count(),
            'latestFollowUps' => FollowUp::with(['deal.client'])->orderBy('followup_date', 'desc')->limit(5)->get(),
            'latestDocuments' => Document::with(['deal.client'])->orderBy('created_at', 'desc')->limit(5)->get(),
        ];

        return view('dashboard', $data);
    }
}
