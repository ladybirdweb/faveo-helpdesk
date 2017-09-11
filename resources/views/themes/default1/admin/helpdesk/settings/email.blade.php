@extends('themes.default1.admin.layout.admin')

@section('Emails')
active
@stop

@section('settings-bar')
active
@stop

@section('email')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{trans('lang.emails')}}</h1>
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
{!! Form::model($emails,['url' => 'postemail/'.$emails->id, 'method' => 'PATCH']) !!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{trans('lang.email-settings')}}</h3>
    </div>
    <div class="box-body">
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
            <b>{!! trans('lang.success') !!} !</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!!Session::get('fails')!!}
        </div>
        @endif
        @if(Session::has('errors'))
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! trans('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @if($errors->first('sys_email'))
            <li class="error-message-padding">{!! $errors->first('sys_email', ':message') !!}</li>
            @endif
        </div>
        @endif

        <div class="row">
        </div>
        <!-- Accept All Emails:	CHECKBOX: Accept email from unknown Users  -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::checkbox('all_emails',1,true) !!}&nbsp;{{trans('lang.accept_all_email')}}
                </div>
            </div>
        </div>
        <!-- Admin's Email Address:	  Text : Required  -->
        <div class="row">
        </div>
        <!-- Accept Email Collaborators: CHECKBOX : Automatically add collaborators from email fields   -->
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::checkbox('email_collaborator',1) !!}&nbsp;{{trans('lang.accept_email_collab')}}
                </div>
            </div>
        </div>
        <!-- Attachments: CHECKBOX	: Email attachments to the user  -->
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::checkbox('attachment',1) !!}&nbsp;{{trans('lang.attachments')}}
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit(trans('lang.submit'),['class'=>'btn btn-primary'])!!}
    </div>
</div>
@stop