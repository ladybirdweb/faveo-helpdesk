@extends('themes.default1.layouts.blank')

@section('Staffs')
class="active"
@stop

@section('staffs-bar')
active
@stop

@section('groups')
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

{!!Form::model($groups, ['url'=>'groups/'.$groups->id , 'method'=> 'PATCH'])!!}

	<div class="box box-primary">
	<div class="content-header">

	 	<h4>{{Lang::get('lang.create')}}	{!! Form::submit(Lang::get('lang.save'),['class'=>'form-group btn btn-primary pull-right'])!!}</h4>

	</div>

	<div class="box-body">

	<div class="row">

		<div class="col-xs-4 form-group {{ $errors->has('name') ? 'has-error' : '' }}">

			{!! Form::label('name',Lang::get('lang.name')) !!}
			{!! $errors->first('name', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('name',null,['disabled'=>'disabled','class' => 'form-control']) !!}

		</div>

		<div class="col-xs-6 form-group {{ $errors->has('group_status') ? 'has-error' : '' }}">

			{!! Form::label('group_status',Lang::get('lang.status')) !!}
			{!! $errors->first('group_status', '<spam class="help-block">:message</spam>') !!}
			<div class="row">
				<div class="col-xs-2">
					{!! Form::radio('group_status','1',true) !!}{{Lang::get('lang.enable')}}
				</div>
				<div class="col-xs-3">
					{!! Form::radio('group_status','0',null) !!}{{Lang::get('lang.disabled')}}
				</div>
			</div>
		</div>

	</div>


			<div class="row">
				{!! Form::label('can_create_ticket',Lang::get('lang.can_create_ticket')) !!}
				<div class="col-xs-1">
					{!! Form::checkbox('can_create_ticket',1,null,['class' => 'checkbox']) !!}
				</div>
			</div>





			<div class="row">
				{!! Form::label('can_edit_ticket',Lang::get('lang.can_edit_ticket')) !!}
				<div class="col-xs-1">
					{!! Form::checkbox('can_edit_ticket',1,null,['class' => 'checkbox']) !!}
				</div>
			</div>





			<div class="row">
				{!! Form::label('can_post_ticket',Lang::get('lang.can_post_ticket')) !!}
				<div class="col-xs-1">
					{!! Form::checkbox('can_post_ticket',1,null,['class' => 'checkbox']) !!}
				</div>
			</div>





			<div class="row">
				{!! Form::label('can_close_ticket',Lang::get('lang.can_close_ticket')) !!}
				<div class="col-xs-1">
					{!! Form::checkbox('can_close_ticket',1,null,['class' => 'checkbox']) !!}
				</div>
			</div>





			<div class="row">
				{!! Form::label('can_delete_ticket',Lang::get('lang.can_delete_ticket')) !!}
				<div class="col-xs-1">
					{!! Form::checkbox('can_delete_ticket',1,null,['class' => 'checkbox']) !!}
				</div>
			</div>





			<div class="row">
				{!! Form::label('can_assign_ticket',Lang::get('lang.can_assign_ticket')) !!}
				<div class="col-xs-1">
					{!! Form::checkbox('can_assign_ticket',1,null,['class' => 'checkbox']) !!}
				</div>
			</div>





			<div class="row">
				{!! Form::label('can_trasfer_ticket',Lang::get('lang.can_transfer_ticket')) !!}
				<div class="col-xs-1">
					{!! Form::checkbox('can_trasfer_ticket',1,null,['class' => 'checkbox']) !!}
				</div>
			</div>



			<div class="row">
				{!! Form::label('can_ban_email',Lang::get('lang.can_ban_emails')) !!}
				<div class="col-xs-1">
					{!! Form::checkbox('can_ban_email',1,null,['class' => 'checkbox']) !!}
				</div>
			</div>



			<div class="row">
				{!! Form::label('can_manage_canned',Lang::get('lang.can_manage_premade')) !!}
				<div class="col-xs-1">
					{!! Form::checkbox('can_manage_canned',1,null,['class' => 'checkbox']) !!}
				</div>
			</div>



			<div class="row">
				{!! Form::label('can_manage_faq',Lang::get('lang.can_manage_FAQ')) !!}
				<div class="col-xs-1">
					{!! Form::checkbox('can_manage_faq',1,null,['class' => 'checkbox']) !!}
				</div>
			</div>



			<div class="row">
				{!! Form::label('can_view_agent_stats',Lang::get('lang.can_view_agent_stats')) !!}
				<div class="col-xs-1">
					{!! Form::checkbox('can_view_agent_stats',1,null,['class' => 'checkbox']) !!}
				</div>
			</div>



			<div class="row">
				{!! Form::label('department_access',Lang::get('lang.department_access')) !!}
				<div class="col-xs-1">
					{!! Form::checkbox('department_access',1,null,['class' => 'checkbox']) !!}
				</div>
			</div>



		<div class="form-group">

			{!! Form::label('admin_notes',Lang::get('lang.admin_notes')) !!}
			{!! Form::textarea('admin_notes',null,['class' => 'form-control','size' => '30x5']) !!}

		</div>
</div>
</div>

{!!Form::close()!!}
@section('FooterInclude')

@stop
@stop
<!-- /content -->