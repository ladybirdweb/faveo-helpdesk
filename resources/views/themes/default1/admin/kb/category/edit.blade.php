@extends('themes.default1.admin.layout.kb')

@section('category')
    active
@stop

<script type="text/javascript" src="{{asset('dist/js/EditnicEdit.js')}}"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>

@section('content')
{!! Form::model($category,['url' => 'category/'.$category->slug , 'method' => 'PATCH'] )!!}


<div class="box box-primary">
	<div class="content-header">

	 	<h4>Edit	{!! Form::submit('save',['class'=>'form-group btn btn-primary pull-right'])!!}</h4>

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

		<div class="col-xs-3 form-group {{ $errors->has('name') ? 'has-error' : '' }}">

			{!! Form::label('name',Lang::get('lang.name')) !!}
			{!! $errors->first('name', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('name',null,['class' => 'form-control']) !!}

		</div>

		<div class="col-xs-3 form-group {{ $errors->has('slug') ? 'has-error' : '' }}">

			{!! Form::label('slug',Lang::get('lang.slug')) !!}
			{!! $errors->first('slug', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('slug',null,['class' => 'form-control']) !!}

		</div>

		<div class="col-xs-3 form-group {{ $errors->has('parent') ? 'has-error' : '' }}">

			{!! Form::label('parent',Lang::get('lang.parent')) !!}
			{!! $errors->first('parent', '<spam class="help-block">:message</spam>') !!}
			{!!Form::select('parent',[''=>'Select a Group','Categorys'=>$category->pluck('name','name')],null,['class' => 'form-control select']) !!}

		</div>


		<div class="col-xs-3 form-group {{ $errors->has('status') ? 'has-error' : '' }}">

			{!! Form::label('status',Lang::get('lang.status')) !!}
			{!! $errors->first('status', '<spam class="help-block">:message</spam>') !!}
			<div class="row">
				<div class="col-xs-3">
					{!! Form::radio('status','1',true) !!}{{Lang::get('lang.active')}}
				</div>
				<div class="col-xs-3">
					{!! Form::radio('status','0',null) !!}{{Lang::get('lang.inactive')}}
				</div>
			</div>
		</div>

		<div class="col-md-12 form-group {{ $errors->has('description') ? 'has-error' : '' }}">
			{!! Form::label('description',Lang::get('lang.description')) !!}
			{!! $errors->first('description', '<spam class="help-block">:message</spam>') !!}
			{!! Form::textarea('description',null,['class' => 'form-control','size' => '128x10','id'=>'description','placeholder'=>'Enter the description']) !!}
		</div>

	</div>


</div>
@stop
@section('FooterInclude')

@stop

<!-- /content -->
