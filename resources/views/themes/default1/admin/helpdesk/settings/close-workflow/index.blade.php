@extends('themes.default1.admin.layout.admin')

@section('Tickets')
active
@stop

@section('close-workflow')
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
        <h3 class="box-title">{!! trans('lang.close_ticket_workflow_settings') !!}</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        @endif
        @if(Session::has('failed'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! trans('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p>{{Session::get('failed')}}</p>                
        </div>
        @endif
        @if(Session::has('errors'))
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! trans('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @if($errors->first('days'))
            <li class="error-message-padding">{!! $errors->first('days', ':message') !!}</li>
            @endif
            @if($errors->first('condition'))
            <li class="error-message-padding">{!! $errors->first('condition', ':message') !!}</li>
            @endif
            @if($errors->first('send_email'))
            <li class="error-message-padding">{!! $errors->first('send_email', ':message') !!}</li>
            @endif
            @if($errors->first('status'))
            <li class="error-message-padding">{!! $errors->first('status', ':message') !!}</li>
            @endif
        </div>
        @endif
        {!! Form::model($security,['route'=>['close-workflow.update', $security->id],'method'=>'PATCH','files' => true]) !!}
        <div class="form-group {{ $errors->has('days') ? 'has-error' : '' }}">
            <div class="row">
                <div class="col-md-3">
                    <label for="title">{!! trans('lang.no_of_days') !!}: <span class="text-red"> *</span></label>
                </div>
                <div  class="col-md-9">
                    <div class="callout callout-default" style="font-style: oblique;">{!! trans('lang.close-msg1') !!}</div>
                    {!! Form::text('days',null,['class'=>'form-control'])!!}
                </div>
            </div>
        </div>
        <!-- <div class="form-group {{ $errors->has('condition') ? 'has-error' : '' }}">
            <div class="row">
                <div class="col-md-3">
                    <label for="title">{!! trans('lang.enable_workflow') !!}:</label>
                </div>
                <div class="col-md-9">
                    <div class="callout callout-default" style="font-style: oblique;">{!! trans('lang.close-msg2') !!}</div>
                    <div class="row">
                        <div class="col-xs-3">
                            {!! Form::radio('condition','1') !!} {{trans('lang.yes')}}
                        </div>
                        <div class="col-xs-3">
                            {!! Form::radio('condition','0') !!} {{trans('lang.no')}}
                        </div>
                    </div>       
                </div>     
            </div>
        </div> -->
        <div class="form-group {{ $errors->has('send_email') ? 'has-error' : '' }}"> 
            <div class="row">
                <div class="col-md-3">
                    <label for="title">{!! trans('lang.send_email_to_user') !!}:</label>
                </div>
                <div class="col-md-6">
                    <div class="callout callout-default" style="font-style: oblique;">{!! trans('lang.close-msg4') !!}</div>
                    <div class="row">
                        <div class="col-xs-3">
                            {!! Form::radio('send_email','1') !!} {{trans('lang.yes')}}
                        </div>
                        <div class="col-xs-3">
                            {!! Form::radio('send_email','0') !!} {{trans('lang.no')}}
                        </div>
                    </div>       
                </div>
            </div>
        </div>
        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}"> 
            <div class="row">
                <div class="col-md-3">
                    <label for="title">{!! trans('lang.ticket_status') !!}:</label>
                </div>
                <div class="col-md-6">
                    <div class="callout callout-default" style="font-style: oblique;">{!! trans('lang.close-msg3') !!}</div>
                    <?php $user = \App\Model\helpdesk\Ticket\Ticket_Status::where('state', '=', 'closed')->get(); ?>
                    {!! Form::select('status',[ trans('lang.status')=>$user->lists('name','id')->toArray()],null,['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
    <div class="box-footer">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-9">
                <button type="submit" class="btn btn-primary">{!! trans('lang.submit') !!}</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
@stop
