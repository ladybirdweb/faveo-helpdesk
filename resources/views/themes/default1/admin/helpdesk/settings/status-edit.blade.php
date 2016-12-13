@extends('themes.default1.admin.layout.admin')

@section('Tickets')
active
@stop

@section('status')
class="active"
@stop

@section('PageHeader')
<h1>{!! Lang::get('lang.status_settings') !!}</h1>
@stop

@section('breadcrumbs')
<ol class="breadcrumb">
</ol>
@stop


@section('content')
{!! Form::model($status,['route'=>['statuss.update', $status->id],'method'=>'PATCH','files' => true]) !!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h4 class="box-title">{!! Lang::get('lang.edit_details') !!}</h4>
    </div><!-- /.box-header -->
    <div class="box-body">
         @if(Session::has('errors'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
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
            <b>{!! Lang::get('lang.alert') !!} !</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p>{{Session::get('failed')}}</p>                
        </div>
        @endif
        <div class="row">
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label>{!! Lang::get('lang.name') !!}: <span class="text-red"> *</span></label><br>
                    {!! Form::text('name',null,['class'=>'form-control'])!!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('sort') ? 'has-error' : '' }}">
                    <label>{!! Lang::get('lang.display_order') !!}: <span class="text-red"> *</span></label><br>
                    <input type="number" name="sort" min="1" class="form-control" value="{!! $status->sort !!}">
                </div>  
            </div>
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('icon_class') ? 'has-error' : '' }}">
                    <label>{!! Lang::get('lang.icon_class') !!}: <span class="text-red"> *</span></label><br>
                    {!! Form::text('icon_class',null,['class'=>'form-control'])!!}
                </div> 
            </div>
        </div>
        <div class="form-group">
            <!-- gender -->
            {!! Form::label('gender',Lang::get('lang.resolved_status')) !!}
            <div class="callout callout-default" style="font-style: oblique;">{!! Lang::get('lang.status_msg3') !!}</div>
            <div class="row">
                <div class="col-xs-3">
                    {!! Form::radio('state','closed',true) !!} {{Lang::get('lang.yes')}}
                </div>
                <div class="col-xs-3">
                    {!! Form::radio('state','open') !!} {{Lang::get('lang.no')}}
                </div>
            </div>
        </div>
        <div class="form-group">
            <!-- Email user -->
            {!! Form::label('gender',Lang::get('lang.deleted_status')) !!}
            <div class="callout callout-default" style="font-style: oblique;">{!! Lang::get('lang.status_msg2') !!}</div>
            <div class="row">
                <div class="col-xs-3">
                    {!! Form::radio('delete','yes') !!} {{Lang::get('lang.yes')}}
                </div>
                <div class="col-xs-3">
                    {!! Form::radio('delete','no') !!} {{Lang::get('lang.no')}}
                </div>
            </div>        
        </div>
        <div class="form-group">
            <!-- gender -->
            {!! Form::label('gender',Lang::get('lang.notify_user')) !!}
            <div class="callout callout-default" style="font-style: oblique;">{!! Lang::get('lang.status_msg1') !!}</div>
            <div class="row">
                <div class="col-xs-3">
                    {!! Form::radio('email_user','yes') !!} {{Lang::get('lang.yes')}}
                </div>
                <div class="col-xs-3">
                    {!! Form::radio('email_user','no') !!} {{Lang::get('lang.no')}}
                </div>
            </div>        
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit(Lang::get('lang.update'),['class'=>'btn btn-primary'])!!}
    </div>
    {!! Form::close() !!}
</div> 
@stop