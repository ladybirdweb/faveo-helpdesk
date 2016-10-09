<?php

namespace App\FaveoLog\controllers;

use App\FaveoLog\LaravelLogViewer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class LogViewerController extends Controller
{
    public function index()
    {
        if (Request::input('l')) {
            //dd(base64_decode(Request::input('l')));
            LaravelLogViewer::setFile(base64_decode(Request::input('l')));
        }

        if (Request::input('dl')) {
            return Response::download(LaravelLogViewer::pathToLogFile(base64_decode(Request::input('dl'))));
        } elseif (Request::has('del')) {
            File::delete(LaravelLogViewer::pathToLogFile(base64_decode(Request::input('del'))));

            return Redirect::to(Request::url());
        }

        $logs = LaravelLogViewer::all();

        return View::make('log::log', [
            'logs'         => $logs,
            'files'        => LaravelLogViewer::getFiles(true),
            'current_file' => LaravelLogViewer::getFileName(),
        ]);
    }
}
