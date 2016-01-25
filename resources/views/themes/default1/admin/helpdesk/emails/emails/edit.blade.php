@extends('themes.default1.admin.layout.admin')

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

	{!!Form::model($emails,['url'=>'emails/'.$emails->id,'method'=>'PATCH'])!!}
	<div class="box box-primary">
	<div class="box-header">

	 	<h4 class="box-title">{{Lang::get('lang.create')}}</h4>	{!! Form::submit(Lang::get('lang.save'),['class'=>'form-group btn btn-primary pull-right'])!!}

	</div>

	<div class="box-body">

	<div class="row">
	<!-- email address -->
		<div class="col-xs-6 form-group {{ $errors->has('email_address') ? 'has-error' : '' }}">

			{!! Form::label('email_address',Lang::get('lang.email_address')) !!}
			{!! $errors->first('email_address', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('email_address',null,['disabled'=>'disabled','class' => 'form-control']) !!}

		</div>
		<!-- email name -->
		<div class="col-xs-6 form-group {{ $errors->has('email_name') ? 'has-error' : '' }}">

			{!! Form::label('email_name',Lang::get('lang.email_name')) !!}
			{!! $errors->first('email_name', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('email_name',null,['class' => 'form-control']) !!}

		</div>

	</div>

	<div class="row">
	<!-- department -->
		<div class="col-xs-4 form-group {{ $errors->has('department') ? 'has-error' : '' }}">

			{!! Form::label('department',Lang::get('lang.department')) !!}
			{!! $errors->first('department', '<spam class="help-block">:message</spam>') !!}
			{!!Form::select('department', [''=>'Select a Department','departments'=>$departments->lists('name','id')],null,['class' => 'form-control select']) !!}

		</div>
		<!-- priority -->
		<div class="col-xs-4 form-group {{ $errors->has('priority') ? 'has-error' : '' }}">

			{!! Form::label('priority',Lang::get('lang.priority')) !!}
			{!! $errors->first('priority', '<spam class="help-block">:message</spam>') !!}
			{!!Form::select('priority', [''=>'Select a Priority','Priorities'=>$priority->lists('priority_desc','priority_id')],null,['class' => 'form-control select']) !!}

		</div>
		<!-- help topic -->
		<div class="col-xs-4 form-group {{ $errors->has('help_topic') ? 'has-error' : '' }}">

			{!! Form::label('help_topic',Lang::get('lang.help_topic')) !!}
			{!! $errors->first('help_topic', '<spam class="help-block">:message</spam>') !!}
			{!!Form::select('help_topic', [''=>'Select a Helptopic','Help Topics'=>$helps->lists('topic','id')],null,['class' => 'form-control select']) !!}
		</div>

	</div>
		<!-- auto response -->
		{{-- <div class="form-group"> --}}

			{{-- {!! Form::label('',Lang::get('lang.auto_response')) !!} --}}
			{{-- <div class="col-xs-1"> --}}
				{{-- {!! Form::checkbox('auto_response',1,null,['class' => 'checkbox']) !!} --}}
			{{-- </div> --}}
		{{-- </div> --}}
<hr>

	<div class="row">

		<div class="col-md-6 form-group">

			<h4>{!! Lang::get('lang.reuired_authentication') !!}</h4>

		</div>

	</div>

	<div class="row">

		<!-- password -->
		<div class="col-xs-6 form-group {{ $errors->has('password') ? 'has-error' : '' }}">

			{!! Form::label('password',Lang::get('lang.password')) !!}
			{!! $errors->first('password', '<spam class="help-block">:message</spam>') !!}
			<input type="password" name="password" value="<?php echo Crypt::decrypt($emails->password); ?>" class="form-control" >

		</div>

	</div>

<hr>

	<div class="row">

		<div class="col-md-6 form-group">

			<h4>{!! Lang::get('lang.fetching_email_via_imap_or_pop') !!}</h4>

		</div>

	</div>

	<div class="row">

		<div class="form-group">
		<!-- status -->
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

		<div class="col-xs-4 form-group">

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
			{!!Form::select('mailbox_protocol',['Mailbox Protocols'=>$mailbox_protocols->lists('name','id')],null,['class' => 'form-control select']) !!}

		</div>
		<!-- imap config -->
	</div>

		<!-- internal notes -->
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