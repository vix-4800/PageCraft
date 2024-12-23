<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Exceptions\ApiForbiddenException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsUserAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        throw_if(! $request->user()->isAdmin(), ApiForbiddenException::class);

        return $next($request);
    }
}
