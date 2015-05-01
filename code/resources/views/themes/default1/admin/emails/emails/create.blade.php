@extends('themes.default1.layouts.blank')

@section('Emails')
class="active"
@stop

@section('emails-bar')
active
@stop

@section('emails')
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

	{!!Form::open(['action'=>'Admin\EmailsController@store','method'=>'POST'])!!}
	<div class="box box-primary">
	<div class="content-header">

	 	<h4>{{Lang::get('lang.create')}}	{!! Form::submit(Lang::get('lang.save'),['class'=>'form-group btn btn-primary pull-right'])!!}</h4>

	</div>

	<div class="box-body">

	<div class="row">

		<div class="col-xs-6 form-group {{ $errors->has('email_address') ? 'has-error' : '' }}">

			{!! Form::label('email_address',Lang::get('lang.email_address')) !!}
			{!! $errors->first('email_address', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('email_address',null,['class' => 'form-control']) !!}

		</div>

		<div class="col-xs-6 form-group {{ $errors->has('email_name') ? 'has-error' : '' }}">

			{!! Form::label('email_name',Lang::get('lang.email_name')) !!}
			{!! $errors->first('email_name', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('email_name',null,['class' => 'form-control']) !!}

		</div>

	</div>

	<div class="row">

		<div class="col-xs-4 form-group {{ $errors->has('department') ? 'has-error' : '' }}">

			{!! Form::label('department',Lang::get('lang.department')) !!}
			{!! $errors->first('department', '<spam class="help-block">:message</spam>') !!}
			{!!Form::select('department', [''=>'Select a Department','departments'=>$departments->lists('name','name')],null,['class' => 'form-control select']) !!}

		</div>

		<div class="col-xs-4 form-group {{ $errors->has('priority') ? 'has-error' : '' }}">

			{!! Form::label('priority',Lang::get('lang.priority')) !!}
			{!! $errors->first('priority', '<spam class="help-block">:message</spam>') !!}
			{!!Form::select('priority', [''=>'Select a Priority','Priorities'=>$priority->lists('name','name')],null,['class' => 'form-control select']) !!}

		</div>

		<div class="col-xs-4 form-group {{ $errors->has('help_topic') ? 'has-error' : '' }}">

			{!! Form::label('help_topic',Lang::get('lang.help_topic')) !!}
			{!! $errors->first('help_topic', '<spam class="help-block">:message</spam>') !!}
			{!!Form::select('help_topic', [''=>'Select a Helptopic','Help Topics'=>$helps->lists('topic','topic')],null,['class' => 'form-control select']) !!}

		</div>

	</div>

		<div class="form-group">

			{!! Form::label('',Lang::get('lang.auto_response')) !!}
			<div class="col-xs-1">
				{!! Form::checkbox('auto_response',1,null,['class' => 'checkbox']) !!}
			</div>
		</div>

	<div class="row">

		<div class="col-xs-6 form-group {{ $errors->has('user_name') ? 'has-error' : '' }}">

			{!! Form::label('user_name',Lang::get('lang.user_name')) !!}
			{!! $errors->first('user_name', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('user_name',null,['class' => 'form-control']) !!}

		</div>

		<div class="col-xs-6 form-group {{ $errors->has('password') ? 'has-error' : '' }}">

			{!! Form::label('password',Lang::get('lang.password')) !!}
			{!! $errors->first('password', '<spam class="help-block">:message</spam>') !!}
			{!! Form::password('password',['class' => 'form-control']) !!}

		</div>

	</div>

	<div class="row">

		<div class="col-md-6 form-group">

			<h4>Fetching Email via IMAP or POP</h4>

		</div>

	</div>

	<div class="row">

		<div class="form-group">

			<div class="col-xs-1 form-group">
			{!! Form::label('fetching_status',Lang::get('lang.status')) !!}
			</div>
			<div class="col-xs-2 form-group">
			{!! Form::radio('fetching_status','1',true) !!}{{Lang::get('lang.enable')}}
			</div>
			<div class="col-xs-2 form-group">
			{!! Form::radio('fetching_status','0',null) !!}{{Lang::get('lang.disabled')}}
			</div>

		</div>

	</div>

	<div class="row">

		<!-- <div class="col-xs-4 form-group">

			{!! Form::label('fetching_host',Lang::get('lang.host_name')) !!}
			{!! Form::text('fetching_host',null,['class' => 'form-control']) !!}

		</div>

		<div class="col-xs-4 form-group">

			{!! Form::label('fetching_port',Lang::get('lang.port_number')) !!}
			{!! Form::text('fetching_port',null,['class' => 'form-control']) !!}

		</div>


		<div class="col-xs-4 form-group {{ $errors->has('mailbox_protocol') ? 'has-error' : '' }}">

			{!! Form::label('mailbox_protocol',Lang::get('lang.mail_box_protocol')) !!}
			{!! $errors->first('mailbox_protocol', '<spam class="help-block">:message</spam>') !!}
			{!!Form::select('mailbox_protocol', [''=>'Select a Mailbox Protocol','Mailbox Protocols'=>$mailbox_protocols->lists('name','name')],null,['class' => 'form-control select']) !!}

		</div> -->

		<div class="col-md-6 form-group {{ $errors->has('imap_config') ? 'has-error' : '' }}">

			{!! Form::label('imap_config',Lang::get('lang.imap_config')) !!}
			{!! $errors->first('imap_config', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('imap_config',null,['class' => 'form-control']) !!}

		</div>

	</div>

		<div class="row">

		<div class="col-md-6 form-group">

			<h4>Sending Email via SMTP</h4>

		</div>

	</div>

	<div class="row">

		<div class="form-group">

			<div class="col-xs-1 form-group">
			{!! Form::label('sending_status',Lang::get('lang.status')) !!}
			</div>
			<div class="col-xs-2 form-group">
			{!! Form::radio('sending_status','1',true) !!}{{Lang::get('lang.enable')}}
			</div>
			<div class="col-xs-2 form-group">
			{!! Form::radio('sending_status','0',null) !!}{{Lang::get('lang.disabled')}}
			</div>

		</div>

	</div>

	<div class="row">

		<div class="col-xs-6 form-group {{ $errors->has('sending_port') ? 'has-error' : '' }}">

			{!! Form::label('sending_port',Lang::get('lang.port_number')) !!}
			{!! $errors->first('sending_port', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('sending_port',null,['class' => 'form-control']) !!}

		</div>

		<div class="col-xs-6 form-group {{ $errors->has('sending_host') ? 'has-error' : '' }}">

			{!! Form::label('sending_host',Lang::get('lang.host_name')) !!}
			{!! $errors->first('sending_host', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('sending_host',null,['class' => 'form-control']) !!}

		</div>

	</div>

	<div class="row">

		<div class="form-group">

			<div class="col-xs-2 form-group">
			{!! Form::label('authentication',Lang::get('lang.authentication_required')) !!}
			</div>
			<div class="col-xs-2 form-group">
			{!! Form::radio('authentication','1',true) !!}{{Lang::get('lang.enable')}}
			</div>
			<div class="col-xs-2 form-group">
			{!! Form::radio('authentication','0',null) !!}{{Lang::get('lang.disabled')}}
			</div>

		</div>

		<div class="form-group">

			<div class="col-xs-2">

				{!! Form::label('',Lang::get('lang.header_spoofing')) !!}
				{!! Form::checkbox('header_spoofing',1,null,['class' => 'checkbox']) !!}

			</div>

		</div>

	</div>

		<div class="form-group">

			{!! Form::label('internal_notes',Lang::get('lang.internal_notes')) !!}
			{!! Form::textarea('internal_notes',null,['class' => 'form-control','size' => '30x5']) !!}

		</div>

	{!!Form::close()!!}

</div>
</div>
@stop
</div><!-- /.box -->
@section('FooterInclude')

@stop
@stop
<!-- /content -->