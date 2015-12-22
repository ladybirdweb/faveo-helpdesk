@extends('themes.default1.admin.layout.admin')

@section('Staffs')
class="active"
@stop

@section('staffs-bar')
active
@stop

@section('staffs')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')


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
	<div class="content-header">

	 	<h4>Create	{!! Form::submit(Lang::get('lang.save'),['class'=>'form-group btn btn-primary pull-right'])!!}</h4>

	</div>

	<div class="box-body">

	<div class="row">
	<!-- username -->
		<div class="col-xs-4 form-group {{ $errors->has('user_name') ? 'has-error' : '' }}">

			{!! Form::label('user_name',Lang::get('lang.user_name')) !!}
			{!! $errors->first('user_name', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('user_name',null,['class' => 'form-control']) !!}

		</div>
	<!-- firstname -->
		<div class="col-xs-4 form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">

			{!! Form::label('first_name',Lang::get('lang.first_name')) !!}
			{!! $errors->first('first_name', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('first_name',null,['class' => 'form-control']) !!}

		</div>
	<!-- lastname -->
		<div class="col-xs-4 form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">

			{!! Form::label('last_name',Lang::get('lang.last_name')) !!}
			{!! $errors->first('last_name', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('last_name',null,['class' => 'form-control']) !!}

		</div>

	</div>

	<div class="row">
	<!-- email address -->
		<div class="col-xs-4 form-group {{ $errors->has('email') ? 'has-error' : '' }}">

			{!! Form::label('email',Lang::get('lang.email_address')) !!}
			{!! $errors->first('email', '<spam class="help-block">:message</spam>') !!}
			{!! Form::email('email',null,['class' => 'form-control']) !!}

		</div>

		<div class="col-xs-1 form-group {{ $errors->has('ext') ? 'has-error' : '' }}">

			<label for="ext">{!! Lang::get('lang.ext') !!}</label>	
			{!! $errors->first('ext', '<spam class="help-block">:message</spam>') !!}			
			{!! Form::text('ext',null,['class' => 'form-control']) !!}

		</div>

	<!-- phone -->
		<div class="col-xs-3 form-group {{ $errors->has('phone_number') ? 'has-error' : '' }}">

			{!! Form::label('phone_number',Lang::get('lang.phone')) !!}
			{!! $errors->first('phone_number', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('phone_number',null,['class' => 'form-control']) !!}

		</div>
		
	<!-- Mobile -->
		<div class="col-xs-4 form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">

			{!! Form::label('mobile',Lang::get('lang.mobile_number')) !!}
			{!! $errors->first('mobile', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('mobile',null,['class' => 'form-control']) !!}

		</div>

	</div>

		<div>

			<h4>{{Lang::get('lang.agent_signature')}}</h4>

		</div>

		<div class="">

			{!! Form::textarea('agent_sign',null,['class' => 'form-control','size' => '30x5']) !!}

		</div>


		<div>
			<h4>{{Lang::get('lang.account_status_setting')}}</h4>
		</div>
	<div class="row">
	<div class="col-xs-6">
	<!-- Role -->
		<div class="form-group {{ $errors->has('role') ? 'has-error' : '' }}">

			{!! Form::label('role',Lang::get('lang.role')) !!}
			{!! $errors->first('role', '<spam class="help-block">:message</spam>') !!}
			<div class="row">
				<div class="col-xs-3">
					{!! Form::radio('role','admin',true) !!}{{Lang::get('lang.admin')}}
				</div>
				<div class="col-xs-3">
					{!! Form::radio('role','agent',null) !!}{{Lang::get('lang.agent')}}
				</div>
			</div>
		</div>
	<!-- account type -->
		<div class="form-group {{ $errors->has('account_type') ? 'has-error' : '' }}">

			{!! Form::label('account_type',Lang::get('lang.account_type')) !!}
			{!! $errors->first('account_type', '<spam class="help-block">:message</spam>') !!}
			<div class="row">
				<div class="col-xs-3">
					{!! Form::radio('account_type','1',true) !!}{{Lang::get('lang.active')}}
				</div>
				<div class="col-xs-3">
					{!! Form::radio('account_type','0',null) !!}{{Lang::get('lang.locked')}}
				</div>
			</div>

		</div>
		</div>

		<div class="col-xs-6">
		
		</div>
	</div>

	<div class="row">
	<!-- assigned group -->
		<div class="col-xs-4 form-group {{ $errors->has('assign_group') ? 'has-error' : '' }}">

			{!! Form::label('assign_group',Lang::get('lang.assigned_group')) !!}
			{!! $errors->first('assign_group', '<spam class="help-block">:message</spam>') !!}
			{!!Form::select('assign_group',[''=>'Select a Group','Groups'=>$groups->lists('name','name')],null,['class' => 'form-control select']) !!}

		</div>

	<!-- primary dept -->
		<div class="col-xs-4 form-group {{ $errors->has('primary_dpt') ? 'has-error' : '' }}">

			{!! Form::label('primary_dpt',Lang::get('lang.primary_department')) !!}
			{!! $errors->first('primary_dpt', '<spam class="help-block">:message</spam>') !!}
			{!!Form::select('primary_dpt', [''=>'Select a Department','Departments'=>$departments->lists('name','name')],null,['class' => 'form-control select']) !!}

		</div>

	<!-- timezone -->
		<div class="col-xs-4 form-group {{ $errors->has('agent_tzone') ? 'has-error' : '' }}">

			{!! Form::label('agent_tzone',Lang::get('lang.agent_time_zone')) !!}
			{!! $errors->first('agent_tzone', '<spam class="help-block">:message</spam>') !!}
			{!! Form::select('agent_tzone', [''=>'Select a Time Zone', 'Time Zones'=>$timezones->lists('name','name')],null,['class' => 'form-control select']) !!}

		</div>
	</div>

		<!-- Assign team -->

			<div class="{{ $errors->has('team_id') ? 'has-error' : '' }}">
				<h4>{{Lang::get('lang.assigned_team')}}</h4>
			{!! $errors->first('team_id', '<spam class="help-block">Assign Team is Required</spam>') !!}

			</div>

			@while (list($key, $val) = each($teams))
			<div class="form-group ">
			<input type="checkbox" name="team_id[]" value="<?php echo $val;?>"  > <?php echo $key;?><br/>
			</div>
			@endwhile

</div>
@stop
@section('FooterInclude')

@stop

<!-- /content -->

