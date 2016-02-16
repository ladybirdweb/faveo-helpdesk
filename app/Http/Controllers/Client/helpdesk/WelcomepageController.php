<?php

namespace App\Http\Controllers\Client\helpdesk;

// controllers
use App\Http\Controllers\Controller;
// models
use App\Model\helpdesk\Settings\System;
// classes
use Config;
use Redirect;
use Exception;

/**
 * OuthouseController
 *
 * @package     Controllers
 * @subpackage  Controller
 * @author      Ladybird <info@ladybirdweb.com>
 */
class WelcomepageController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function get(System $note) {
        if (Config::get('database.install') == '%0%') {
            return Redirect::route('licence');
        }
        $notes = $note->get();
        foreach ($notes as $note) {
            $content = $note->content;
        }
        return view('themes.default1.client.guest-user.guest', compact('heading', 'content'));
    }

    public function index() {
        if (Config::get('database.install') == '%0%') {
            return Redirect::route('licence');
        }
        return view('themes.default1.client.helpdesk.guest-user.index');
    }

}
