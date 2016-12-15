<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

class AlwaysExpectsJson
{
    public function handle(Request $request, \Closure $next)
    {
        $request->headers->add(['accept' => 'application/json']);

        return $next($request);
    }
}
