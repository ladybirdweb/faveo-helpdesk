@extends('themes.default1.admin.layout.admin')

@section('Staffs')
class="nav-link active"
@stop

@section('staff-menu-parent')
class="nav-item menu-open"
@stop

@section('staff-menu-open')
class="nav nav-treeview menu-open"
@stop

@section('departments')
class="nav-link active"
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
{!! Form::open(array('route' => 'departments.store') )!!}
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
<div class="card card-light">
    <div class="card-header">
        <h3 class="card-title">{!! Lang::get('lang.create_a_department') !!}</h3>	
    </div>
    <div class="card-body">
        <div class="row">
            <!-- name -->
            <div class="col-sm-6 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                {!! Form::label('name',Lang::get('lang.name')) !!}  <span class="text-red"> *</span>
                {!! Form::text('name',null,['class' => 'form-control']) !!}
            </div>
            <!-- account status -->
            <div class="col-sm-6 form-group {{ $errors->has('account_status') ? 'has-error' : '' }}">
                {!! Form::label('type',Lang::get('lang.type')) !!}
                <div class="row">
                    <div class="col-sm-2">
                        {!! Form::radio('type','1',true) !!} {{Lang::get('lang.public')}}
                    </div>
                    <div class="col-sm-3">
                        {!! Form::radio('type','0',null) !!} {{Lang::get('lang.private')}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- slaplan -->
            <div class="col-sm-6 form-group {{ $errors->has('sla') ? 'has-error' : '' }}">
                {!! Form::label('sla',Lang::get('lang.SLA_plan')) !!}
                {!!Form::select('sla', [''=>Lang::get('lang.select_a_sla'), Lang::get('lang.sla_plans')=>$slas->pluck('grace_period','id')->toArray()],null,['class' => 'form-control select']) !!}
            </div>
            <!-- manager -->
            <div class="col-sm-6 form-group {{ $errors->has('manager') ? 'has-error' : '' }}">
                {!! Form::label('manager',Lang::get('lang.manager')) !!}
                {!!Form::select('manager',[''=>Lang::get('lang.select_a_manager'),Lang::get('lang.manager')=>$user->pluck('full_name','id')->toArray()],null,['class' => 'form-control select']) !!}
            </div>
        </div>

        <div class="row">
            <!-- sla -->
            <div class="col-sm-6 form-group {{ $errors->has('outgoing_email') ? 'has-error' : '' }}">
                {!! Form::label('outgoing_email',Lang::get('lang.outgoing_email')) !!}
                {!!Form::select('outgoing_email', ['' => Lang::get('lang.system_default'), Lang::get('lang.emails')=>$emails->pluck('email_name','id')->toArray()],null,['class' => 'form-control select']) !!}
            </div>
        </div>
        <div>
            <input type="checkbox" name="sys_department"> {{ Lang::get('lang.make-default-department')}}
        </div>
    </div>
    <div class="card-footer">
        {!! Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary'])!!}    
    </div>
    {!!Form::close()!!}
</div>
@stop