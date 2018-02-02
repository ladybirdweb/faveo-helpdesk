@extends('themes.default1.admin.layout.admin')

@section('Tickets')
active
@stop

@section('status')
class="active"
@stop

@section('PageHeader')
<h1>{!! trans('lang.status_settings') !!}</h1>
@stop

@section('breadcrumbs')
<ol class="breadcrumb">
</ol>
@stop


@section('content')
{!! Form::model($status,['route'=>['statuss.update', $status->id],'method'=>'PATCH','files' => true]) !!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h4 class="box-title">{!! trans('lang.edit_details') !!}</h4>
    </div><!-- /.box-header -->
    <div class="box-body">
         @if(Session::has('errors'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! trans('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @foreach ($errors->all() as $error)
            <li class="error-message-padding">{{ $error }}</li>
            @endforeach 
        </div>
        @endif
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
            <b>{!! trans('lang.alert') !!} !</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p>{{Session::get('failed')}}</p>                
        </div>
        @endif
        <div class="row">
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label>{!! trans('lang.name') !!}: <span class="text-red"> *</span></label><br>
                    {!! Form::text('name',null,['class'=>'form-control'])!!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('sort') ? 'has-error' : '' }}">
                    <label>{!! trans('lang.display_order') !!}: <span class="text-red"> *</span></label><br>
                    <input type="number" name="sort" min="1" class="form-control" value="{!! $status->sort !!}">
                </div>  
            </div>
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('icon_class') ? 'has-error' : '' }}">
                    <label>{!! trans('lang.icon_class') !!}: <span class="text-red"> *</span></label><br>
                    {!! Form::text('icon_class',null,['class'=>'form-control'])!!}
                </div> 
            </div>
        </div>
        <div class="form-group">
            <!-- gender -->
            {!! Form::label('gender',trans('lang.resolved_status')) !!}
            <div class="callout callout-default" style="font-style: oblique;">{!! trans('lang.status_msg3') !!}</div>
            <div class="row">
                <div class="col-xs-3">
                    {!! Form::radio('state','closed',true) !!} {{trans('lang.yes')}}
                </div>
                <div class="col-xs-3">
                    {!! Form::radio('state','open') !!} {{trans('lang.no')}}
                </div>
            </div>
        </div>
        <div class="form-group">
            <!-- Email user -->
            {!! Form::label('gender',trans('lang.deleted_status')) !!}
            <div class="callout callout-default" style="font-style: oblique;">{!! trans('lang.status_msg2') !!}</div>
            <div class="row">
                <div class="col-xs-3">
                    {!! Form::radio('delete','yes') !!} {{trans('lang.yes')}}
                </div>
                <div class="col-xs-3">
                    {!! Form::radio('delete','no') !!} {{trans('lang.no')}}
                </div>
            </div>        
        </div>
        <div class="form-group">
            <!-- gender -->
            {!! Form::label('gender',trans('lang.notify_user')) !!}
            <div class="callout callout-default" style="font-style: oblique;">{!! trans('lang.status_msg1') !!}</div>
            <div class="row">
                <div class="col-xs-3">
                    {!! Form::radio('email_user','yes') !!} {{trans('lang.yes')}}
                </div>
                <div class="col-xs-3">
                    {!! Form::radio('email_user','no') !!} {{trans('lang.no')}}
                </div>
            </div>        
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit(trans('lang.update'),['class'=>'btn btn-primary'])!!}
    </div>
    {!! Form::close() !!}
</div> 
@stop