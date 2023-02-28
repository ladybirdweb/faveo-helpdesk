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

@section('groups')
class="nav-link active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{Lang::get('lang.staffs')}}</h1>
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
{!! Form::open(array('route' => 'groups.store' , 'method' => 'post') )!!}
@if(Session::has('errors'))
<div class="alert alert-danger alert-dismissable">
    <i class="fas fa-ban"></i>
    <b> {!! Lang::get('lang.alert') !!}</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <br/>
    @if($errors->first('name'))
    <li class="error-message-padding">{!! $errors->first('name', ':message') !!}</li>
    @endif
    @if($errors->first('group_status'))
    <li class="error-message-padding">{!! $errors->first('group_status', ':message') !!}</li>
    @endif
</div>
@endif
<div class="card card-light">
    <div class="card-header">
        <h3 class="card-title"> {{Lang::get('lang.create_a_group')}} </h3> 
    </div>
    <div class="card-body">
        
        <div class="row">
            <!-- name -->
            <div class="col-sm-4 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                {!! Form::label('name',Lang::get('lang.name')) !!} <span class="text-red"> *</span>
                {!! Form::text('name',null,['class' => 'form-control']) !!}
            </div>
            <!-- group status -->
            <div class="col-sm-6 form-group {{ $errors->has('group_status') ? 'has-error' : '' }}">
                {!! Form::label('group_status',Lang::get('lang.status')) !!}
                <div class="row">
                    <div class="col-sm-2">
                        {!! Form::radio('group_status','1',true) !!} {{Lang::get('lang.active')}}
                    </div>
                    <div class="col-sm-3">
                        {!! Form::radio('group_status','0',null) !!} {{Lang::get('lang.inactive')}}
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-light">
            
            <div class="card-header">
                
                <h3 class="card-title">Permissions</h3>
            </div>

            <div class="card-body">
                <!-- can create ticket -->
                <div class="row">
                    {!! Form::checkbox('can_create_ticket',1,null,['class' => 'checkbox']) !!}
                    &nbsp;{!! Form::label('can_create_ticket',Lang::get('lang.can_create_ticket'),['style' => 'line-height:1;']) !!}
                </div>
                <!-- can_edit_ticket -->
                <div class="row">
                    {!! Form::checkbox('can_edit_ticket',1,null,['class' => 'checkbox']) !!}
                    &nbsp;{!! Form::label('can_edit_ticket',Lang::get('lang.can_edit_ticket'),['style' => 'line-height:1;']) !!}
                </div>
                <!-- can post ticket -->
                <div class="row">
                    {!! Form::checkbox('can_post_ticket',1,null,['class' => 'checkbox']) !!}
                    &nbsp;{!! Form::label('can_post_ticket',Lang::get('lang.can_post_ticket'),['style' => 'line-height:1;']) !!}
                </div>
                <!-- can_close_ticket -->
                <div class="row">
                    {!! Form::checkbox('can_close_ticket',1,null,['class' => 'checkbox']) !!}
                    &nbsp;{!! Form::label('can_close_ticket',Lang::get('lang.can_close_ticket'),['style' => 'line-height:1;']) !!}
                </div>
                <!-- can delete ticket -->
                <div class="row">
                    {!! Form::checkbox('can_delete_ticket',1,null,['class' => 'checkbox']) !!}
                    &nbsp;{!! Form::label('can_delete_ticket',Lang::get('lang.can_delete_ticket'),['style' => 'line-height:1;']) !!}
                </div>
                <!-- can assign ticket -->
                <div class="row">
                    {!! Form::checkbox('can_assign_ticket',1,null,['class' => 'checkbox']) !!}
                    &nbsp;{!! Form::label('can_assign_ticket',Lang::get('lang.can_assign_ticket'),['style' => 'line-height:1;']) !!}
                </div>
                <!-- can ban email -->
                <div class="row">
                    {!! Form::checkbox('can_ban_email',1,null,['class' => 'checkbox']) !!}
                    &nbsp;{!! Form::label('can_ban_email',Lang::get('lang.can_ban_emails'),['style' => 'line-height:1;']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        {!! Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary'])!!}
    </div>
</div>
{!!Form::close()!!}
@stop