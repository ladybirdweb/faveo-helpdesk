<?php namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Model\Settings\System;

class OuthouseController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function get(System $note) {
		$notes = $note->get();
		foreach ($notes as $note) {
			$content = $note->content;
		}
		return view('themes.default1.client.guest-user.guest', compact('heading', 'content'));
	}

}
