@extends('themes.default1.admin.layout.admin')

@section('Settings')
active
@stop

@section('settings-bar')
active
@stop

@section('tickets')
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

	{!! Form::model($tickets,['url' => 'postticket/'.$tickets->id, 'method' => 'PATCH']) !!}


	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header">
                <h3 class="box-title">{{Lang::get('lang.ticket')}}</h3> <div class="pull-right">
                {!! Form::submit(Lang::get('lang.save'),['class'=>'btn btn-primary'])!!}
              </div>
            </div>

            <!-- check whether success or not -->

@if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <i class="fa  fa-check-circle"></i>
        <b>Success!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {!! Session::get('success') !!}
    </div>
    @endif
    <!-- failure message -->
    @if(Session::has('fails'))
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <b>Fail!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {!! Session::get('fails') !!}
    </div>
    @endif


    <div class="box-body table-responsive"style="overflow:hidden;">
        <div class="row">
            {{-- <div class="col-md-6"> --}}
                {{-- <div class="form-group"> --}}

	<!-- Default Ticket Number Format: text	 e.g. 268330 -->

		<!-- <div class="form-group {{ $errors->has('num_format') ? 'has-error' : '' }}"> -->

			{{-- {!! Form::label('num_format',Lang::get('lang.default_ticket_number_format')) !!} --}}
			{{-- {!! $errors->first('num_format', '<spam class="help-block">:message</spam>') !!} --}}
			{{-- {!! Form::text('num_format',$tickets->num_format,['class' => 'form-control']) !!} --}}

		{{-- </div> --}}
		{{-- </div> --}}

	<!-- Default Ticket Number Sequence: dropdown : manual	   Manage -->
            {{-- <div class="col-md-6"> --}}
		      {{-- <div class="form-group {{ $errors->has('num_sequence') ? 'has-error' : '' }}"> --}}

			{{-- {!! Form::label('num_sequence',Lang::get('lang.default_ticket_number_sequence')) !!} --}}
			{{-- {!! $errors->first('num_sequence', '<spam class="help-block">:message</spam>') !!} --}}
			{{-- {!!Form::select('num_sequence', ['random','general'],null,['class' => 'form-control select']) !!} --}}

		{{-- </div> --}}
		{{-- </div> --}}

	<!-- Default Status: Required : manual: Dropdowm  -->
          <div class="col-md-3">
		<div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
			{!! Form::label('status',Lang::get('lang.default_status')) !!}
			{!! $errors->first('status', '<spam class="help-block">:message</spam>') !!}
			<select class="form-control" id="status" name="status">
				<option value="1" >Open</option>
			</select>
			</div>
		</div>

	<!-- Default Priority:	Required : manual : Dropdowm  -->
          <div class="col-md-2">
		<div class="form-group {{ $errors->has('priority') ? 'has-error' : '' }}">
			{!! Form::label('priority',Lang::get('lang.default_priority')) !!}
			{!! $errors->first('priority', '<spam class="help-block">:message</spam>') !!}
			{!!Form::select('priority', [''=>'select a priority','Priorities'=>$priority->lists('priority_desc','priority_id')->toArray()],null,['class' => 'form-control']) !!}
			</div>
		</div>

	<!-- Default SLA:	Required : manual : Dropdowm  -->
       <div class="col-md-2">
		<div class="form-group {{ $errors->has('sla') ? 'has-error' : '' }}">
			{!! Form::label('sla',Lang::get('lang.default_sla')) !!}
			{!! $errors->first('sla', '<spam class="help-block">:message</spam>') !!}
			{!!Form::select('sla', $slas->lists('grace_period','id'),null,['class' => 'form-control']) !!}
			</div>
		</div>

	<!-- Default Help Topic:  Dropdowm from Help topic table	 -->
            <div class="col-md-2">
		        <div class="form-group {{ $errors->has('help_topic') ? 'has-error' : '' }}">
			        {!! Form::label('help_topic',Lang::get('lang.default_help_topic')) !!}
			        {!! $errors->first('help_topic', '<spam class="help-block">:message</spam>') !!}
			        {!!Form::select('help_topic', $topics->lists('topic','id'),null,['class' => 'form-control']) !!}
			    </div>
		    </div>

	<!-- Maximum Open Tickets: text-number	 per end user  -->
            {{-- <div class="col-md-6"> --}}
		        {{-- <div class="form-group {{ $errors->has('max_open_ticket') ? 'has-error' : '' }}"> --}}
			      	{{-- {!! Form::label('max_open_ticket',Lang::get('lang.maximum_open_tickets')) !!} --}}
			      	{{-- {!! $errors->first('max_open_ticket', '<spam class="help-block">:message</spam>') !!} --}}
			      	{{-- {!! Form::text('max_open_ticket',$tickets->max_open_ticket,['class' => 'form-control']) !!} --}}
			    {{-- </div> --}}
		    {{-- </div> --}}

	<!-- Agent Collision Avoidance Duration: text-number   -minutes  -->
          	<div class="col-md-3">
		        <div class="form-group {{ $errors->has('collision_avoid') ? 'has-error' : '' }}">
			        {!! Form::label('collision_avoid',Lang::get('lang.agent_collision_avoidance_duration')) !!} 
			       	{!! $errors->first('collision_avoid', '<spam class="help-block">:message</spam>') !!} 
			        <div class="input-group">
			        <input type="number" class="form-control" name="collision_avoid" min="0"  step="1" value="{{$tickets->collision_avoid}}" placeholder="in minutes">
			    	<div class="input-group-addon">
                          <span><i class="fa fa-clock-o"></i> {!!Lang::get('lang.in_minutes')!!}</span>
                    </div>
                </div>
			    </div> 
		    </div> 


	<!-- Human Verification: checkbox	 Enable CAPTCHA on new web tickets.      -->

            {{-- <div class="col-md-6"> --}}
		      	{{-- <div class="form-group"> --}}
			    	{{-- {!! Form::checkbox('captcha',1,true) !!}&nbsp; --}}
		        	{{-- {!! Form::label('captcha',Lang::get('lang.human_verification')) !!} --}}
				{{-- </div> --}}

	<!-- Claim on Response:	 checkbox -->

				{{-- <div class="form-group"> --}}
			       	{{-- {!! Form::checkbox('claim_response',1,true) !!}&nbsp; --}}
					{{-- {!! Form::label('claim_response',Lang::get('lang.claim_on_response')) !!} --}}
				{{-- </div> --}}

	<!-- Assigned Tickets:	checkbox- Exclude assigned tickets from open queue.  -->

				{{-- <div class="form-group"> --}}
					{{-- {!! Form::checkbox('assigned_ticket',1,true) !!}&nbsp; --}}
					{{-- {!! Form::label('assigned_ticket',Lang::get('lang.assigned_tickets')) !!} --}}
				{{-- </div> --}}

	<!-- Answered Tickets:	checkbox- Exclude answered tickets from open queue.  -->

				{{-- <div class="form-group"> --}}
					{{-- {!! Form::checkbox('answered_ticket',1,true) !!}&nbsp; --}}
					{{-- {!! Form::label('answered_ticket',Lang::get('lang.answered_tickets')) !!} --}}
				{{-- </div> --}}

	<!-- Agent Identity Masking: checkbox-	 Hide agent's name on responses.  -->

				{{-- <div class="form-group"> --}}
					{{-- {!! Form::checkbox('agent_mask',1,true) !!}	&nbsp; --}}
					{{-- {!! Form::label('agent_mask',Lang::get('lang.agent_identity_masking')) !!} --}}
				{{-- </div> --}}

	<!-- Enable HTML Ticket Thread:	 checkbox- Enable rich text in ticket thread and autoresponse emails.  -->

				{{-- <div class="form-group"> --}}
					{{-- {!! Form::checkbox('html',1,true) !!}&nbsp; --}}
					{{-- {!! Form::label('html',Lang::get('lang.enable_HTML_ticket_thread')) !!} --}}
				{{-- </div> --}}

	<!-- Allow Client Updates: checkbox -->

				{{-- <div class="form-group"> --}}
					{{-- {!! Form::checkbox('client_update',1,true) !!}&nbsp; --}}
					{{-- {!! Form::label('client_update',Lang::get('lang.allow_client_updates')) !!} --}}
				{{-- </div> --}}

	<!-- EndUser Attachment Settings:	 Config  -->

	<!-- **** TODO  ***** -->

	<!-- Agent Maximum File Size: -->

	<!-- **** TODO  ***** -->

	<!-- Submit button -->

		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
@stop