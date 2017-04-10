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
{!! Form::model($slas,['url' => 'sla/'.$slas->id, 'method' => 'PATCH']) !!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h2 class="box-title">{{Lang::get('lang.edit')}}</h2>
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
                        {!! Form::label('name',Lang::get('lang.name')) !!} <span class="text-red"> *</span>
                        {!! Form::text('name',null,['class' => 'form-control']) !!}
                    </div>
                </div>
                <!-- Grace Period text form Required -->
                <?php
                    $grace_period_time = [];
                    if ($slas) {
                        $total_grace_period = $slas->grace_period;
                        $grace_period = explode(' ', $total_grace_period);
                    }
                    ?>


                <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('grace_period',Lang::get('lang.grace_period')) !!}
                    <span class="text-red"> *</span>
                    <div class="row">
                   <div class="col-md-3 {{ $errors->has('grace_period_time') ? 'has-error' : '' }}" style="padding:0;">
                        <input type="number"  name="grace_period_time" class="form-control" value="{!! checkArray(0,$grace_period)!!}">
                    </div>
                    <div class="col-md-5">
                        <select name="grace_period_type" class="form-control">
                             <option value="Min" <?php
                            if (checkArray(1, $grace_period) == 'Min') {
                                echo 'selected';
                            }
                            ?> >{{Lang::get('lang.min')}}</option>
                            <option value="Hours" <?php
                            if (checkArray(1, $grace_period) == 'Hours') {
                                echo 'selected';
                            }
                            ?> >{{Lang::get('lang.hours')}}</option>
                            <option value="Days" <?php
                            if (checkArray(1, $grace_period) == 'Days') {
                                echo 'selected';
                            }
                            ?> >{{Lang::get('lang.days')}}</option>
                            <option value="Months" <?php
                            if (checkArray(1, $grace_period) == 'Months') {
                                echo 'selected';
                            }
                            ?> >{{Lang::get('lang.months')}}</option>
                            <option value="Year" <?php
                            if (checkArray(1, $grace_period) == 'Year') {
                                echo 'selected';
                            }
                            ?> >{{Lang::get('lang.year')}}</option>
                        </select>
                    </div>
                    </div>
                </div>

                
            </div>
               <!--  <div class="col-md-6">
                    <div class="form-group {{ $errors->has('grace_period') ? 'has-error' : '' }}">
                        {!! Form::label('grace_period',Lang::get('lang.grace_period')) !!}
                        {!! Form::select('grace_period',['6 Hours'=>'6 Hours', '12 Hours'=>'12 Hours', '18 Hours'=>'18 Hours', '24 Hours'=>'24 Hours', '36 Hours'=>'36 Hours', '48 Hours'=>'48 Hours'],null,['class' => 'form-control']) !!}
                    </div>
                </div> -->
                <!-- status radio: required: Active|Dissable -->
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                        {!! Form::label('status',Lang::get('lang.status')) !!}&nbsp;
                        {!! Form::radio('status','1',true) !!} &nbsp; {{Lang::get('lang.active')}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {!! Form::radio('status','0') !!} &nbsp; {{Lang::get('lang.inactive')}}
                    </div>
                </div>
            </div>
            <!-- Admin Note : Textarea : -->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('admin_note',Lang::get('lang.admin_notes')) !!}
                        {!! Form::textarea('admin_note',null,['class' => 'form-control','size' => '30x5']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <div class="form-group">
            <input type="checkbox" name="sys_sla" @if($slas->id == $sla->sla) checked disabled @endif> {{ Lang::get('lang.make-default-sla')}}
        </div>
        {!! Form::submit(Lang::get('lang.update'),['class'=>'btn btn-primary'])!!}
    </div>
</div>
<!-- close form -->
{!! Form::close() !!}
@stop
