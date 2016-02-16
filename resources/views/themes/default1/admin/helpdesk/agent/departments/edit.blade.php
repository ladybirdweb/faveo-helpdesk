@extends('themes.default1.admin.layout.admin')

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
{!!Form::model($departments, ['url'=>'departments/'.$departments->id , 'method'=> 'PATCH'])!!}

	<div class="box box-primary">
	<div class="box-header">

	 	<h4 class="box-title">{!! Lang::get('lang.edit') !!}</h4>	{!! Form::submit(Lang::get('lang.save'),['class'=>'form-group btn btn-primary pull-right'])!!}

	</div>

	<div class="box-body">

	<div class="row">
		<!-- name -->
		<div class="col-xs-6 form-group {{ $errors->has('name') ? 'has-error' : '' }}">

			{!! Form::label('name',Lang::get('lang.name')) !!}
			{!! $errors->first('name', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('name',null,['disabled'=>'disabled','class' => 'form-control']) !!}

		</div>
		<!-- account status -->
		<div class="col-xs-6 form-group {{ $errors->has('account_status') ? 'has-error' : '' }}">

			{!! Form::label('type',Lang::get('lang.type')) !!}
			{!! $errors->first('account_status', '<spam class="help-block">:message</spam>') !!}

			<div class="row">
				<div class="col-xs-2">
					{!! Form::radio('type','1',true) !!} {{Lang::get('lang.public')}}
				</div>
				<div class="col-xs-3">
					{!! Form::radio('type','0',null) !!} {{Lang::get('lang.private')}}
				</div>
			</div>

		</div>
	</div>
		<div class="row">
		<!-- sla -->
			<div class="col-xs-6 form-group {{ $errors->has('sla') ? 'has-error' : '' }}">

				{!! Form::label('sla',Lang::get('lang.SLA_plan')) !!}
				{!! $errors->first('sla', '<spam class="help-block">:message</spam>') !!}
				{!!Form::select('sla', ['SLA Plans'=>$slas->lists('grace_period','id')],null,['class' => 'form-control select']) !!}

			</div>
			<!-- manager -->
			<div class="col-xs-6 form-group {{ $errors->has('manager') ? 'has-error' : '' }}">

				{!! Form::label('manager',Lang::get('lang.manager')) !!}
				{!! $errors->first('manager', '<spam class="help-block">:message</spam>') !!}
				{!!Form::select('manager',[null=>'Select a Manager','Managers'=>$user->lists('user_name','id')],null,['class' => 'form-control select']) !!}

			</div>

		</div>

<hr>

<h4>Outgoing Email Settings</h4>
<br/>

		<div class="row">
		<!-- sla -->
			<div class="col-xs-6 form-group {{ $errors->has('outgoing_email') ? 'has-error' : '' }}">

				{!! Form::label('outgoing_email',Lang::get('lang.outgoing_email')) !!}
				{!! $errors->first('outgoing_email', '<spam class="help-block">:message</spam>') !!}
				{!!Form::select('outgoing_email', ['' => 'System Default', 'Emails'=>$emails->lists('email_name','id')],null,['class' => 'form-control select']) !!}

			</div>

		</div>

	{!!Form::close()!!}
	</div>
</div>

@stop