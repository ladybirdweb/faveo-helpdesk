@extends('themes.default1.admin.layout.admin')

@section('Manage')
active
@stop

@section('manage-bar')
active
@stop

@section('url')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{!! Lang::get('lang.url') !!}</h1>
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')
<ol class="breadcrumb">
</ol>
@stop

@section('content')
{!! Form::open(['url' => 'url/settings', 'method' => 'PATCH']) !!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">URL Settings</h3>
    </div>

    <div class="box-body table-responsive">
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <!-- check whether success or not -->
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!!Session::get('success')!!}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!!Session::get('fails')!!}
        </div>
        @endif
        
        <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('url','App URL') !!}
                </div>
                <div class="form-group">
                    {!! Form::text('url',$url,['class'=>'form-control']) !!}
                </div>
            </div>
             
        </div>
       
    </div>
    <div class="box-footer">
        {!! Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary'])!!}
    </div>
</div>
{!! Form::close() !!}
@stop
