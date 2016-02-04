@extends('themes.default1.admin.layout.admin')

@section('Emails')
class="active"
@stop

@section('emails-bar')
active
@stop

@section('template')
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
	<div class="row">
<div class="col-md-12">
<div class="box box-primary">
<div class="box-header">
<!--	<h2 class="box-title">{{Lang::get('lang.templates')}}</h2><a href="{{route('template.create')}}" class="btn btn-primary pull-right">{{Lang::get('lang.create_template')}}</a>-->
<button class="btn btn-primary pull-right" data-toggle="modal" data-target="#createtemp">{{Lang::get('lang.create_template')}}</button> 
                                   
                                  <div class="modal fade" id="createtemp">
                                       <div class="modal-dialog">
                                          <div class="modal-content">
                                  {!! Form::open(['route'=>'template.createnew']) !!}
                    <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">{{Lang::get('lang.create_template')}}</h4>
        </div>
                     <div class="modal-body">
                              <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">

		{!! Form::label('folder_name', 'Folder Name:',['style'=>'display: block']) !!}
                
                
	
		{!! Form::text('folder_name',null,['class'=>'form-control'])!!}

		{!! $errors->first('folder', '<spam class="help-block">:message</spam>') !!}
	
	</div>
                                     </div>
                                                                        <div class="modal-footer">
                                                                            <div class="form-group">
                                                                                {!! Form::submit('Create Folder',['class'=>'btn btn-primary'])!!}
                                                                            
                                                                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                                        </div></div>
                                                                        {!! Form::close() !!}
                                                                    </div> 
                                                                </div>
                                                            </div></div>

<div class="box-body table-responsive no-padding">

<!-- check whether success or not -->

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

				<table class="table table-hover" style="overflow:hidden;">
	<tr>
		<th width="100px">{{Lang::get('lang.name')}}</th>

	</tr>
	<!-- Foreach @var templates as @var template -->
        
		@foreach($templates as $template)
                <?php if ($template === '.' or $template === '..') continue; ?>
	<tr>
		<!-- Template Name with Link to Edit page along Id -->
		<td><a href="{{route('template.read',[$template,$directory])}}">{!! $template !!}</a></td>
		<!-- template Status : if status==1 active -->
		<!-- Deleting Fields -->
		
		
	</tr>
@endforeach

	<!-- Set a link to Create Page -->




</table>
@stop
</div><!-- /.box -->
@section('FooterInclude')

@stop
@stop
<!-- /content -->