<?php namespace App\Http\Middleware;

use Closure;

class CustomAuth {
    public function handle($request, Closure $next) {
        if (!$request->session()->has('user_logged')) {
            return redirect('login')->withErrors([trans('messages.login_required')]);
        }
        return $next($request);
    }
}