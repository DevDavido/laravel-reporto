<?php

namespace DevDavido\Reporto\Middleware;

use Closure;
use Illuminate\Http\Request;

class ReportoEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (!config('reporto.enabled')) {
            abort(404);
        }

        return $next($request);

    }
}
