@extends('themes.default1.admin.layout.admin')


@section('Emails')
class="active"
@stop

@section('emails-bar')
active
@stop

@section('ban')
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

{!! Form::open(['action' => 'Admin\helpdesk\BanlistController@store','method' => 'POST']) !!}

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
        <b>Fail!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('fails')}}
    </div>
    @endif

<div class="row">
<div class="col-md-12">
<div class="box box-primary">
<div class="box-header">
	<h3 class="box-title">{{Lang::get('lang.ban_email')}}</h3>
	<div class="pull-right">
	{!! Form::submit(Lang::get('lang.save'),['class'=>'btn btn-primary'])!!}</div>
	</div>
		<!-- Ban Status : Radio form : Required -->
		 <div class="box-body table-responsive"style="overflow:hidden;">
             <div class="row">
               <div class="col-md-6">
		       <div class="form-group {{ $errors->has('ban') ? 'has-error' : '' }}">
			{!! Form::label('ban',Lang::get('lang.ban_status')) !!}
			<div class="row">
				<div class="col-xs-3">
					{!! Form::radio('ban',1) !!}{{Lang::get('lang.active')}}
				</div>
				<div class="col-xs-3">
					{!! Form::radio('ban',0) !!}{{Lang::get('lang.disabled')}}
				</div>
			</div>
		</div>

		<!-- email Address : Text form : Required -->

		<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
			{!! Form::label('email',Lang::get('lang.email_address')) !!}
			{!! $errors->first('email', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('email',null,['class' => 'form-control']) !!}

		</div>

		<!-- intrnal Notes : Textarea :  -->

		<div class="form-group">
			{!! Form::label('internal_note',Lang::get('lang.internal_notes')) !!}
			{!! Form::textarea('internal_note',null,['class' => 'form-control']) !!}
		</div>

		</div>
		</div>
		</div>
		</div>
		</div>
		</div>

@stop
