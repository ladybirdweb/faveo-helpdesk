@extends('themes.default1.admin.layout.admin')

@section('Settings')
class="active"
@stop

@section('settings-bar')
active
@stop

@section('alert')
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

	{!! Form::model($alerts,['url' => 'postalert/'.$alerts->id, 'method' => 'PATCH']) !!}

		<div class="box box-primary">
    	<div class="box-header">

    	 	<h4 class="box-title">{{Lang::get('lang.alert_notices')}}</h4> {!! Form::submit(Lang::get('lang.save'),['class'=>' btn btn-primary pull-right'])!!}

    	</div>
    </div>
	<!-- check whether success or not -->

@if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <i class="fa  fa-check-circle"></i>
        <b>Success!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {!!Session::get('success')!!}
    </div>
    @endif
    <!-- failure message -->
    @if(Session::has('fails'))
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <b>Fail!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {!!Session::get('fails')!!}
    </div>
    @endif

          <div class="row">
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title">{{Lang::get('lang.new_ticket_alert')}}</h3>
                  <div class="pull-right">

              		</div>
                </div><!-- /.box-header -->
                <!-- form start -->
                <hr style="margin-top: 0;margin-bottom: 0;">

                  <div class="box-body">
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
                    <!-- Department Manager -->
                    {{-- <div class="form-group"> --}}
                    {{-- {!! Form::checkbox('ticket_department_manager',1) !!} --}}
					{{-- {!! Form::label('ticket_department_manager',Lang::get('lang.department_manager')) !!} --}}
                    {{-- </div> --}}
                    <!-- Department Members -->
                    <div class="form-group">
                    {!! Form::checkbox('ticket_department_member',1) !!}
					{!! Form::label('ticket_department_member',Lang::get('lang.department_members')) !!}
                    </div>
                    <!-- Organization Account Manager -->
                    {{-- <div class="form-group"> --}}
                    {{-- {!! Form::checkbox('ticket_organization_accmanager',1) !!} --}}
					{{-- {!! Form::label('ticket_organization_accmanager',Lang::get('lang.organization_account_manager')) !!} --}}
                    {{-- </div> --}}
                  </div><!-- /.box-body -->



              </div><!-- /.box -->
              {{-- <div class ="box box-primary"> --}}
                {{-- <div class="box-header"> --}}
                  {{-- <h3 class="box-title">{{Lang::get('lang.new_message_alert')}}</h3> --}}
                  {{-- <div class="pull-right"> --}}

              		{{-- </div> --}}
                {{-- </div>/.box-header --}}
                <!-- form start -->
                {{-- <hr style="margin-top: 0;margin-bottom: 0;"> --}}
                  {{-- <div class="box-body"> --}}
                    <!-- Status:     Enable      Disable -->
                    {{-- <div class="form-group"> --}}
					{{-- {!! Form::label('message_status',Lang::get('lang.status').":") !!}&nbsp;&nbsp; --}}
          {{-- {!! Form::radio('message_status',1) !!} {!! Lang::get('lang.enable') !!} &nbsp;&nbsp; {!! Form::radio('message_status',0) !!}  {!! Lang::get('lang.disable') !!} --}}
                    {{-- </div> --}}
                    <!-- Last Respondent -->
                    {{-- <div class="form-group"> --}}
                    {{-- {!! Form::checkbox('message_last_responder',1) !!} --}}
					{{-- {!! Form::label('message_last_responder',Lang::get('lang.last_respondent')) !!} --}}
                    {{-- </div> --}}
                    <!-- Assigned Agent / Team -->
                    {{-- <div class="form-group"> --}}
                    {{-- {!! Form::checkbox('message_assigned_agent',1) !!} --}}
					{{-- {!! Form::label('message_assigned_agent',Lang::get('lang.assigned_agent_team')) !!} --}}
                    {{-- </div> --}}
                    <!-- Department Manager -->
			 		{{-- <div class="form-group"> --}}
					{{-- {!! Form::checkbox('message_department_manager',1) !!} --}}
					{{-- {!! Form::label('message_department_manager',Lang::get('lang.department_manager')) !!} --}}
					{{-- </div> --}}
					<!-- Organization Account Manager -->
					{{-- <div class="form-group"> --}}
				    {{-- {!! Form::checkbox('message_organization_accmanager',1) !!} --}}
					{{-- {!! Form::label('message_organization_accmanager',Lang::get('lang.organization_account_manager')) !!} --}}
					{{-- </div> --}}
                  {{-- </div>/.box-body --}}



              {{-- </div>/.box --}}
              {{-- <div class="box box-primary"> --}}
                {{-- <div class="box-header"> --}}
                  {{-- <h3 class="box-title">{{Lang::get('lang.new_internal_note_alert')}}</h3> --}}
                  {{-- <div class="pull-right"> --}}

              		{{-- </div> --}}
                {{-- </div> --}}
                <!-- form start -->
                {{-- <hr style="margin-top: 0;margin-bottom: 0;"> --}}
                  {{-- <div class="box-body"> --}}
             				<!-- Status:     Enable   Disable      -->

			 	{{-- <div class="form-group"> --}}
					{{-- {!! Form::label('transfer_status',Lang::get('lang.status').":") !!} --}}
          {{-- {!! Form::radio('transfer_status',1) !!} {!! Lang::get('lang.enable') !!} &nbsp;&nbsp; {!! Form::radio('transfer_status',0) !!}  {!! Lang::get('lang.disable') !!} --}}
				{{-- </div> --}}

			 <!-- Assigned Agent / Team -->

			 	{{-- <div class="form-group"> --}}
				{{-- {!! Form::checkbox('transfer_assigned_agent',1) !!} --}}
					{{-- {!! Form::label('transfer_assigned_agent',Lang::get('lang.ticket_assignment_alert')) !!} --}}
				{{-- </div> --}}

			 <!-- Department Manager -->

			 	{{-- <div class="form-group"> --}}
				{{-- {!! Form::checkbox('transfer_department_manager',1) !!} --}}
					{{-- {!! Form::label('transfer_department_manager',Lang::get('lang.department_manager')) !!} --}}
				{{-- </div> --}}

			 <!-- Department Members -->

			 	{{-- <div class="form-group"> --}}
				{{-- {!! Form::checkbox('transfer_department_member',1) !!} --}}
					{{-- {!! Form::label('transfer_department_member',Lang::get('lang.department_members')) !!} --}}
				{{-- </div> --}}
                  {{-- </div>/.box-body --}}

              {{-- </div>/.box --}}
              {{-- <div class="box box-primary"> --}}
                {{-- <div class="box-header"> --}}
                  {{-- <h3 class="box-title">{{Lang::get('lang.system_alerts')}}</h3> --}}
                  {{-- <div class="pull-right"> --}}

              		{{-- </div> --}}
                {{-- </div> --}}
                <!-- /.box-header -->
                <!-- form start -->
                {{-- <hr style="margin-top: 0;margin-bottom: 0;"> --}}
                  {{-- <div class="box-body"> --}}
                <!-- System Errors (enabled by default) -->

			 	{{-- <div class="form-group"> --}}
				{{-- {!! Form::checkbox('system_error',1) !!} --}}
					{{-- {!! Form::label('system_error',Lang::get('lang.system_errors')) !!} --}}
				{{-- </div> --}}

			 <!-- SQL errors -->

			 	{{-- <div class="form-group"> --}}
				{{-- {!! Form::checkbox('sql_error',1) !!} --}}
					{{-- {!! Form::label('sql_error',Lang::get('lang.SQL_errors')) !!} --}}
				{{-- </div> --}}

			 <!-- Excessive failed login attempts -->

			 	{{-- <div class="form-group"> --}}
				{{-- {!! Form::checkbox('excessive_failure',1) !!} --}}
					{{-- {!! Form::label('excessive_failure',Lang::get('lang.excessive_failed_login_attempts')) !!} --}}
				{{-- </div> --}}
                  {{-- </div> --}}
                  <!-- /.box-body -->

              {{-- </div> --}}
              <!-- /.box -->
            </div><!--/.col (left) -->
            <div class="col-md-6">
              <!-- general form elements -->
              {{-- <div class="box box-primary"> --}}
                {{-- <div class="box-header"> --}}
                  {{-- <h3 class="box-title">{{Lang::get('lang.overdue_ticket_alert')}}</h3> --}}
                  {{-- <div class="pull-right"> --}}

              		{{-- </div> --}}
                {{-- </div>/.box-header --}}
                <!-- form start -->
                {{-- <hr style="margin-top: 0;margin-bottom: 0;"> --}}
                  {{-- <div class="box-body"> --}}
                    {{-- <div class="form-group"> --}}
					{{-- {!! Form::label('overdue_status',Lang::get('lang.status').":") !!} --}}
          {{-- {!! Form::radio('overdue_status',1) !!} {!! Lang::get('lang.enable') !!} &nbsp;&nbsp; {!! Form::radio('overdue_status',0) !!}  {!! Lang::get('lang.disable') !!} --}}

					{{-- </div> --}}
			 <!-- Assigned Agent / Team -->

			 	{{-- <div class="form-group"> --}}
				{{-- {!! Form::checkbox('overdue_assigned_agent',1) !!} --}}
					{{-- {!! Form::label('overdue_assigned_agent',Lang::get('lang.assigned_agent_team')) !!} --}}


				{{-- </div> --}}

			 <!-- Department Manager -->


			 	{{-- <div class="form-group"> --}}
				{{-- {!! Form::checkbox('overdue_department_manager',1) !!} --}}
					{{-- {!! Form::label('overdue_department_manager',Lang::get('lang.department_manager')) !!} --}}


				{{-- </div> --}}

			 <!-- Department Members -->

			 	{{-- <div class="form-group"> --}}
				{{-- {!! Form::checkbox('overdue_department_member',1) !!} --}}
				{{-- {!! Form::label('overdue_department_member',Lang::get('lang.department_members')) !!} --}}


				{{-- </div> --}}
                  {{-- </div>/.box-body --}}



              {{-- </div>/.box --}}
              {{-- <div class="box box-primary"> --}}
                {{-- <div class="box-header"> --}}
                  {{-- <h3 class="box-title">{{Lang::get('lang.ticket_transfer_alert')}}</h3> --}}
                  {{-- <div class="pull-right"> --}}

              		{{-- </div> --}}
                {{-- </div>/.box-header --}}
                <!-- form start -->
                {{-- <hr style="margin-top: 0;margin-bottom: 0;"> --}}
                  {{-- <div class="box-body"> --}}
                    {{-- <div class="form-group"> --}}
			 <!-- Status:     Enable      Disable      -->
					{{-- {!! Form::label('internal_status',Lang::get('lang.status').":") !!} --}}
          {{-- {!! Form::radio('internal_status',1) !!} {!! Lang::get('lang.enable') !!} &nbsp;&nbsp; {!! Form::radio('internal_status',0) !!}  {!! Lang::get('lang.disable') !!} --}}
				{{-- </div>/ --}}

			 <!-- Last Respondent -->

			 	{{-- <div class="form-group"> --}}
				{{-- {!! Form::checkbox('internal_last_responder',1) !!} --}}
					{{-- {!! Form::label('internal_last_responder',Lang::get('lang.last_respondent')) !!} --}}
				{{-- </div> --}}

			 <!-- Assigned Agent / Team -->

			 	{{-- <div class="form-group"> --}}
				{{-- {!! Form::checkbox('internal_assigned_agent',1) !!} --}}
					{{-- {!! Form::label('internal_assigned_agent',Lang::get('lang.assigned_agent_team')) !!} --}}
				{{-- </div> --}}

			 <!-- Department Manager -->

			 	{{-- <div class="form-group"> --}}
				{{-- {!! Form::checkbox('internal_department_manager',1) !!} --}}
					{{-- {!! Form::label('internal_department_manager',Lang::get('lang.department_manager')) !!} --}}
				{{-- </div> --}}
                  {{-- </div>/.box-body --}}



              {{-- </div>/.box --}}
              <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title">{{Lang::get('lang.ticket_assignment_alert')}}</h3>
                  <div class="pull-right">

              		</div>
                </div><!-- /.box-header -->
                <!-- form start -->
                <hr style="margin-top: 0;margin-bottom: 0;">
                  <div class="box-body">
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

			 <!-- Team Lead -->

			 	{{-- <div class="form-group"> --}}
				{{-- {!! Form::checkbox('assignment_team_leader',1) !!} --}}
					{{-- {!! Form::label('assignment_team_leader',Lang::get('lang.team_lead')) !!} --}}
				{{-- </div> --}}

			 <!-- Team Members -->

			 	<div class="form-group">
				{!! Form::checkbox('assignment_team_member',1) !!}
					{!! Form::label('assignment_team_member',Lang::get('lang.team_members')) !!}
				</div>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div><!--/.col (left) -->
  <div class="col-md-6">
  <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title">{{Lang::get('lang.system_error_reports')}}</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <hr style="margin-top: 0;margin-bottom: 0;">
                  <div class="box-body">
                <!-- System Errors (enabled by default) -->

          <div class="form-group">
            {!! Form::checkbox('system_error',1) !!}
            {!! Form::label('system_error',Lang::get('lang.Send_app_crash_reports_to_help_Ladybird_improve_Faveo')) !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@stop
