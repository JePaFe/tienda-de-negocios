<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth('api')->user()->is_admin) {
            return response()->json(['error' => 'No tienes permisos para crear productos'], 403);
        }

        return $next($request);
    }
}
