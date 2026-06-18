<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterCompanyRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(RegisterCompanyRequest $request, AuthService $authService): RedirectResponse
    {
        $user = $authService->registerCompany($request->company(), $request->userData());

        // Log the new company admin in and redirect to company dashboard
        Auth::login($user);

        return redirect('/company/dashboard');
    }
}
