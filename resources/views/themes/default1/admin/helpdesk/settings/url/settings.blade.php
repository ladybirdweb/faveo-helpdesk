@extends('themes.default1.admin.layout.admin')

@section('Manage')
class="nav-link active"
@stop

@section('manage-menu-parent')
class="nav-item menu-open"
@stop

@section('manage-menu-open')
class="nav nav-treeview menu-open"
@stop

@section('url')
class="nav-link active"
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
<div class="card card-light">
    <div class="card-header">
        <h3 class="card-title">URL Settings</h3>
    </div>

    <div class="card-body">
        
        
        <div class="row">

            <div class="col-md-3">
                {!! Form::label('www','WWW/non-WWW') !!}<br/>
                {!! Form::radio('www','yes',$www['www'],['class'=>'option']) !!} WWW&nbsp;&nbsp;
                {!! Form::radio('www','no',$www['nonwww'],['class'=>'option']) !!} Non WWW
            </div>
 
            <div class="col-md-3">
                
                {!! Form::label('option','SSl') !!}<br/>
                {!! Form::radio('ssl','yes',$https['https'],['class'=>'option']) !!} HTTPS&nbsp;&nbsp;
                {!! Form::radio('ssl','no',$https['http'],['class'=>'option']) !!} HTTP
            </div>
        </div>
    </div>
    
    <div class="card-footer">
        {!! Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary'])!!}
    </div>
</div>
{!! Form::close() !!}
@stop
