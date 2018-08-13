@extends('themes.default1.agent.layout.agent')
@extends('themes.default1.agent.layout.sidebar')    

@section('content')

    <div class="row">
    <div class="col-md-6">

{!! Form::model($user,['url'=>'post-profile' , 'method' => 'PATCH','files'=>true]) !!}

<div class="box box-primary">

	<div class="content-header">

	 	<h4>Profile	{!! Form::submit('Save',['class'=>'form-group btn btn-primary pull-right'])!!}</h4>

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

    <div class="row">
		<div class="form-group col-md-6 {{ $errors->has('firstname') ? 'has-error' : '' }}">

			{!! Form::label('firstname',Lang::get('lang.firstname')) !!}
			{!! $errors->first('firstname', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('firstname',null,['class' => 'form-control']) !!}

		</div>
		<div class="form-group col-md-6 {{ $errors->has('lastname') ? 'has-error' : '' }}">

			{!! Form::label('lastname',Lang::get('lang.lastname')) !!}
			{!! $errors->first('lastname', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('lastname',null,['class' => 'form-control']) !!}

		</div>
	</div>

		<div class="row">

		<div class="form-group col-md-6">
			{!! Form::label('gender',Lang::get('lang.gender')) !!}
			<div class="row">
				<div class="col-xs-6">
					{!! Form::radio('gender','1',true) !!}{{Lang::get('lang.male')}}
				</div>
				<div class="col-xs-6">
					{!! Form::radio('gender','0') !!}{{Lang::get('lang.female')}}
				</div>
			</div>
		</div>

		<div class="col-md-6 form-group">

                        {!! Form::label('timezone',Lang::get('lang.timezone')) !!}
                        {!!Form::select('timezone',$time->pluck('location','name') ,null,['class' => 'form-control select']) !!}

                    </div>

		</div>



		<div class="form-group">

			{!! Form::label('email',Lang::get('lang.email')) !!}
			<div>
				{{$user->email}}
			</div>
		</div>

		<div class="form-group {{ $errors->has('company') ? 'has-error' : '' }}">

			{!! Form::label('company',Lang::get('lang.company')) !!}
			{!! $errors->first('company', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('company',null,['class' => 'form-control']) !!}

		</div>

		<div class="row">
			<div class="col-xs-3 form-group {{ $errors->has('ext') ? 'has-error' : '' }}">

				{!! Form::label('ext',Lang::get('lang.ext')) !!}
				{!! $errors->first('ext', '<spam class="help-block">:message</spam>') !!}
				{!! Form::text('ext',null,['class' => 'form-control']) !!}

			</div>

			<div class="col-xs-9 form-group {{ $errors->has('phone_number') ? 'has-error' : '' }}">

				{!! Form::label('phone_number',Lang::get('lang.phone')) !!}
				{!! $errors->first('phone_number', '<spam class="help-block">:message</spam>') !!}
				{!! Form::text('phone_number',null,['class' => 'form-control']) !!}

			</div>
		</div>

			<div class="form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">

				{!! Form::label('mobile',Lang::get('lang.mobile')) !!}
				{!! $errors->first('mobile', '<spam class="help-block">:message</spam>') !!}
				{!! Form::text('mobile',null,['class' => 'form-control']) !!}

			</div>


	<div class="form-group {{ $errors->has('profile_pic') ? 'has-error' : '' }}">
	<div class="btn btn-default btn-file">
		{!! Form::label('profile_pic',Lang::get('lang.profilepicture')) !!}
		{!! $errors->first('profile_pic', '<spam class="help-block">:message</spam>') !!}
		{!! Form::file('profile_pic') !!}
	</div>
	</div>

	{!! Form::token() !!}
	{!! Form::close() !!}
</div>
</div>
</div>
<div class="col-md-6">

    {!! Form::model($user,['url'=>'post-profile-password/'.$user->id, 'method' => 'PATCH']) !!}

<div class="box box-primary">

	<div class="content-header">

	 	<h4>Change Password	{!! Form::submit('Save',['class'=>'form-group btn btn-primary pull-right'])!!}</h4>

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

	<div class="form-group has-feedback {{ $errors->has('old_password') ? 'has-error' : '' }}">
			{!! Form::label('old_password',Lang::get('lang.oldpassword')) !!}
            {!! Form::password('old_password',['placeholder'=>'Password','class' => 'form-control']) !!}
			{!! $errors->first('old_password', '<spam class="help-block">:message</spam>') !!}
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>

    <div class="form-group has-feedback {{ $errors->has('new_password') ? 'has-error' : '' }}">
    		{!! Form::label('new_password',Lang::get('lang.newpassword')) !!}
            {!! Form::password('new_password',['placeholder'=>'New Password','class' => 'form-control']) !!}
			{!! $errors->first('new_password', '<spam class="help-block">:message</spam>') !!}
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>

    <div class="form-group has-feedback {{ $errors->has('confirm_password') ? 'has-error' : '' }}">
    		{!! Form::label('confirm_password',Lang::get('lang.confirmpassword')) !!}
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