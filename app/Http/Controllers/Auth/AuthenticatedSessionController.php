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
    /**
     * Display the login view.
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'fournisseur') {
            return redirect()->route('fournisseur.dashboard');
        }

        if ($user->role === 'consignataire') {
            return redirect()->route('consignataire.dashboard');
        }

        if ($user->role === 'client') {
            return redirect()->route('client.dashboard');
        }

    }


    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */

    public function store(LoginRequest $request): RedirectResponse
    {
    $request->authenticate();
    $request->session()->regenerate();

    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    if ($user->role === 'fournisseur') {
        return redirect()->route('fournisseur.dashboard');
    }
     if ($user->role === 'consignataire') {
        return redirect()->route('consignataire.dashboard');
    }
    // Ajoute d'autres rôles si besoin

    return redirect()->route('client.dashboard');
}

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
