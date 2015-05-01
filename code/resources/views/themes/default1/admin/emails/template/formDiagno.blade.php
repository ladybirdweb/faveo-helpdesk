@extends('themes.default1.layouts.blank')

@section('Emails')
class="active"
@stop

@section('emails-bar')
active
@stop

@section('diagno')
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

@stop
<!-- /breadcrumbs -->
<!-- content -->
@section('content')


{!! Form::open(['method'=>'post' , 'action'=>'Admin\TemplateController@postDiagno']) !!}


	<div class="box box-primary">
	<div class="content-header">

	<h4>{{Lang::get('lang.diagnostics')}}	{!! Form::submit(Lang::get('lang.send'),['class'=>'form-group btn btn-primary pull-right'])!!}</h4>

	</div>

	<div class="box-body">

		<!-- Form for define From Address : Drop down : required -->

		<div class="form-group {{ $errors->has('from') ? 'has-error' : '' }}">
			{!! Form::label('from',Lang::get('lang.from')) !!}
			{!! $errors->first('from', '<spam class="help-block">:message</spam>') !!}
			{!!Form::select('from', [''=>'Select a Email','Emails'=>$emails->lists('email_address','email_address')],null,['class' => 'form-control select']) !!}

		</div>



		<!-- To : define To Address : Text form : Required -->

		<div class="form-group {{ $errors->has('to') ? 'has-error' : '' }}">
			{!! Form::label('to',Lang::get('lang.to')) !!}
			{!! $errors->first('to', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('to',null,['class' => 'form-control']) !!}

		</div>

		<!-- Subject : define the Subject of the Mail : Text form : Required -->

		<div class="form-group {{ $errors->has('subject') ? 'has-error' : '' }}">
			{!! Form::label('subject',Lang::get('lang.subject')) !!}
			{!! $errors->first('subject', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('subject',null,['class' => 'form-control']) !!}

		</div>




		<!-- Email message to Send : Textarea :  -->

		<div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
			{!! Form::label('message',Lang::get('lang.message')) !!}
			{!! $errors->first('message', '<spam class="help-block">:message</spam>') !!}
			{!! Form::textarea('message',null,['class' => 'form-control']) !!}
		</div>



	</div>
	</div>



@stop
</div><!-- /.box -->
@section('FooterInclude')

@stop
@stop
<!-- /content -->
