@extends('themes.default1.admin.layout.admin')

@section('Staffs')
active
@stop

@section('staffs-bar')
active
@stop

@section('agents')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{trans('lang.agents')}}</h1>
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
{!! Form::open(array('action' => 'Admin\helpdesk\AgentController@store' , 'method' => 'post') )!!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{!! trans('lang.create_an_agent') !!}</h3>
    </div>
    <div class="box-body">
        @if(Session::has('errors'))
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! trans('lang.alert') !!}!</b>
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
            @if($errors->first('country_code'))
            <li class="error-message-padding">{!! $errors->first('country_code', ':message') !!}</li>
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
        <div class="row">
            <!-- username -->
            <div class="col-xs-4 form-group {{ $errors->has('user_name') ? 'has-error' : '' }}">
                {!! Form::label('user_name',trans('lang.user_name')) !!} <span class="text-red"> *</span>
                {!! Form::text('user_name',null,['class' => 'form-control']) !!}
            </div>
            <!-- firstname -->
            <div class="col-xs-4 form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                {!! Form::label('first_name',trans('lang.first_name')) !!} <span class="text-red"> *</span>
                {!! Form::text('first_name',null,['class' => 'form-control']) !!}
            </div>
            <!-- lastname -->
            <div class="col-xs-4 form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                {!! Form::label('last_name',trans('lang.last_name')) !!} <span class="text-red"> *</span>
                {!! Form::text('last_name',null,['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row">
            <!-- email address -->
            <div class="col-xs-4 form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                {!! Form::label('email',trans('lang.email_address')) !!} <span class="text-red"> *</span>
                {!! Form::email('email',null,['class' => 'form-control']) !!}
            </div>
            <div class="col-xs-1 form-group {{ $errors->has('ext') ? 'has-error' : '' }}">
                <label for="ext">{!! trans('lang.ext') !!}</label>
                {!! Form::text('ext',null,['class' => 'form-control']) !!}
            </div>
            <!--country code-->
            <div class="col-xs-1 form-group {{  $errors->has('country_code') ? 'has-error' : '' }}">

                {!! Form::label('country_code',trans('lang.country-code')) !!} @if($send_otp->status ==1)<span class="text-red"> *</span>@endif
                {!! Form::text('country_code',null,['class' => 'form-control', 'placeholder' => $phonecode, 'title' => trans('lang.enter-country-phone-code')]) !!}

            </div>
            <!-- phone -->
            <div class="col-xs-3 form-group {{ $errors->has('phone_number') ? 'has-error' : '' }}">
                {!! Form::label('phone_number',trans('lang.phone')) !!}
                {!! Form::text('phone_number',null,['class' => 'form-control']) !!}
            </div>
            <!-- Mobile -->
            <div class="col-xs-3 form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
                {!! Form::label('mobile',trans('lang.mobile_number')) !!}@if($send_otp->status ==1)<span class="text-red"> *</span>@endif
                {!! Form::input('number', 'mobile',null,['class' => 'form-control']) !!}
            </div>
        </div>
        <div>
            <h4>{!! trans('lang.agent_signature') !!}</h4>
        </div>
        <div class="">
            {!! Form::textarea('agent_sign',null,['class' => 'form-control','size' => '30x5']) !!}
        </div>
        <div>
            <h4>{{trans('lang.account_status_setting')}}</h4>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <!-- acccount type -->
                <div class="form-group {{ $errors->has('active') ? 'has-error' : '' }}">
                    {!! Form::label('active',trans('lang.status')) !!}
                    <div class="row">
                        <div class="col-xs-3">
                            {!! Form::radio('active','1',true) !!} {{trans('lang.active')}}
                        </div>
                        <div class="col-xs-3">
                            {!! Form::radio('active','0',null) !!} {{trans('lang.inactive')}}
                        </div>
                    </div>
                </div>
                <!-- Role -->
                <div class="form-group {{ $errors->has('role') ? 'has-error' : '' }}">
                    {!! Form::label('role',trans('lang.role')) !!}
                    <div class="row">
                        <div class="col-xs-3">
                            {!! Form::radio('role','admin',true) !!} {{trans('lang.admin')}}
                        </div>
                        <div class="col-xs-3">
                            {!! Form::radio('role','agent',null) !!} {{trans('lang.agent')}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6">
            </div>
        </div>
        <div class="row">
            <!-- assigned group -->
            <div class="col-xs-4 form-group {{ $errors->has('group') ? 'has-error' : '' }}">
                {!! Form::label('assign_group',trans('lang.assigned_group')) !!} <span class="text-red"> *</span>
                {!!Form::select('group',[''=>trans('lang.select_a_group'),trans('lang.groups')=>$groups->lists('name','id')->toArray()],null,['class' => 'form-control select']) !!}
            </div>

           <!-- primary department -->
            <div class="col-xs-4 form-group {{ $errors->has('primary_department') ? 'has-error' : '' }}">
                {!! Form::label('primary_dpt', trans('lang.primary_department')) !!} <span class="text-red"> *</span>

                {!!Form::select('primary_department', [''=>trans('lang.select_a_department'), trans('lang.departments')=>$departments->lists('name','id')->toArray()],'',['class' => 'form-control select']) !!}
            </div>

            <!-- timezone -->
            <div class="col-xs-4 form-group {{ $errors->has('agent_time_zone') ? 'has-error' : '' }}">
                {!! Form::label('agent_tzone',trans('lang.agent_time_zone')) !!} <span class="text-red"> *</span>
                {!! Form::select('agent_time_zone', [''=>trans('lang.select_a_time_zone'),trans('lang.time_zones')=>$timezones->lists('name','id')->toArray()],null,['class' => 'form-control select']) !!}
            </div>
        </div>
        <!-- Assign team -->
        <div class="form-group {{ $errors->has('team') ? 'has-error' : '' }}">
            {!! Form::label('agent_tzone',trans('lang.assigned_team')) !!} <span class="text-red"> *</span>
            @while (list($key, $val) = each($teams))
            <div class="form-group ">
                <input type="checkbox" name="team[]" value="<?php echo $val; ?>"  > <?php echo $key; ?><br/>
            </div>
            @endwhile 
        </div>
        <!-- Send email to user about registration password -->
        <br/>
        <div class="form-group">
            <input type="checkbox" name="send_email" checked> &nbsp;<label> {{ trans('lang.send_password_via_email')}}</label>
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit(trans('lang.submit'),['class'=>'form-group btn btn-primary'])!!}
    </div>
</div>
{!!Form::close()!!}

<script type="text/javascript">
    $(function() {
        //Initialize Select2 Elements
        $(".select2").select2();
    });
    </script>



@stop