<?php

namespace App\Http\Controllers\Admin\helpdesk;

// controller
use App\Http\Controllers\Controller;
// request
use App\Http\Requests\helpdesk\BanlistRequest;
use App\Http\Requests\helpdesk\BanRequest;
// model
use App\Model\helpdesk\Email\Banlist;
use App\User;
//classes
use Exception;

/**
 * BanlistController
 * In this controller in the CRUD function for all the banned emails.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class BanlistController extends Controller
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
        // checking admin roles
        $this->middleware('roles');
    }

    /**
     * Display a listing of the resource.
     *
     * @param type Banlist $ban
     *
     * @return type Response
     */
    public function index()
    {
        try {
            $bans = User::where('ban', '=', 1)->get();

            return view('themes.default1.admin.helpdesk.emails.banlist.index', compact('bans'));
        } catch (Exception $e) {
            return view('404');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return type Response
     */
    public function create()
    {
        try {
            return view('themes.default1.admin.helpdesk.emails.banlist.create');
        } catch (Exception $e) {
            return view('404');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param type banlist    $ban
     * @param type BanRequest $request
     * @param type User       $user
     *
     * @return type Response
     */
    public function store(BanRequest $request, User $user)
    {
        // dd($request);
        try {
            //adding field to user whether it is banned or not
            $adban = $request->input('email');
            $use = $user->where('email', $adban)->first();
            if ($use != null) {
                $use->ban = $request->input('ban');
                $use->internal_note = $request->input('internal_note');
                $use->save();
                // $user->create($request->input())->save();
                return redirect('banlist')->with('success', 'Email Banned sucessfully');
            } else {
                $user = new User();
                $user->email = $adban;
                $user->ban = $request->input('ban');
                $user->internal_note = $request->input('internal_note');
                $user->save();

                return redirect('banlist')->with('success', 'Email Banned sucessfully');
            }
        } catch (Exception $e) {
            return redirect('banlist')->with('fails', 'Email can not Ban');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param type int     $id
     * @param type Banlist $ban
     *
     * @return type Response
     */
    public function edit($id, User $ban)
    {
        try {
            $bans = $ban->whereId($id)->first();

            return view('themes.default1.admin.helpdesk.emails.banlist.edit', compact('bans'));
        } catch (Exception $e) {
            return view('404');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param type int            $id
     * @param type Banlist        $ban
     * @param type BanlistRequest $request
     *
     * @return type Response
     */
    public function update($id, User $ban, BanlistRequest $request)
    {
        try {
            $bans = $ban->whereId($id)->first();
            $bans->internal_note = $request->input('internal_note');
            $bans->ban = $request->input('ban');
            // dd($request->input('ban'));
            if ($bans->save()) {
                return redirect('banlist')->with('success', 'Banned Email Updated sucessfully');
            } else {
                return redirect('banlist')->with('fails', 'Banned Email not Updated');
            }
        } catch (Exception $e) {
            return redirect('banlist')->with('fails', 'Banned Email not Updated');
        }
    }

    /*
     * Remove the specified resource from storage.
     * @param type int $id
     * @param type Banlist $ban
     * @return type Response
     */
    // public function destroy($id, Banlist $ban) {
    // 		$bans = $ban->whereId($id)->first();
    // 		dd($bans);
    // 		/* Success and Falure condition */
    // 		try{
    // 			$bans->delete();
    // 			return redirect('banlist')->with('success', 'Banned Email Deleted sucessfully');
    // 		} catch (Exception $e) {
    // 			return redirect('banlist')->with('fails', 'Banned Email can not Delete'.'<li>'.$e->errorInfo[2].'</li>');
    // 		}
    // }
}
