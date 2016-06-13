@extends('themes.default1.client.layout.client')
@section('HeadInclude')
<link href="{{asset("lb-faveo/css/AdminLTE.css")}}" rel="stylesheet" type="text/css" />
@stop

@section('content')
<div id="content" class="site-content col-md-12">
    <section class="section-title">
        <h2>
            {!! Lang::get('lang.profile_settings') !!} </h2>
    </section>
    <div class="row">
        <div class="col-md-6">
            {!! Form::model($user,['url'=>'client-profile-edit', 'method' => 'PATCH','files'=>true]) !!}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4>{!! Lang::get('lang.pofile') !!} </h4>
                </div>
                <div class="box-body">
                    @if(Session::has('success1'))
                    <div class="alert alert-success alert-dismissable">
                        <i class="fa fa-ban"></i>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{Session::get('success1')}}
                    </div>
                    @endif
                    <!-- fail message -->
                    @if(Session::has('fails1'))
                    <div class="alert alert-danger alert-dismissable">
                        <i class="fa fa-ban"></i>
                        <b>{!! Lang::get('lang.alert') !!}!</b>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{Session::get('fails1')}}
                    </div>
                    @endif
                    <div class="form-group {{ $errors->has('firstname') ? 'has-error' : '' }}">
                        <!-- first name -->
                        {!! Form::label('firstname',Lang::get('lang.firstname')) !!}
                        {!! $errors->first('firstname', '<spam class="help-block">:message</spam>') !!}
                        {!! Form::text('firstname',null,['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group {{ $errors->has('lastname') ? 'has-error' : '' }}">
                        <!-- last name -->
                        {!! Form::label('lastname',Lang::get('lang.lastname')) !!}
                        {!! $errors->first('lastname', '<spam class="help-block">:message</spam>') !!}
                        {!! Form::text('lastname',null,['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <!-- gender -->
                        {!! Form::label('gender',Lang::get('lang.gender')) !!}
                        <div class="row">
                            <div class="col-xs-3">
                                {!! Form::radio('gender','1',true) !!}{{Lang::get('lang.male')}}
                            </div>
                            <div class="col-xs-3">
                                {!! Form::radio('gender','0') !!}{{Lang::get('lang.female')}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- email -->
                        {!! Form::label('email',Lang::get('lang.email')) !!}
                        <div>
                            {{$user->email}}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('company') ? 'has-error' : '' }}">
                        <!-- company -->
                        {!! Form::label('company',Lang::get('lang.company')) !!}
                        {!! $errors->first('company', '<spam class="help-block">:message</spam>') !!}
                        {!! Form::text('company',null,['class' => 'form-control']) !!}
                    </div>
                    <div class="row">
                        <div class="col-xs-3 form-group {{ $errors->has('ext') ? 'has-error' : '' }}">
                            <!-- phone extensionn -->
                            {!! Form::label('ext',Lang::get('lang.ext')) !!}
                            {!! $errors->first('ext', '<spam class="help-block">:message</spam>') !!}
                            {!! Form::text('ext',null,['class' => 'form-control']) !!}
                        </div>
                        <div class="col-xs-9 form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                            <!-- phone number -->
                            {!! Form::label('phone_number',Lang::get('lang.phone')) !!}
                            {!! $errors->first('phone_number', '<spam class="help-block">:message</spam>') !!}
                            {!! Form::text('phone_number',null,['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
                        <!-- mobile -->
                        {!! Form::label('mobile',Lang::get('lang.mobile')) !!}
                        {!! $errors->first('mobile', '<spam class="help-block">:message</spam>') !!}
                        {!! Form::text('mobile',null,['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group {{ $errors->has('profile_pic') ? 'has-error' : '' }}" >
                        <!-- profile pic -->
                        <div class="btn btn-default btn-file">
                            {!! Form::label('profile_pic',Lang::get('lang.profilepicture')) !!}
                            {!! $errors->first('profile_pic', '<spam class="help-block">:message</spam>') !!}
                            {!! Form::file('profile_pic') !!}
                        </div>
                    </div>
                    {!! Form::token() !!}
                    {!! Form::close() !!}
                </div>
                <div class="box-footer">
                    {!! Form::submit(Lang::get('lang.update'),['class'=>'btn btn-primary'])!!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            {!! Form::model($user,['url'=>'client-profile-password' , 'method' => 'PATCH']) !!}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4>{!! Lang::get('lang.change_password') !!}	{!! Form::submit(Lang::get('lang.update'),['class'=>'form-group btn btn-primary pull-right'])!!}</h4>
                </div>
                <div class="box-body">
                    @if(Session::has('success2'))
                    <div class="alert alert-success alert-dismissable">
                        <i class="fa fa-ban"></i>
                        <b>Alert!</b> Success.
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{Session::get('success2')}}
                    </div>
                    @endif
                    <!-- fail message -->
                    @if(Session::has('fails2'))
                    <div class="alert alert-danger alert-dismissable">
                        <i class="fa fa-ban"></i>
                        <b>Alert!</b> Failed.
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{Session::get('fails2')}}
                    </div>
                    @endif
                    <!-- old password -->
                    <div class="form-group has-feedback {{ $errors->has('old_password') ? 'has-error' : '' }}">
                        {!! Form::label('old_password',Lang::get('lang.oldpassword')) !!}
                        {!! Form::password('old_password',['placeholder'=>'Password','class' => 'form-control']) !!}
                        {!! $errors->first('old_password', '<spam class="help-block">:message</spam>') !!}
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <!-- new password -->
                    <div class="form-group has-feedback {{ $errors->has('new_password') ? 'has-error' : '' }}">
                        {!! Form::label('new_password',Lang::get('lang.newpassword')) !!}
                        {!! Form::password('new_password',['placeholder'=>'New Password','class' => 'form-control']) !!}
                        {!! $errors->first('new_password', '<spam class="help-block">:message</spam>') !!}
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <!-- cofirm password -->
                    <div class="form-group has-feedback {{ $errors->has('confirmpassword') ? 'has-error' : '' }}">
                        {!! Form::label('confirm_password',Lang::get('lang.confirm_password')) !!}
                        {!! Form::password('confirm_password',['placeholder'=>'Confirm Password','class' => 'form-control']) !!}
                        {!! $errors->first('confirm_password', '<spam class="help-block">:message</spam>') !!}
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>

                </div>
            </div>
        </div>
    </div>


    {!! Form::close() !!}
</div>
@stop