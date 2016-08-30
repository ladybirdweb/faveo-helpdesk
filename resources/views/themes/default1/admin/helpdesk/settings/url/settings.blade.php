@extends('themes.default1.admin.layout.admin')

@section('Settings')
class="active"
@stop

@section('settings-bar')
active
@stop

@section('access')
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
                {!! Form::label('www','WWW/non-WWW') !!}
                </div>
                <div class="col-md-4 ">
                    <p> {!! Form::radio('www','yes',$www['www'],['class'=>'option']) !!} WWW</p>
                </div>
                <div class="col-md-4">
                    <p> {!! Form::radio('www','no',$www['nonwww'],['class'=>'option']) !!} Non WWW</p>
                </div>
            </div>
 

            <div class="col-md-6 form-group">
                <div class="form-group">
                {!! Form::label('option','SSl') !!}
                </div>
                <div class="col-md-4">
                    <p> {!! Form::radio('ssl','yes',$https['https'],['class'=>'option']) !!} HTTPS</p>
                </div>
                <div class="col-md-4">
                    <p> {!! Form::radio('ssl','no',$https['http'],['class'=>'option']) !!} HTTP</p>
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
