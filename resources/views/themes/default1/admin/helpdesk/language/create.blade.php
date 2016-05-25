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
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{Lang::get('lang.add-lang-package')}}</h3>
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
        @if(Session::has('errors'))
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
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
        <div class="row">
            <!-- username -->
            <div class="col-xs-4 form-group {{ $errors->has('language-name') ? 'has-error' : '' }}">
                {!! Form::label('language-name',Lang::get('lang.language-name')) !!}
                {!! Form::text('language-name',null,['placeholder'=>'English','class' => 'form-control']) !!}
            </div>
            <div class="col-xs-4 form-group {{ $errors->has('iso-code') ? 'has-error' : '' }}">
                {!! Form::label('iso-code',Lang::get('lang.iso-code')) !!}
                {!! Form::text('iso-code',null,['placeholder'=>'en','class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4 form-group {{ $errors->has('File') ? 'has-error' : '' }}">
                {!! Form::label('File',Lang::get('lang.file')) !!}&nbsp
                <div class="btn bg-olive btn-file" style="color:blue"> {!! Lang::get('lang.upload_file') !!}
                    {!! Form::file('File') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit(Lang::get('lang.submit'),['class'=>'form-group btn btn-primary'])!!}
    </div>
</div>
@stop