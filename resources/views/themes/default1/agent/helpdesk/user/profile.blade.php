@extends('themes.default1.agent.layout.agent')

@section('Dashboard')
class="active"
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
<img src="{{Auth::user()->profile_pic}}" class="img-circle" alt="User Image" width="100%"/>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><b>{!! Lang::get('lang.profile') !!}</b>&nbsp;&nbsp;<a href="{{URL::route('agent-profile-edit')}}"><i class="fa fa-fw fa-edit"> </i></a></h3>
        @if(Session::has('success'))
        <br><br>
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
    <div class="row">
        <div class="col-md-6">
            <div class="box-header  with-border">
                <h3 class="box-title"><b>{!! Lang::get('lang.user_information') !!}</b></h3>
            </div>
            <div class="box-body">
                <div class="form-group row">
                    @if($user->gender == 1)
                    <div class='col-xs-4'><label>{!! Lang::get('lang.gender') !!}:</label></div> <div class='col-xs-7'>{{ 'Male' }}</div>
                    @else
                    <div class='col-xs-4'><label>{!! Lang::get('lang.gender') !!}:</label></div> <div class='col-xs-7'>{{ 'Female' }}</div>
                    @endif
                </div>
                <div class="form-group  row">
                    <div class='col-xs-4'><label>{!! Lang::get('lang.department') !!}:</label></div> <div class='col-xs-7'> {{ $dept }}</div>
                </div>
                <div class="form-group  row">
                    <div class='col-xs-4'><label>{!! Lang::get('lang.group') !!}:</label></div> <div class='col-xs-7'> {{ $grp }}</div>
                </div>
                <div class="form-group  row">
                    <div class='col-xs-4'><label>{!! Lang::get('lang.company') !!}:</label></div> <div class='col-xs-7'> {{ $user->role }}</div>
                </div>
                <div class="form-group  row">
                    <div class='col-xs-4'><label>{!! Lang::get('lang.role') !!}:</label></div> <div class='col-xs-7'> {{ $user->company }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box-header  with-border">
                <h3 class="box-title"><b>{!! Lang::get('lang.contact_information') !!}</b></h3>
            </div>
            <div class="box-body">
                <div class="form-group row">
                    <div class='col-xs-4'><label>{!! Lang::get('lang.email') !!}:</label></div> <div class='col-xs-7'> {{ $user->email }}</div>
                </div>
                <div class="form-group row">
                    <div class='col-xs-4'><label>{!! Lang::get('lang.phone_number') !!}:</label></div> <div class='col-xs-7'> {{ $user->ext }}{{ $user->phone_number }}</div>
                </div>
                <div class="form-group row">
                    <div class='col-xs-4'><label>{!! Lang::get('lang.mobile') !!}:</label></div> <div class='col-xs-7'> {{ $user->mobile }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop