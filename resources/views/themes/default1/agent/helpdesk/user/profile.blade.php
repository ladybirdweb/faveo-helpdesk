@extends('themes.default1.agent.layout.agent')

@section('Dashboard')
class="nav-link active"
@stop

@section('dashboard-bar')
active
@stop

@section('profile')
class="active"
@stop

@section('PageHeader')
<h1>{{Lang::get('lang.view-profile')}}</h1>
@stop

@section('profileimg')
<img src="{{Auth::user()->profile_pic}}" id="sidebar-profile-img" class="img-circle elevation-2" alt="User Image" width="auto" height="auto" />
@stop

@section('content')

@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <i class="fa fa-check-circle"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('success')}}
</div>
@endif
<!-- fail message -->
@if(Session::has('fails'))
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <b>{!! Lang::get('lang.alert') !!} !</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('fails')}}
</div>
@endif

<div class="card card-light">
    <div class="card-header">
        <h3 class="card-title">{!! Lang::get('lang.profile') !!}&nbsp;&nbsp;
            <a href="{{URL::route('agent-profile-edit')}}"><i class="fas fa-fw fa-edit"> </i></a>
        </h3>
    </div>

    <?php
    if ($user->primary_dpt) {
        $dept = App\Model\helpdesk\Agent\Department::where('id', '=', $user->primary_dpt)->first();
        $dept = $dept->name;
    } else {
        $dept = "";
    }
    if ($user->assign_group) {
        $grp = App\Model\helpdesk\Agent\Groups::where('id', '=', $user->assign_group)->first();
        $grp = $grp->name;
    } else {
        $grp = "";
    }
    if ($user->agent_tzone) {
        $timezone = App\Model\helpdesk\Utility\Timezones::where('id', '=', $user->agent_tzone)->first();
        $timezone = $timezone->name;
    } else {
        $timezone = "";
    }
    ?>
    
    <div class="card-body">
        
        <div class="row">
            <div class="col-md-6">
                
                <div class="card card-light">
                    
                    <div class="card-header">
                        <h3 class="card-title">{!! Lang::get('lang.user_information') !!}</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            @if($user->gender == 1)
                            <div class='col-sm-4'><label>{!! Lang::get('lang.gender') !!}:</label></div> <div class='col-sm-7'>{{ 'Male' }}</div>
                            @else
                            <div class='col-sm-4'><label>{!! Lang::get('lang.gender') !!}:</label></div> <div class='col-sm-7'>{{ 'Female' }}</div>
                            @endif
                        </div>
                        <div class="form-group  row">
                            <div class='col-sm-4'><label>{!! Lang::get('lang.department') !!}:</label></div> <div class='col-sm-7'> {{ $dept }}</div>
                        </div>
                        <div class="form-group  row">
                            <div class='col-sm-4'><label>{!! Lang::get('lang.group') !!}:</label></div> <div class='col-sm-7'> {{ $grp }}</div>
                        </div>
                        <div class="form-group  row">
                            <div class='col-sm-4'><label>{!! Lang::get('lang.company') !!}:</label></div> <div class='col-sm-7'> {{ $user->company }}</div>
                        </div>
                        <div class="form-group  row">
                            <div class='col-sm-4'><label>{!! Lang::get('lang.role') !!}:</label></div> <div class='col-sm-7'>  {{ $user->role }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                
                <div class="'card card-light" style="    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    margin-bottom: 1rem;">
                    
                    <div class="card-header">
                        <h3 class="card-title">{!! Lang::get('lang.contact_information') !!}</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class='col-sm-4'><label>{!! Lang::get('lang.email') !!}:</label></div> <div class='col-sm-7'> {{ $user->email }}</div>
                        </div>
                        <div class="form-group row">
                            <div class='col-sm-4'><label>{!! Lang::get('lang.phone_number') !!}:</label></div> <div class='col-sm-7'> {{ $user->ext }}{{ $user->phone_number }}</div>
                        </div>
                        <div class="form-group row">
                            <div class='col-sm-4'><label>{!! Lang::get('lang.mobile') !!}:</label></div> <div class='col-sm-7'> {{ $user->mobile }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop