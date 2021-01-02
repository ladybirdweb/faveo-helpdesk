@extends('themes.default1.admin.layout.admin')

@section('Tickets')
class="nav-link active"
@stop

@section('ticket-menu-parent')
class="nav-item menu-open"
@stop

@section('ticket-menu-open')
class="nav nav-treeview menu-open"
@stop

@section('ratings')
class="nav-link active"
@stop

@section('HeadInclude')
@stop

<!-- header -->
@section('PageHeader')
<h1>Create Ratings</h1>
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
{!! Form::open(['route'=>'rating.store']) !!}
 @if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <i class="fas fa-check-circle"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('success')}}
</div>
@endif
@if(Session::has('errors'))
<?php //dd($errors); ?>
<div class="alert alert-danger alert-dismissable">
    <i class="fas fa-ban"></i>
    <b>{!! Lang::get('lang.alert') !!}!</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <br/>
    @if($errors->first('name'))
    <li class="error-message-padding">{!! $errors->first('name', ':message') !!}</li>
    @endif
    @if($errors->first('display_order'))
    <li class="error-message-padding">{!! $errors->first('display_order', ':message') !!}</li>
    @endif
    @if($errors->first('rating_scale'))
    <li class="error-message-padding">{!! $errors->first('rating_scale', ':message') !!}</li>
    @endif
    @if($errors->first('rating_area'))
    <li class="error-message-padding">{!! $errors->first('rating_area', ':message') !!}</li>
    @endif
    @if($errors->first('restrict'))
    <li class="error-message-padding">{!! $errors->first('restrict', ':message') !!}</li>
    @endif
    @if($errors->first('allow_modification'))
    <li class="error-message-padding">{!! $errors->first('allow_modification', ':message') !!}</li>
    @endif
</div>
@endif
<div class="card card-light">
    <div class="card-header">
        <h3 class="card-title">{{Lang::get('lang.create')}}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                {!! Form::label('name',Lang::get('lang.rating_label')) !!}<span style="color:red;">*</span>
                {!! Form::text('name',null,['class' => 'form-control']) !!}
            </div>
            <div class="col-md-6 form-group {{ $errors->has('display_order') ? 'has-error' : '' }}">
                {!! Form::label('display_order',Lang::get('lang.display_order')) !!}<span style="color:red;">*</span>
                {!! Form::text('display_order',null,['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('rating_scale') ? 'has-error' : '' }}">
            {!! Form::label('rating_scale',Lang::get('lang.rating_scale')) !!}<span style="color:red;">*</span>
            <div class="callout callout-default" style="font-style: oblique;">{!! Lang::get('lang.rating-msg1') !!}</div>
            {!! Form::select('rating_scale',['1' => '1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8'],null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group {{ $errors->has('rating_area') ? 'has-error' : '' }}">
            {!! Form::label('rating_area',Lang::get('lang.rating_area')) !!}<span style="color:red;">*</span>
            {!! Form::select('rating_area',['Helpdesk Area' => 'Helpdesk Area','Comment Area'=>'Comment Area'],null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group {{ $errors->has('restrict') ? 'has-error' : '' }}">
            <!-- gender -->
            {!! Form::label('gender',Lang::get('lang.rating_restrict')) !!}<span style="color:red;">*</span>
            <div class="callout callout-default" style="font-style: oblique;">{!! Lang::get('lang.rating-msg2') !!}</div>
            {!! Form::select('restrict',['General' => 'general','Support'=>'support'],null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group {{ $errors->has('allow_modification') ? 'has-error' : '' }}">
            <!-- Email user -->
            {!! Form::label('allow_modification',Lang::get('lang.rating_change')) !!}<span style="color:red;">*</span>
            <div class="callout callout-default" style="font-style: oblique;">{!! Lang::get('lang.rating-msg3') !!}</div>
            <div class="row">
                <div class="col-sm-2">
                    {!! Form::radio('allow_modification','1') !!} {{Lang::get('lang.yes')}}
                </div>
                <div class="col-sm-2">
                    {!! Form::radio('allow_modification','0') !!} {{Lang::get('lang.no')}}
                </div>
            </div>        
        </div>
    </div>
    <div class="card-footer">
        {!! Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary'])!!}
    </div>
</div>
@stop