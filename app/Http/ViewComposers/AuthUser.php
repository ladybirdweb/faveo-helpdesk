<?php

namespace App\Http\ViewComposers;

use Auth;
use Illuminate\View\View;

class AuthUser
{
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function compose(View $view)
    {
        $view->with([
            'auth_user_role'         => $this->user->role,
            'auth_user_id'           => $this->user->id,
            'auth_user_profile_pic'  => $this->user->profile_pic,
            'auth_name'              => $this->user->name(),
            'auth_user_active'       => $this->user->active,
            'auth_user_primary_dept' => $this->user->primary_dept,
            'auth_user_assign_group' => $this->user->assign_group,
        ]);
    }
}
