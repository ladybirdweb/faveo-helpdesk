@extends('themes.default1.admin.layout.admin')

@section('Settings')
active
@stop

@section('security')
class="active"
@stop

@section('PageHeader')
<h1>{!! trans('lang.settings') !!}</h1>
@stop

@section('header')
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{!! trans('lang.security_settings') !!}</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! Session::get('success') !!}
        </div>
        @endif
        @if(Session::has('failed'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! trans('lang/alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p>{{Session::get('failed')}}</p>                
        </div>
        @endif
        @if(Session::has('errors'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! trans('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @if($errors->first('lockout_message'))
            <li class="error-message-padding">{!! $errors->first('lockout_message', ':message') !!}</li>
            @endif
            @if($errors->first('backlist_threshold'))
            <li class="error-message-padding">{!! $errors->first('backlist_threshold', ':message') !!}</li>
            @endif
            @if($errors->first('lockout_period'))
            <li class="error-message-padding">{!! $errors->first('lockout_period', ':message') !!}</li>
            @endif
        </div>
        @endif
        {!! Form::model($security,['route'=>['securitys.update', $security->id],'method'=>'PATCH','files' => true]) !!}
        <div class="form-group {{ $errors->has('lockout_message') ? 'has-error' : '' }}">
            <div class="row">
                <div class="col-md-3">
                    <label for="title">Lockout Message: <span class="text-red"> *</span></label>
                </div>
                <div  class="col-md-9">
                    <div class="callout callout-default" style="font-style: oblique;">{!! trans('lang.security_msg1') !!}</div>
                    {!! Form::textarea('lockout_message',null,['class'=>'form-control'])!!}
                </div>
            </div>
        </div>
        <div class="form-group {{ $errors->has('backlist_threshold') ? 'has-error' : '' }}">
            <div class="row">
                <div class="col-md-3">
                    <label for="title">{!! trans('lang.max_attempt') !!}: <span class="text-red"> *</span></label>
                </div>
                <div class="col-md-9">
                    <div class="callout callout-default" style="font-style: oblique;">{!! trans('lang.security_msg2') !!}</div>
                    <span>{!! Form::text('backlist_threshold',null,['class'=>'form-control'])!!} {!! trans('lang.lockouts') !!}</span>
                </div>     
            </div>
        </div>
        <div class="form-group {{ $errors->has('lockout_period') ? 'has-error' : '' }}"> 
            <div class="row">
                <div class="col-md-3">
                    <label for="title">Lockout Period: <span class="text-red"> *</span></label>
                </div>
                <div class="col-md-8">
                    <div class="callout callout-default" style="font-style: oblique;">{!! trans('lang.security_msg3') !!}</div>
                    <span> {!! Form::text('lockout_period',null,['class'=>'form-control'])!!} {!! trans('lang.minutes') !!}</span>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
    <div class="box-footer">
        <button type="submit" class="btn btn-primary">{!! trans('lang.submit') !!}</button>
    </div>
    {!! Form::close() !!}
</div>
@stop
