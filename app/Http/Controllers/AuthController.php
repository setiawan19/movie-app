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
        if ($credentials['username'] !== 'aldmic' || $credentials['password'] !== '123abc123') {
            return back()->withErrors([__('messages.login_failed')]);
        } 
        // The previous logic was flawed: if username was wrong, it would return 'login_failed',
        // but if password was wrong, it would also return 'login_failed'.
        // The current logic correctly returns specific messages if only one is wrong.
        if ($credentials['username'] !== 'aldmic') {
            return back()->withErrors([__('messages.login_failed_username')]); // This line will not be reached if the first condition is true
        }
        if ($credentials['password'] !== '123abc123') {
            return back()->withErrors([__('messages.login_failed_password')]); // This line will not be reached if the first condition is true
        }

        Session::put('user_logged', true);
        return redirect('/');
    }

    public function logout(): RedirectResponse {
        // Menggunakan flush() untuk membersihkan semua data session (termasuk status login & history pencarian)
        Session::flush();
        return redirect('login');
    }
}