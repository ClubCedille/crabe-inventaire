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
        app()->setLocale(str_contains($langs, 'fr') ? 'fr' : 'en');

        return $next($request);
    }
}
