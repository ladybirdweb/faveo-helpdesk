@extends('themes.default1.admin.layout.admin')

@section('Manage')
active
@stop

@section('manage-bar')
active
@stop

@section('help')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{!! Lang::get('lang.help_topic') !!}</h1>
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
{!! Form::model($topics,['url' => 'helptopic/'.$topics->id, 'method' => 'PATCH']) !!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{Lang::get('lang.edit')}}</h3>
    </div>
    <div class="box-body">
        @if(Session::has('errors'))
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>Alert!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @if($errors->first('status'))
            <li class="error-message-padding">{!! $errors->first('status', ':message') !!}</li>
            @endif
            @if($errors->first('type'))
            <li class="error-message-padding">{!! $errors->first('type', ':message') !!}</li>
            @endif
            @if($errors->first('topic'))
            <li class="error-message-padding">{!! $errors->first('topic', ':message') !!}</li>
            @endif
            @if($errors->first('parent_topic'))
            <li class="error-message-padding">{!! $errors->first('parent_topic', ':message') !!}</li>
            @endif
            @if($errors->first('custom_form'))
            <li class="error-message-padding">{!! $errors->first('custom_form', ':message') !!}</li>
            @endif
            @if($errors->first('department'))
            <li class="error-message-padding">{!! $errors->first('department', ':message') !!}</li>
            @endif
            @if($errors->first('priority'))
            <li class="error-message-padding">{!! $errors->first('priority', ':message') !!}</li>
            @endif
            @if($errors->first('sla_plan'))
            <li class="error-message-padding">{!! $errors->first('sla_plan', ':message') !!}</li>
            @endif
            @if($errors->first('auto_assign'))
            <li class="error-message-padding">{!! $errors->first('auto_assign', ':message') !!}</li>
            @endif
        </div>
        @endif
        <!-- status radio: required: Active|Dissable -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('ticket_status') ? 'has-error' : '' }}">
                    {!! Form::label('ticket_status',Lang::get('lang.status')) !!}&nbsp;&nbsp;
                    {!! Form::radio('status','1',true) !!} {{Lang::get('lang.active')}}&nbsp;&nbsp;&nbsp;
                    {!! Form::radio('status','0') !!} {{Lang::get('lang.inactive')}}
                </div>
            </div>
            <!-- Type : Radio : required : Public|private -->
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                    {!! Form::label('type',Lang::get('lang.type')) !!}&nbsp;&nbsp;
                    {!! Form::radio('type','1',true) !!} {{Lang::get('lang.public')}}&nbsp;&nbsp;&nbsp;
                    {!! Form::radio('type','0') !!} {{Lang::get('lang.private')}}
                </div>
            </div>
            <!-- Topic text form Required -->
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('topic') ? 'has-error' : '' }}">
                    {!! Form::label('topic',Lang::get('lang.topic')) !!} <span class="text-red"> *</span>
                    {!! Form::text('topic',null,['class' => 'form-control']) !!}
                </div>
            </div>
            <!-- Parent Topic: Drop down: value from helptopic table -->
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('parent_topic') ? 'has-error' : '' }}">
                    {!! Form::label('parent_topic',Lang::get('lang.parent_topic')) !!}
                    {!!Form::select('parent_topic', [''=>Lang::get('lang.select_a_parent_topic'),Lang::get('lang.help_topic')=>$topics->lists('topic','id')->toArray()],null,['class' => 'form-control']) !!}
                </div>
            </div>
            <!-- Custom Form: Drop down: value from form table -->
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('custom_form') ? 'has-error' : '' }}">
                    {!! Form::label('custom_form',Lang::get('lang.Custom_form')) !!}
                    {!!Form::select('custom_form', [''=>Lang::get('lang.select_a_form'),Lang::get('lang.custom_form')=>$forms->lists('formname','id')->toArray()],null,['class' => 'form-control']) !!}
                </div>
            </div>
            <!-- Department:	Drop down: value Department form table -->
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('department') ? 'has-error' : '' }}">
                    {!! Form::label('department',Lang::get('lang.department')) !!}
                    {!!Form::select('department', [''=>Lang::get('lang.select_a_department'),Lang::get('lang.departments')=>$departments->lists('name','id')->toArray()],null,['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <!-- Priority:	Drop down: value from Priority  table -->
        <div class="row">
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('priority') ? 'has-error' : '' }}">
                    {!! Form::label('priority',Lang::get('lang.priority')) !!} <span class="text-red"> *</span>
                    {!!Form::select('priority', [''=>Lang::get('lang.select_a_priority'),Lang::get('lang.priorities')=>$priority->lists('priority_desc','priority_id')->toArray()],null,['class' => 'form-control']) !!}
                </div>
            </div>
            <!-- SLA Plan:	 Drop down: value SLA Plan  table-->
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('sla_plan') ? 'has-error' : '' }}">
                    {!! Form::label('sla_plan',Lang::get('lang.SLA_plan')) !!}
                    {!!Form::select('sla_plan', [''=>Lang::get('lang.select_a_sla_plan'),Lang::get('lang.sla_plans')=>$slas->lists('name','id')->toArray()],null,['class' => 'form-control']) !!}
                </div>
            </div>
            <!-- Auto-assign To:	Drop Down: value  from Agent table   -->
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('auto_assign') ? 'has-error' : '' }}">
                    {!! Form::label('auto_assign',Lang::get('lang.auto_assign')) !!}
                    {!!Form::select('auto_assign', [''=>Lang::get('lang.select_an_agent'),Lang::get('lang.agents')=>$agents->lists('full_name','id')->toArray()],null,['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <!-- Auto-response:	checkbox : Disable new ticket auto-response  -->
        <div class="row">
            <div class="col-md-12">
                <!-- intrnal Notes : Textarea :  -->
                <div class="form-group">
                    {!! Form::label('internal_notes',Lang::get('lang.internal_notes')) !!}
                    {!! Form::textarea('internal_notes',null,['class' => 'form-control','size' => '10x5']) !!}
                </div>
            </div>
            <!-- Submit button -->
        </div>
    </div>
    <div class="box-footer">
        <div class="form-group">
            <input type="checkbox" name="sys_help_tpoic" @if($sys_help_topic->help_topic == $topics->id) checked disabled @endif> {{ Lang::get('lang.make-default-helptopic')}}
        </div>
        {!! Form::submit(Lang::get('lang.update'),['class'=>'btn btn-primary'])!!}
    </div>
</div>
<!-- close form -->
{!! Form::close() !!}
@stop