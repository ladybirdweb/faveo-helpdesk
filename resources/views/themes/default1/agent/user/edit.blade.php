@extends('themes.default1.layouts.agent')

@section('Users')
class="active"
@stop

@section('user-bar')
active
@stop

@section('user')
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

{!! Form::model($users,['url'=>'user/'.$users->id,'method'=>'PATCH']) !!}

<div class="box box-primary">
	<div class="content-header">

	 	<h4>{{Lang::get('lang.edit')}}	{!! Form::submit(Lang::get('lang.save'),['class'=>'form-group btn btn-primary pull-right'])!!}</h4>

	</div>

	<div class="box-body">

<!-- Email Address : Email : Required -->

	<div class="row">

		<div class="col-xs-4 form-group {{ $errors->has('email') ? 'has-error' : '' }}">

			{!! Form::label('email',Lang::get('lang.email')) !!}
			{!! $errors->first('email', '<spam class="help-block">:message</spam>') !!}
			{!! Form::email('email',null,['class' => 'form-control']) !!}

		</div>



<!-- Full Name : Text : Required-->

		<div class="col-xs-4 form-group {{ $errors->has('full_name') ? 'has-error' : '' }}">

			{!! Form::label('full_name',Lang::get('lang.full_name')) !!}
			{!! $errors->first('full_name', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('full_name',null,['disabled'=>'disabled','class' => 'form-control']) !!}

		</div>

<!-- Phone Number : Text :  -->

		<div class="col-xs-4 form-group {{ $errors->has('phone') ? 'has-error' : '' }}">

			{!! Form::label('phone',Lang::get('lang.phone')) !!}
			{!! $errors->first('phone', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('phone',null,['class' => 'form-control']) !!}

		</div>

	</div>

<!-- Internal Notes : Textarea -->

		<div class="form-group">

			{!! Form::label('internal_notes',Lang::get('lang.internal_notes')) !!}
			{!! Form::textarea('internal_notes',null,['class' => 'form-control']) !!}

		</div>

</div>
</div>


@section('FooterInclude')

@stop
@stop
<!-- /content -->
@stop
@section('FooterInclude')

@stop

<!-- /content -->