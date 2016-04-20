@extends('themes.default1.admin.layout.admin')

@section('Settings')
active
@stop

@section('settings-bar')
active
@stop

@section('languages')
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

	{!! Form::open(array('url'=>'language/add' , 'method' => 'post', 'files'=>true) )!!}


<div class="box box-primary">
	<div class="content-header">

	 	<h4>{{Lang::get('lang.add-lang-package')}}	{!! Form::submit(Lang::get('lang.save'),['class'=>'form-group btn btn-primary pull-right'])!!}</h4>

	</div>

	<div class="box-body">
		@if(Session::has('success'))
            <div class="alert alert-success alert-dismissable">
                <i class="fa  fa-check-circle"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p>{{Session::get('success')}}</p>
            </div>
            @endif
            <!-- failure message -->
            @if(Session::has('fails'))
            <div class="alert alert-danger alert-dismissable">
                <i class="fa fa-ban"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{Session::get('fails')}}
                @if(Session::has('link'))
                	<a href="{{url(Session::get('link'))}}">{{Lang::get('lang.enable_lang')}}</a>
            	@endif
            	@if(Session::has('link2'))
            		<a href="{{url(Session::get('link2'))}}" target="blank">{{Lang::get('lang.read-more')}}</a>
            	@endif
            </div>
            @endif

	<div class="row">
	<!-- username -->
		<div class="col-xs-4 form-group {{ $errors->has('language-name') ? 'has-error' : '' }}">

			{!! Form::label('language-name',Lang::get('lang.language-name')) !!}
			{!! Form::text('language-name',null,['placeholder'=>'English','class' => 'form-control']) !!}
			{!! $errors->first('language-name', '<spam class="help-block" style="color:red">:message</spam>') !!}
			

		</div>
		<div class="col-xs-4 form-group {{ $errors->has('iso-code') ? 'has-error' : '' }}">

			{!! Form::label('iso-code',Lang::get('lang.iso-code')) !!}
			{!! Form::text('iso-code',null,['placeholder'=>'en','class' => 'form-control']) !!}
			{!! $errors->first('iso-code', '<spam class="help-block" style="color:red">:message</spam>') !!}

		</div>
	</div>
	<div class="row">
        <div class="col-xs-4 form-group {{ $errors->has('File') ? 'has-error' : '' }}">
               		
			{!! Form::label('File',Lang::get('lang.file')) !!}&nbsp
        	<div class="btn bg-olive btn-file" style="color:blue"> {!! Lang::get('lang.upload_file') !!}
			{!! Form::file('File') !!}
        	</div>
        	{!! $errors->first('File', '<spam class="help-block" style="color:red">:message</spam>') !!}
				
		</div>
	</div>

	
@stop