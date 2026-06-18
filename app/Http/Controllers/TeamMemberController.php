<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBusinessDevelopmentRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TeamMemberController extends Controller
{
    public function create(): View
    {
        $this->authorize('create', auth()->user());

        return view('dashboard.team.create');
    }

    public function store(CreateBusinessDevelopmentRequest $request, AuthService $authService): RedirectResponse
    {
        $companyAdmin = auth()->user();
        $this->authorize('create', $companyAdmin);

        $authService->createBusinessDevelopment($companyAdmin, $request->validated());

        return redirect()->route('dashboard')->with('status', 'Business development account created.');
    }
}
