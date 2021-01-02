@extends('themes.default1.admin.layout.admin')

@section('Settings')
class="nav-link active"
@stop

@section('settings-menu-parent')
class="nav-item menu-open"
@stop

@section('settings-menu-open')
class="nav nav-treeview menu-open"
@stop

@section('languages')
class="nav-link active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{!! Lang::get('lang.language') !!}</h1>
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
@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <i class="fas fa-check-circle"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <span>{{Session::get('success')}}</span>
</div>
@endif
<!-- failure message -->
@if(Session::has('fails'))
<div class="alert alert-danger alert-dismissable">
    <i class="fas fa-ban"></i>
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
@if(Session::has('errors'))
<?php //dd($errors); ?>
<div class="alert alert-danger alert-dismissable">
    <i class="fas fa-ban"></i>
    <b>{!! Lang::get('lang.alert') !!}!</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <br/>
    @if($errors->first('language-name'))
    <li class="error-message-padding">{!! $errors->first('language-name', ':message') !!}</li>
    @endif
    @if($errors->first('iso-code'))
    <li class="error-message-padding">{!! $errors->first('iso-code', ':message') !!}</li>
    @endif
    @if($errors->first('File'))
    <li class="error-message-padding">{!! $errors->first('File', ':message') !!}</li>
    @endif
</div>
@endif
<div class="card card-light">
    <div class="card-header">
        <h3 class="card-title">{{Lang::get('lang.add-lang-package')}}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- username -->
            <div class="col-sm-4 form-group {{ $errors->has('language-name') ? 'has-error' : '' }}">
                {!! Form::label('language-name',Lang::get('lang.language-name')) !!} <span class="text-red"> *</span>
                {!! Form::text('language-name',null,['placeholder'=>'English','class' => 'form-control']) !!}
            </div>
            <div class="col-sm-4 form-group {{ $errors->has('iso-code') ? 'has-error' : '' }}">
                {!! Form::label('iso-code',Lang::get('lang.iso-code')) !!} <span class="text-red"> *</span>
                {!! Form::text('iso-code',null,['placeholder'=>'en','class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 form-group {{ $errors->has('File') ? 'has-error' : '' }}">
                {!! Form::label('File',Lang::get('lang.file')) !!} <span class="text-red"> *</span>&nbsp
                <div class="btn bg-olive btn-file" style="color:blue"> {!! Lang::get('lang.upload_file') !!}
                    {!! Form::file('File') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        {!! Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary'])!!}
    </div>
</div>
@stop