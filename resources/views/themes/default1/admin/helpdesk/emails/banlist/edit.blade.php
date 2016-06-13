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
<h1>{!! Lang::get('lang.ban_email') !!}</h1>
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
{!! Form::model($bans,['url'=>'banlist/'.$bans->id,'method'=>'PATCH']) !!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{Lang::get('lang.edit_banned_email')}}</h3>
    </div>
    <!-- Ban Status : Radio form : Required -->
    <div class="box-body">
        @if(Session::has('errors'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @if($errors->first('ban'))
            <li class="error-message-padding">{!! $errors->first('ban', ':message') !!}</li>
            @endif
        </div>
        @endif
        <div class="form-group {{ $errors->has('ban') ? 'has-error' : '' }}">
            {!! Form::label('ban',Lang::get('lang.ban_status')) !!} <span class="text-red"> *</span>
            <div class="row">
                <div class="col-xs-2">
                    {!! Form::radio('ban',1) !!} {{Lang::get('lang.active')}}
                </div>
                <div class="col-xs-2">
                    {!! Form::radio('ban',0) !!} {{Lang::get('lang.inactive')}}
                </div>
            </div>
        </div>
        <!-- email Address : Text form : Required -->
        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            {!! Form::label('email',Lang::get('lang.email_address')) !!} <span class="text-red"> *</span>
            {!! Form::text('email',null,['disabled'=>'disabled','class' => 'form-control']) !!}
        </div>
        <!-- intrnal Notes : Textarea :  -->
        <div class="form-group">
            {!! Form::label('internal_note',Lang::get('lang.internal_notes')) !!}
            {!! Form::textarea('internal_note',null,['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit(Lang::get('lang.update'),['class'=>'btn btn-primary'])!!}
    </div>
</div>
@stop