<?php

namespace App\Http\Controllers\Agent\helpdesk;

// controllers
use App\Http\Controllers\Controller;
// requests
use App\Http\Requests\helpdesk\CannedRequest;
use App\Http\Requests\helpdesk\CannedUpdateRequest;
// model
use App\Model\helpdesk\Agent_panel\Canned;
use App\User;
// classes
use Exception;
use Lang;

/**
 * CannedController.
 *
 * This controller is for all the functionalities of Canned response for Agents in the Agent Panel
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class CannedController extends Controller
{
    /**
     * Create a new controller instance.
     * constructor to check
     * 1. authentication
     * 2. user roles
     * 3. roles must be agent.
     *
     * @return void
     */
    public function __construct()
    {
        // checking authentication
        $this->middleware('auth');
        // checking if role is agent
        $this->middleware('role.agent');
    }

    /**
     * Display a listing of the Canned Responses.
     *
     * @return type View
     */
    public function index()
    {
        try {
            return view('themes.default1.agent.helpdesk.canned.index');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * Show the form for creating a new Canned Response.
     *
     * @return type View
     */
    public function create()
    {
        try {
            return view('themes.default1.agent.helpdesk.canned.create');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * Store a newly created Canned Response.
     *
     * @param type CannedRequest $request
     * @param type Canned        $canned
     *
     * @return type Redirect
     */
    public function store(CannedRequest $request, Canned $canned)
    {
        try {
            // fetching all the requested inputs
            $canned->user_id = \Auth::user()->id;
            $canned->title = $request->input('title');
            $canned->message = $request->input('message');
            // saving inputs
            $canned->save();

            return redirect()->route('canned.list')->with('success', Lang::get('lang.added_successfully'));
        } catch (Exception $e) {
            return redirect()->route('canned.list')->with('fails', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the Canned Response.
     *
     * @param type $id
     * @param type Canned $canned
     *
     * @return type View
     */
    public function edit($id, Canned $canned)
    {
        try {
            // fetching requested canned response
            $canned = $canned->where('user_id', '=', \Auth::user()->id)->where('id', '=', $id)->first();

            return view('themes.default1.agent.helpdesk.canned.edit', compact('canned'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * Update the Canned Response in database.
     *
     * @param type $id
     * @param type CannedUpdateRequest $request
     * @param type Canned              $canned
     *
     * @return type Redirect
     */
    public function update($id, CannedUpdateRequest $request, Canned $canned)
    {
        try {
            /* select the field where id = $id(request Id) */
            $canned = $canned->where('id', '=', $id)->where('user_id', '=', \Auth::user()->id)->first();
            // fetching all the requested inputs
            $canned->user_id = \Auth::user()->id;
            $canned->title = $request->input('title');
            $canned->message = $request->input('message');
            // saving inputs
            $canned->save();

            return redirect()->route('canned.list')->with('success', Lang::get('lang.updated_successfully'));
        } catch (Exception $e) {
            return redirect()->route('canned.list')->with('fails', $e->getMessage());
        }
    }

    /**
     * Delete the Canned Response from storage.
     *
     * @param type $id
     * @param type Canned $canned
     *
     * @return type Redirect
     */
    public function destroy($id, Canned $canned)
    {
        try {
            /* select the field where id = $id(request Id) */
            $canned = $canned->whereId($id)->first();
            /* delete the selected field */
            /* Check whether function success or not */
            $canned->delete();
            /* redirect to Index page with Success Message */
            return redirect()->route('canned.list')->with('success', Lang::get('lang.canned_response_deleted'));
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect()->route('canned.list')->with('fails', $e->getMessage());
        }
    }

    /**
     * Fetch Canned Response in the ticket detail page.
     *
     * @param type $id
     *
     * @return type json
     */
    public function get_canned($id)
    {
        // checking for the canned response with requested value
        if ($id != 'zzz') {
            // fetching canned response
            $canned = Canned::where('id', '=', $id)->where('user_id', '=', \Auth::user()->id)->first();
            $msg = $canned->message;
        } else {
            $msg = '';
        }
        // returning the canned response in JSON format
        return \Response::json($msg);
    }
}
