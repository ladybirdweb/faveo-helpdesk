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
<h1>{{Lang::get('lang.edit-profile')}}</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        {!! Form::model($user,['url'=>'agent-profile', 'method' => 'PATCH','files'=>true]) !!}
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    {!! Lang::get('lang.profile') !!}
                </h3>
            </div>
            <div class="box-body">
                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <b>Success</b>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{Session::get('success')}}
                </div>
                @endif
                <!-- fail message -->
                @if(Session::has('fails'))
                <div class="alert alert-danger alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <b>Fail!</b>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{Session::get('fails')}}
                </div>
                @endif
                @if(Session::has('errors'))
                <?php //dd($errors); ?>
                @if($errors->first('first_name'))
                <div class="alert alert-danger alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <b>{!! Lang::get('lang.alert') !!}!</b>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <br/>
                    <li class="error-message-padding">{!! $errors->first('first_name', ':message') !!}</li>
                </div>
                @endif
                @endif
                <!-- first name -->
                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                    {!! Form::label('first_name',Lang::get('lang.first_name')) !!} <span class="text-red"> *</span>
                    {!! Form::text('first_name',null,['class' => 'form-control']) !!}
                </div>
                <!-- last name -->
                <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                    {!! Form::label('last_name',Lang::get('lang.last_name')) !!}
                    {!! Form::text('last_name',null,['class' => 'form-control']) !!}
                </div>
                <!-- gender -->
                <div class="form-group">
                    {!! Form::label('gender',Lang::get('lang.gender')) !!}
                    <div class="row">
                        <div class="col-xs-3">
                            {!! Form::radio('gender','1',true) !!} {{Lang::get('lang.male')}}
                        </div>
                        <div class="col-xs-3">
                            {!! Form::radio('gender','0') !!} {{Lang::get('lang.female')}}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <!-- email address -->
                    {!! Form::label('email',Lang::get('lang.email_address')) !!}
                    <div>
                        {{$user->email}}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('company') ? 'has-error' : '' }}">
                    <!-- company -->
                    {!! Form::label('company',Lang::get('lang.company')) !!}
                    {!! Form::text('company',null,['class' => 'form-control']) !!}
                </div>
                <div class="row">
                    <!-- phone extension -->
                    <div class="col-xs-2 form-group {{ Session::has('country_code_error') ? 'has-error' : '' }}">
                        {!! Form::label('country_code',Lang::get('lang.country-code')) !!}
                        {!! Form::text('country_code',null,['class' => 'form-control', 'placeholder' => $phonecode, 'title' => Lang::get('lang.enter-country-phone-code')]) !!}
                    </div>
                    <div class="col-xs-2 form-group {{ $errors->has('ext') ? 'has-error' : '' }}">
                        {!! Form::label('ext',Lang::get('lang.ext')) !!}
                        {!! Form::text('ext',null,['class' => 'form-control']) !!}
                    </div>
                    <!-- phone number -->
                    <div class="col-xs-8 form-group {{ $errors->has('phone_number') ? 'has-error' : '' }}">
                        {!! Form::label('phone_number',Lang::get('lang.phone')) !!}
                        {!! Form::text('phone_number',null,['class' => 'form-control']) !!}
                    </div>
                </div>
                <!-- mobile -->
                <div class="form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
                    {!! Form::label('mobile',Lang::get('lang.mobile_number')) !!}
                    {!! Form::text('mobile',null,['class' => 'form-control']) !!}
                </div>
                <div class="form-group {{ $errors->has('agent_sign') ? 'has-error' : '' }}">
                    {!! Form::label('agent_sign',Lang::get('lang.agent_sign')) !!}
                    {!! Form::textarea('agent_sign',null,['class' => 'form-control']) !!}
                </div>
                <div class="form-group {{ $errors->has('profile_pic') ? 'has-error' : '' }}">
                    <!-- profile pic -->
                    <div type="file" class="btn btn-default btn-file" style="color:orange">
                        <i class="fa fa-user"> </i>
                        {!! Form::label('profile_pic',Lang::get('lang.profile_pic')) !!}
                        {!! Form::file('profile_pic',['class' => 'form-file']) !!}
                    </div>  
                </div>
                {!! Form::token() !!}
                {!! Form::close() !!}
            </div>
            <div class="box-footer">
                {!! Form::submit(Lang::get('lang.submit'),['class'=>'form-group btn btn-primary'])!!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        {!! Form::model($user,['url'=>'agent-profile-password/'.$user->id , 'method' => 'PATCH']) !!}
        <div class="box box-primary">
            <div class="box-header with-border">
                <h4 class="box-title">{!! Lang::get('lang.change_password') !!}</h4> 
            </div>
            <div class="box-body">
                @if(Session::has('success1'))
                <div class="alert alert-success alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <b>Success</b>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{Session::get('success1')}}
                </div>
                @endif
                <!-- fail message -->
                @if(Session::has('fails1'))
                <div class="alert alert-danger alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <b>Fail!</b>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{Session::get('fails1')}}
                </div>
                @endif
                <!-- old password -->
                <div class="form-group has-feedback {{ $errors->has('old_password') ? 'has-error' : '' }}">
                    {!! Form::label('old_password',Lang::get('lang.old_password')) !!} <span class="text-red"> *</span>
                    {!! Form::password('old_password',['placeholder'=>Lang::get('lang.old_password'),'class' => 'form-control']) !!}
                    {!! $errors->first('old_password', '<spam class="help-block">:message</spam>') !!}
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <!-- new password -->
                <div class="form-group has-feedback {{ $errors->has('new_password') ? 'has-error' : '' }}">
                    {!! Form::label('new_password',Lang::get('lang.new_password')) !!} <span class="text-red"> *</span>
                    {!! Form::password('new_password',['placeholder'=>Lang::get('lang.new_password'),'class' => 'form-control']) !!}
                    {!! $errors->first('new_password', '<spam class="help-block">:message</spam>') !!}
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <!-- confirm password -->
                <div class="form-group has-feedback {{ $errors->has('confirm_password') ? 'has-error' : '' }}">
                    {!! Form::label('confirm_password',Lang::get('lang.confirm_password')) !!} <span class="text-red"> *</span>
                    {!! Form::password('confirm_password',['placeholder'=>Lang::get('lang.confirm_password'),'class' => 'form-control']) !!}
                    {!! $errors->first('confirm_password', '<spam class="help-block">:message</spam>') !!}
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
            </div>
            <div class="box-footer">
                {!! Form::submit(Lang::get('lang.save'),['class'=>'form-group btn btn-primary'])!!}
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
<script>
    $(function() {
        $("textarea").wysihtml5();
    });
</script>
@stop