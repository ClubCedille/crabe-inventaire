<?php

namespace App\Http\Middleware;
use Closure;
class localization

{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $langs = $request->server('HTTP_ACCEPT_LANGUAGE');

        // Uses french when user has it
        if (str_contains($langs, 'fr')) {
            app()->setLocale('fr');
        } else { // Defaults to english
            app()->setLocale('en');
        }

        return $next($request);
    }
}
