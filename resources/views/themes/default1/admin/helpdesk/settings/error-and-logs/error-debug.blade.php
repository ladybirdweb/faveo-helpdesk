@extends('themes.default1.admin.layout.admin')

@section('error-bugs')
active
@stop

@section('settings-bar')
active
@stop

@section('debugging-option')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{trans('lang.error-debug')}}</h1>
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
	<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{trans('lang.debug-options')}}</h3>
    </div>
    <!-- Helpdesk Status: radio Online Offline -->
    <div class="box-body">
        <!-- check whether success or not -->
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!!Session::get('success')!!}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <b>{!! trans('lang.alert') !!}!</b><br/>
            <li class="error-message-padding">{!!Session::get('fails')!!}</li>
        </div>
        @endif
        {!! Form::open(['url' => route('post.error.debug.settings'), 'method' => 'POST']) !!}
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('debug',trans('lang.debugging')) !!}
                    <div class="row">
                        <div class="col-xs-3">
                            <input type="radio" name="debug" value="true" @if($debug == true) checked="true" @endif> {{trans('lang.enable')}}
                        </div>
                        <div class="col-xs-3">
                            <input type="radio" name="debug" value="false" @if($debug == false) checked="true" @endif> {{trans('lang.disable')}}
                        </div>
                    </div>
                </div> 
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('bugsnag',trans('lang.bugsnag-debugging')) !!}
                    <div class="row">
                        <div class="col-xs-3">
                            <input type="radio" name="bugsnag" value="true" @if($bugsnag == true) checked="true" @endif> {{trans('lang.yes')}}
                        </div>
                        <div class="col-xs-3">
                            <input type="radio" name="bugsnag" value="false" @if($bugsnag == false) checked="true" @endif> {{trans('lang.no')}}
                        </div>
                    </div>
                </div> 
            </div>
        </div>
        </div>
         <div class="box-footer">
        {!! Form::submit(trans('lang.save'),['onclick'=>'sendForm()','class'=>'btn btn-primary'])!!}
    </div>
     {!! Form::close() !!}  
        </div>
@stop