@extends('themes.default1.admin.layout.admin')

@section('Settings')
active
@stop

@section('settings-bar')
active
@stop

@section('tickets')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')

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
{!! Form::model($tickets,['url' => 'postticket/'.$tickets->id, 'method' => 'PATCH']) !!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{Lang::get('lang.ticket')}}</h3>
    </div>
    <div class="box-body">
        <!-- check whether success or not -->
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! Session::get('success') !!}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! Session::get('fails') !!}
        </div>
        @endif
        @if(Session::has('errors'))
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @if($errors->first('status'))
            <li class="error-message-padding">{!! $errors->first('status', ':message') !!}</li>
            @endif
            @if($errors->first('priority'))
            <li class="error-message-padding">{!! $errors->first('priority', ':message') !!}</li>
            @endif
            @if($errors->first('sla'))
            <li class="error-message-padding">{!! $errors->first('sla', ':message') !!}</li>
            @endif
            @if($errors->first('help_topic'))
            <li class="error-message-padding">{!! $errors->first('help_topic', ':message') !!}</li>
            @endif
            @if($errors->first('collision_avoid'))
            <li class="error-message-padding">{!! $errors->first('collision_avoid', ':message') !!}</li>
            @endif
        </div>
        @endif
        <div class="row">
            <!-- Default Status: Required : manual: Dropdowm  -->
            <div class="col-md-3">
                <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                    {!! Form::label('status',Lang::get('lang.default_status')) !!}
                    <select class="form-control" id="status" name="status">
                        <option value="1" >Open</option>
                    </select>
                </div>
            </div>
            <!-- Default Priority:	Required : manual : Dropdowm  -->
            <div class="col-md-2">
                <div class="form-group {{ $errors->has('priority') ? 'has-error' : '' }}">
                    {!! Form::label('priority',Lang::get('lang.default_priority')) !!}
                    {!!Form::select('priority', [''=>'select a priority','Priorities'=>$priority->lists('priority_desc','priority_id')->toArray()],null,['class' => 'form-control']) !!}
                </div>
            </div>
            <!-- Default SLA:	Required : manual : Dropdowm  -->
            <div class="col-md-2">
                <div class="form-group {{ $errors->has('sla') ? 'has-error' : '' }}">
                    {!! Form::label('sla',Lang::get('lang.default_sla')) !!}
                    {!!Form::select('sla', $slas->lists('grace_period','id'),null,['class' => 'form-control']) !!}
                </div>
            </div>
            <!-- Default Help Topic:  Dropdowm from Help topic table	 -->
            <div class="col-md-2">
                <div class="form-group {{ $errors->has('help_topic') ? 'has-error' : '' }}">
                    {!! Form::label('help_topic',Lang::get('lang.default_help_topic')) !!}
                    {!!Form::select('help_topic', $topics->lists('topic','id'),null,['class' => 'form-control']) !!}
                </div>
            </div>
            <!-- Agent Collision Avoidance Duration: text-number   -minutes  -->
            <div class="col-md-3">
                <div class="form-group {{ $errors->has('collision_avoid') ? 'has-error' : '' }}">
                    {!! Form::label('collision_avoid',Lang::get('lang.agent_collision_avoidance_duration')) !!} 
                    <div class="input-group">
                        <input type="number" class="form-control" name="collision_avoid" min="0"  step="1" value="{{$tickets->collision_avoid}}" placeholder="in minutes">
                        <div class="input-group-addon">
                            <span><i class="fa fa-clock-o"></i> {!!Lang::get('lang.in_minutes')!!}</span>
                        </div>
                    </div>
                </div> 
            </div> 
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary'])!!}
    </div>
</div>
{!! Form::close() !!}
@stop