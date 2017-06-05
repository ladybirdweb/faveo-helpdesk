@extends('themes.default1.admin.layout.admin')

@section('Staffs')
active
@stop

@section('staffs-bar')
active
@stop

@section('departments')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{Lang::get('lang.departments')}}</h1>
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
{!!Form::model($departments, ['url'=>'departments/'.$departments->id , 'method'=> 'PATCH'])!!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.edit_department') !!}</h3>
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
            @if($errors->first('account_status'))
            <li class="error-message-padding">{!! $errors->first('account_status', ':message') !!}</li>
            @endif
            @if($errors->first('sla'))
            <li class="error-message-padding">{!! $errors->first('sla', ':message') !!}</li>
            @endif
            @if($errors->first('manager'))
            <li class="error-message-padding">{!! $errors->first('manager', ':message') !!}</li>
            @endif
            @if($errors->first('outgoing_email'))
            <li class="error-message-padding">{!! $errors->first('outgoing_email', ':message') !!}</li>
            @endif
        </div>
        @endif
        <div class="row">
            <!-- name -->
            <div class="col-xs-4 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                {!! Form::label('name',Lang::get('lang.name')) !!} <span class="text-red"> *</span>
                {!! Form::text('name',null,['class' => 'form-control']) !!}
            </div>
            <!-- account status -->
            <div class="col-xs-4 form-group {{ $errors->has('account_status') ? 'has-error' : '' }}">
                {!! Form::label('type',Lang::get('lang.type')) !!}
                <a href="#" data-toggle="tooltip" title="{!! Lang::get('tooltip.department-type') !!}"><i class="fa fa-question-circle" style="padding: 0px;"></i></a>
                <div class="row">
                    <div class="col-xs-6">
                        {!! Form::radio('type','1',true) !!} {{Lang::get('lang.public')}}
                    </div>
                    <div class="col-xs-6">
                        {!! Form::radio('type','0',null) !!} {{Lang::get('lang.private')}}
                    </div>
                </div>
            </div>
            <!-- sla -->
            
            <!-- manager -->
            <div class="col-xs-4 form-group {{ $errors->has('manager') ? 'has-error' : '' }}">
                {!! Form::label('manager',Lang::get('lang.manager')) !!}
                <a href="#" data-toggle="tooltip" title="{!! Lang::get('tooltip.department-manager') !!}"><i class="fa fa-question-circle" style="padding: 0px;"></i></a>
                {!!Form::select('manager',[null=>Lang::get('lang.select_a_manager'),Lang::get('lang.manager')=>$user->pluck('full_name','id')->toArray()],null,['class' => 'form-control select']) !!}
            </div>
        </div>
    </div>
    <div class="box-header with-border">
        <h4 class="box-title">{!! Lang::get('lang.outgoing_email_settings') !!}</h4>
    </div>
    <div class="box-body">
        <div class="row">
            <!-- sla -->
            <div class="col-xs-6 form-group {{ $errors->has('outgoing_email') ? 'has-error' : '' }}">
                {!! Form::label('outgoing_email',Lang::get('lang.outgoing_email')) !!}
                <a href="#" data-toggle="tooltip" title="{!! Lang::get('tooltip.department-outgoin-mail') !!}"><i class="fa fa-question-circle" style="padding: 0px;"></i></a>
                {!!Form::select('outgoing_email', ['' => Lang::get('lang.system_default'), Lang::get('lang.emails')=>$emails->pluck('email_name','id')->toArray()],null,['class' => 'form-control select']) !!}
            </div>
        </div>
        <div>
            <h4>{!! Lang::get('lang.department_signature') !!}</h4>
        </div>
        <div class="">
            {!! Form::textarea('department_sign',null,['class' => 'form-control','size' => '30x5']) !!}
        </div>
        <div class="form-group">
            <input type="checkbox" name="sys_department" @if($sys_department->department == $departments->id) checked disabled @endif> {{ Lang::get('lang.make-default-department')}}&nbsp;<a href="#" data-toggle="tooltip" title="{!! Lang::get('tooltip.default-department') !!}"><i class="fa fa-question-circle" style="padding: 0px;"></i></a>
        </div>
    </div>

    <div class="box-footer">

        {!! Form::submit(Lang::get('lang.update'),['class'=>'form-group btn btn-primary'])!!}    
    </div>
    {!!Form::close()!!}
</div>
@stop