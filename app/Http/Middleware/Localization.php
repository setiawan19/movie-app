<?php namespace App\Http\Middleware;

use Closure;
use App;

class Localization {
    public function handle($request, Closure $next) {
        if ($request->session()->has('locale')) {
            App::setLocale($request->session()->get('locale'));
        } else {
            App::setLocale('en'); // Default EN
        }
        return $next($request);
    }
}