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
	<h2 class="box-title">{{Lang::get('lang.templates')}}</h2><a href="modal" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal3">Edit Template</a></div>

<div class="modal modal-primary" id="modal3">
              <div class="modal-dialog">
                <div class="modal-content" style="width:90%">
                    {!! Form::model($contents,['route'=>['template.write', $template,$path],'method'=>'PATCH','files' => true]) !!}
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Edit</h4>
                  </div>
                  <div class="modal-body">
                    
   <!-- <div class="col-lg-12 col-xs-6 col-sm-6" style="margin-top: 3%;"> -->
                <div class="form-group">
                      {!! Form::textarea('templatedata',$contents,['class'=>'form-control'])!!}
                    </div>
            <!-- </div> -->
			
			
            <!-- </div> -->
               <!-- <div class="col-lg-12 col-xs-6 col-sm-6" style="margin-top: 3%;"> -->
          
               <!-- <div class="col-lg-12 col-xs-6 col-sm-6" style="margin-top: 3%;"> -->
           
            <!-- </div> -->


                  </div>
                   <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline">Save changes</button>
                  </div>
                    {!! Form::close() !!}
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div> 
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

				<div class="box-body" style="background-color: #f3f3f3; height: 410px;">

                  {!! nl2br($contents) !!}

</div>

@stop
</div><!-- /.box -->
@section('FooterInclude')

@stop
@stop
<!-- /content -->