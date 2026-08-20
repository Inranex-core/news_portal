<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', 'bn'); // Default to Bengali 'bn'

        if (in_array($locale, ['bn', 'en'])) {
            App::setLocale($locale);
        } else {
            App::setLocale('bn');
        }

        return $next($request);
    }
}
