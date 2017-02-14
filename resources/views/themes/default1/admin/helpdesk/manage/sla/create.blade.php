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
<h1>{!! Lang::get('lang.sla_plan') !!}</h1>
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
{!! Form::open(['action' => 'Admin\helpdesk\SlaController@store', 'method' => 'post']) !!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h2 class="box-title">{{Lang::get('lang.create')}}</h2>
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
        <!-- <table class="table table-hover" style="overflow:hidden;"> -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    {!! Form::label('name',Lang::get('lang.name')) !!} <span class="text-red"> *</span>
                    {!! Form::text('name',null,['class' => 'form-control']) !!}
                </div>
            </div>
            <!-- Grace Period text form Required -->
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('grace_period',Lang::get('lang.grace_period')) !!}<span class="text-red"> *</span>
                     <div class="row">
                 <div class="col-md-3  {{ $errors->has('grace_period_time') ? 'has-error' : '' }}" style="padding:0;">
                        <input type="number" name="grace_period_time" class="form-control">
                    </div>
                    <div class="col-md-5">
                        <select name="grace_period_type" class="form-control">
                            <option value="Min">{{Lang::get('lang.min')}}</option>
                            <option value="Hours">{{Lang::get('lang.hours')}}</option>
                            <option value="Days">{{Lang::get('lang.days')}}</option>
                            <option value="Months">{{Lang::get('lang.months')}}</option>
                            <option value="Year">{{Lang::get('lang.year')}}</option>
                        </select>
                    </div>
                    </div>
                </div>

               
            </div>
            <!-- status radio: required: Active|Dissable -->
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                    {!! Form::label('status',Lang::get('lang.status')) !!}&nbsp;
                    {!! Form::radio('status','1',true) !!} {{Lang::get('lang.active')}}&nbsp;&nbsp;
                    {!! Form::radio('status','0') !!} {{Lang::get('lang.inactive')}}
                </div>
            </div>
        </div>
        <!-- Admin Note  : Textarea :  -->
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('admin_note',Lang::get('lang.admin_notes')) !!}
                    {!! Form::textarea('admin_note',null,['class' => 'form-control','size' => '30x5']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary'])!!}
    </div>
</div>
<!-- close form -->
{!! Form::close() !!}
@stop