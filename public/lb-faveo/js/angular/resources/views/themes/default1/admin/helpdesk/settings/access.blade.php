@extends('themes.default1.admin.layout.admin')

@section('Settings')
class="active"
@stop

@section('settings-bar')
active
@stop

@section('access')
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

	{!! Form::model($accesses,['url' => 'postaccess/'.$accesses->id, 'method' => 'PATCH']) !!}


	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header">
                <h3 class="box-title">{{Lang::get('lang.access')}}</h3> <div class="pull-right">
                {!! Form::submit(Lang::get('lang.save'),['class'=>'btn btn-primary'])!!}
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


		<!-- Password Expiration Policy: DROPDOWN	  -->
          <div class="box-body table-responsive"style="overflow:hidden;">
             <div class="row">
               <div class="col-md-4">
               <div class="form-group">
                {!! Form::label('password_expire',Lang::get('lang.expiration_policy')) !!}
				{!!Form::select('password_expire',['1 month','2 month','3 month'],null,['class' => 'form-control select']) !!}

			</div>
		</div>



		<!-- Reset Token Expiration: TEXT- minutes    -->
			<div class="col-md-4">
             <div class="form-group">
				{!! Form::label('reset_ticket_expire',Lang::get('lang.reset_token_expiration')) !!}
				{!! Form::text('reset_ticket_expire',$accesses->reset_ticket_expire,['class' => 'form-control']) !!}

			</div>
			</div>

		<!-- Agent Excessive Logins:	TEXT failed login attempt(s) allowed before a lock-out is enforced

		 								TEXT minutes locked out -->

		 		<!-- *************************    TODO    ************************** -->



		<!-- Agent Session Timeout: TEXT - minutes (0 to disable).  -->


			<div class="col-md-4">
			    <div class="form-group">
				{!! Form::label('agent_session',Lang::get('lang.agent_session_timeout')) !!}
				{!! Form::text('agent_session',$accesses->agent_session,['class' => 'form-control']) !!}

			</div>
			</div>
			</div>
			<!-- Allow Password Resets:	 CHECKBOX  -->
			<div class="row">
			<div class="col-md-4">
				<div class="form-group">
				{!! Form::label('password_reset',Lang::get('lang.allow_password_resets')) !!}
				{!! Form::checkbox('password_reset',1) !!}

			</div>
			</div>
            </div>

		<!-- Registration Method:	DROPDOWN  -->

			<div class="row">
			<div class="col-md-6">
                <div class="form-group">
				{!! Form::label('reg_method',Lang::get('lang.registration_method')) !!}
				{!!Form::select('reg_method',['public','private','dissabled'],null,['class' => 'form-control select']) !!}

			</div>
			</div>


		<!-- User Excessive Logins:	TEXT failed login attempt(s) allowed before a lock-out is enforced

								TEXT	minutes locked out -->

		<!--*************************************    TODO   ******************************************  -->



		<!-- User Session Timeout:	TEXT  -->


			<div class="col-md-6">
                 <div class="form-group">
				{!! Form::label('user_session',Lang::get('lang.user_session_timeout')) !!}
				{!! Form::text('user_session',$accesses->user_session,['class' => 'form-control']) !!}

			</div>
			</div>
			</div>
			        <!-- Bind Agent Session to IP:	CHECKBOX  -->

			<div class="row">
			<div class="col-md-4">
				<div class="form-group">
				{!! Form::checkbox('bind_agent_ip',1,true) !!} &nbsp;
				{!! Form::label('bind_agent_ip',Lang::get('lang.bind_agent_session_IP')) !!}


			</div>
			</div>
			</div>
			<!-- Registration Required:	CHECKBOX- Require registration and login to create tickets  -->

			<div class="row">
			<div class="col-md-4">
                  <div class="form-group">
                  {!! Form::checkbox('reg_require',1,true,['class' => 'form-control']) !!}&nbsp;
				{!! Form::label('reg_require',Lang::get('lang.registration_required')) !!}


			</div>
			</div>
          </div>


		<!-- Client Quick Access: CHECKBOX -->

			<div class="row">
			<div class="col-md-4">
			<div class="form-group">
			{!! Form::checkbox('quick_access',1,true) !!}&nbsp;
				{!! Form::label('quick_access',Lang::get('lang.client_quick_access')) !!}


			</div>
			</div>
          </div>



		</div>
		</div>
	</div>
	</div>

@stop
