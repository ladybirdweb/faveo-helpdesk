@extends('themes.default1.agent.layout.agent')

@section('Tools')
class="active"
@stop

@section('tools-bar')
active
@stop

@section('tools')
class="active"
@stop

<!-- content -->
@section('content')

<!-- open a form -->

	{!! Form::model($canned, ['url' => 'canned/update/'.$canned->id,'method' => 'PATCH'] )!!}

	<!-- <section class="content"> -->
<div class="box box-primary">
	<div class="box-header">
	 <h3 class="box-title">Edit</h3>{!! Form::submit(Lang::get('lang.save'),['class'=>'form-group btn btn-primary pull-right'])!!}
	</div>
	<div class="box-body">

	<div class="row">
	<!-- username -->
		<div class="col-xs-6 form-group {{ $errors->has('title') ? 'has-error' : '' }}">

			{!! Form::label('title',Lang::get('lang.title')) !!}
			{!! $errors->first('title', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('title',null,['class' => 'form-control']) !!}

		</div>
	<!-- firstname -->
		<div class="col-xs-12 form-group {{ $errors->has('message') ? 'has-error' : '' }}">

			{!! Form::label('message',Lang::get('lang.message')) !!}
			{!! $errors->first('message', '<spam class="help-block">:message</spam>') !!}
			{!! Form::textarea('message',null,['class' => 'form-control']) !!}

		</div>

</div>

    <script>
        $(function () {
            //Add text editor
          	$("textarea").wysihtml5();
        });
    </script>

@stop
