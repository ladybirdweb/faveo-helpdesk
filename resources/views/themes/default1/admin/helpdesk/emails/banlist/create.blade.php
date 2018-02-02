@extends('themes.default1.admin.layout.admin')

@section('Emails')
active
@stop

@section('emails-bar')
active
@stop

@section('ban')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{!! trans('lang.ban_email') !!}</h1>
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
{!! Form::open(['action' => 'Admin\helpdesk\BanlistController@store','method' => 'POST']) !!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{trans('lang.create_a_banned_email')}}</h3>
    </div>
    <!-- Ban Status : Radio form : Required -->
    <div class="box-body">
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        @endif
        @if(Session::has('errors'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! trans('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @if($errors->first('ban'))
            <li class="error-message-padding">{!! $errors->first('ban', ':message') !!}</li>
            @endif
            @if($errors->first('email'))
            <li class="error-message-padding">{!! $errors->first('email', ':message') !!}</li>
            @endif
        </div>
        @endif
        <div class="form-group {{ $errors->has('ban') ? 'has-error' : '' }}">
            {!! Form::label('ban',trans('lang.ban_status')) !!} <span class="text-red"> *</span>
            <div class="row">
                <div class="col-xs-3">
                    {!! Form::radio('ban',1) !!} {{trans('lang.active')}}
                </div>
                <div class="col-xs-3">
                    {!! Form::radio('ban',0) !!} {{trans('lang.inactive')}}
                </div>
            </div>
        </div>
        <!-- email Address : Text form : Required -->
        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            {!! Form::label('email',trans('lang.email_address')) !!} <span class="text-red"> *</span>
            {!! Form::text('email',null,['class' => 'form-control']) !!}

        </div>
        <!-- intrnal Notes : Textarea :  -->
        <div class="form-group">
            {!! Form::label('internal_note',trans('lang.internal_notes')) !!}
            {!! Form::textarea('internal_note',null,['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit(trans('lang.submit'),['class'=>'btn btn-primary'])!!}
    </div>
</div>
@stop
