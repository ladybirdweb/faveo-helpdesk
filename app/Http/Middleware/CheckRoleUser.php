<?php

namespace App\Http\Middleware;

use Closure;

/**
 * CheckRoleUser.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class CheckRoleUser
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
        if ($request->user()->role == 'user') {
            return $next($request);
        }

        return redirect('guest')->with('fails', 'You are not Authorised');
    }
}
