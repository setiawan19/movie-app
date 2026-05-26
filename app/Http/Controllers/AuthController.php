<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller {
    public function showLogin(): View {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse {
        $credentials = $request->only(['username', 'password']);

        // Autentikasi statis sesuai kriteria test
        if ($credentials['username'] === 'aldmic' && $credentials['password'] === '123abc123') {
            Session::put('user_logged', true);
            return redirect('/');
        }

        return back()->withErrors([__('messages.login_failed')]);
    }

    public function logout(): RedirectResponse {
        // Menggunakan flush() untuk membersihkan semua data session (termasuk status login & history pencarian)
        Session::flush();
        return redirect('login');
    }
}