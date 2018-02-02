@extends('themes.default1.admin.layout.admin')

@section('Tickets')
active
@stop

@section('ratings')
class="active"
@stop

@section('HeadInclude')
@stop

<!-- header -->
@section('PageHeader')
<h1>{!! trans('lang.ratings') !!}</h1>
@stop

<!-- content -->
@section('content')
{!! Form::model($rating,['route'=>['settings.rating', $rating->id],'method'=>'PATCH','files' => true]) !!} 
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{trans('lang.edit')}}</h3>
    </div>
    <div class="box-body">
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        @endif
        @if(Session::has('errors'))
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! trans('lang.alert') !!}!</b>
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
        <div class="row">
            <div class="col-md-6 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                {!! Form::label('name',trans('lang.rating_label')) !!}<span style="color:red;">*</span>
                {!! Form::text('name',null,['class' => 'form-control']) !!}
            </div>
            <div class="col-md-6 form-group {{ $errors->has('display_order') ? 'has-error' : '' }}">
                {!! Form::label('display_order',trans('lang.display_order')) !!}<span style="color:red;">*</span>
                {!! Form::text('display_order',null,['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('rating_scale') ? 'has-error' : '' }}">
            {!! Form::label('rating_scale',trans('lang.rating_scale')) !!}<span style="color:red;">*</span>
            <div class="callout callout-default" style="font-style: oblique;">{!! trans('lang.rating-msg1') !!}</div>
            {!! Form::select('rating_scale',['1' => '1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8'],null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group {{ $errors->has('rating_area') ? 'has-error' : '' }}">
            {!! Form::label('rating_area',trans('lang.rating_area')) !!}<span style="color:red;">*</span>
            {!! Form::select('rating_area',['Helpdesk Area' => 'Helpdesk Area','Comment Area'=>'Comment Area'],null,['class' => 'form-control','disabled' => 'disabled']) !!}
        </div>
        <div class="form-group {{ $errors->has('restrict') ? 'has-error' : '' }}">
            <!-- gender -->
            {!! Form::label('gender',trans('lang.rating_restrict')) !!}<span style="color:red;">*</span>
            <div class="callout callout-default" style="font-style: oblique;">{!! trans('lang.rating-msg2') !!}</div>
            {!! Form::select('restrict',['General' => 'general','Support'=>'support'],null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group {{ $errors->has('allow_modification') ? 'has-error' : '' }}">
            <!-- Email user -->
            {!! Form::label('allow_modification',trans('lang.rating_change')) !!}<span style="color:red;">*</span>
            <div class="callout callout-default" style="font-style: oblique;">{!! trans('lang.rating-msg3') !!}</div>
            <div class="row">
                <div class="col-xs-2">
                    {!! Form::radio('allow_modification','1') !!} {{trans('lang.yes')}}
                </div>
                <div class="col-xs-2">
                    {!! Form::radio('allow_modification','0') !!} {{trans('lang.no')}}
                </div>
            </div>        
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit(trans('lang.update'),['class'=>'btn btn-primary'])!!}
    </div>
</div>
{!! Form::close() !!}
@stop