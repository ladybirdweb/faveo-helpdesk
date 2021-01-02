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

@section('auto-response')
class="nav-link active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{ Lang::get('lang.settings') }}</h1>
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
{!! Form::model($responders,['url' => 'postresponder/'.$responders->id, 'method' => 'PATCH']) !!}
<!-- check whether success or not -->
@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <i class="fas fa-check-circle"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {!!Session::get('success')!!}
</div>
@endif
<!-- failure message -->
@if(Session::has('fails'))
<div class="alert alert-danger alert-dismissable">
    <i class="fas fa-ban"></i>
    <b>{!! lang::get('lang.alert') !!}!</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {!!Session::get('fails')!!}
</div>
@endif
<div class="card card-light">
    <div class="card-header">
        <h3 class="card-title">{{Lang::get('lang.auto_responce-settings')}}</h3> 
    </div>
    <!-- New Ticket: CHECKBOX	 Ticket Owner   -->
    <div class="card-body">
        
        <div class="form-group">
            {!! Form::checkbox('new_ticket',1) !!} &nbsp;
            {!! Form::label('new_ticket',Lang::get('lang.new_ticket')) !!}
        </div>
        <!-- New Ticket by Agent: CHECKBOX	 Ticket Owner   -->
        <div>
            {!! Form::checkbox('agent_new_ticket',1) !!}&nbsp;
            {!! Form::label('agent_new_ticket',Lang::get('lang.new_ticket_by_agent')) !!}
        </div>
    </div>
    <div class="card-footer">
        {!! Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary'])!!}
    </div>
</div>
@stop
