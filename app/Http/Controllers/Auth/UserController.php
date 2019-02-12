<?php

namespace App\Http\Controllers\Agent\helpdesk;

// controllers
use App\Http\Controllers\Controller;
// requests
/*  Include Sys_user Model  */
use App\Http\Requests\helpdesk\ProfilePassword;
/* For validation include Sys_userRequest in create  */
use App\Http\Requests\helpdesk\ProfileRequest;
/* For validation include Sys_userUpdate in update  */
use App\Http\Requests\helpdesk\Sys_userRequest;
/*  include guest_note model */
use App\Http\Requests\helpdesk\Sys_userUpdate;
// models
use App\Model\helpdesk\Agent_panel\Organization;
use App\Model\helpdesk\Agent_panel\User_org;
/* include User Model */
/* include Help_topic Model */
/* Profile validator */
/* Profile Password validator */
use App\User;
// classes
/* include ticket_thred model */
use Auth;
/* include tickets model */
use Hash;
/* TicketRequest to validate the ticket response */
/* Validate post check ticket */
use Input;
use Redirect;

/**
 * UserController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class UserController extends Controller
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
        $this->middleware('auth');
        $this->middleware('role.agent');
        // $this->middleware('roles');
    }

    /**
     * Display a listing of the resource.
     *
     * @param type User $user
     *
     * @return type Response
     */
    public function index()
    {
        try {
            /* get all values in Sys_user */
            return view('agent.helpdesk.user.index');
        } catch (Exception $e) {
            return view('404');
        }
    }

    /**
     * This function is used to display the list of users.
     *
     * @return datatable
     */
    public function user_list()
    {
        return \Datatable::collection(User::where('role', '!=', 'admin')->where('role', '!=', 'agent')->get())
                        ->searchColumns('user_name')
                        ->orderColumns('user_name', 'email')
                        ->addColumn('user_name', function ($model) {
                            return $model->user_name;
                        })
                        ->addColumn('email', function ($model) {
                            $email = $model->email;

                            return $email;
                        })
                        ->addColumn('phone', function ($model) {
                            $phone = '';
                            if ($model->phone_number) {
                                $phone = $model->ext.' '.$model->phone_number;
                            }
                            $mobile = '';
                            if ($model->mobile) {
                                $mobile = $model->mobile;
                            }
                            $phone = $phone.'&nbsp;&nbsp;&nbsp;'.$mobile;

                            return $phone;
                        })
                        ->addColumn('status', function ($model) {
                            $status = $model->active;
                            if ($status == 1) {
                                $stat = '<button class="btn btn-success btn-xs">Active</button>';
                            } else {
                                $stat = '<button class="btn btn-danger btn-xs">Inactive</button>';
                            }

                            return $stat;
                        })
                        ->addColumn('lastlogin', function ($model) {
                            $t = $model->updated_at;

                            return TicketController::usertimezone($t);
                        })
                        ->addColumn('Actions', function ($model) {
                            //return '<a href=article/delete/ ' . $model->id . ' class="btn btn-danger btn-flat" onclick="myFunction()">Delete</a>&nbsp;<a href=article/' . $model->id . '/edit class="btn btn-warning btn-flat">Edit</a>&nbsp;<a href=show/' . $model->id . ' class="btn btn-warning btn-flat">View</a>';
                            //return '<form action="article/delete/ ' . $model->id . '" method="post" onclick="alert()"><button type="sumbit" value="Delete"></button></form><a href=article/' . $model->id . '/edit class="btn btn-warning btn-flat">Edit</a>&nbsp;<a href=show/' . $model->id . ' class="btn btn-warning btn-flat">View</a>';
                            return '<span  data-toggle="modal" data-target="#deletearticle'.$model->id.'"><a href="#" ><button class="btn btn-danger btn-xs"></a> '.\Lang::get('lang.delete').' </button></span>&nbsp;<a href="'.route('user.edit', $model->id).'" class="btn btn-warning btn-xs">'.\Lang::get('lang.edit').'</a>&nbsp;<a href="'.route('user.show', $model->id).'" class="btn btn-primary btn-xs">'.\Lang::get('lang.view').'</a>
				<div class="modal fade" id="deletearticle'.$model->id.'">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Are You Sure ?</h4>
                </div>
                <div class="modal-body">
                '.$model->user_name.'
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis2">Close</button>
                    <a href="'.route('user.delete', $model->id).'"><button class="btn btn-danger">delete</button></a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>';
                        })
                        ->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return type Response
     */
    public function create()
    {
        try {
            return view('agent.helpdesk.user.create');
        } catch (Exception $e) {
            return view('404');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param type User            $user
     * @param type Sys_userRequest $request
     *
     * @return type Response
     */
    public function store(User $user, Sys_userRequest $request)
    {
        try {
            /* insert the input request to sys_user table */
            /* Check whether function success or not */
            $user->email = $request->input('email');
            $user->user_name = $request->input('full_name');
            $user->mobile = $request->input('mobile');
            $user->ext = $request->input('ext');
            $user->phone_number = $request->input('phone_number');
            $user->active = $request->input('active');
            $user->internal_note = $request->input('internal_note');
            $user->role = 'user';
            if ($user->save() == true) {
                /* redirect to Index page with Success Message */
                return redirect('user')->with('success', 'User  Created Successfully');
            } else {
                /* redirect to Index page with Fails Message */
                return redirect('user')->with('fails', 'User  can not Create');
            }
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('user')->with('fails', 'User  can not Create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param type int  $id
     * @param type User $user
     *
     * @return type Response
     */
    public function show($id, User $user)
    {
        try {
            /* select the field where id = $id(request Id) */
            $users = $user->whereId($id)->first();

            return view('agent.helpdesk.user.show', compact('users'));
        } catch (Exception $e) {
            return view('404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param type int  $id
     * @param type User $user
     *
     * @return type Response
     */
    public function edit($id, User $user)
    {
        try {
            /* select the field where id = $id(request Id) */
            $users = $user->whereId($id)->first();

            return view('agent.helpdesk.user.edit', compact('users'));
        } catch (Exception $e) {
            return view('404');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param type int            $id
     * @param type User           $user
     * @param type Sys_userUpdate $request
     *
     * @return type Response
     */
    public function update($id, User $user, Sys_userUpdate $request)
    {
        try {
            /* select the field where id = $id(request Id) */
            $users = $user->whereId($id)->first();
            /* Update the value by selected field  */
            /* Check whether function success or not */
            if ($users->fill($request->input())->save() == true) {
                /* redirect to Index page with Success Message */
                return redirect('user')->with('success', 'User  Updated Successfully');
            } else {
                /* redirect to Index page with Fails Message */
                return redirect('user')->with('fails', 'User  can not Update');
            }
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('user')->with('fails', 'User  can not Update');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param type int  $id
     * @param type User $user
     *
     * @return type Response
     */
    public function destroy($id, User $user)
    {
        try {
            /* select the field where id = $id(request Id) */
            $users = $user->whereId($id)->first();
            /* delete the selected field */
            /* Check whether function success or not */
            if ($users->delete() == true) {
                /* redirect to Index page with Success Message */
                return redirect('user')->with('success', 'User  Deleted Successfully');
            } else {
                /* redirect to Index page with Fails Message */
                return redirect('user')->with('fails', 'User  can not Delete');
            }
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('user')->with('fails', 'User  can not Delete');
        }
    }

    /**
     * get profile page.
     *
     * @return type Response
     */
    public function getProfile()
    {
        $user = Auth::user();

        return view('agent.helpdesk.user.profile', compact('user'));
    }

    /**
     * get profile edit page.
     *
     * @return type Response
     */
    public function getProfileedit()
    {
        $user = Auth::user();

        return view('agent.helpdesk.user.profile-edit', compact('user'));
    }

    /**
     * post profile page.
     *
     * @param type int            $id
     * @param type ProfileRequest $request
     *
     * @return type Response
     */
    public function postProfileedit(ProfileRequest $request)
    {
        $user = Auth::user();
        $user->gender = $request->input('gender');
        $user->save();
        if ($user->profile_pic == 'avatar5.png' || $user->profile_pic == 'avatar2.png') {
            if ($request->input('gender') == 1) {
                $name = 'avatar5.png';
                $destinationPath = 'uploads/profilepic';
                $user->profile_pic = $name;
            } elseif ($request->input('gender') == 0) {
                $name = 'avatar2.png';
                $destinationPath = 'uploads/profilepic';
                $user->profile_pic = $name;
            }
        }
        if (Input::file('profile_pic')) {
            //$extension = Input::file('profile_pic')->getClientOriginalExtension();
            $name = Input::file('profile_pic')->getClientOriginalName();
            $destinationPath = 'uploads/profilepic';
            $fileName = rand(0000, 9999).'.'.$name;
            //echo $fileName;
            Input::file('profile_pic')->move($destinationPath, $fileName);
            $user->profile_pic = $fileName;
        } else {
            $user->fill($request->except('profile_pic', 'gender'))->save();

            return Redirect::route('profile')->with('success', 'Profile Updated sucessfully');
        }
        if ($user->fill($request->except('profile_pic'))->save()) {
            return Redirect::route('profile')->with('success', 'Profile Updated sucessfully');
        }
    }

    /**
     * Post profile password.
     *
     * @param type int             $id
     * @param type ProfilePassword $request
     *
     * @return type Response
     */
    public function postProfilePassword($id, ProfilePassword $request)
    {
        $user = Auth::user();
        //echo $user->password;
        if (Hash::check($request->input('old_password'), $user->getAuthPassword())) {
            $user->password = Hash::make($request->input('new_password'));
            $user->save();

            return redirect('profile-edit')->with('success1', 'Password Updated sucessfully');
        } else {
            return redirect('profile-edit')->with('fails1', 'Password was not Updated. Incorrect old password');
        }
    }

    /**
     * User Assign Org.
     *
     * @param type $id
     *
     * @return type boolean
     */
    public function UserAssignOrg($id)
    {
        $org = Input::get('org');
        $user_org = new User_org();
        $user_org->org_id = $org;
        $user_org->user_id = $id;
        $user_org->save();

        return 1;
    }

    /**
     * user create organisation.
     *
     * @return type value
     */
    public function User_Create_Org($id)
    {
        if (Input::get('website') != null) {
            // checking website
            $check = Organization::where('website', '=', Input::get('website'))->first();
        } else {
            $check = null;
        }

        // checking name
        $check2 = Organization::where('name', '=', Input::get('name'))->first();

        if (\Input::get('name') == null) {
            return 'Name is required';
        } elseif ($check2 != null) {
            return 'Name should be Unique';
        } elseif ($check != null) {
            return 'Website should be Unique';
        } else {
            $org = new Organization();
            $org->name = Input::get('name');
            $org->phone = Input::get('phone');
            $org->website = Input::get('website');
            $org->address = Input::get('address');
            $org->internal_notes = Input::get('internal');
            $org->save();

            $user_org = new User_org();
            $user_org->org_id = $org->id;
            $user_org->user_id = $id;
            $user_org->save();

            return 0;
        }
    }
}
