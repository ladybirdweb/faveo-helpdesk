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

@section('alert')
class="nav-link active"
@stop


@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{Lang::get('lang.settings')}}</h1>
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
    <i class="fas fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <b>{!! lang::get('lang.alert') !!}!</b><br/>
    {!!Session::get('fails')!!}
</div>
@endif
<div class="card card-light">
    <div class="card-header">
        <h3 class="card-title">{{Lang::get('lang.alert_notices_setitngs')}}</h3> 
    </div>

    <div class="card-body">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-light">
                    <div class="card-header">
                        <h3 class="card-title">{{Lang::get('lang.new_ticket_alert')}}</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <div class="card-body">
                        <div class="form-group">
                            <!-- Status:     Enable   Disable     -->
                            {!! Form::label('ticket_status',Lang::get('lang.status').":") !!}&nbsp;&nbsp;
                            {!! Form::radio('ticket_status',1) !!} {!! Lang::get('lang.enable') !!} &nbsp;&nbsp; {!! Form::radio('ticket_status',0) !!}  {!! Lang::get('lang.disable') !!}
                        </div>
                        <div class="form-group">
                            <!-- Admin Email -->
                            {!! Form::checkbox('ticket_admin_email',1) !!}
                            {!! Form::label('ticket_admin_email',Lang::get('lang.admin_email_2')) !!}
                        </div>
                        <!-- Department Members -->
                        <div class="form-group">
                            {!! Form::checkbox('ticket_department_member',1) !!}
                            {!! Form::label('ticket_department_member',Lang::get('lang.department_members')) !!}
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <!-- /.box -->
            </div><!--/.col (left) -->
            <div class="col-md-6">
                <div class="card card-light">
                    <div class="card-header">
                        <h3 class="card-title">{{Lang::get('lang.ticket_assignment_alert')}}</h3>
                    </div><!-- /.box-header -->
                    <div class="card-body">
                        <!-- Status:     Enable      Disable      -->
                        <div class="form-group">
                            {!! Form::label('assignment_status',Lang::get('lang.status').":") !!}
                            {!! Form::radio('assignment_status',1) !!} {!! Lang::get('lang.enable') !!} &nbsp;&nbsp; {!! Form::radio('assignment_status',0) !!}  {!! Lang::get('lang.disable') !!}
                        </div>
                        <!-- Assigned Agent / Team -->
                        <div class="form-group">
                            {!! Form::checkbox('assignment_assigned_agent',1) !!}
                            {!! Form::label('assignment_assigned_agent',Lang::get('lang.agent')) !!}
                        </div>
                        <!-- Team Members -->
                        <div class="form-group">
                            {!! Form::checkbox('assignment_team_member',1) !!}
                            {!! Form::label('assignment_team_member',Lang::get('lang.team_members')) !!}
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!--/.col (left) -->
        </div>
    </div>

    <div class="card-footer">
        {!! Form::submit(Lang::get('lang.submit'),['class'=>' btn btn-primary'])!!}
    </div>
</div>
@stop
