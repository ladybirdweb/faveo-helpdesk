@extends('themes.default1.admin.layout.admin')

@section('Tickets')
active
@stop

@section('tickets-bar')
active
@stop

@section('alert')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{trans('lang.settings')}}</h1>
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
{!! Form::model($alerts,['url' => 'postalert/'.$alerts->id, 'method' => 'PATCH']) !!}
<div class="box box-primary">
    <div class="box-header">
        <h4 class="box-title">{{trans('lang.alert_notices_setitngs')}}</h4> {!! Form::submit(trans('lang.submit'),['class'=>' btn btn-primary pull-right'])!!}
    </div>

</div>
@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <i class="fa  fa-check-circle"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {!!Session::get('success')!!}
</div>
@endif
<!-- failure message -->
@if(Session::has('fails'))
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <b>{!! trans('lang.alert') !!}!</b><br/>
    {!!Session::get('fails')!!}
</div>
@endif
<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{trans('lang.new_ticket_alert')}}</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <div class="form-group">
                    <!-- Status:     Enable   Disable     -->
                    {!! Form::label('ticket_status',trans('lang.status').":") !!}&nbsp;&nbsp;
                    {!! Form::radio('ticket_status',1) !!} {!! trans('lang.enable') !!} &nbsp;&nbsp; {!! Form::radio('ticket_status',0) !!}  {!! trans('lang.disable') !!}
                </div>
                <div class="form-group">
                    <!-- Admin Email -->
                    {!! Form::checkbox('ticket_admin_email',1) !!}
                    {!! Form::label('ticket_admin_email',trans('lang.admin_email_2')) !!}
                </div>
                <!-- Department Members -->
                <div class="form-group">
                    {!! Form::checkbox('ticket_department_member',1) !!}
                    {!! Form::label('ticket_department_member',trans('lang.department_members')) !!}
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
        <!-- /.box -->
    </div><!--/.col (left) -->
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{trans('lang.ticket_assignment_alert')}}</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <!-- Status:     Enable      Disable      -->
                <div class="form-group">
                    {!! Form::label('assignment_status',trans('lang.status').":") !!}
                    {!! Form::radio('assignment_status',1) !!} {!! trans('lang.enable') !!} &nbsp;&nbsp; {!! Form::radio('assignment_status',0) !!}  {!! trans('lang.disable') !!}
                </div>
                <!-- Assigned Agent / Team -->
                <div class="form-group">
                    {!! Form::checkbox('assignment_assigned_agent',1) !!}
                    {!! Form::label('assignment_assigned_agent',trans('lang.agent')) !!}
                </div>
                <!-- Team Members -->
                <div class="form-group">
                    {!! Form::checkbox('assignment_team_member',1) !!}
                    {!! Form::label('assignment_team_member',trans('lang.team_members')) !!}
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>
@stop
