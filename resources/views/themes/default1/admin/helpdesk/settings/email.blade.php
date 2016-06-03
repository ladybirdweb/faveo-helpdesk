@extends('themes.default1.admin.layout.admin')

@section('Settings')
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
        <h3 class="box-title">{{Lang::get('lang.email')}}</h3>             
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
            <b>{!! lang::get('lang.success') !!} !</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!!Session::get('fails')!!}
        </div>
        @endif
        @if(Session::has('errors'))
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @if($errors->first('sys_email'))
            <li class="error-message-padding">{!! $errors->first('sys_email', ':message') !!}</li>
            @endif
        </div>
        @endif
        <div class="row">
            <!-- Default System Email:	DROPDOWN value from emails table : Required -->
            <div class="col-md-12">
                <div class="col-md-3 no-padding">
                    <div class="form-group {{ $errors->has('sys_email') ? 'has-error' : '' }}">
                        {!! Form::label('sys_email',Lang::get('lang.default_system_email')) !!}
                        {!!Form::select('sys_email', [ 'Select an Email', 'Emails' => $emails1->lists('email_name','id')->toArray()],null,['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        </div>
        <!-- Accept All Emails:	CHECKBOX: Accept email from unknown Users  -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::checkbox('all_emails',1,true) !!}&nbsp;{{Lang::get('lang.accept_all_email')}}
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
                    {!! Form::checkbox('email_collaborator',1) !!}&nbsp;{{Lang::get('lang.accept_email_collab')}}
                </div>
            </div>
        </div>
        <!-- Attachments: CHECKBOX	: Email attachments to the user  -->
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::checkbox('attachment',1) !!}&nbsp;{{Lang::get('lang.attachments')}}
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary'])!!}
    </div>
</div>
@stop