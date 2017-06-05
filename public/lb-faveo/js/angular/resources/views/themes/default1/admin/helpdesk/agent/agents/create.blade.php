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
<h1>{{Lang::get('lang.agents')}}</h1>
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
        <h3 class="box-title">{!! Lang::get('lang.create_an_agent') !!}</h3>    
    </div>
    <div class="box-body">
        @if(Session::has('errors'))
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
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
            <!-- email address -->
            <div class="col-xs-6 form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                {!! Form::label('email',Lang::get('lang.email_address')) !!} <span class="text-red"> *</span>
                {!! Form::email('email',null,['class' => 'form-control']) !!}
            </div>
            <div class="col-xs-6 form-group {{ $errors->has('user_name') ? 'has-error' : '' }}">
                {!! Form::label('user_name',Lang::get('lang.user_name')) !!} <span class="text-red"> *</span>
                {!! Form::text('user_name',null,['class' => 'form-control', 'pattern' => '^[a-zA-Z0-9-_\.]{1,20}$|[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$', 'title' => Lang::get('lang.username_pattern_warning')]) !!}
            </div>
        </div>
        <div class="row">
            <!-- firstname -->
            <div class="col-xs-6 form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                {!! Form::label('first_name',Lang::get('lang.first_name')) !!} <span class="text-red"> *</span>
                {!! Form::text('first_name',null,['class' => 'form-control']) !!}
            </div>
            <!-- lastname -->
            <div class="col-xs-6 form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                {!! Form::label('last_name',Lang::get('lang.last_name')) !!}
                {!! Form::text('last_name',null,['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-xs-1 form-group {{ $errors->has('ext') ? 'has-error' : '' }}">
                <label for="ext">{!! Lang::get('lang.ext') !!}</label>  
                <!-- {!! Form::text('ext',null,['class' => 'form-control']) !!} -->

                <input type="text" name="ext" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
            </div>

             <!-- phone -->
            <div class="col-xs-5 form-group {{ $errors->has('phone_number') ? 'has-error' : '' }}">
                {!! Form::label('phone_number',Lang::get('lang.phone')) !!}
                <!-- {!! Form::text('phone_number',null,['class' => 'form-control']) !!} -->
                <!-- {!! Form::input('number','phone_number',null,['class' => 'form-control', 'id' => 'phone_number']) !!} -->

                 <input type="text" name="phone_number" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57"  id="phone_number">
            </div>
            <!--country code-->
            <div class="col-xs-1 form-group {{  $errors->has('country_code') ? 'has-error' : '' }}">

                {!! Form::label('country_code',Lang::get('lang.country-code')) !!} @if($send_otp->status ==1)<span class="text-red"> *</span>@endif
                <!-- {!! Form::text('country_code',null,['class' => 'form-control', 'placeholder' => $phonecode, 'title' => Lang::get('lang.enter-country-phone-code')]) !!} -->

                   <input type="text" name="country_code" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder = {{$phonecode}}>

            </div>
           
            <!-- Mobile -->
            <div class="col-xs-5 form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
                {!! Form::label('mobile',Lang::get('lang.mobile_number')) !!}@if($send_otp->status ==1)<span class="text-red"> *</span>@endif
                <!-- {!! Form::text('mobile',null,['class' => 'form-control']) !!} -->
                <!-- {!! Form::input('number','mobile',null,['class' => 'form-control', 'id' => 'mobile']) !!} -->
                 <input type="text" name="mobile" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57" >

            </div>
        </div>
        <div>
            <h4>{{Lang::get('lang.account_status_setting')}}</h4>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <!-- acccount type -->
                <div class="form-group {{ $errors->has('active') ? 'has-error' : '' }}">
                    {!! Form::label('active',Lang::get('lang.status')) !!}
                    <div class="row">
                        <div class="col-xs-3">
                            {!! Form::radio('active','1',true) !!} {{Lang::get('lang.active')}}
                        </div>
                        <div class="col-xs-3">
                            {!! Form::radio('active','0',null) !!} {{Lang::get('lang.inactive')}}
                        </div>
                    </div>
                </div>
                <!-- Role -->
                <div class="form-group {{ $errors->has('role') ? 'has-error' : '' }}">
                    {!! Form::label('role',Lang::get('lang.role')) !!}
                    <div class="row">
                        <div class="col-xs-3">
                            {!! Form::radio('role','admin',true) !!} {{Lang::get('lang.admin')}}
                        </div>
                        <div class="col-xs-3">
                            {!! Form::radio('role','agent',null) !!} {{Lang::get('lang.agent')}}
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
                {!! Form::label('assign_group',Lang::get('lang.assigned_group')) !!} <span class="text-red"> *</span>
                {!!Form::select('group',[''=>Lang::get('lang.select_a_group'),Lang::get('lang.groups')=>$groups->pluck('name','id')->toArray()],null,['class' => 'form-control select']) !!}
            </div>
            <!-- primary dept -->
            <div class="col-xs-4 form-group {{ $errors->has('primary_department') ? 'has-error' : '' }}">
                {!! Form::label('primary_dpt',Lang::get('lang.primary_department')) !!} <span class="text-red"> *</span>

<!-- <input type="" name="primary_department[]" class="form-control select2" id="primary_department"> -->


                
            {!! Form::select('primary_department[]', [Lang::get('lang.departments')=>$departments->pluck('name','id')->toArray()],null,['multiple'=>true,'class'=>"form-control select2" ,'id'=>"primary_department"]) !!}

            </div>
            <!-- timezone -->
            <div class="col-xs-4 form-group {{ $errors->has('agent_time_zone') ? 'has-error' : '' }}">
                {!! Form::label('agent_tzone',Lang::get('lang.agent_time_zone')) !!} <span class="text-red"> *</span>
                {!! Form::select('agent_time_zone', [''=>Lang::get('lang.select_a_time_zone'),Lang::get('lang.time_zones')=>$timezones->pluck('name','id')->toArray()],null,['class' => 'form-control select']) !!}
            </div>
        </div>
        <!-- Assign team -->
        <div class="form-group {{ $errors->has('team') ? 'has-error' : '' }}">
            {!! Form::label('agent_tzone',Lang::get('lang.assigned_team')) !!} 


             @while (list($key, $val) = each($teams))
            <div class="form-group ">
                <input type="checkbox" name="team[]" value="<?php echo $val; ?>"  > <?php echo $key; ?><br/>
            </div>
            @endwhile


        </div>
        <div class="row">
            <div class="col-xs-12">
            <h4>{!! Lang::get('lang.agent_signature') !!}</h4>
            </div>
            <div class="col-xs-12">
                {!! Form::textarea('agent_sign',null,['class' => 'form-control','size' => '30x5']) !!}
            </div>
        </div>
        <!-- Send email to user about registration password -->
        <br/>
        <div class="form-group">
            <input type="checkbox" name="send_email" checked> &nbsp;<label> {{ Lang::get('lang.send_password_via_email')}}</label>
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit(Lang::get('lang.submit'),['class'=>'form-group btn btn-primary'])!!}
    </div>
</div>
{!!Form::close()!!}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script>
        $('#primary_department').select2({

            // alert('ogkkggk');
           placeholder: "{{Lang::get('lang.Choose_departments...')}}",
            minimumInputLength: 2,
            ajax: {
               url: '{{route("agent.dept.search")}}',
                 dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    </script>


   <!--   type: 'post',
            url: '{{route("settingsUpdateApproval.settings")}}', -->


<script type="text/javascript">
    $(function() {
        $('.select2-selection--multiple').css('border-radius','0px');
        $('.select2-selection__rendered').css('margin-bottom','-7px');
    });
    </script>


@stop