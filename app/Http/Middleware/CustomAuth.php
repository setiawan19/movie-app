<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CustomAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('user_logged')) {
            return redirect()->route('login')->withErrors([__('messages.login_required')]);
        }

        return $next($request);
    }
}