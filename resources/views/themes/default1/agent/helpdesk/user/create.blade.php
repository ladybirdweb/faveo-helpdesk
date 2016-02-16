@extends('themes.default1.agent.layout.agent')


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

{!! Form::open(['action'=>'Agent\helpdesk\UserController@store','method'=>'post']) !!}

<div class="box box-primary">
	<div class="content-header">

	 	<h4>{!! Lang::get('lang.create') !!}	{!! Form::submit(Lang::get('lang.save'),['class'=>'form-group btn btn-primary pull-right'])!!}</h4>

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
			{!! Form::text('full_name',null,['class' => 'form-control']) !!}

		</div>

<!-- mobile Number : Text :  -->

		<div class="col-md-4 form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">

			{!! Form::label('mobile',Lang::get('lang.mobile')) !!}
			{!! $errors->first('mobile', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('mobile',null,['class' => 'form-control']) !!}

		</div>

		<div class="col-xs-1 form-group {{ $errors->has('ext') ? 'has-error' : '' }}">

			<label for="ext">{!! Lang::get('lang.ext') !!}</label>	
			{!! $errors->first('ext', '<spam class="help-block">:message</spam>') !!}			
			{!! Form::text('ext',null,['class' => 'form-control']) !!}

		</div>

		<div class="col-xs-5 form-group {{ $errors->has('phone_number') ? 'has-error' : '' }}">

			<label for="phone_number">{!! Lang::get('lang.phone') !!}</label>
			{!! $errors->first('phone_number', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('phone_number',null,['class' => 'form-control']) !!}

		</div>

		<div class="col-md-4 form-group {{ $errors->has('active') ? 'has-error' : '' }}">

			{!! Form::label('active',Lang::get('lang.status')) !!}
			{!! $errors->first('active', '<spam class="help-block">:message</spam>') !!}
			<div class="row">
				<div class="col-xs-12">
					{!! Form::radio('active','1',true) !!} {{Lang::get('lang.active')}}
				</div>
				<div class="col-xs-12">
					{!! Form::radio('active','0') !!} {{Lang::get('lang.inactive')}}
				</div>
			</div>

		</div>

	</div>

<!-- Internal Notes : Textarea -->

		<div class="form-group">

			{!! Form::label('internal_note',Lang::get('lang.internal_notes')) !!}
			{!! Form::textarea('internal_note',null,['class' => 'form-control']) !!}

		</div>

</div>
</div>


                    <script>
                        $(function () {
                        	$("textarea").wysihtml5();
                        });
                    </script>


@stop
