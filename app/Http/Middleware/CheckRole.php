<?php

namespace App\Http\Middleware;

use Closure;
use Lang;

/**
 * CheckRole.
 *
 * @author   Ladybird <info@ladybirdweb.com>
 */
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->role == 'admin') {
            return $next($request);
        }

        return redirect('guest')->with('fails', Lang::get('lang.not-autherised'));
    }
}
