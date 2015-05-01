@extends('themes.default1.layouts.blank')

@section('Staffs')
class="active"
@stop

@section('staffs-bar')
active
@stop

@section('departments')
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
{!! Form::open(array('action' => 'Admin\DepartmentController@store' , 'method' => 'post') )!!}

	<div class="box box-primary">
	<div class="content-header">

	 	<h4>Create	{!! Form::submit(Lang::get('lang.save'),['class'=>'form-group btn btn-primary pull-right'])!!}</h4>

	</div>

	<div class="box-body">

	<div class="row">

		<div class="col-xs-6 form-group {{ $errors->has('name') ? 'has-error' : '' }}">

			{!! Form::label('name',Lang::get('lang.name')) !!}
			{!! $errors->first('name', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('name',null,['class' => 'form-control']) !!}

		</div>

		<div class="col-xs-6 form-group {{ $errors->has('account_status') ? 'has-error' : '' }}">

			{!! Form::label('type',Lang::get('lang.type')) !!}
			{!! $errors->first('account_status', '<spam class="help-block">:message</spam>') !!}

			<div class="row">
				<div class="col-xs-2">
					{!! Form::radio('type','1',true) !!}{{Lang::get('lang.public')}}
				</div>
				<div class="col-xs-3">
					{!! Form::radio('type','0',null) !!}{{Lang::get('lang.private')}}
				</div>
			</div>

		</div>
	</div>

		<div class="row">

			<div class="col-xs-6 form-group {{ $errors->has('sla') ? 'has-error' : '' }}">

				{!! Form::label('sla',Lang::get('lang.SLA_plan')) !!}
				{!! $errors->first('sla', '<spam class="help-block">:message</spam>') !!}
				{!!Form::select('sla', ['SLA Plans'=>$slas->lists('grace_period','grace_period')],null,['class' => 'form-control select']) !!}

			</div>

			<div class="col-xs-6 form-group {{ $errors->has('manager') ? 'has-error' : '' }}">

				{!! Form::label('manager',Lang::get('lang.manager')) !!}
				{!! $errors->first('manager', '<spam class="help-block">:message</spam>') !!}
				{!!Form::select('manager',[''=>'Select a Manager','Managers'=>$user->lists('user_name','user_name')],null,['class' => 'form-control select']) !!}

			</div>

		</div>

				<div class="form-group">

						{!! Form::label('ticket_assignment',Lang::get('lang.ticket_assignment')) !!}<br/>
						{!! Form::checkbox('ticket_assignment',1,null,['class' => 'form-control']) !!}
						{{Lang::get('lang.restrict_ticket_assignment_to_department_members')}}

				</div>


		<div class="row">

			<div class="col-xs-6 form-group {{ $errors->has('outgoing_email') ? 'has-error' : '' }}">

				{!! Form::label('outgoing_email',Lang::get('lang.outgoing_emails')) !!}
				{!! $errors->first('outgoing_email', '<spam class="help-block">:message</spam>') !!}
				{!!Form::select('outgoing_email', [''=>'Select an Email','Outgoing Emails'=>$emails->lists('email_address','email_address')],null,['class' => 'form-control select']) !!}

			</div>

			<div class="col-xs-6 form-group {{ $errors->has('template_set') ? 'has-error' : '' }}">

				{!! Form::label('template_set',Lang::get('lang.template_set')) !!}
				{!! $errors->first('template_set', '<spam class="help-block">:message</spam>') !!}
				{!!Form::select('template_set', [''=>'Select a Template','Templates'=>$templates->lists('name','name')],null,['class' => 'form-control select']) !!}

			</div>

		</div>

		<div class='form-group'>

			<div class="row">

				<div class="col-xs-6">
					{!! Form::label('auto_ticket_response',Lang::get('lang.auto_responding_settings')) !!}<br>
					{!! Form::checkbox('auto_ticket_response',1,null,['class' => 'checkbox']) !!}
					{{Lang::get('lang.disable_for_this_department')}}

				</div>



				<div class="col-xs-6">
					{!! Form::label('auto_message_response',Lang::get('lang.new_message')) !!}<br>
					{!! Form::checkbox('auto_message_response',1,null,['class' => 'checkbox']) !!}
					{{Lang::get('lang.disable_for_this_department')}}

				</div>

			</div>


		</div>

		<div class="row">

			<div class="col-xs-6 form-group {{ $errors->has('auto_response_email') ? 'has-error' : '' }}">

				{!! Form::label('auto_response_email',Lang::get('lang.auto_response_email')) !!}
				{!! $errors->first('auto_response_email', '<spam class="help-block">:message</spam>') !!}
				{!!Form::select('auto_response_email', [''=>'Select a Email','Auto-Response Email'=>$emails->lists('email_address','email_address')],null,['class' => 'form-control select']) !!}

			</div>


			<div class="col-xs-6 form-group {{ $errors->has('recipient') ? 'has-error' : '' }}">

				{!! Form::label('recipient',Lang::get('lang.recipient')) !!}
				{!! $errors->first('recipient', '<spam class="help-block">:message</spam>') !!}
				{!!Form::select('recipient',['No One','Department Members','Department and Group Members'],2,['class' => 'form-control select']) !!}

			</div>

		</div>

			<div class="{{ $errors->has('group_id') ? 'has-error' : '' }}">

				<h4>{{Lang::get('lang.group_access')}}</h4>
				{!! $errors->first('group_id', '<spam class="help-block" style="color:red">Assign Group is Required</spam>') !!}

			</div>

			@while (list($key, $val) = each($groups))
				<div class="form-group">
					<input type="checkbox" name="group_id[]" value="<?php echo $val;?>" class="form-control"  >
					<label><?php echo $key;?></label>
				</div>
			@endwhile

			<div>

				<h4>{{Lang::get('lang.department_signature')}}</h4>

			</div>

			<div class="">

				{!! Form::textarea('department_sign',null,['class' => 'form-control','size' => '30x5']) !!}

			</div>

{!!Form::close()!!}
</div>
</div>
</div>
@section('FooterInclude')

@stop
@stop
<!-- /content -->



