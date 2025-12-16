<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    $request->session()->regenerate();

    // 1. Redirection Admin
    if (Auth::user()->role === 'admin') {
        // Redirection ke Admin Dashboard
        return redirect()->intended(route('admin.dashboard')); 
    }

    // 2. Redirection Mahasiswa (User Biasa)
    // GANTI: return redirect()->intended(RouteServiceProvider::HOME); 
    // MENJADI: return redirect()->intended('/kuisioner');
    return redirect()->intended('/kuisioner'); 
}
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
  
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
