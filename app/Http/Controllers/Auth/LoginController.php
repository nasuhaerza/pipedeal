<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\RedirectService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request, RedirectService $redirectService): JsonResponse|RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $remember = (bool) $request->input('remember');

        if (! Auth::attempt($credentials, $remember)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Invalid credentials.'], 401);
            }

            return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Authenticated.']);
        }

        return redirect($redirectService->pathFor($user));
    }

    public function logout(): JsonResponse|RedirectResponse
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Logged out.']);
        }

        return redirect()->route('login');
    }
}
