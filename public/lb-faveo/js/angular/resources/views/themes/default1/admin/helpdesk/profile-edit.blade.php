@extends('themes.default1.admin.layout.admin')
@section('content')

    <div class="row">
    <div class="col-md-6">

{!! Form::model($user,['url'=>'admin-profile' , 'method' => 'PATCH','files'=>true]) !!}

<div class="box box-primary">

	<div class="content-header">

	 	<h4>Profile	{!! Form::submit(Lang::get('lang.save'),['class'=>'form-group btn btn-primary pull-right'])!!}</h4>

	</div>

<div class="box-body">

@if(Session::has('success'))
                    <div class="alert alert-success alert-dismissable">
                        <i class="fa fa-ban"></i>
                        <b>Alert!</b> Success.
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{Session::get('success')}}
                    </div>
                    @endif
                    <!-- fail message -->
                    @if(Session::has('fails'))
                    <div class="alert alert-danger alert-dismissable">
                        <i class="fa fa-ban"></i>
                        <b>Alert!</b> Failed.
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{Session::get('fails')}}
                    </div>
                    @endif

        <!-- first name -->
		<div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">

			{!! Form::label('first_name',Lang::get('lang.first_name')) !!}
			{!! $errors->first('first_name', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('first_name',null,['class' => 'form-control']) !!}

		</div>
		<!-- last name -->
		<div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">

			{!! Form::label('last_name',Lang::get('lang.last_name')) !!}
			{!! $errors->first('last_name', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('last_name',null,['class' => 'form-control']) !!}

		</div>
		<!-- gender -->
		<div class="form-group">
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

			{!! Form::label('email',Lang::get('lang.email_address')) !!}
			<div>
				{{$user->email}}
			</div>
		</div>
		<!-- company -->
		<div class="form-group {{ $errors->has('company') ? 'has-error' : '' }}">

			{!! Form::label('company',Lang::get('lang.company')) !!}
			{!! $errors->first('company', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('company',null,['class' => 'form-control']) !!}

		</div>

		<div class="row">
			<!-- phone extension -->
			<div class="col-xs-3 form-group {{ $errors->has('ext') ? 'has-error' : '' }}">

				{!! Form::label('ext',Lang::get('lang.ext')) !!}
				{!! $errors->first('ext', '<spam class="help-block">:message</spam>') !!}
				{!! Form::text('ext',null,['class' => 'form-control']) !!}

			</div>
			<!-- phone number -->
			<div class="col-xs-9 form-group {{ $errors->has('phone_number') ? 'has-error' : '' }}">

				{!! Form::label('phone_number',Lang::get('lang.phone')) !!}
				{!! $errors->first('phone_number', '<spam class="help-block">:message</spam>') !!}
				{!! Form::text('phone_number',null,['class' => 'form-control']) !!}

			</div>
		</div>
			<!-- mobile -->
			<div class="form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">

				{!! Form::label('mobile',Lang::get('lang.mobile_number')) !!}
				{!! $errors->first('mobile', '<spam class="help-block">:message</spam>') !!}
				{!! Form::input('number', 'mobile',null,['class' => 'form-control']) !!}

			</div>

	<!-- profile pic -->
	<div class="form-group {{ $errors->has('profile_pic') ? 'has-error' : '' }}">

		{!! Form::label('profile_pic',Lang::get('lang.profile_pic')) !!}
		{!! $errors->first('profile_pic', '<spam class="help-block">:message</spam>') !!}
		{!! Form::file('profile_pic') !!}

	</div>

	{!! Form::token() !!}
	{!! Form::close() !!}
</div>
</div>
</div>
<div class="col-md-6">

    {!! Form::model($user,['url'=>'admin-profile-password/'.$user->id , 'method' => 'PATCH']) !!}

<div class="box box-primary">

	<div class="content-header">

	 	<h4>Change Password	{!! Form::submit(Lang::get('lang.save'),['class'=>'form-group btn btn-primary pull-right'])!!}</h4>

	</div>

<div class="box-body">
					@if(Session::has('success'))
                    <div class="alert alert-success alert-dismissable">
                        <i class="fa fa-ban"></i>
                        <b>Alert!</b> Success.
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{Session::get('success')}}
                    </div>
                    @endif
                    <!-- fail message -->
                    @if(Session::has('fails'))
                    <div class="alert alert-danger alert-dismissable">
                        <i class="fa fa-ban"></i>
                        <b>Alert!</b> Failed.
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{Session::get('fails')}}
                    </div>
                    @endif
	<!-- old password -->
	<div class="form-group has-feedback {{ $errors->has('old_password') ? 'has-error' : '' }}">
			{!! Form::label('old_password',Lang::get('lang.old_password')) !!}
            {!! Form::password('old_password',['placeholder'=>'Password','class' => 'form-control']) !!}
			{!! $errors->first('old_password', '<spam class="help-block">:message</spam>') !!}
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <!-- new password -->
    <div class="form-group has-feedback {{ $errors->has('new_password') ? 'has-error' : '' }}">
    		{!! Form::label('new_password',Lang::get('lang.new_password')) !!}
            {!! Form::password('new_password',['placeholder'=>'New Password','class' => 'form-control']) !!}
			{!! $errors->first('new_password', '<spam class="help-block">:message</spam>') !!}
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <!-- confirm password -->
    <div class="form-group has-feedback {{ $errors->has('confirm_password') ? 'has-error' : '' }}">
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
@stop