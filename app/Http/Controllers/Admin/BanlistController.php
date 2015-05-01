<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\BanRequest;
use App\Http\Controllers\Controller;
/* include banlist Request for update function validation */
use App\Http\Requests\BanlistRequest;
use Illuminate\Http\Request;

use App\Model\Email\Banlist;

use App\User;

class BanlistController extends Controller {

	/*  constructor for authentication  */

	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('roles');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Banlist $ban)
	{
		try
		{
			$bans = $ban->get();
			return view('themes.default1.admin.emails.banlist.index',compact('bans'));
		}
		catch(Exception $e)
		{
			return view('404');
		}

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		try
		{
			return view('themes.default1.admin.emails.banlist.create');
		}
		catch(Exception $e)
		{
			return view('404');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(banlist $ban, BanRequest $request, User $user)
	{
		try
		{
			//adding field to user whether it is banned or not
			$adban = $request->input('email_address');
			$use = $user->where('email',$adban)->first();
			 // dd($use);
			if($use!==null)
			{
				$use->ban = 1;
				$use->save();
				$ban->create($request->input())->save();
				return redirect('banlist')->with('success','Email Banned sucessfully');
			}
			else
			{
				$ban->create($request->input())->save();
				return redirect('banlist')->with('success','Email Banned sucessfully');
			}
			// $use = $user->where('email',$adban)->first();
			// $use->ban = 1;
			// $use->save();
			
			

			// if($ban->create($request->input())->save()==true)
			// {
			// 	return redirect('banlist')->with('success','Email Banned sucessfully');
			// }
			// else
			// {
			// 	return redirect('banlist')->with('fails','Email can not Ban');
			// }
		}
		catch(Exception $e)
		{
			return redirect('banlist')->with('fails','Email can not Ban');
		}
		
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Banlist $ban)
	{
		try
		{
			$bans = $ban->whereId($id)->first();
			return view('themes.default1.admin.emails.banlist.edit',compact('bans'));
		}
		catch(Exception $e)
		{
			return view('404');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Banlist $ban, BanlistRequest $request)
	{
		try
		{
			$bans = $ban->whereId($id)->first();
			if($bans->fill($request->input())->save())
			{
				return redirect('banlist')->with('success','Banned Email Updated sucessfully');
			}
			else
			{
				return redirect('banlist')->with('fails','Banned Email not Updated');
			}
		}
		catch(Exception $e)
		{
			return redirect('banlist')->with('fails','Banned Email not Updated');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, Banlist $ban)
	{
		try
		{
			$bans = $ban->whereId($id)->first();

			/* Success and Falure condition */

			if($bans->delete()==true)
			{
				return redirect('banlist')->with('success','Banned Email Deleted sucessfully');
			}
			else
			{
				return redirect('banlist')->with('fails','Banned Email can not Delete');
			}
		}
		catch(Exception $e)
		{
			return redirect('banlist')->with('fails','Banned Email can not Delete');
		}
	}

}
