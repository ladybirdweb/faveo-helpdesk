@extends('themes.default1.layouts.agent')

@section('Users')
class="active"
@stop

@section('user-bar')
active
@stop

@section('user')
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


<div class="box box-primary">
<div class="box-header">
<!-- full name -->
@if($users->first_name || $users->last_name)
	<h2 class="box-title">{{$users->first_name}} {{$users->last_name}}</h2></div>
@else
	<h2 class="box-title">{{$users->user_name}}</h2></div>
@endif
<div class="row">
	<div class="col-md-6">
		<div class="col-xs-4 form-group">
			<strong>{{Lang::get('lang.name')}}</strong>
		</div>
		<div class="col-xs-4">
		  @if($users->first_name || $users->last_name)
			<a href="{{route('user.edit', $users->id)}}">{{$users->first_name}} {{$users->last_name}}</a>
		  @else
		    <a href="{{route('user.edit', $users->id)}}"> {{$users -> user_name }}</a>
		  @endif
		</div>
	</div>
	<div class="col-md-6">
	<!-- email -->
		<div class="col-xs-4 form-group">
			<strong>{{Lang::get('lang.email')}}</strong>
		</div>
		<div class="col-xs-4">
			{{$users -> email }}
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
	<!-- organisation -->
		<div class="col-xs-4 form-group">
			<strong>{{Lang::get('lang.organization')}}</strong>
		</div>
		<div class="col-xs-4">
			<a href="{{route('organizations.create')}}"> {{Lang::get('lang.create_organization')}}</a>
		</div>
	</div>
	<div class="col-md-6">
	<!-- status -->
		<div class="col-xs-4 form-group">
			<strong>{{Lang::get('lang.status')}}</strong>
		</div>
		<div class="col-xs-4">
			@if($users->active == '1')
			 <span style="color:green;">Active</span>
			@else
			 <span style="color:red;">Inactive</span>
			@endif
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
	<!-- created -->
		<div class="col-xs-4 form-group">
			<strong>{{Lang::get('lang.created')}}</strong>
		</div>
		<div class="col-xs-4">
			{{$users -> created_at}}
		</div>
	</div>
	<div class="col-md-6">
	<!-- updated -->
		<div class="col-xs-4 form-group">
			<strong>{{Lang::get('lang.last_updated')}}</strong>
		</div>
		<div class="col-xs-4">
			{{$users -> updated_at}}
		</div>
	</div>
</div>
</div>
{{-- detals table starts --}}
<?php $user = App\User::where('id',$users->id)->first(); ?>
<?php $open = count(App\Model\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=','1')->get());
$counted = count(App\Model\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=','2')->get());
$deleted = count(App\Model\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=','5')->get()); ?>
          <div class="row">
            <div class="col-md-12">
              <!-- Custom Tabs -->
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab">Open Tickets ({{$open}})</a></li>
                  <li><a href="#tab_2" data-toggle="tab">Closed Tickets ({{$counted}})</a></li>
                  <li><a href="#tab_3" data-toggle="tab">Deleted Tickets ({{$deleted}})</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                    {{-- open tab --}}
						    <?php $open = count(App\Model\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=','1')->get()); ?>
						      
						        @if(Session::has('success'))
						        <div class="alert alert-success alert-dismissable">
						            <i class="fa  fa-check-circle"> </i> <b> Success </b>
						            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						            {{Session::get('success')}}
						        </div>
						        @endif
						        <!-- failure message -->
						        @if(Session::has('fails'))
						        <div class="alert alert-danger alert-dismissable">
						            <i class="fa fa-ban"> </i> <b> Alert! </b>
						            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						            {{Session::get('fails')}}
						        </div>
						        @endif
						    <div class="box-body no-padding ">
						        
						    {!! Form::open(['route'=>'select_all','method'=>'post']) !!}
						        <div class="mailbox-controls">
						            <!-- Check all button -->
						            <a class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></a>
						            <a class="btn btn-default btn-sm" id="click"><i class="fa fa-refresh"></i></a>
						            <input type="submit" class="btn btn-default text-orange btn-sm" name="submit" value="Delete">
						            <input type="submit" class="btn btn-default text-yellow btn-sm" name="submit" value="Close">
						            <div class="pull-right">
						                <?php
						$counted = count(App\Model\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=','1')->get());
						if ($counted < 20) {
							echo $counted . "/" . $counted;
						} else {
							echo "20/" . $counted;
						}
						?>
						            </div>
						        </div>
						        <div class=" table-responsive mailbox-messages" id="refresh">
						        <p style="display:none;text-align:center; position:fixed; margin-left:40%;margin-top:-70px;" id="show" class="text-red"><b>Loading...</b></p>
						        <!-- table -->
						            <table class="table table-hover table-striped">
						                <thead>
						                <th>
						                </th>
						                <th>Subject</th>
						                <th>Ticket ID</th>
						                <th>Priority</th>
						                <th>From</th>
						                <th>Last Replier</th>
						                <th>Assigned To</th>
						                <th>Last Activity</th>
						                <th>Reply Due</th>
						                </thead>
						                <tbody id="hello">
						                    <?php $tickets = App\Model\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=','1')->orderBy('id', 'DESC')->paginate(20);?>
						                    @foreach ($tickets  as $ticket)
						                    <tr <?php if ($ticket->seen_by == null) {?> style="color:green;" <?php }
						?> >
						                        <td ><input type="checkbox" class="icheckbox_flat-blue" name="select_all[]" value="{{$ticket->id}}"/></td>
						                        <?php 
						                        //  collaborators
						                        $collaborators = App\Model\Ticket\Ticket_Collaborator::where('ticket_id','=',$ticket->id)->get();
						                        $collab = count($collaborators);
						                        //  title
						                        $title = App\Model\Ticket\Ticket_Thread::where('ticket_id', '=', $ticket->id)->first();
						                        $string = strip_tags($title->title);
						                        // check atatchments
						                        $attachments = App\Model\Ticket\Ticket_attachments::where('thread_id','=',$title->id)->first();
						                        $attach = count($attachments);

						                        if (strlen($string) > 40) {
						                            $stringCut = substr($string, 0, 40);
						                            $string = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...'; 
						                        }
						                        $TicketData = App\Model\Ticket\Ticket_Thread::where('ticket_id', '=', $ticket->id)->max('id');
						                        $TicketDatarow = App\Model\Ticket\Ticket_Thread::where('id', '=', $TicketData)->first();
						                        $LastResponse = App\User::where('id', '=', $TicketDatarow->user_id)->first(); 
						                        if($LastResponse->role == "user") {
						                            $rep = "#F39C12";
						                            $username = $LastResponse->user_name;
						                            } else { $rep = "#000"; $username = $LastResponse->first_name ." ". $LastResponse->last_name; 
						                            if($LastResponse->first_name==null || $LastResponse->last_name==null) {
						                                $username = $LastResponse->user_name;
						                            }}   
						                        $titles = App\Model\Ticket\Ticket_Thread::where('ticket_id', '=', $ticket->id)->get();
						                        $count = count($titles);
						                        foreach($titles as $title)
						                        {
						                            $title = $title;
						                        }  
						                        $assigned_to = App\User::where('id','=',$ticket->assigned_to)->first();
						                        if($assigned_to == null)
						                        {
						                            $assigned = "Unassigned";
						                        }
						                        else
						                        {
						                            $assigned = $assigned_to->first_name ." ". $assigned_to->last_name;
						                        }
						                        ?>
						                        <td class="mailbox-name"><a href="{!! route('ticket.thread',[$ticket->id]) !!}" title="{!! $title->title !!}">{{$string}}   </a> ({!! $count!!}) <i class="fa fa-comment"></i>
						                        @if($collab > 0)&nbsp;<i class="fa fa-users"></i>@endif 
						                        @if($attach > 0)&nbsp;<i class="fa fa-paperclip"></i>@endif</td>
						                        <td class="mailbox-Id"><a href="{!! route('ticket.thread',[$ticket->id]) !!}" title="{!! $title->title !!}">#{!! $ticket->ticket_number !!}</a></td>
						                        <?php $priority = App\Model\Ticket\Ticket_Priority::where('priority_id', '=', $ticket->priority_id)->first();?>
						                        <td class="mailbox-priority"><spam class="btn btn-{{$priority->priority_color}} btn-xs">{{$priority->priority}}</spam></td>
						                        <?php $from = App\User::where('id','=',$ticket->user_id)->first();   ?> 
						                        @if($from->role == "user")
						                <td class="mailbox-from" >{!! $from->user_name !!}</td>        
						                        @else
						                <td class="mailbox-from" >{!! $from->first_name." ".$from->last_name !!}</td>        
						                        @endif
						                <td class="mailbox-last-reply" style="color:{!! $rep !!}">{!! $username !!}</td>
						                <td>{!! $assigned !!}</td>
						                <td class="mailbox-last-activity">{!! $title->updated_at !!}</td>
						                <td class="mailbox-date"></td>
						                </tr>
						                @endforeach
						                </tbody>
						            </table><!-- /.table -->
						            
						            <div class="pull-right">
						                <?php echo $tickets->setPath(url('/ticket/open'))->render();?>&nbsp;
						            </div>
						        </div><!-- /.mail-box-messages -->
						        {!! Form::close() !!}

                   {{-- end deleted tickets --}}
                   </div>
                  </div><!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_2">
                    {{-- open tab --}}
						    <?php $closed = count(App\Model\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', 2)->get()); ?>
						        
						        @if(Session::has('success'))
						        <div class="alert alert-success alert-dismissable">
						            <i class="fa  fa-check-circle"> </i> <b> Success </b>
						            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						            {{Session::get('success')}}
						        </div>
						        @endif
						        <!-- failure message -->
						        @if(Session::has('fails'))
						        <div class="alert alert-danger alert-dismissable">
						            <i class="fa fa-ban"> </i> <b> Alert! </b>
						            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						            {{Session::get('fails')}}
						        </div>
						        @endif
						    <div class="box-body no-padding ">
						        
						    {!! Form::open(['route'=>'select_all','method'=>'post']) !!}
						        <div class="mailbox-controls">
						            <!-- Check all button -->
						            <a class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></a>
						            <a class="btn btn-default btn-sm" id="click"><i class="fa fa-refresh"></i></a>
						            <input type="submit" class="btn btn-default text-orange btn-sm" name="submit" value="Delete">
						            <input type="submit" class="btn btn-default text-yellow btn-sm" name="submit" value="Close">
						            <div class="pull-right">
						                <?php
						$counted = count(App\Model\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=','2')->get());
						if ($counted < 20) {
							echo $counted . "/" . $counted;
						} else {
							echo "20/" . $counted;
						}
						?>
						            </div>
						        </div>
						        <div class=" table-responsive mailbox-messages" id="refresh">
						        <p style="display:none;text-align:center; position:fixed; margin-left:40%;margin-top:-70px;" id="show" class="text-red"><b>Loading...</b></p>
						        <!-- table -->
						            <table class="table table-hover table-striped">
						                <thead>
						                <th>
						                </th>
						                <th>Subject</th>
						                <th>Ticket ID</th>
						                <th>Priority</th>
						                <th>From</th>
						                <th>Last Replier</th>
						                <th>Assigned To</th>
						                <th>Last Activity</th>
						                <th>Reply Due</th>
						                </thead>
						                <tbody id="hello">
						                    <?php $tickets = App\Model\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=','2')->orderBy('id', 'DESC')->paginate(20);?>
						                    @foreach ($tickets  as $ticket)
						                    <tr <?php if ($ticket->seen_by == null) {?> style="color:green;" <?php }
						?> >
						                        <td ><input type="checkbox" class="icheckbox_flat-blue" name="select_all[]" value="{{$ticket->id}}"/></td>
						                        <?php 
						                        //  collaborators
						                        $collaborators = App\Model\Ticket\Ticket_Collaborator::where('ticket_id','=',$ticket->id)->get();
						                        $collab = count($collaborators);
						                        //  title
						                        $title = App\Model\Ticket\Ticket_Thread::where('ticket_id', '=', $ticket->id)->first();
						                        $string = strip_tags($title->title);
						                        // check atatchments
						                        $attachments = App\Model\Ticket\Ticket_attachments::where('thread_id','=',$title->id)->first();
						                        $attach = count($attachments);

						                        if (strlen($string) > 40) {
						                            $stringCut = substr($string, 0, 40);
						                            $string = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...'; 
						                        }
						                        $TicketData = App\Model\Ticket\Ticket_Thread::where('ticket_id', '=', $ticket->id)->max('id');
						                        $TicketDatarow = App\Model\Ticket\Ticket_Thread::where('id', '=', $TicketData)->first();
						                        $LastResponse = App\User::where('id', '=', $TicketDatarow->user_id)->first(); 
						                        if($LastResponse->role == "user") {
						                            $rep = "#F39C12";
						                            $username = $LastResponse->user_name;
						                            } else { $rep = "#000"; $username = $LastResponse->first_name ." ". $LastResponse->last_name; 
						                            if($LastResponse->first_name==null || $LastResponse->last_name==null) {
						                                $username = $LastResponse->user_name;
						                            }}   
						                        $titles = App\Model\Ticket\Ticket_Thread::where('ticket_id', '=', $ticket->id)->get();
						                        $count = count($titles);
						                        foreach($titles as $title)
						                        {
						                            $title = $title;
						                        }  
						                        $assigned_to = App\User::where('id','=',$ticket->assigned_to)->first();
						                        if($assigned_to == null)
						                        {
						                            $assigned = "Unassigned";
						                        }
						                        else
						                        {
						                            $assigned = $assigned_to->first_name ." ". $assigned_to->last_name;
						                        }
						                        ?>
						                        <td class="mailbox-name"><a href="{!! route('ticket.thread',[$ticket->id]) !!}" title="{!! $title->title !!}">{{$string}}   </a> ({!! $count!!}) <i class="fa fa-comment"></i>
						                        @if($collab > 0)&nbsp;<i class="fa fa-users"></i>@endif 
						                        @if($attach > 0)&nbsp;<i class="fa fa-paperclip"></i>@endif</td>
						                        <td class="mailbox-Id"><a href="{!! route('ticket.thread',[$ticket->id]) !!}" title="{!! $title->title !!}">#{!! $ticket->ticket_number !!}</a></td>
						                        <?php $priority = App\Model\Ticket\Ticket_Priority::where('priority_id', '=', $ticket->priority_id)->first();?>
						                        <td class="mailbox-priority"><spam class="btn btn-{{$priority->priority_color}} btn-xs">{{$priority->priority}}</spam></td>
						                        <?php $from = App\User::where('id','=',$ticket->user_id)->first();   ?> 
						                        @if($from->role == "user")
						                <td class="mailbox-from" >{!! $from->user_name !!}</td>        
						                        @else
						                <td class="mailbox-from" >{!! $from->first_name." ".$from->last_name !!}</td>        
						                        @endif
						                <td class="mailbox-last-reply" style="color:{!! $rep !!}">{!! $username !!}</td>
						                <td>{!! $assigned !!}</td>
						                <td class="mailbox-last-activity">{!! $title->updated_at !!}</td>
						                <td class="mailbox-date"></td>
						                </tr>
						                @endforeach
						                </tbody>
						            </table><!-- /.table -->
						            
						            <div class="pull-right">
						                <?php echo $tickets->setPath(url('/ticket/open'))->render();?>&nbsp;
						            </div>
						        </div><!-- /.mail-box-messages -->
						        {!! Form::close() !!}

                   {{-- end deleted tickets --}}
                   </div>
                   </div>
                  <div class="tab-pane" id="tab_3">
                    {{-- open tab --}}
						    <?php $deleted = count(App\Model\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=','5')->get()); ?>
						       
						        @if(Session::has('success'))
						        <div class="alert alert-success alert-dismissable">
						            <i class="fa  fa-check-circle"> </i> <b> Success </b>
						            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						            {{Session::get('success')}}
						        </div>
						        @endif
						        <!-- failure message -->
						        @if(Session::has('fails'))
						        <div class="alert alert-danger alert-dismissable">
						            <i class="fa fa-ban"> </i> <b> Alert! </b>
						            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						            {{Session::get('fails')}}
						        </div>
						        @endif
						    <div class="box-body no-padding ">
						        
						    {!! Form::open(['route'=>'select_all','method'=>'post']) !!}
						        <div class="mailbox-controls">
						            <!-- Check all button -->
						            <a class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></a>
						            <a class="btn btn-default btn-sm" id="click"><i class="fa fa-refresh"></i></a>
						            <input type="submit" class="btn btn-default text-orange btn-sm" name="submit" value="Delete">
						            <input type="submit" class="btn btn-default text-yellow btn-sm" name="submit" value="Close">
						            <div class="pull-right">
						                <?php
						$counted = count(App\Model\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=','5')->get());
						if ($counted < 20) {
							echo $counted . "/" . $counted;
						} else {
							echo "20/" . $counted;
						}
						?>
						            </div>
						        </div>
						        <div class=" table-responsive mailbox-messages" id="refresh">
						        <p style="display:none;text-align:center; position:fixed; margin-left:40%;margin-top:-70px;" id="show" class="text-red"><b>Loading...</b></p>
						        <!-- table -->
						            <table class="table table-hover table-striped">
						                <thead>
						                <th>
						                </th>
						                <th>Subject</th>
						                <th>Ticket ID</th>
						                <th>Priority</th>
						                <th>From</th>
						                <th>Last Replier</th>
						                <th>Assigned To</th>
						                <th>Last Activity</th>
						                <th>Reply Due</th>
						                </thead>
						                <tbody id="hello">
						                    <?php $tickets = App\Model\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=','5')->orderBy('id', 'DESC')->paginate(20);?>
						                    @foreach ($tickets  as $ticket)
						                    <tr <?php if ($ticket->seen_by == null) {?> style="color:green;" <?php }
						?> >
						                        <td ><input type="checkbox" class="icheckbox_flat-blue" name="select_all[]" value="{{$ticket->id}}"/></td>
						                        <?php 
						                        //  collaborators
						                        $collaborators = App\Model\Ticket\Ticket_Collaborator::where('ticket_id','=',$ticket->id)->get();
						                        $collab = count($collaborators);
						                        //  title
						                        $title = App\Model\Ticket\Ticket_Thread::where('ticket_id', '=', $ticket->id)->first();
						                        $string = strip_tags($title->title);
						                        // check atatchments
						                        $attachments = App\Model\Ticket\Ticket_attachments::where('thread_id','=',$title->id)->first();
						                        $attach = count($attachments);

						                        if (strlen($string) > 40) {
						                            $stringCut = substr($string, 0, 40);
						                            $string = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...'; 
						                        }
						                        $TicketData = App\Model\Ticket\Ticket_Thread::where('ticket_id', '=', $ticket->id)->max('id');
						                        $TicketDatarow = App\Model\Ticket\Ticket_Thread::where('id', '=', $TicketData)->first();
						                        $LastResponse = App\User::where('id', '=', $TicketDatarow->user_id)->first(); 
						                        if($LastResponse->role == "user") {
						                            $rep = "#F39C12";
						                            $username = $LastResponse->user_name;
						                            } else { $rep = "#000"; $username = $LastResponse->first_name ." ". $LastResponse->last_name; 
						                            if($LastResponse->first_name==null || $LastResponse->last_name==null) {
						                                $username = $LastResponse->user_name;
						                            }}   
						                        $titles = App\Model\Ticket\Ticket_Thread::where('ticket_id', '=', $ticket->id)->get();
						                        $count = count($titles);
						                        foreach($titles as $title)
						                        {
						                            $title = $title;
						                        }  
						                        $assigned_to = App\User::where('id','=',$ticket->assigned_to)->first();
						                        if($assigned_to == null)
						                        {
						                            $assigned = "Unassigned";
						                        }
						                        else
						                        {
						                            $assigned = $assigned_to->first_name ." ". $assigned_to->last_name;
						                        }
						                        ?>
						                        <td class="mailbox-name"><a href="{!! route('ticket.thread',[$ticket->id]) !!}" title="{!! $title->title !!}">{{$string}}   </a> ({!! $count!!}) <i class="fa fa-comment"></i>
						                        @if($collab > 0)&nbsp;<i class="fa fa-users"></i>@endif 
						                        @if($attach > 0)&nbsp;<i class="fa fa-paperclip"></i>@endif</td>
						                        <td class="mailbox-Id"><a href="{!! route('ticket.thread',[$ticket->id]) !!}" title="{!! $title->title !!}">#{!! $ticket->ticket_number !!}</a></td>
						                        <?php $priority = App\Model\Ticket\Ticket_Priority::where('priority_id', '=', $ticket->priority_id)->first();?>
						                        <td class="mailbox-priority"><spam class="btn btn-{{$priority->priority_color}} btn-xs">{{$priority->priority}}</spam></td>
						                        <?php $from = App\User::where('id','=',$ticket->user_id)->first();   ?> 
						                        @if($from->role == "user")
						                <td class="mailbox-from" >{!! $from->user_name !!}</td>        
						                        @else
						                <td class="mailbox-from" >{!! $from->first_name." ".$from->last_name !!}</td>        
						                        @endif
						                <td class="mailbox-last-reply" style="color:{!! $rep !!}">{!! $username !!}</td>
						                <td>{!! $assigned !!}</td>
						                <td class="mailbox-last-activity">{!! $title->updated_at !!}</td>
						                <td class="mailbox-date"></td>
						                </tr>
						                @endforeach
						                </tbody>
						            </table><!-- /.table -->
						            
						            <div class="pull-right">
						                <?php echo $tickets->setPath(url('/ticket/open'))->render();?>&nbsp;
						            </div>
						        </div><!-- /.mail-box-messages -->
						        {!! Form::close() !!}
                  </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
              </div><!-- nav-tabs-custom -->
            </div><!-- /.col -->

           
          </div> <!-- /.row -->
          <!-- END CUSTOM TABS -->


<script>
      $(function () {
        //Enable check and uncheck all functionality
        $(".checkbox-toggle").click(function () {
          var clicks = $(this).data('clicks');
          if (clicks) {
            //Uncheck all checkboxes
            $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
            $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
          } else {
            //Check all checkboxes
            $(".mailbox-messages input[type='checkbox']").iCheck("check");
            $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
          }          
          $(this).data("clicks", !clicks);
        });
      });



    $(function() {
        // Enable check and uncheck all functionality
        $(".checkbox-toggle").click(function() {
            var clicks = $(this).data('clicks');
            if (clicks) {
                //Uncheck all checkboxes
                $("input[type='checkbox']", ".mailbox-messages").iCheck("uncheck");
            } else {
                //Check all checkboxes
                $("input[type='checkbox']", ".mailbox-messages").iCheck("check");
            }
            $(this).data("clicks", !clicks);
        });
    });


    $(document).ready(function() { /// Wait till page is loaded
        $('#click').click(function() {
            $('#refresh').load('open #refresh');
            $("#show").show();
        });
    });


    //  check box get data
    // jQuery(function($) {
    //     $("form input[id='check_all']").click(function() { // triggred check

    //         var inputs = $("form input[type='checkbox']"); // get the checkbox

    //         for(var i = 0; i < inputs.length; i++) { // count input tag in the form
    //             var type = inputs[i].getAttribute("type"); //  get the type attribute
    //                 if(type == "checkbox") {
    //                     if(this.checked) {
    //                         inputs[i].checked = true; // checked
    //                     } else {
    //                         inputs[i].checked = false; // unchecked
    //                      }
    //                 }
    //         }
    //     });

    //     $("form input[id='submit']").click(function() {  // triggred submit

    //         var count_checked = $("[name='data[]']:checked").length; // count the checked
    //         if(count_checked == 0) {
    //             alert("Please select a product(s) to delete.");
    //             return false;
    //         }
    //         if(count_checked == 1) {
    //             return confirm("Are you sure you want to delete these product?");
    //         } else {
    //             return confirm("Are you sure you want to delete these products?");
    //           }
    //     });
    // }); // jquery end

</script>



{{-- details table ends --}}
@section('FooterInclude')

@stop
@stop
<!-- /content -->
@stop
@section('FooterInclude')

@stop

<!-- /content -->








