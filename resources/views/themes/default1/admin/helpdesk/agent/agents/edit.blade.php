@extends('themes.default1.admin.layout.admin')

@section('Staffs')
class="nav-link active"
@stop

@section('staff-menu-parent')
class="nav-item menu-open"
@stop

@section('staff-menu-open')
class="nav nav-treeview menu-open"
@stop

@section('agents')
class="nav-link active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{Lang::get('lang.staffs')}}</h1>
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')
<ol class="breadcrumb">

</ol>
@stop
<!-- /breadcrumbs -->
<!-- content -->
@section('content')

<!-- open a form -->
<?php //dd($user->agent_tzone); ?>
{!! Form::model($user, ['url' => 'agents/'.$user->id,'method' => 'PATCH'] )!!}

@if(Session::has('errors'))
<?php //dd($errors); ?>
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <b>Alert!</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <br/>
    @if($errors->first('user_name'))
    <li class="error-message-padding">{!! $errors->first('user_name', ':message') !!}</li>
    @endif
    @if($errors->first('first_name'))
    <li class="error-message-padding">{!! $errors->first('first_name', ':message') !!}</li>
    @endif
    @if($errors->first('last_name'))
    <li class="error-message-padding">{!! $errors->first('last_name', ':message') !!}</li>
    @endif
    @if($errors->first('email'))
    <li class="error-message-padding">{!! $errors->first('email', ':message') !!}</li>
    @endif
    @if($errors->first('ext'))
    <li class="error-message-padding">{!! $errors->first('ext', ':message') !!}</li>
    @endif
    @if($errors->first('phone_number'))
    <li class="error-message-padding">{!! $errors->first('phone_number', ':message') !!}</li>
    @endif
    @if($errors->first('mobile'))
    <li class="error-message-padding">{!! $errors->first('mobile', ':message') !!}</li>
    @endif
    @if($errors->first('active'))
    <li class="error-message-padding">{!! $errors->first('active', ':message') !!}</li>
    @endif
    @if($errors->first('role'))
    <li class="error-message-padding">{!! $errors->first('role', ':message') !!}</li>
    @endif
    @if($errors->first('group'))
    <li class="error-message-padding">{!! $errors->first('group', ':message') !!}</li>
    @endif
    @if($errors->first('primary_department'))
    <li class="error-message-padding">{!! $errors->first('primary_department', ':message') !!}</li>
    @endif
    @if($errors->first('agent_time_zone'))
    <li class="error-message-padding">{!! $errors->first('agent_time_zone', ':message') !!}</li>
    @endif
    @if($errors->first('team'))
    <li class="error-message-padding">{!! $errors->first('team', ':message') !!}</li>
    @endif 
</div>
@endif
@if(Session::has('fails2'))
    <div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <b>Alert!</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <br/>
        <li class="error-message-padding">{!! Session::get('fails2') !!}</li>
    </div>
@endif
<!-- <section class="content"> -->
<div class="card card-light">
    <div class="card-header">
        <h3 class="card-title">{!! Lang::get('lang.edit_an_agent') !!}</h3>	
    </div>
    <div class="card-body">

        <div class="row">
            <!-- username -->
            <div class="col-sm-4 form-group {{ $errors->has('user_name') ? 'has-error' : '' }}">

                {!! Form::label('user_name',Lang::get('lang.user_name')) !!} <span class="text-red"> *</span>

                {!! Form::text('user_name',null,['class' => 'form-control']) !!}

            </div>

            <!-- firstname -->
            <div class="col-sm-4 form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">

                {!! Form::label('first_name',Lang::get('lang.first_name')) !!} <span class="text-red"> *</span>

                {!! Form::text('first_name',null,['class' => 'form-control']) !!}

            </div>

            <!-- Lastname -->
            <div class="col-sm-4 form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">

                {!! Form::label('last_name',Lang::get('lang.last_name')) !!} <span class="text-red"> *</span>

                {!! Form::text('last_name',null,['class' => 'form-control']) !!}

            </div>

        </div>

        <div class="row">
            <!-- Email -->
            <div class="col-sm-4 form-group {{ $errors->has('email') ? 'has-error' : '' }}">

                {!! Form::label('email',Lang::get('lang.email_address')) !!} <span class="text-red"> *</span>

                {!! Form::email('email',null,['class' => 'form-control']) !!}

            </div>

            <div class="col-sm-1 form-group {{ $errors->has('ext') ? 'has-error' : '' }}">

                <label for="ext">EXT</label>	

                {!! Form::text('ext',null,['class' => 'form-control']) !!}

            </div>
            <!--country code-->
            <div class="col-sm-1 form-group {{ Session::has('country_code') ? 'has-error' : '' }}">

                {!! Form::label('country_code',Lang::get('lang.country-code')) !!}
                {!! Form::text('country_code',null,['class' => 'form-control', 'placeholder' => $phonecode, 'title' => Lang::get('lang.enter-country-phone-code')]) !!}

            </div>
            <!-- phone -->
            <div class="col-sm-3 form-group {{ $errors->has('phone_number') ? 'has-error' : '' }}">

                {!! Form::label('phone_number',Lang::get('lang.phone')) !!}

                {!! Form::text('phone_number',null,['class' => 'form-control']) !!}

            </div>

            <!-- Mobile -->
            <div class="col-sm-3 form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">

                {!! Form::label('mobile',Lang::get('lang.mobile_number')) !!}

                {!! Form::input('number', 'mobile',null,['class' => 'form-control']) !!}

            </div>

        </div>

        <div class="row">
            <!-- assigned group -->
            <div class="col-sm-4 form-group {{ $errors->has('group') ? 'has-error' : '' }}">
                {!! Form::label('assign_group', Lang::get('lang.assigned_group')) !!} <span class="text-red"> *</span>

                {!!Form::select('group',[''=>Lang::get('lang.select_a_group'), Lang::get('lang.groups')=>$groups->pluck('name','id')->toArray()],$user->assign_group,['class' => 'form-control select']) !!}
            </div>

            <!-- primary department -->
            <div class="col-sm-4 form-group {{ $errors->has('primary_department') ? 'has-error' : '' }}">
                {!! Form::label('primary_dpt', Lang::get('lang.primary_department')) !!} <span class="text-red"> *</span>

                {!!Form::select('primary_department', [''=>Lang::get('lang.select_a_department'), Lang::get('lang.departments')=>$departments->pluck('name','id')->toArray()],$user->primary_dpt,['class' => 'form-control select']) !!}
            </div>

            <!-- agent timezone -->
            <div class="col-sm-4 form-group {{ $errors->has('agent_time_zone') ? 'has-error' : '' }}">
                {!! Form::label('agent_tzone', Lang::get('lang.agent_time_zone')) !!} <span class="text-red"> *</span>

                {!!Form::select('agent_time_zone', [''=>Lang::get('lang.select_a_time_zone'), Lang::get('lang.time_zones')=>$timezones->pluck('name','id')->toArray()],$user->agent_tzone,['class' => 'form-control select']) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <!-- acccount type -->
                <div class="form-group {{ $errors->has('active') ? 'has-error' : '' }}">

                    {!! Form::label('active',Lang::get('lang.status')) !!}

                    <div class="row">
                        <div class="col-sm-3">
                            {!! Form::radio('active','1',true) !!} {{ Lang::get('lang.active') }}
                        </div>
                        <div class="col-sm-3">
                            {!! Form::radio('active','0',null) !!} {{Lang::get('lang.inactive')}}
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-sm-4">
                  <!-- role -->
                <div class="form-group {{ $errors->has('role') ? 'has-error' : '' }}">

                    {!! Form::label('role',Lang::get('lang.role')) !!}

                    <div class="row">
                        <div class="col-sm-3">
                            {!! Form::radio('role','admin',true) !!} {{Lang::get('lang.admin')}}
                        </div>
                        <div class="col-sm-3">
                            {!! Form::radio('role','agent',null) !!} {{Lang::get('lang.agent')}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <!-- team -->
                <div class="form-group {{ $errors->has('team') ? 'has-error' : '' }}">
                    {!! Form::label('agent_tzone',Lang::get('lang.assigned_team')) !!} <span class="text-red"> *</span>
                </div>
                @foreach($teams as $key => $val)
                <div class="form-group ">
                    <input type="checkbox" name="team[]" value="<?php echo $val; ?> " <?php
                    if (in_array($val, $assign)) {
                        echo ('checked');
                    }
                    ?> > &nbsp;<?php echo "  " . $key; ?><br/>
                </div>
                @endforeach
            </div>
        </div>

         <div>
            {!! Form::label('agent_signature',Lang::get('lang.agent_signature')) !!}
            {!! Form::textarea('agent_sign',null,['class' => 'form-control','size' => '30x5']) !!}
        </div>
    </div>
    <div class="card-footer">
        {!! Form::submit(Lang::get('lang.update'),['class'=>'btn btn-primary'])!!}
    </div>
</div>
{!!Form::close()!!}
@stop