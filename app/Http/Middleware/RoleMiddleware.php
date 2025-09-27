<?php

namespace App\Http\Middleware;

use App\Http\Helpers\ResponseFormatter as HelpersResponseFormatter;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    use HelpersResponseFormatter;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! Auth::check()) {
            return $this->errorResponse('Unauthorized', ['error' => 'Kamu belum melakukan login'], 401);
        }

        if (! in_array(Auth::user()->role, $roles)) {
            return $this->errorResponse('Unauthorized', ['error' => 'Kamu tidak memiliki akses route ini'], 403);
        }

        return $next($request);
    }
}
