<?php

namespace App\Http\Middleware;

use App\Model\helpdesk\Settings\System;
use Closure;

/**
 * CheckBoard.
 * Checking if the system board is online or offline.
 *
 * @author   Ladybird <info@ladybirdweb.com>
 */
class CheckBoard
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return type Mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->checkBoard() == '1') {
            return $next($request);
        } else {
            return redirect()->route('board.offline')->with('offline', 'the system seems to be offline please try later');
        }
    }

    /**
     * Function to get the system offline details.
     *
     * @return type Mixed
     */
    public function checkBoard()
    {
        $res = 0;
        $system = new System();
        if ($system->first()) {
            $res = $system->first()->status;
        }

        return $res;
    }
}
