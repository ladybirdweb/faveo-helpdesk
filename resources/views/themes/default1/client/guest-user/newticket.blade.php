@extends('themes.default1.layouts.blank')
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

	{!! Form::model($ticket,array('url' => 'postcheck' , 'method' => 'post') )!!}


<div class="box box-primary">
	<div class="content-header">

	 	<h4>New Ticket	{!! Form::submit(Lang::get('lang.send'),['class'=>'form-group btn btn-primary pull-right'])!!}</h4>

	</div>

	<div class="box-body">

	@if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <i class="fa  fa-check-circle"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('success')}}
    </div>
    @endif
    <!-- failure message -->
    @if(Session::has('fails'))
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('fails')}}
    </div>
    @endif


	<div class="row">
		<div class="col-xs-6 form-group {{ $errors->has('email') ? 'has-error' : '' }}">
			<!-- email -->
			{!! Form::label('email',Lang::get('lang.email')) !!}
			{!! $errors->first('email', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('email',null,['class' => 'form-control']) !!}

		</div>

		<div class="col-xs-6 form-group {{ $errors->has('ticket_number') ? 'has-error' : '' }}">
			<!-- ticket number -->
			{!! Form::label('ticket_number',Lang::get('lang.ticket_number')) !!}
			{!! $errors->first('ticket_number', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('ticket_number',null,['class' => 'form-control']) !!}

		</div>
	</div>


<!-- open a form -->
@stop