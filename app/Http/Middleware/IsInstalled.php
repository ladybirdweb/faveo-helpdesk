<?php

namespace App\Http\Middleware;

use Closure;

class IsInstalled
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
        if (!isInstall()) {
            return $next($request);
        } else {
            if ($request->isJson()) {
                $url = url('/');
                $result = ['fails' => 'already installed', 'api' => $url];

                return response()->json(compact('result'));
            } else {
                return redirect('/');
            }
        }
    }
}
