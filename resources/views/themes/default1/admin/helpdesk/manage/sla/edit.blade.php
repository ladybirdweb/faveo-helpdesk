@extends('themes.default1.admin.layout.admin')

@section('Manage')
active
@stop

@section('manage-bar')
active
@stop

@section('sla')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{!! trans('lang.sla_plan') !!}</h1>
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
{!! Form::model($slas,['url' => 'sla/'.$slas->id, 'method' => 'PATCH']) !!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h2 class="box-title">{{trans('lang.edit')}}</h2>
    </div>
    <div class="box-body">
        @if(Session::has('errors'))
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>Alert!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @if($errors->first('name'))
            <li class="error-message-padding">{!! $errors->first('name', ':message') !!}</li>
            @endif
            @if($errors->first('grace_period'))
            <li class="error-message-padding">{!! $errors->first('grace_period', ':message') !!}</li>
            @endif
            @if($errors->first('status'))
            <li class="error-message-padding">{!! $errors->first('status', ':message') !!}</li>
            @endif
        </div>
        @endif
        <!-- Name text form Required -->
        <div class="box-body table-responsive no-padding"style="overflow:hidden;">
        <!-- <table class="table table-hover" style="overflow:hidden;"> -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('name',trans('lang.name')) !!} <span class="text-red"> *</span>
                        {!! Form::text('name',null,['class' => 'form-control']) !!}
                    </div>
                </div>
                <!-- Grace Period text form Required -->
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('grace_period') ? 'has-error' : '' }}">
                        {!! Form::label('grace_period',trans('lang.grace_period')) !!}
                        {!! Form::select('grace_period',['6 Hours'=>'6 Hours', '12 Hours'=>'12 Hours', '18 Hours'=>'18 Hours', '24 Hours'=>'24 Hours', '36 Hours'=>'36 Hours', '48 Hours'=>'48 Hours'],null,['class' => 'form-control']) !!}
                    </div>
                </div>
                <!-- status radio: required: Active|Dissable -->
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                        {!! Form::label('status',trans('lang.status')) !!}&nbsp;
                        {!! Form::radio('status','1',true) !!} &nbsp; {{trans('lang.active')}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {!! Form::radio('status','0') !!} &nbsp; {{trans('lang.inactive')}}
                    </div>
                </div>
            </div>
            <!-- Admin Note : Textarea : -->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('admin_note',trans('lang.admin_notes')) !!}
                        {!! Form::textarea('admin_note',null,['class' => 'form-control','size' => '30x5']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <div class="form-group">
            <input type="checkbox" name="sys_sla" @if($slas->id == $sla->sla) checked disabled @endif> {{ trans('lang.make-default-sla')}}
        </div>
        {!! Form::submit(trans('lang.update'),['class'=>'btn btn-primary'])!!}
    </div>
</div>
<!-- close form -->
{!! Form::close() !!}
@stop
