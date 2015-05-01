@extends('themes.default1.layouts.agentblank')

@section('Tickets')
class="active"
@stop

@section('ticket-bar')
active
@stop

<?php $user = App\User::where('id', '=', $tickets->user_id)->first();?>
<?php $assignedto = App\User::where('id', '=', $tickets->assigned_to)->first();?>

@section('sidebar')
<li class="header">TICKET INFORMATION</li>
<li>
    <a href="">
        <span>TICKET ID</span>
        </br><b>#{{$tickets->ticket_number}}</b>
    </a>
</li>
<li>
    <a href="">
        <span>USER</span>
        </br><i class="fa fa-user"></i> <b>{{$user->user_name}}</b>
    </a>
</li>
<li >
    <a href="">
        @if($tickets->assigned_to > 0)
        <span>ASSIGNED TO</span>
        </br> <b>{{$assignedto->user_name}}</b><br/>{{$assignedto->email}}
        @else
        <span>UNASSIGNED</span>
        @endif
    </a>
</li>
@stop

@section('content')
<!-- Main content -->
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title" id="refresh2"><i class="fa fa-user"> </i> {!! $thread->title !!} </h3>
        <div class="pull-right">
            <!-- <button type="button" class="btn btn-default"><i class="fa fa-edit" style="color:green;"> </i> Edit</button> -->
            <button type="button" class="btn btn-default" id="Edit_Ticket" data-toggle="modal" data-target="#Edit"><i class="fa fa-edit" style="color:green;"> </i> Edit</button>
            <a href="{{url('ticket/print/'.$tickets->id)}}" target="_blank" class="btn btn-default"><i class="fa fa-print" style="color:blue;"> </i> Print</a>
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" id="d1"><i class="fa fa-exchange" style="color:teal;" id="hidespin"> </i><i class="fa fa-spinner fa-spin" style="color:teal; display:none;" id="spin"></i>
                    Change Status <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li id="open"><a href="#"><i class="fa fa-folder-open-o" style="color:red;"> </i>Open</a></li>
                    <li id="close"><a href="#"><i class="fa fa-check" style="color:green;"> </i>Close</a></li>
                    <li id="resolved"><a href="#"><i class="fa fa-check-circle-o " style="color:green;"> </i> Resolved</a></li>
                </ul>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" id="d2"><i class="fa fa-cogs" style="color:teal;"> </i>
                    More <span class="caret"></span>
                </button>
                <ul class="dropdown-menu pull-right">
                    <!-- <li data-toggle="modal" data-target="#ChangeOwner"><a href="#"><i class="fa fa-users" style="color:green;"> </i>Change Owner</a></li> -->
                    <!-- <li><a href="#"><i class="fa fa-edit" style="color:blue;"> </i>Manage Forms</a></li> -->
                    <li id="delete"><a href="#"><i class="fa fa-trash-o" style="color:red;"> </i>Delete Ticket</a></li>
                    <li  data-toggle="modal" data-target="#banemail"><a href="#" ><i class="fa fa-ban" style="color:red;" > </i> Ban Email</a></li>
            </div>
            </ul>
        </div>
    </div>
<!-- ticket details Table -->
    <div class="box-body">
        <div class="row">
            <section class="content"  >
                <div class="col-md-12">
                    <?php
$priority = App\Model\Ticket\Ticket_Priority::where('priority_id', '=', $tickets->priority_id)->first();
?>
                    <div class="callout callout-{{$priority->priority_color}}">
                        <div class="row">
                            <div class="col-md-3">
                                <?php
$sla = $tickets->sla;
$SlaPlan = App\Model\Manage\Sla_plan::where('id', '=', $sla)->first();
?>
                                <b>SLA Plan: {{$SlaPlan->grace_period}} </b>
                            </div>
                            <div class="col-md-3">
                                <b>Created Date: </b> {{date_format($tickets->created_at, 'd/m/Y H:i:s')}}
                            </div>
                            <div class="col-md-3">
                                <b>Due Date: </b>
                                <?php
$time = $tickets->created_at;
$time = date_create($time);
date_add($time, date_interval_create_from_date_string($SlaPlan->grace_period));
echo date_format($time, 'd/m/Y H:i:s');
?>
                            </div>
                            <div class="col-md-3">
                                <?php $response = App\Model\Ticket\Ticket_Thread::where('ticket_id', '=', $tickets->id)->get();?>
                                @foreach($response as $last)
                                <?php $ResponseDate = $last->created_at;?>
                                @endforeach
                                <b>Last Response: </b> {{date_format($ResponseDate, 'd/m/Y H:i:s')}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <table class="table table-hover"id="refresh">
                        <tr><td><b>Status:</b></td>       <div><?php $status = App\Model\Ticket\Ticket_Status::where('id', '=', $tickets->status)->first();?><td title="{{$status->properties}}">{{$status->state}}</td></div></tr>
                        <tr><td><b>Priority:</b></td>     <?php $priority = App\Model\Ticket\Ticket_Priority::where('priority_id', '=', $tickets->priority_id)->first();?><td title="{{$priority->priority_desc}}">{{$priority->priority}}</td></tr>
                        <tr><td><b>Department:</b></td>   <?php $help_topic = App\Model\Manage\Help_topic::where('id', '=', $tickets->help_topic_id)->first();?><td title="{{$help_topic->topic}}">{{$help_topic->department}}</td></tr>
                        <tr><td><b>Email:</b></td>        <td>{{$user->email}}</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-hover">
                        <tr><td><b>Phone:</b></td>          <td>{{$thread->user_id}}</td></tr>
                        <tr><td><b>Source:</b></td>         <td>{{$thread->ip_address}}</td></tr>
                        <tr><td><b>Help Topic:</b></td>     <?php $help_topic = App\Model\Manage\Help_topic::where('id', '=', $tickets->help_topic_id)->first();?><td title="{{$help_topic->topic}}">{{$help_topic->topic}}</td></tr>
                        <tr><td><b>Last Message:</b></td>   <td>{{$last->poster}}</td></tr>
                    </table>
                </div>
            </section>
        </div>
    </div>
</div>

<div class='row'>
    <div class='col-xs-12'>
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#General" data-toggle="tab" style="color:green;" id="aa"><i class="fa fa-reply-all"> </i> Reply</a></li>
                <!-- <li><a href="#Reply" data-toggle="tab" style="color:orange;"><i class="fa fa-mail-forward" > </i> Forward</a></li> -->
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="General">
                    <div class="form-group">
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#{{$tickets->id}}assign"><i class="fa fa-hand-o-right" style="color:orange;"> </i> Assign</button>
                        <button type="button" id="internal" class="btn btn-default"><i class="fa fa-file-text" style="color:blue;"> </i>  Internal Notes</button>
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#surrender"> <i class="fa fa-arrows-alt" style="color:red;"> </i>  Surrender</button>
                    </div>
<!-- ticket reply -->

                    {!! Form::model($tickets->id, ['id'=>'form3','method' => 'PATCH'] )!!}
                    <div id="t1">
                        <div class="form-group">
                            <div class="row">
                                <input type="hidden" name="ticket_ID" value="{{$tickets->id}}">
                                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                    <div class="col-md-2">
                                        {!! Form::label('To', 'To:') !!}
                                    </div>
                                    <div class="col-md-10">
                                        {!! Form::text('To',$user->email,['class'=>'form-control','style'=>'width:55%'])!!}
                                        {!! $errors->first('To', '<spam class="help-block text-red">:message</spam>') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Response:</label>
                                </div>
                                <div class="col-md-10">
                                    <select class="form-control" style="width:55%" name="CannedResponse">
                                        <option>Select a canned response</option>
                                        <option>Original Message</option>
                                        <option>Last Message</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                    <div class="col-md-2">
                                        {!! Form::label('Reply Content', 'ReplyContent:') !!}
                                    </div>
                                    <div class="col-md-10">
                                        <textarea name="ReplyContent"></textarea>
                                        {!! $errors->first('ReplyContent', '<spam class="help-block text-red">:message</spam>') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-10">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o" style="color:white;"> </i> Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!!Form::close()!!}

<!-- Internal Content -->
                    <div id="t2" style="display:none">
                        {!! Form::model($tickets->id, ['id'=>'form2','method' => 'PATCH'] )!!}
                        <div id="t4">
                            <div class="form-group">
                                <div class="row">
                                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                        <div class="col-md-2">
                                            <label>Internal Note</label>
                                        </div>
                                        <div class="col-md-10">
                                            <textarea name="InternalContent"></textarea>
                                            {!! $errors->first('InternalContent', '<spam class="help-block text-red">:message</spam>') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-10">
                                            <button type="submit"  class="btn btn-primary"><i class="fa fa-check-square-o" style="color:white;"> </i> Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!!Form::close()!!}
                    </div>
                </div>
<!-- ticket foreward -->
                <!-- <div class="tab-pane" id="Reply" >
                    <div class="form-group">
                        <button type="button" class="btn btn-default"><i class="fa fa-mail-forward" style="color:green;"> </i> Send</button>
                        <button type="button" class="btn btn-default"><i class="fa fa-th-large" style="color:teal;"> </i> Option</button>
                        <button type="button" class="btn btn-default"><i class="fa fa-file-text" style="color:blue;"> </i> Internal Notes</button>
                    </div>
                    <form>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>From</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="from" id="from" style="width:40%" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>To</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="to" id="to" style="width:55%" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Subject</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="from" id="from" style="width:100%" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Response</label>
                                </div>
                                <div class="col-md-10">
                                    <select class="form-control" style="width:55%" >
                                        <option>Select a canned response</option>
                                        <option>Original Message</option>
                                        <option>Last Message</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Reply Content</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea id="txtEditor2"> </textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div> -->
            </div>
        </div>
<!-- ticket  conversations -->
        <!-- row -->
        <div class="row" >
            <div id="refresh1">
                <div class="col-md-12" >
                    <!-- The time line -->
                    <ul class="timeline">
                        <!-- timeline time label -->
                        <?php
$conversations = App\Model\Ticket\Ticket_Thread::where('ticket_id', '=', $tickets->id)->paginate(10);
foreach ($conversations as $conversation) {
	?>
                            <li class="time-label">
                                <?php
$ConvDate1 = $conversation->created_at;
	$ConvDate = explode(' ', $ConvDate1);

	$date = $ConvDate[0];
	$time = $ConvDate[1];
	$time = substr($time, 0, -3);
	if (isset($data) && $date == $data) {
	} else {
		?> <span class="bg-green">
                                        {{date_format($conversation->created_at, 'd/m/Y')}}
                                    </span> <?php
$data = $ConvDate[0];
	}
	?>
                            </li>
                            <li>
                                <?php if ($conversation->staff_id > 0) {?>
                                    <i class="fa fa-group bg-yellow" title="Posted by Support Team"></i>
                                <?php } elseif ($conversation->user_id > 0) {?>
                                    <i class="fa fa-user bg-aqua" title="Posted by Customer"></i>
                                <?php } else {?>
                                    <i class="fa fa-mail-reply-all bg-purple" title="Posted by System"></i>
                                <?php }?>
                                <div class="timeline-item">
                                    <span id="date" class="time"  style="color:#fff;"><i class="fa fa-clock-o"> </i> {{date_format($conversation->created_at, 'd/m/Y H:i:s')}}</span>
                                    <h3 class="timeline-header"  style="background-color:{!! $conversation->color !!};color:#fff;"><a href="#" style="color:#fff;">{{$conversation->poster}}</a></h3>
                                    <div class="timeline-body">
                                        {!! $conversation->body !!}
                                    </div>
                                </div>
                            </li>
                            <?php $lastid = $conversation->id?>
                        <?php }?>
                        <li>
                            <i class="fa fa-clock-o bg-gray"></i>
                        </li>
                        <ul class="pull-right">
                            <?php echo $conversations->setPath(url('/thread/' . $tickets->id))->render();?>
                        </ul>
                    </ul>
                </div><!-- /.col -->
            </div>
        </div><!-- /.row -->
    </div>
</div>
<!-- </section>/.content -->
<!-- page modals -->
<div>
    <!-- Edit Ticket modal -->
    <div class="modal fade" id="Edit">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::model($tickets->id, ['id'=>'form','method' => 'PATCH'] )!!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit <b>({!! $tickets->ticket_number !!})</b>({!! $user->user_name !!})</h4>
                </div>
                <div class="modal-body" id="hide">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="subject" class="form-control" value="{{$thread->title}}" required>
                        {!! $errors->first('subject', '<spam class="help-block text-red">:message</spam>') !!}
                    </div>
                    <div class="form-group">
                        <label>Body</label>
                        <textarea name="body" class="form-control" required>{!! $thread->body !!}</textarea>
                        {!! $errors->first('body', '<spam class="help-block text-red">:message</spam>') !!}
                    </div>
                </div>
                <div id="show" style="display:none;">
                    <div class="row">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-9">
                            <img src="{{asset("dist/img/gifloader.gif")}}"><br/><br/><br/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis">Close</button>
                    <input type="submit" class="btn btn-primary pull-right" value="Update">
                </div>
                {!! Form::close() !!}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- ban email modal -->
    <div class="modal fade" id="banemail">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Ban Email</h4>
                </div>
                <div class="modal-body">
                    Are you sure to ban {!! $user->email !!}
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis2">Close</button>
                    <button id="ban" type="button" class="btn btn-warning pull-right" >Ban Email</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- change Owner Modal -->
    <div class="modal fade" id="ChangeOwner">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::model($tickets->id, ['id'=>'form4','method' => 'PATCH'] )!!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change Owner for ticket <b>#{!! $tickets->ticket_number !!}</b></h4>
                </div>
                <div class="modal-body" >
                    <div class="form-group has-feedback">
                        <!-- <input type="text" class="form-control" id="search" name="search" placeholder="Search Users"\> -->
                        <?php $users = App\User::where('role', '=', 'user')->get();?>
                        Add another Owner
                        <select name="SelectOwner" class="form-control">
                            @foreach($users as $user)
                            @if($user->id !== $tickets->user_id)
                            <option value="{!! $user->user_name !!}">{!! $user->user_name !!}({!! $user->email !!})</option>
                            @endif
                            @endforeach
                        </select>
                        <!-- <spam class="glyphicon glyphicon-search form-control-feedback"></spam> -->
                    </div>
                    <div class="row">
                        <div class="col-md-2"><spam class="glyphicon glyphicon-user fa-5x"></spam></div>
                        <div class="col-md-10">
                            <?php $user = App\User::where('id', '=', $tickets->user_id)->first();?>

                            <b>User Details</b><br/>
                            {!! $user->user_name !!}<br/>{!! $user->email !!}<br/>
                            @if($user->phone != null)
                            <b>Contact Informations</b><br/>
                            {!! $user->phone !!}
                            @endif
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis2">Close</button>
                    <button id="ban" type="button" class="btn btn-warning pull-right" >Submit</button>
                </div>
                {!! Form::close() !!}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Ticket Assign Modal -->
    <div class="modal fade" id="{{$tickets->id}}assign">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['id'=>'form1','method' => 'PATCH'] )!!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Delete</h4>
                </div>
                <div class="modal-body">
                    <p>Whome do you want to assign ticket?</p>

                    <select id="asssign" class="form-control" name="user">
                        <?php $assign = App\User::where('role', '=', 'agent')->get();?>
                        @foreach($assign as $user)
                        <option  value="{{$user->email}}">{{$user->user_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis4">Close</button>
                    <button type="submit" class="btn btn-success pull-right" id="submt2">Assign</button>
                </div>
                {!! Form::close()!!}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Surrender Modal -->
    <div class="modal fade" id="surrender">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Delete</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to surrender this Ticket?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis6">Close</button>
                    <button type="button" class="btn btn-warning pull-right" id="Surrender">Surrender</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<!-- scripts used on page -->
<script type="text/javascript">
    jQuery(document).ready(function($) {
        // Close a ticket
        $('#close').on('click', function(e) {
            $.ajax({
                type: "GET",
                url: "../ticket/close/{{$tickets->id}}",

                beforeSend: function() {
                    $("#hidespin").hide();
                    $("#spin").show();
                },

                success: function(response) {
                    $("#refresh").load("../thread/{{$tickets->id}}   #refresh");
                    $("#spin").hide();
                    $("#hidespin").show();
                    $("#d1").trigger("click");
                }
            })
            return false;
        });

        // Resolved  a ticket
        $('#resolved').on('click', function(e) {
            $.ajax({
                type: "GET",
                url: "../ticket/resolve/{{$tickets->id}}",
                success: function(response) {
                    $("#refresh").load("../thread/{{$tickets->id}}  #refresh");
                    $("#d1").trigger("click");
                }
            })
            return false;
        });

        // Open a ticket
        $('#open').on('click', function(e) {
            $.ajax({
                type: "GET",
                url: "../ticket/open/{{$tickets->id}}",
                success: function(response) {
                    $("#refresh").load("../thread/{{$tickets->id}}   #refresh");
                    $("#d1").trigger("click");
                }
            })
            return false;
        });

        // delete a ticket
        $('#delete').on('click', function(e) {
            $.ajax({
                type: "GET",
                url: "../ticket/delete/{{$tickets->id}}",
                success: function(response) {
                    $("#refresh").load("../thread/{{$tickets->id}}   #refresh");
                    $("#d2").trigger("click");
                }
            })
            return false;
        });

        // ban email
        $('#ban').on('click', function(e) {
            $.ajax({
                type: "GET",
                url: "../email/ban/{{$tickets->id}}",
                success: function(response) {
                    $("#dismis2").trigger("click");
                    $("#refresh").load("../thread/{{$tickets->id}}   #refresh");
                }
            })
            return false;
        });

        // internal note
        $('#internal').click(function() {
            $('#t1').hide();
            $('#t2').show();
        });

        // comment a ticket
        $('#aa').click(function() {
            $('#t1').show();
            $('#t2').hide();
        });

// Edit a ticket
        $('#form').on('submit', function() {

            $.ajax({
                type: "POST",
                url: "http://localhost/faveogit/public/ticket/post/edit/{{$tickets->id}}",
                dataType: "html",
                data: $(this).serialize(),
                beforeSend: function() {
                    $("#hide").hide();
                    $("#show").show();
                },
                success: function(response) {
                    $("#show").hide();
                    $("#hide").show();
                    $("#dismis").trigger("click");
                    $("#refresh1").load("../thread/{{$tickets->id}}   #refresh1");
                    $("#refresh2").load("../thread/{{$tickets->id}}   #refresh2");
                    if (response == 1)
                    {
                        alert('Updated successfully');
                    }
                    else if (response == 0)
                    {
                        alert('Please check all your fields');
                    }

                }
            })
            return false;
        });

// Assign a ticket
        $('#form1').on('submit', function() {
            $.ajax({
                type: "POST",
                url: "../ticket/assign/{{ $tickets->id }}",
                dataType: "html",
                data: $(this).serialize(),
                success: function(response) {
                    $("#dismis4").trigger("click");
                    // $("#RefreshAssign").load( "../thread/{{$tickets->id}} #RefreshAssign");
                    // $("#General").load( "../thread/{{$tickets->id}} #General");
                }
            })
            return false;
        });

// Internal Note
        $('#form2').on('submit', function() {
            $.ajax({
                type: "POST",
                url: "../internal/note/{{ $tickets->id }}",
                dataType: "html",
                data: $(this).serialize(),
                success: function(response) {

                    if (response == 1)
                    {
                        $("#refresh1").load("../thread/{{$tickets->id}}   #refresh1");
                        $("#t4").load("../thread/{{$tickets->id}}   #t4");
                    }
                    else
                    {
                        alert('fail');
                        // $( "#dismis4" ).trigger( "click" );
                    }
                }
            })
            return false;
        });

// Ticket Reply
        $('#form3').on('submit', function() {
            $.ajax({
                type: "POST",
                url: "../thread/reply/{{ $tickets->id }}",
                dataType: "html",
                data: $(this).serialize(),
                success: function(response) {

                    if (response == 1)
                    {
                        $("#refresh1").load("../thread/{{$tickets->id}}  #refresh1");
                        $("#t1").load("../thread/{{$tickets->id}}  #t1");
                    }
                    else
                    {
                        alert('fail');
                        // $( "#dismis4" ).trigger( "click" );
                    }
                }
            })
            return false;
        });

// Surrender
        $('#Surrender').on('click', function() {
            $.ajax({
                type: "GET",
                url: "../ticket/surrender/{{ $tickets->id }}",
                success: function(response) {

                    if (response == 1)
                    {
                        alert('ticket has been un assigned');
                        // $("#refresh1").load( "http://localhost/faveo/public/thread/{{$tickets->id}}   #refresh1");
                    }
                    else
                    {
                        alert('fail');
                        // $( "#dismis4" ).trigger( "click" );
                    }
                    $("#dismis6").trigger("click");
                }
            })
            return false;
        });
    });


// // Change Owner
//     jQuery(document).ready(function($) {
//         $('#form4').on('submit', function() {
//             $.ajax({
//                 type: "POST",
//                 url: "../change/owner/{{ $tickets->id }}",
//                 dataType: "html",
//                 data: $(this).serialize(),
//                 success: function(response) {

//                     if (response == 1)
//                     {
//                         $("#refresh1").load("../thread/{{$tickets->id}}  #refresh1");
//                     }
//                     else
//                     {
//                         alert('fail');
//                         // $( "#dismis4" ).trigger( "click" );
//                     }
//                 }
//             })
//             return false;
//         });
//     });


// jQuery(document).ready(function(cash) {
//     $('select').on('change', function (e) {
//         $('#submt2').on('click', function (e) {
//         var data1 = $(this).children('option:selected').data('id');

//             $.ajax({
//                 type        :   "GET",
//                 url         :   "http://localhost/faveo/public/ticket/assign/{{$tickets->id}}",
//                 dataType    :   'html',
//                 data        :   ({data2:data1}) ,
//                 success : function(response) {

//                             alert(response);
//                 }
//             })
//             return false;
//         });
//     });
// });




    // Auto Populate Change Owner
    $("#search").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: 'http://localhost/faveo/public/change/owner',
                dataType: "json",
                data: {
                    name_startsWith: request.term,
                    type: 'product'
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item,
                            value: item
                        }
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0
    });
    $('#item').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: 'http://localhost/LAKSA/public/select',
                dataType: "json",
                data: {
                    name_startsWith: request.term,
                    type: 'product_table',
                    row_num: 1
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        var code = item.split("|");
                        return {
                            label: code[0],
                            value: code[0],
                            data: item
                        }
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function(event, ui) {
            var names = ui.item.data.split("|");
            console.log(names[0], names[1], names[2]);
            $('#item').val(names[0]);
            $('#desc').val(names[1]);
            $('#box1').val(names[2]);
        }
    });
    //End of Autopopulate


</script>
@stop