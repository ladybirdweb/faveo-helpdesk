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
{!! Form::open(['url' => 'alert', 'method' => 'patch']) !!}
<div class="box box-primary">
    <div class="box-header">
        <h4 class="box-title">
        {{Lang::get('lang.alert_notices_setitngs')}}</h4> {!! Form::submit(Lang::get('lang.submit'),['class'=>' btn btn-primary pull-right'])!!}
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
    <b>{!! lang::get('lang.alert') !!}!</b><br/>
    {!!Session::get('fails')!!}
</div>
@endif

<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{Lang::get('lang.new_ticket_alert')}}</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <div class="form-group">
                    <!-- Status:     Enable   Disable     -->
                    {!! Form::label('new_ticket_alert',Lang::get('lang.status').":") !!}&nbsp;&nbsp;
                    {!! Form::radio('new_ticket_alert',1,$alerts->isValueExists('new_ticket_alert',1)) !!} {!! Lang::get('lang.enable') !!} &nbsp;&nbsp; 
                    {!! Form::radio('new_ticket_alert',0,$alerts->isValueExists('new_ticket_alert',0)) !!}  {!! Lang::get('lang.disable') !!}

                </div>
                <div class="form-group">
                 <!-- Mode :   Email    Sms -->
                     {!! Form::label('new_ticket_mode',Lang::get('lang.mode').":") !!}&nbsp;&nbsp;
                    {!! Form::checkbox('new_ticket_alert_mode[]','email',$alerts->isValueExists('new_ticket_alert_mode','email')) !!} {!! Lang::get('lang.email') !!} &nbsp;&nbsp; 
                    {{--{!! Form::checkbox('new_ticket_alert_mode[]','sms',$alerts->isValueExists('new_ticket_alert_mode','sms')) !!}  {!! Lang::get('lang.sms') !!}--}}
                    {!! Form::checkbox('new_ticket_alert_mode[]','system',$alerts->isValueExists('new_ticket_alert_mode','system')) !!}  {!! Lang::get('lang.in_app_system') !!}
                </div>
                <div class="form-group">
                    <!--Client -->
                    <div class="form-group">
                        {!! Form::checkbox('new_ticket_alert_persons[]','client',$alerts->isValueExists('new_ticket_alert_persons','client')) !!}
                        {!! Form::label('new_ticket_alert_persons',Lang::get('lang.client')) !!}
                    </div>
                    <!-- Admin Email -->
                    {!! Form::checkbox('new_ticket_alert_persons[]','admin',$alerts->isValueExists('new_ticket_alert_persons','admin')) !!}
                    {!! Form::label('ticket_admin_email',Lang::get('lang.admin')) !!}
                </div>
                <!-- Department Members -->
                <div class="form-group">
                    {!! Form::checkbox('new_ticket_alert_persons[]','department_members',$alerts->isValueExists('new_ticket_alert_persons','department_members')) !!}
                    {!! Form::label('ticket_department_member',Lang::get('lang.department_members')) !!}
                </div>

                <!-- Department Manager -->
                <div class="form-group">
                    {!! Form::checkbox('new_ticket_alert_persons[]','department_manager',$alerts->isValueExists('new_ticket_alert_persons','department_manager')) !!}
                    {!! Form::label('ticket_department_manager',Lang::get('lang.department_manager')) !!}
                </div>
                <!-- Organization Account Manager -->

                <div class="form-group">
                    {!! Form::checkbox('new_ticket_alert_persons[]','organization_manager',$alerts->isValueExists('new_ticket_alert_persons','organization_manager')) !!}
                    {!! Form::label('organization_account_manager',Lang::get('lang.organization_account_manager')) !!}
                </div>


                
            </div><!-- /.box-body -->
        </div><!-- /.box -->
        <!-- /.box -->
    </div><!--/.col (left) -->

    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{Lang::get('lang.ticket_assignment_alert')}}</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <!-- Status:     Enable      Disable      -->
                <div class="form-group">
                    {!! Form::label('ticket_assign_alert',Lang::get('lang.status').":") !!}
                    {!! Form::radio('ticket_assign_alert',1,$alerts->isValueExists('ticket_assign_alert',1)) !!} {!! Lang::get('lang.enable') !!} &nbsp;&nbsp; 
                    {!! Form::radio('ticket_assign_alert',0,$alerts->isValueExists('ticket_assign_alert',0)) !!}  {!! Lang::get('lang.disable') !!}
                </div>

                   <div class="form-group">
                 <!-- Mode :   Email    Sms -->
                     {!! Form::label('ticket_assign_alert_mode[]',Lang::get('lang.mode').":") !!}&nbsp;&nbsp;
                    {!! Form::checkbox('ticket_assign_alert_mode[]','email',$alerts->isValueExists('ticket_assign_alert_mode','email')) !!} {!! Lang::get('lang.email') !!} &nbsp;&nbsp; 
                    {{--{!! Form::checkbox('ticket_assign_alert_mode[]','sms',$alerts->isValueExists('ticket_assign_alert_mode','sms')) !!}  {!! Lang::get('lang.sms') !!}--}}
                     {!! Form::checkbox('ticket_assign_alert_mode[]','system',$alerts->isValueExists('ticket_assign_alert_mode','system')) !!}  {!! Lang::get('lang.in_app_system') !!}
                 </div>
                
                <div class="form-group">
                    {!! Form::checkbox('ticket_assign_alert_persons[]','admin',$alerts->isValueExists('ticket_assign_alert_persons','admin')) !!}
                    {!! Form::label('ticket_assign_alert_admin',Lang::get('lang.admin')) !!}
                </div>
                
                <!-- Assigned Agent / Team -->
                <div class="form-group">
                    {!! Form::checkbox('ticket_assign_alert_persons[]','agent',$alerts->isValueExists('ticket_assign_alert_persons','agent')) !!}
                    {!! Form::label('ticket_assign_alert_agent',Lang::get('lang.agent')) !!}
                </div>
                <div class="form-group">
                    {!! Form::checkbox('ticket_assign_alert_persons[]','assigned_agent_team',$alerts->isValueExists('ticket_assign_alert_persons','assigned_agent_team')) !!}
                    {!! Form::label('assignment_alert_persons',Lang::get('lang.assigned_agent')) !!}
                </div>
                
                <!-- Department -->
                <div class="form-group">
                    {!! Form::checkbox('ticket_assign_alert_persons[]','department_members',$alerts->isValueExists('ticket_assign_alert_persons','department_members')) !!}
                    {!! Form::label('ticket_assign_alert_agent',Lang::get('lang.department_members')) !!}
                </div>
                <div class="form-group">
                    {!! Form::checkbox('ticket_assign_alert_persons[]','department_manager',$alerts->isValueExists('ticket_assign_alert_persons','department_manager')) !!}
                    {!! Form::label('assignment_alert_persons',Lang::get('lang.department_manager')) !!}
                </div>
                <!-- End Department -->
                <!-- Team Members -->
                <div class="form-group">
                    {!! Form::checkbox('ticket_assign_alert_persons[]','team_members',$alerts->isValueExists('ticket_assign_alert_persons','team_members')) !!}
                    {!! Form::label('assignment_team_member',Lang::get('lang.team_members')) !!}
                </div>
                <div class="form-group">
                    {!! Form::checkbox('ticket_assign_alert_persons[]','team_lead',$alerts->isValueExists('ticket_assign_alert_persons','team_lead')) !!}
                    {!! Form::label('assignment_team_member',Lang::get('lang.team_lead')) !!}
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>

<!-- new row for Message alert  -->
<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{Lang::get('lang.report')}}</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <div class="form-group">
                    <!-- Status:     Enable   Disable     -->
                    {!! Form::label('notification_alert',Lang::get('lang.status').":") !!}&nbsp;&nbsp;
                    {!! Form::radio('notification_alert',1,$alerts->isValueExists('notification_alert',1)) !!} {!! Lang::get('lang.enable') !!} &nbsp;&nbsp; 
                    {!! Form::radio('notification_alert',0,$alerts->isValueExists('notification_alert',0)) !!}  {!! Lang::get('lang.disable') !!}

                </div>
                <div class="form-group">
                 <!-- Mode :   Email    Sms -->
                     {!! Form::label('notification_alert_mode[]',Lang::get('lang.mode').":") !!}&nbsp;&nbsp;
                    {!! Form::checkbox('notification_alert_mode[]','email',$alerts->isValueExists('notification_alert_mode','email')) !!} {!! Lang::get('lang.email') !!} &nbsp;&nbsp; 
                    {{--{!! Form::checkbox('notification_alert_mode[]','sms',$alerts->isValueExists('notification_alert_mode','sms')) !!}  {!! Lang::get('lang.sms') !!}--}}
                    {!! Form::checkbox('notification_alert_mode[]','system',$alerts->isValueExists('notification_alert_mode','system')) !!}  {!! Lang::get('lang.in_app_system') !!}
                 </div>
                <div class="form-group">
                    <!-- Last responds -->
                    {!! Form::checkbox('notification_alert_persons[]','admin',$alerts->isValueExists('notification_alert_persons','admin')) !!}
                    {!! Form::label('last_respondent',Lang::get('lang.admin')) !!}
                </div>
                <!-- Assigned Agent/Team -->
                <div class="form-group">
                    {!! Form::checkbox('notification_alert_persons[]','agent',$alerts->isValueExists('notification_alert_persons','agent')) !!}
                    {!! Form::label('assigned_agent_team',Lang::get('lang.agent')) !!}
                </div>

                <!-- Department Manager -->
                <div class="form-group">
                    {!! Form::checkbox('notification_alert_persons[]','department_manager',$alerts->isValueExists('notification_alert_persons','department_manager')) !!}
                    {!! Form::label('ticket_department_manager',Lang::get('lang.department_manager')) !!}
                </div>
                <!-- Organization Account Manager -->
                {{--
                <div class="form-group">
                    {!! Form::checkbox('notification_alert_persons[]','organization_manager',$alerts->isValueExists('notification_alert_persons','organization_manager')) !!}
                    {!! Form::label('organization_account_manager',Lang::get('lang.organization_account_manager')) !!}
                </div>
                --}}
                 <div class="form-group">
                    {!! Form::checkbox('notification_alert_persons[]','team_lead',$alerts->isValueExists('notification_alert_persons','team_lead')) !!}
                    {!! Form::label('organization_account_manager',Lang::get('lang.team_lead')) !!}
                </div>


                
            </div><!-- /.box-body -->
        </div><!-- /.box -->
        <!-- /.box -->
    </div><!--/.col (left) -->
    
      
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{Lang::get('lang.new_ticket_confirmation_alert')}}</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <div class="form-group">
                    <!-- Status:     Enable   Disable     -->
                    {!! Form::label('new_ticket_confirmation_alert',Lang::get('lang.status').":") !!}&nbsp;&nbsp;
                    {!! Form::radio('new_ticket_confirmation_alert',1,$alerts->isValueExists('new_ticket_confirmation_alert',1)) !!} {!! Lang::get('lang.enable') !!} &nbsp;&nbsp; 
                    {!! Form::radio('new_ticket_confirmation_alert',0,$alerts->isValueExists('new_ticket_confirmation_alert',0)) !!}  {!! Lang::get('lang.disable') !!}

                </div>
                <div class="form-group">
                 <!-- Mode :   Email    Sms -->
                     {!! Form::label('new_ticket_confirmation_alert_mode',Lang::get('lang.mode').":") !!}&nbsp;&nbsp;
                    {!! Form::checkbox('new_ticket_confirmation_alert_mode[]','email',$alerts->isValueExists('new_ticket_confirmation_alert_mode','email')) !!} {!! Lang::get('lang.email') !!} &nbsp;&nbsp; 
                    {{--{!! Form::checkbox('new_ticket_alert_mode[]','sms',$alerts->isValueExists('new_ticket_alert_mode','sms')) !!}  {!! Lang::get('lang.sms') !!}--}}
                    {!! Form::checkbox('new_ticket_confirmation_alert_mode[]','system',$alerts->isValueExists('new_ticket_confirmation_alert_mode','system')) !!}  {!! Lang::get('lang.in_app_system') !!}
                </div>
                <div class="form-group">
                    
                        {!! Form::checkbox('new_ticket_confirmation_alert_persons[]','client',$alerts->isValueExists('new_ticket_confirmation_alert_persons','client')) !!}
                        {!! Form::label('new_ticket_confirmation_alert_persons',Lang::get('lang.client')) !!}
                  
                    
                </div>
                
            </div><!-- /.box-body -->
        </div><!-- /.box -->
        <!-- /.box -->
    </div><!--/.col (left) -->
    
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{Lang::get('lang.new_internal_activity_alert')}}</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <!-- Status:     Enable      Disable      -->
                <div class="form-group">
                    {!! Form::label('internal_activity_alert',Lang::get('lang.status').":") !!}
                    {!! Form::radio('internal_activity_alert',1,$alerts->isValueExists('internal_activity_alert',1)) !!} {!! Lang::get('lang.enable') !!} &nbsp;&nbsp; 
                    {!! Form::radio('internal_activity_alert',0,$alerts->isValueExists('internal_activity_alert',0)) !!}  {!! Lang::get('lang.disable') !!}
                </div>

                   <div class="form-group">
                 <!-- Mode :   Email    Sms -->
                     {!! Form::label('internal_activity_alert_mode',Lang::get('lang.mode').":") !!}&nbsp;&nbsp;
                    {!! Form::checkbox('internal_activity_alert_mode[]','email',$alerts->isValueExists('internal_activity_alert_mode','email')) !!} {!! Lang::get('lang.email') !!} &nbsp;&nbsp; 
                   {{-- {!! Form::checkbox('internal_activity_alert_mode[]','sms',$alerts->isValueExists('internal_activity_alert_mode','sms')) !!}  {!! Lang::get('lang.sms') !!} --}}
                    {!! Form::checkbox('internal_activity_alert_mode[]','system',$alerts->isValueExists('internal_activity_alert_mode','system')) !!}  {!! Lang::get('lang.in_app_system') !!}
                 </div>

                <!-- Assigned Agent -->
                <div class="form-group">
                    {!! Form::checkbox('internal_activity_alert_persons[]','agent',$alerts->isValueExists('internal_activity_alert_persons','agent')) !!}
                    {!! Form::label('assignment_assigned_agent',Lang::get('lang.agent')) !!}
                </div>
                <!-- admin -->
                <div class="form-group">
                    {!! Form::checkbox('internal_activity_alert_persons[]','admin',$alerts->isValueExists('internal_activity_alert_persons','admin')) !!}
                    {!! Form::label('assignment_assigned_agent',Lang::get('lang.admin')) !!}
                </div>
                <!-- end admin -->
                
                <!-- department members -->
                <div class="form-group">
                    {!! Form::checkbox('internal_activity_alert_persons[]','department_members',$alerts->isValueExists('internal_activity_alert_persons','department_members')) !!}
                    {!! Form::label('assignment_assigned_agent',Lang::get('lang.department_members')) !!}
                </div>
                <!-- end department members -->
                
                <!-- department manager -->
                <div class="form-group">
                    {!! Form::checkbox('internal_activity_alert_persons[]','department_manager',$alerts->isValueExists('internal_activity_alert_persons','department_manager')) !!}
                    {!! Form::label('assignment_assigned_agent',Lang::get('lang.department_manager')) !!}
                </div>
                <!-- end department manager -->
                
                <div class="form-group">
                    {!! Form::checkbox('internal_activity_alert_persons[]','assigned_agent_team',$alerts->isValueExists('internal_activity_alert_persons','assigned_agent_team')) !!}
                    {!! Form::label('assignment_assigned_agent',Lang::get('lang.assigned_agent')) !!}
                </div>
                
                <!-- Team Members -->
                <div class="form-group">
                    {!! Form::checkbox('internal_activity_alert_persons[]','team_members',$alerts->isValueExists('internal_activity_alert_persons','team_members')) !!}
                    {!! Form::label('assignment_team_member',Lang::get('lang.team_members')) !!}
                </div>
                <div class="form-group">
                    {!! Form::checkbox('internal_activity_alert_persons[]','team_lead',$alerts->isValueExists('internal_activity_alert_persons','team_lead')) !!}
                    {!! Form::label('assignment_team_member',Lang::get('lang.team_lead')) !!}
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>


<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{Lang::get('lang.ticket_transfer_alert')}}</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <div class="form-group">
                    <!-- Status:     Enable   Disable     -->
                    {!! Form::label('ticket_transfer_alert',Lang::get('lang.status').":") !!}&nbsp;&nbsp;
                    {!! Form::radio('ticket_transfer_alert',1,$alerts->isValueExists('ticket_transfer_alert',1)) !!} {!! Lang::get('lang.enable') !!} &nbsp;&nbsp; 
                    {!! Form::radio('ticket_transfer_alert',0,$alerts->isValueExists('ticket_transfer_alert',0)) !!}  {!! Lang::get('lang.disable') !!}

                </div>
                <div class="form-group">
                 <!-- Mode :   Email    Sms -->
                     {!! Form::label('ticket_transfer_alert_mode',Lang::get('lang.mode').":") !!}&nbsp;&nbsp;
                    {!! Form::checkbox('ticket_transfer_alert_mode[]','email',$alerts->isValueExists('ticket_transfer_alert_mode','email')) !!} {!! Lang::get('lang.email') !!} &nbsp;&nbsp; 
                   {{-- {!! Form::checkbox('ticket_transfer_alert_mode[]','sms',$alerts->isValueExists('ticket_transfer_alert_mode','sms')) !!}  {!! Lang::get('lang.sms') !!}--}}
                    {!! Form::checkbox('ticket_transfer_alert_mode[]','system',$alerts->isValueExists('ticket_transfer_alert_mode','system')) !!}  {!! Lang::get('lang.in_app_system') !!}
                 </div>
                
                <!-- admin-->
                <div class="form-group">
                    {!! Form::checkbox('ticket_transfer_alert_persons[]','admin',$alerts->isValueExists('ticket_transfer_alert_persons','admin')) !!}
                    {!! Form::label('assigned_agent_team',Lang::get('lang.admin')) !!}
                </div>
             
                <!-- Assigned Agent/Team -->
                <div class="form-group">
                    {!! Form::checkbox('ticket_transfer_alert_persons[]','assigned_agent_team',$alerts->isValueExists('ticket_transfer_alert_persons','assigned_agent_team')) !!}
                    {!! Form::label('assigned_agent_team',Lang::get('lang.assigned_agent')) !!}
                </div>
                
                <!-- Department members -->
                <div class="form-group">
                    {!! Form::checkbox('ticket_transfer_alert_persons[]','department_members',$alerts->isValueExists('ticket_transfer_alert_persons','department_members')) !!}
                    {!! Form::label('ticket_department_manager',Lang::get('lang.department_members')) !!}
                </div>

                <!-- Department Manager -->
                <div class="form-group">
                    {!! Form::checkbox('ticket_transfer_alert_persons[]','department_manager',$alerts->isValueExists('ticket_transfer_alert_persons','department_manager')) !!}
                    {!! Form::label('ticket_department_manager',Lang::get('lang.department_manager')) !!}
                </div>
                <!-- Organization Account Manager -->

                <div class="form-group">
                    {!! Form::checkbox('ticket_transfer_alert_persons[]','organization_manager',$alerts->isValueExists('ticket_transfer_alert_persons','organization_manager')) !!}
                    {!! Form::label('organization_account_manager',Lang::get('lang.organization_account_manager')) !!}
                </div>


                
            </div><!-- /.box-body -->
        </div><!-- /.box -->
        <!-- /.box -->
    </div><!--/.col (left) -->


    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{Lang::get('lang.registration_verification')}}</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <div class="form-group">
                    <!-- Status:     Enable   Disable     -->
                    {!! Form::label('registration_alert',Lang::get('lang.status').":") !!}&nbsp;&nbsp;
                    {!! Form::radio('registration_alert',1,$alerts->isValueExists('registration_alert',1)) !!} {!! Lang::get('lang.enable') !!} &nbsp;&nbsp; 
                    {!! Form::radio('registration_alert',0,$alerts->isValueExists('registration_alert',0)) !!}  {!! Lang::get('lang.disable') !!}

                </div>
                <div class="form-group">
                 <!-- Mode :   Email    Sms -->
                     {!! Form::label('registration_alert_mode',Lang::get('lang.mode').":") !!}&nbsp;&nbsp;
                    {!! Form::checkbox('registration_alert_mode[]','email',$alerts->isValueExists('registration_alert_mode','email')) !!} {!! Lang::get('lang.email') !!} &nbsp;&nbsp; 
                    {{--{!! Form::checkbox('registration_alert_mode[]','sms',$alerts->isValueExists('registration_alert_mode','sms')) !!}  {!! Lang::get('lang.sms') !!}--}}
                    {!! Form::checkbox('registration_alert_mode[]','system',$alerts->isValueExists('registration_alert_mode','system')) !!}  {!! Lang::get('lang.in_app_system') !!}
                 </div>
             
                <!-- Assigned Agent/Team -->
                <div class="form-group">
                    {!! Form::checkbox('registration_alert_persons[]','client',$alerts->isValueExists('registration_alert_persons','client')) !!}
                    {!! Form::label('registration_alert_persons',Lang::get('lang.client')) !!}
                </div>

                <!-- Department Manager -->
                <div class="form-group">
                    {!! Form::checkbox('registration_alert_persons[]','agent',$alerts->isValueExists('registration_alert_persons','agent')) !!}
                    {!! Form::label('registration_alert_persons',Lang::get('lang.agent')) !!}
                </div>
                <!-- Organization Account Manager -->
                <!-- Department Manager -->
                <div class="form-group">
                    {!! Form::checkbox('registration_alert_persons[]','admin',$alerts->isValueExists('registration_alert_persons','admin')) !!}
                    {!! Form::label('registration_alert_persons',Lang::get('lang.admin')) !!}
                </div>
                
                
            </div><!-- /.box-body -->
        </div><!-- /.box -->
        <!-- /.box -->
    </div><!--/.col (left) -->

</div>

<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{Lang::get('lang.registration_notification')}}</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <div class="form-group">
                    <!-- Status:     Enable   Disable     -->
                    {!! Form::label('new_user_alert',Lang::get('lang.status').":") !!}&nbsp;&nbsp;
                    {!! Form::radio('new_user_alert',1,$alerts->isValueExists('new_user_alert',1)) !!} {!! Lang::get('lang.enable') !!} &nbsp;&nbsp; 
                    {!! Form::radio('new_user_alert',0,$alerts->isValueExists('new_user_alert',0)) !!}  {!! Lang::get('lang.disable') !!}

                </div>
                <div class="form-group">
                 <!-- Mode :   Email    Sms -->
                     {!! Form::label('new_user_alert_mode',Lang::get('lang.mode').":") !!}&nbsp;&nbsp;
                    {!! Form::checkbox('new_user_alert_mode[]','email',$alerts->isValueExists('new_user_alert_mode','email')) !!} {!! Lang::get('lang.email') !!} &nbsp;&nbsp; 
                    {{--{!! Form::checkbox('new_user_alert_mode[]','sms',$alerts->isValueExists('new_user_alert_mode','sms')) !!}  {!! Lang::get('lang.sms') !!}--}}
                    {!! Form::checkbox('new_user_alert_mode[]','system',$alerts->isValueExists('new_user_alert_mode','system')) !!}  {!! Lang::get('lang.in_app_system') !!}
                 </div>
             
                <!-- Assigned Agent/Team -->
                <div class="form-group">
                    {!! Form::checkbox('new_user_alert_persons[]','admin',$alerts->isValueExists('new_user_alert_persons','admin')) !!}
                    {!! Form::label('new_user_alert_persons',Lang::get('lang.admin')) !!}
                </div>

                <!-- Department Manager -->
                <div class="form-group">
                    {!! Form::checkbox('new_user_alert_persons[]','agent',$alerts->isValueExists('new_user_alert_persons','agent')) !!}
                    {!! Form::label('new_user_alert_persons',Lang::get('lang.agent')) !!}
                </div>
                <!-- Organization Account Manager -->
                <!-- Department Manager -->
                <div class="form-group">
                    {!! Form::checkbox('new_user_alert_persons[]','all_department_manager',$alerts->isValueExists('new_user_alert_persons','all_department_manager')) !!}
                    {!! Form::label('new_user_alert_persons',Lang::get('lang.all_department_manager')) !!}
                </div>
                <div class="form-group">
                    {!! Form::checkbox('new_user_alert_persons[]','all_team_lead',$alerts->isValueExists('new_user_alert_persons','all_team_lead')) !!}
                    {!! Form::label('new_user_alert_persons',Lang::get('lang.all_team_lead')) !!}
                </div>
                <div class="form-group">
                    {!! Form::checkbox('new_user_alert_persons[]','organization_manager',$alerts->isValueExists('new_user_alert_persons','organization_manager')) !!}
                    {!! Form::label('new_user_alert_persons',Lang::get('lang.organization_account_manager')) !!}
                </div>
                
            </div><!-- /.box-body -->
        </div><!-- /.box -->
        <!-- /.box -->
    </div><!--/.col (left) -->


    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{Lang::get('lang.agent_reply')}}</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <div class="form-group">
                    <!-- Status:     Enable   Disable     -->
                    {!! Form::label('reply_alert',Lang::get('lang.status').":") !!}&nbsp;&nbsp;
                    {!! Form::radio('reply_alert',1,$alerts->isValueExists('reply_alert',1)) !!} {!! Lang::get('lang.enable') !!} &nbsp;&nbsp; 
                    {!! Form::radio('reply_alert',0,$alerts->isValueExists('reply_alert',0)) !!}  {!! Lang::get('lang.disable') !!}

                </div>
                <div class="form-group">
                 <!-- Mode :   Email    Sms -->
                     {!! Form::label('reply_alert_mode',Lang::get('lang.mode').":") !!}&nbsp;&nbsp;
                    {!! Form::checkbox('reply_alert_mode[]','email',$alerts->isValueExists('reply_alert_mode','email')) !!} {!! Lang::get('lang.email') !!} &nbsp;&nbsp; 
                    {{--{!! Form::checkbox('reply_alert_mode[]','sms',$alerts->isValueExists('reply_alert_mode','sms')) !!}  {!! Lang::get('lang.sms') !!}--}}
                    {!! Form::checkbox('reply_alert_mode[]','system',$alerts->isValueExists('reply_alert_mode','system')) !!}  {!! Lang::get('lang.in_app_system') !!}
                 </div>
             
                <!-- Assigned Agent/Team -->
                <div class="form-group">
                    {!! Form::checkbox('reply_alert_persons[]','client',$alerts->isValueExists('reply_alert_persons','client')) !!}
                    {!! Form::label('reply_alert_persons',Lang::get('lang.client')) !!}
                </div>

                <!-- Department Manager -->
                <div class="form-group">
                    {!! Form::checkbox('reply_alert_persons[]','agent',$alerts->isValueExists('reply_alert_persons','agent')) !!}
                    {!! Form::label('reply_alert_persons',Lang::get('lang.agent')) !!}
                </div>
                <!-- Organization Account Manager -->
                <!-- Department Manager -->
                <div class="form-group">
                    {!! Form::checkbox('reply_alert_persons[]','admin',$alerts->isValueExists('reply_alert_persons','admin')) !!}
                    {!! Form::label('reply_alert_persons',Lang::get('lang.admin')) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::checkbox('reply_alert_persons[]','assigned_agent_team',$alerts->isValueExists('reply_alert_persons','assigned_agent_team')) !!}
                    {!! Form::label('reply_notification_alert_persons',Lang::get('lang.assigned_agent_team')) !!}
                </div>
                <!-- Organization Account Manager -->
                <!-- Department Manager -->
                <div class="form-group">
                    {!! Form::checkbox('reply_alert_persons[]','all_department_manager',$alerts->isValueExists('reply_alert_persons','all_department_manager')) !!}
                    {!! Form::label('reply_notification_alert_persons',Lang::get('lang.department_manager')) !!}
                </div>
                <div class="form-group">
                    {!! Form::checkbox('reply_alert_persons[]','department_members',$alerts->isValueExists('reply_alert_persons','department_members')) !!}
                    {!! Form::label('reply_notification_alert_persons',Lang::get('lang.department_members')) !!}
                </div>
                <div class="form-group">
                    {!! Form::checkbox('reply_alert_persons[]','all_team_lead',$alerts->isValueExists('reply_alert_persons','all_team_lead')) !!}
                    {!! Form::label('reply_notification_alert_persons',Lang::get('lang.team_lead')) !!}
                </div>
                <div class="form-group">
                    {!! Form::checkbox('reply_alert_persons[]','organization_manager',$alerts->isValueExists('reply_alert_persons','organization_manager')) !!}
                    {!! Form::label('reply_notification_alert_persons',Lang::get('lang.organization_account_manager')) !!}
                </div>
                
            </div><!-- /.box-body -->
        </div><!-- /.box -->
        <!-- /.box -->
    </div><!--/.col (left) -->

</div>

<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{Lang::get('lang.client_reply')}}</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <div class="form-group">
                    <!-- Status:     Enable   Disable     -->
                    {!! Form::label('reply_notification_alert',Lang::get('lang.status').":") !!}&nbsp;&nbsp;
                    {!! Form::radio('reply_notification_alert',1,$alerts->isValueExists('reply_notification_alert',1)) !!} {!! Lang::get('lang.enable') !!} &nbsp;&nbsp; 
                    {!! Form::radio('reply_notification_alert',0,$alerts->isValueExists('reply_notification_alert',0)) !!}  {!! Lang::get('lang.disable') !!}

                </div>
                <div class="form-group">
                 <!-- Mode :   Email    Sms -->
                     {!! Form::label('reply_notification_alert_mode',Lang::get('lang.mode').":") !!}&nbsp;&nbsp;
                    {!! Form::checkbox('reply_notification_alert_mode[]','email',$alerts->isValueExists('reply_notification_alert_mode','email')) !!} {!! Lang::get('lang.email') !!} &nbsp;&nbsp; 
                    {{--{!! Form::checkbox('reply_notification_alert_mode[]','sms',$alerts->isValueExists('reply_notification_alert_mode','sms')) !!}  {!! Lang::get('lang.sms') !!}--}}
                    {!! Form::checkbox('reply_notification_alert_mode[]','system',$alerts->isValueExists('reply_notification_alert_mode','system')) !!}  {!! Lang::get('lang.in_app_system') !!}
                 </div>
             
                <!-- Assigned Agent/Team -->
                <div class="form-group">
                    {!! Form::checkbox('reply_notification_alert_persons[]','admin',$alerts->isValueExists('reply_notification_alert_persons','admin')) !!}
                    {!! Form::label('reply_notification_alert_persons',Lang::get('lang.admin')) !!}
                </div>

                <!-- Department Manager -->
                <div class="form-group">
                    {!! Form::checkbox('reply_notification_alert_persons[]','agent',$alerts->isValueExists('reply_notification_alert_persons','agent')) !!}
                    {!! Form::label('reply_notification_alert_persons',Lang::get('lang.agent')) !!}
                </div>
                <!-- Department Manager -->
                <div class="form-group">
                    {!! Form::checkbox('reply_notification_alert_persons[]','assigned_agent_team',$alerts->isValueExists('reply_notification_alert_persons','assigned_agent_team')) !!}
                    {!! Form::label('reply_notification_alert_persons',Lang::get('lang.assigned_agent_team')) !!}
                </div>
                <!-- Organization Account Manager -->
                <!-- Department Manager -->
                <div class="form-group">
                    {!! Form::checkbox('reply_notification_alert_persons[]','all_department_manager',$alerts->isValueExists('reply_notification_alert_persons','all_department_manager')) !!}
                    {!! Form::label('reply_notification_alert_persons',Lang::get('lang.department_manager')) !!}
                </div>
                <div class="form-group">
                    {!! Form::checkbox('reply_notification_alert_persons[]','department_members',$alerts->isValueExists('reply_notification_alert_persons','department_members')) !!}
                    {!! Form::label('reply_notification_alert_persons',Lang::get('lang.department_members')) !!}
                </div>
                <div class="form-group">
                    {!! Form::checkbox('reply_notification_alert_persons[]','all_team_lead',$alerts->isValueExists('reply_notification_alert_persons','all_team_lead')) !!}
                    {!! Form::label('reply_notification_alert_persons',Lang::get('lang.team_lead')) !!}
                </div>
                <div class="form-group">
                    {!! Form::checkbox('reply_notification_alert_persons[]','organization_manager',$alerts->isValueExists('reply_notification_alert_persons','organization_manager')) !!}
                    {!! Form::label('reply_notification_alert_persons',Lang::get('lang.organization_account_manager')) !!}
                </div>
                
            </div><!-- /.box-body -->
        </div><!-- /.box -->
        <!-- /.box -->
    </div><!--/.col (left) -->
    
      <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{Lang::get('lang.sla_alert')}}</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <div class="form-group">
                    <!-- Status:     Enable   Disable     -->
                    {!! Form::label('sla_alert',Lang::get('lang.status').":") !!}&nbsp;&nbsp;
                    {!! Form::radio('sla_alert',1,$alerts->isValueExists('sla_alert',1)) !!} {!! Lang::get('lang.enable') !!} &nbsp;&nbsp; 
                    {!! Form::radio('sla_alert',0,$alerts->isValueExists('sla_alert',0)) !!}  {!! Lang::get('lang.disable') !!}

                </div>
                <div class="form-group">
                 <!-- Mode :   Email    Sms -->
                     {!! Form::label('sla_alert_mode',Lang::get('lang.mode').":") !!}&nbsp;&nbsp;
                    {!! Form::checkbox('sla_alert_mode[]','email',$alerts->isValueExists('sla_alert_mode','email')) !!} {!! Lang::get('lang.email') !!} &nbsp;&nbsp; 
                    {{--{!! Form::checkbox('sla_alert_mode[]','sms',$alerts->isValueExists('sla_alert_mode','sms')) !!}  {!! Lang::get('lang.sms') !!}--}}
                    {!! Form::checkbox('sla_alert_mode[]','system',$alerts->isValueExists('sla_alert_mode','system')) !!}  {!! Lang::get('lang.in_app_system') !!}
                 </div>
             
                <!-- Assigned Agent/Team -->
                <div class="form-group">
                    {!! Form::checkbox('sla_alert_persons[]','admin',$alerts->isValueExists('sla_alert_persons','admin')) !!}
                    {!! Form::label('sla_alert_persons',Lang::get('lang.admin')) !!}
                </div>

                <!-- Department Manager -->
                <div class="form-group">
                    {!! Form::checkbox('sla_alert_persons[]','agent',$alerts->isValueExists('sla_alert_persons','agent')) !!}
                    {!! Form::label('sla_alert_persons',Lang::get('lang.agent')) !!}
                </div>
                <!-- Department Manager -->
                <div class="form-group">
                    {!! Form::checkbox('sla_alert_persons[]','assigned_agent_team',$alerts->isValueExists('sla_alert_persons','assigned_agent_team')) !!}
                    {!! Form::label('sla_alert_persons',Lang::get('lang.assigned_agent')) !!}
                </div>
                <!-- Organization Account Manager -->
                <!-- Department Manager -->
                <div class="form-group">
                    {!! Form::checkbox('sla_alert_persons[]','department_manager',$alerts->isValueExists('sla_alert_persons','department_manager')) !!}
                    {!! Form::label('sla_alert_persons',Lang::get('lang.department_manager')) !!}
                </div>
                <div class="form-group">
                    {!! Form::checkbox('sla_alert_persons[]','department_members',$alerts->isValueExists('sla_alert_persons','department_members')) !!}
                    {!! Form::label('sla_alert_persons',Lang::get('lang.department_members')) !!}
                </div>
                <div class="form-group">
                    {!! Form::checkbox('sla_alert_persons[]','all_team_lead',$alerts->isValueExists('sla_alert_persons','all_team_lead')) !!}
                    {!! Form::label('sla_alert_persons',Lang::get('lang.team_lead')) !!}
                </div>
                <div class="form-group">
                    {!! Form::checkbox('sla_alert_persons[]','organization_manager',$alerts->isValueExists('sla_alert_persons','organization_manager')) !!}
                    {!! Form::label('sla_alert_persons',Lang::get('lang.organization_account_manager')) !!}
                </div>
                
            </div><!-- /.box-body -->
        </div><!-- /.box -->
        <!-- /.box -->
    </div><!--/.col (left) -->

</div>
{!! Form::close() !!}

@stop
