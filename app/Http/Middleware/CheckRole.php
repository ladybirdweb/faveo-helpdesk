<?php

namespace App\Http\Middleware;

use Closure;

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

        return redirect('guest')->with('fails', 'You are not Authorised');
    }
}
