@extends('themes.default1.layouts.admin')


@section('Emails')
class="active"
@stop

@section('emails-bar')
active
@stop

@section('smtp')
class="active"
@stop

@section('HeadInclude')
@stop

<!-- /breadcrumbs -->
<!-- content -->
@section('content')

@if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <i class="fa  fa-check-circle"></i>
        <b>Success!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('success')}}
    </div>
    @endif
    <!-- failure message -->
    @if(Session::has('fails'))
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <b>Alert!</b> Failed.
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('fails')}}
    </div>
    @endif

<form action="{!! URL::route('post_smtp') !!}" method="post">
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title">{{Lang::get('lang.smtp')}}</h3>
		<div class="pull-right">
			{!! Form::submit(Lang::get('lang.save'),['class'=>'btn btn-primary'])!!}
		</div>
	</div>
		<!-- Ban Status : Radio form : Required -->
	<div class="box-body table-responsive"style="overflow:hidden;">
		<div class="row">
			<!-- email Address : Text form : Required -->

			<div class="col-md-4 form-group {{ $errors->has('host') ? 'has-error' : '' }}">
				{!! Form::label('host',Lang::get('lang.host')) !!}
				{!! $errors->first('host', '<spam class="help-block">:message</spam>') !!}
				{!! Form::text('host',null,['class' => 'form-control']) !!}
			</div>

			<div class="col-md-4 form-group {{ $errors->has('port') ? 'has-error' : '' }}">
				{!! Form::label('port',Lang::get('lang.port')) !!}
				{!! $errors->first('port', '<spam class="help-block">:message</spam>') !!}
				{!! Form::text('port',null,['class' => 'form-control']) !!}
			</div>

			<div class="col-md-4 form-group {{ $errors->has('encryption') ? 'has-error' : '' }}">
				{!! Form::label('encryption',Lang::get('lang.encryption')) !!}
				{!! $errors->first('encryption', '<spam class="help-block">:message</spam>') !!}
				{!! Form::text('encryption',null,['class' => 'form-control']) !!}
			</div>

			<div class="col-md-4 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
				{!! Form::label('name',Lang::get('lang.name')) !!}
				{!! $errors->first('name', '<spam class="help-block">:message</spam>') !!}
				{!! Form::text('name',null,['class' => 'form-control']) !!}
			</div>

			<div class="col-md-4 form-group {{ $errors->has('email') ? 'has-error' : '' }}">
				{!! Form::label('email',Lang::get('lang.email')) !!}
				{!! $errors->first('email', '<spam class="help-block">:message</spam>') !!}
				{!! Form::text('email',null,['class' => 'form-control']) !!}
			</div>

			<div class="col-md-4 form-group {{ $errors->has('password') ? 'has-error' : '' }}">
				{!! Form::label('password',Lang::get('lang.password')) !!}
				{!! $errors->first('password', '<spam class="help-block">:message</spam>') !!}
				{!! Form::text('password',null,['class' => 'form-control']) !!}
			</div>
		</div>

	</div>
</div>
		
@stop