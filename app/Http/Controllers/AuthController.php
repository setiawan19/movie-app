<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller {
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->only(['username', 'password']);

        // Autentikasi statis sesuai kriteria test
        if ($credentials['username'] === 'aldmic' && $credentials['password'] === '123abc123') {
            $request->session()->put('user_logged', true);
            return redirect('/');
        }

        return redirect()->back()->withErrors([trans('messages.login_failed')]);
    }

    public function logout(Request $request) {
        $request->session()->forget('user_logged');
        return redirect('login');
    }
}