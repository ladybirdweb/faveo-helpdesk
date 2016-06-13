<?php

namespace App\Http\Controllers\Error;

// controllers
use App\Http\Controllers\Controller;

/**
 * ErrorController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class ErrorController extends Controller
{
    /**
     * Display a Error Page of 404.
     *
     * @return Response
     */
    public function error404()
    {
        return view('errors.404');
    }
}
