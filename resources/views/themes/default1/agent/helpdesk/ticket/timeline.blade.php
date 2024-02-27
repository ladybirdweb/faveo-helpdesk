@extends('themes.default1.agent.layout.agent')
<meta charset="utf-8">

@section('Tickets')
class="nav-link active"
@stop

@section('ticket-bar')
active
@stop

@section('PageHeader')
<h1>{{Lang::get('lang.ticket-details')}}</h1>
@include('themes.default1.agent.helpdesk.ticket.response-messages')
@stop
<?php
$user = App\User::where('id', '=', $tickets->user_id)->first();
$assignedto = App\User::where('id', '=', $tickets->assigned_to)->first();
$agent_group = Auth::user()->assign_group;
$group = App\Model\helpdesk\Agent\Groups::where('id', '=', $agent_group)->where('group_status', '=', '1')->first();
?>

@section('sidebar')
<li class="nav-header">{!! Lang::get('lang.Ticket_Information') !!} </li>
<li class="nav-item">
    <a href="" class="nav-link">
        <span>{!! Lang::get('lang.Ticket_Id') !!} </span>
        </br><b>#{{$tickets->ticket_number}}</b>
    </a>
</li>
<li class="nav-item">
    <a href="{!! URL('user/'.$user->id) !!}" class="nav-link">
        <span>{!! Lang::get('lang.User') !!} </span>
        </br><i class="fa fa-user"></i> <b>{{$user->name() }}</b>
    </a>
</li>
<li class="nav-item">
    @if($tickets->assigned_to > 0)
    <a href="{!! URL('user/'.$tickets->assigned_to) !!}" class="nav-link">
        <span>{!! Lang::get('lang.Assigned_To') !!} </span>
        </br> {{$assignedto->first_name}}
    </a>
    @else
    <a href="" class="nav-link">
        <span>{!! Lang::get('lang.Unassigned') !!} </span>
    </a>
    @endif
</li>

<li  class="nav-header">
    {!! Lang::get('lang.ticket_ratings') !!}
</li>
<li class="nav-item"> 
    <?php $ratings = App\Model\helpdesk\Ratings\Rating::orderby('display_order')->get(); ?>
    @foreach($ratings as $rating) 

    @if($rating->rating_area == 'Helpdesk Area')
    <?php
    $rating_value = App\Model\helpdesk\Ratings\RatingRef::where('rating_id', '=', $rating->id)->where('ticket_id', '=', $tickets->id)->first();
    if ($rating_value == null) {
        $ratingval = '0';
    } else {
        $ratingval = $rating_value->rating_value;
    }
    ?>
    <a href="#" class="nav-link">
        {!! $rating->name !!}:
        <small class="float-right">
            <?php for ($i = 1; $i <= $rating->rating_scale; $i++) { ?>
                <input type="radio" class="star not-apply" id="star5" name="{!! $rating->name !!}" value="{!! $i !!}"<?php echo ($ratingval == $i) ? 'checked' : '' ?> />
            <?php } ?>
        </small>
    </a>
    @else 
    <?php
    $rating_value = App\Model\helpdesk\Ratings\RatingRef::where('rating_id', '=', $rating->id)->where('ticket_id', '=', $tickets->id)->avg('rating_value');
    if ($rating_value == null) {
        $avg_rating = '0';
    } else {

        $avg_rate = explode('.', $rating_value);
        $avg_rating = $avg_rate[0];
    }
    ?>
    <a href="#" class="nav-link">
        {!! $rating->name !!}:
        <small class="float-right">
            <?php for ($i = 1; $i <= $rating->rating_scale; $i++) { ?>
                <input type="radio" class="star not-apply" id="star5" name="{!! $rating->name !!}" value="{!! $i !!}"<?php echo ($avg_rating == $i) ? 'checked' : '' ?> />
            <?php } ?>
        </small>
    </a>
    @endif
    @endforeach
</li>
@stop 
<?php
if ($thread->title != "") {
    $title = wordwrap($thread->title, 70, "<br>\n");
} else {
    $title = "";
}
?>

@section('content')
<div id="alert10" class="alert alert-success alert-dismissable" style="display:none;">
    <button id="dismiss10" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <b><i class="icon fas fa-check"></i>{!! Lang::get('lang.alert') !!}!</b>
    <div id="message-success0"></div>
</div>
<div id="alert11" class="alert alert-success alert-dismissable" style="display:none;">
    <button id="dismiss11" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fas fa-check"></i>{!! Lang::get('lang.alert') !!}!</h4>
    <div id="message-success1"></div>
</div>
<div id="alert12" class="alert alert-warning alert-dismissable" style="display:none;">
    <button id="dismiss12" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fas fa-exclamation-triangle"></i>{!! Lang::get('lang.alert') !!}!</h4>
    <div id="message-warning1"></div>
</div>
<div id="alert13" class="alert alert-danger alert-dismissable" style="display:none;">
    <button id="dismiss13" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fas fa-ban"></i>{!! Lang::get('lang.alert') !!}!</h4>
    <div id="message-danger1"></div>
</div>
<!-- Main content -->
<div class="card card-light">
    <div class="card-header">
        <h3 class="card-title" id="refresh2"><i class="fas fa-ticket-alt"> </i> {!! $thread->getSubject() !!}</h3>
    </div>
    <!-- ticket details Table -->
    <div class="card-body">

        <div class="mb-3">
            <!-- <button type="button" class="btn btn-default"><i class="fa fa-edit" style="color:green;"> </i> Edit</button> -->
            <?php
            \Illuminate\Support\Facades\Event::dispatch(new \App\Events\TicketBoxHeader($user->id));

            if ($group->can_edit_ticket == 1) {
                ?>
            <button type="button" class="btn btn-sm btn-default btn-tool" data-toggle="modal" data-target="#Edit">

                <i class="fas fa-edit" style="color:green;"></i> {{trans('lang.edit')}}

            </button>            <?php } ?>

            <?php if ($group->can_assign_ticket == 1) { ?>
            <button type="button" class="btn btn-sm btn-default btn-tool" data-toggle="modal" data-target="#assign{{$tickets->id}}">

                <i class="fas fa-hand-point-right" style="color:orange;"></i> {{trans('lang.assign')}}

            </button>            <?php } ?>

            @if($tickets->assigned_to == Auth::user()->id)
                <button type="button" id="surrender_button" class="btn btn-sm btn-default btn-tool" data-toggle="modal" data-target="#surrender">

                    <i class="fas fa-arrows-alt" style="color:red;"></i> {{trans('lang.surrender')}}

                </button>
            @endif


            <?php \Illuminate\Support\Facades\Event::dispatch('show-add-event-btn', []); ?>

            <a href="{{url('ticket/print/'.$tickets->id)}}" target="_blank" class="btn btn-default btn-tool btn-sm">

                <i class="fas fa-print"></i> {{trans('lang.generate_pdf')}}

            </a>            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" id="d1"><i class="fas fa-exchange-alt" style="color:teal;" id="hidespin"> </i><i class="fa fa-spinner fa-spin" style="color:teal; display:none;" id="spin"></i>
                    {!! Lang::get('lang.change_status') !!} <span class="caret"></span>
                </button>
                <div class="dropdown-menu">
                    <a href="#" id="open" class="dropdown-item"><i class="fas fa-folder-open" style="color:red;"> </i> {!! Lang::get('lang.open') !!}</a>

                    <?php if ( $tickets_approval->status==7) {?>
                  @if(Auth::user()->role == 'admin')
                     <a href="#" id="approval_close" class="dropdown-item"><i class="fas fa-thumbs-up" style="color:red;"> </i> {!! Lang::get('lang.approval') !!}</a>
                     @endif
                    
                    <?php } ?>

                     <?php if ( $tickets_approval->status==3) {?>
                    <?php if ($group->can_edit_ticket == 1) {?>
                    <a href="#"  id="close" class="dropdown-item"><i class="fas fa-check" style="color:green;"> </i> {!! Lang::get('lang.close') !!}</a>
                    <?php } ?>
                     <?php } ?>

                     <?php if ( $tickets_approval->status==1) {?>
                    <?php if ($group->can_edit_ticket == 1) {?>
                    <a href="#" id="close" class="dropdown-item"><i class="fas fa-check" style="color:green;"> </i> {!! Lang::get('lang.close') !!}</a>
                    <?php } ?>
                     <?php } ?>
                    <a href="#" id="resolved" class="dropdown-item"><i class="fas fa-check-circle " style="color:green;"> </i> {!! Lang::get('lang.resolved') !!} </a>
                </div>
            </div>
            <?php if ($group->can_delete_ticket == 1 || $group->can_ban_email == 1) { ?>
                <div id="more-option" class="btn-group ml-0">
                    <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" id="d2"><i class="fas fa-cogs" style="color:teal;"> </i>
                        {!! Lang::get('lang.more') !!} <span class="caret"></span>
                    </button>
                    <div  class="dropdown-menu dropdown-menu-right">
                        <a href="#" data-toggle="modal" data-target="#ChangeOwner" class="dropdown-item"><i class="fas fa-users" style="color:green;"> </i>{!! Lang::get('lang.change_owner_for_ticket') !!}</a>
                        @if($tickets->status != 3 && $tickets->status != 2)
                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#MergeTickets"><i class="fas fa-cogs" style="color:teal;"> </i> {!! Lang::get('lang.merge-ticket') !!}</a>
                        @endif
                        <?php if ($group->can_delete_ticket == 1) { ?>
                        <a href="#" id="delete" class="dropdown-item" data-toggle="modal" data-target="#MergeTickets"><i class="fas fa-trash" style="color:red;"> </i> {!! Lang::get('lang.delete_ticket') !!}</a>
                        <?php }
                        ?>
                        <?php if ($group->can_ban_email == 1) { ?>
                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#banemail"><i class="fas fa-ban" style="color:red;"></i> {{trans('lang.ban_email')}}</a>
                        <?php 
                        \Illuminate\Support\Facades\Event::dispatch('ticket.details.more.list',[$tickets]);
                        }
                        ?>          </div>
                </div>
            <?php }
            ?>
        </div>
       <?php
        $priority = App\Model\helpdesk\Ticket\Ticket_Priority::where('priority_id', '=', $tickets->priority_id)->first();
        ?>
        <div class="callout callout-{{$priority->priority_color}}" style = 'background-color:{{$priority->priority_color}}; color:#F9F9F9'>
            <div class="row">
                <div class="col-md-3">
                    <?php
                    $sla = $tickets->sla;
                    $SlaPlan = App\Model\helpdesk\Manage\Sla_plan::where('id', '=', $sla)->first();
                    ?>
                    <b>{!! Lang::get('lang.sla_plan') !!}: {{$SlaPlan->grace_period}} </b>
                </div>
                <div class="col-md-3">
                    <b>{!! Lang::get('lang.created_date') !!}: </b> {{ UTC::usertimezone($tickets->created_at) }}
                </div>
                <div class="col-md-3">
                    <b>{!! Lang::get('lang.due_date') !!}: </b>
                    <?php
                    $duedate = $tickets->duedate;
                    $user_timezone = new DateTimeZone('Asia/Kolkata');
                    $time = date_create($tickets->duedate, $user_timezone);
                    date_add($time, date_interval_create_from_date_string($SlaPlan->grace_period));
                    date_add($time, date_interval_create_from_date_string('30 minutes'));
                    echo $time->format('Y-m-d H:i:s');
                    ?>
                </div>
                <div class="col-md-3">
                    <?php $response = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $tickets->id)->get(); ?>
                    @foreach($response as $last)
                    <?php $ResponseDate = $last->created_at; ?>
                    @endforeach
                    <b>{!! Lang::get('lang.last_response') !!}: </b> {{ UTC::usertimezone($ResponseDate) }}
                </div>
            </div>
        </div>
        
        <div class="text-center">
            <div id="show2" style="display:none;">
             
                <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}"><br/><br/><br/>
            </div>
        </div>

        <div id="hide2" class="row" style="width: 100%;">
            <div class="col-md-6">
                <table class="table table-hover">
                    <div id="refresh">
                        <tr><td><b>{!! Lang::get('lang.status') !!}:</b></td>       
                            <?php $status = App\Model\helpdesk\Ticket\Ticket_Status::where('id', '=', $tickets->status)->first(); ?>
                            @if($status)
                            <td title="{{$status->properties}}">{{$status->name}}</td>
                            @endif
                        </tr>
                        <tr><td><b>{!! Lang::get('lang.priority') !!}:</b></td>     
                            <?php $priority = App\Model\helpdesk\Ticket\Ticket_Priority::where('priority_id', '=', $tickets->priority_id)->first(); ?>
                            @if($priority)
                            <td title="{{$priority->priority_desc}}">{{$priority->priority_desc}}</td>
                            @endif
                        </tr>
                        <tr><td><b>{!! Lang::get('lang.department') !!}:</b></td>   
                            <?php $dept123 = App\Model\helpdesk\Agent\Department::where('id', '=', $tickets->dept_id)->first(); ?>
                            @if($dept123)
                            <td title="{{$dept123->name}}">{{$dept123->name}}</td></tr>
                            @endif
                        <tr><td><b>{!! Lang::get('lang.email') !!}:</b></td>        <td>{{Str::limit($user->email,30)}}</td></tr>
                        @if($user->ban > 0)  <tr><td style="color:orange;"><i class="fa fa-warning"></i><b>
                                    {!!  Lang::get('lang.this_ticket_is_under_banned_user')!!}</td><td></td></tr>@endif
                    </div>
                </table>
            </div>
            <div class="col-md-6">
                <?php
                $user_phone = App\User::where('mobile', '=', $thread->user_id)->first();
                $TicketData = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $thread->ticket_id)->where('is_internal', '=', 0)->max('id');
                $TicketDatarow = App\Model\helpdesk\Ticket\Ticket_Thread::where('id', '=', $TicketData)->where('is_internal', '=', 0)->first();
                $LastResponse = App\User::where('id', '=', $TicketDatarow->user_id)->first();
                if ($LastResponse->role == "user") {
                    $rep = "#F39C12";
                    $username = $LastResponse->first_name . " " . $LastResponse->last_name;
                    if ($LastResponse->first_name == null || $LastResponse->first_name == '') {
                        $username = $LastResponse->user_name;
                    }                        } else {
                    $rep = "#000";
                    $username = $LastResponse->first_name . " " . $LastResponse->last_name;
                    if ($LastResponse->first_name == null || $LastResponse->last_name == null) {
                        $username = $LastResponse->user_name;
                    }
                }
                if ($tickets->source > 0) {
                    $ticket_source = App\Model\helpdesk\Ticket\Ticket_source::where('id', '=', $tickets->source)->first();
                    $ticket_source = $ticket_source->value;
                } else
                    $ticket_source = $tickets->source;
                ?>
                <table class="table table-hover">
                    <div id="refresh3">

                        @if($user->phone_number !=null)<tr><td><b>{!! Lang::get('lang.phone') !!}:</b></td>          <td>{{$user->phone_number}}</td></tr>@endif
                        @if($user->mobile !=null)<tr><td><b>{!! Lang::get('lang.mobile') !!}:</b></td>          <td>{{$user->ext . $user->mobile}}</td></tr>@endif
                        <tr><td><b>{!! Lang::get('lang.source') !!}:</b></td>         <td>{{$ticket_source}}</td></tr>
                        <tr><td><b>{!! Lang::get('lang.help_topic') !!}:</b></td>     <?php $help_topic = App\Model\helpdesk\Manage\Help_topic::where('id', '=', $tickets->help_topic_id)->first(); ?><td title="{{$help_topic->topic}}">{{$help_topic->topic}}</td></tr>
                        <tr><td><b>{!! Lang::get('lang.last_message') !!}:</b></td>   <td>{{Str::limit($username,30)}}</td></tr>
                        <tr><td><b>{!! Lang::get('lang.organization') !!}:</b></td>   <td>{!!$LastResponse->getOrgWithLink()!!}</td></tr>
                        <?php \Illuminate\Support\Facades\Event::dispatch(new App\Events\TicketDetailTable($TicketData)); ?>
                    </div>
                </table>
            </div>
        </div>

        <?php \Illuminate\Support\Facades\Event::dispatch('ticket.timeline.marble',[$TicketData]);?>
        <div id="gifshow" style="display:none" class="text-center">
            <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}">
        </div>  <!-- added 05/05/2016-->
        <div id="resultdiv"></div>

        <div class="card card-light" id="inboxactions">
            
            <div class="card-header">
                
                <h3 class="card-title">{{trans('lang.action')}}</h3>
            </div>

                    <div class="card-body">
            
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" href="#General" data-toggle="tab" style="color:#27C116;" id="aa"><i class="fa fa-reply-all"> </i> {!! Lang::get('lang.reply') !!}</a></li>
                <li class="nav-item"><a class="nav-link" href="#Internal" data-toggle="tab" style="color:#0495FF;" id="bb"><i class="fa fa-file-text"> </i> {!! Lang::get('lang.internal_notes') !!}</a></li>
                <?php \Illuminate\Support\Facades\Event::dispatch('timeline.tab.list',[$TicketData]); ?>
                <!-- <li><a href="#Reply" data-toggle="tab" style="color:orange;"><i class="fa fa-mail-forward" > </i> Forward</a></li> -->
            </ul>

            <div class="tab-content mt-3">
                
                <div id="alert21" class="alert alert-success alert-dismissable" style="display:none;">
                    <button id="dismiss21" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <div id="message-success2"></div>
                </div>
                <div id="alert22" class="alert alert-warning alert-dismissable" style="display:none;">
                    <h4><i class="icon fa fa-warning"></i>{!! Lang::get('lang.alert') !!}!</h4>
                    <div id="message-warning2"></div>
                </div>
                <div id="alert23" class="alert alert-danger alert-dismissable" style="display:none;">
                    <button id="dismiss23" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="icon fa fa-ban"></i><b>{!! Lang::get('lang.alert') !!} !</b>
                    <div id="message-danger2"></div>
                </div>

                <div class="tab-pane active" id="General">
                    <!-- ticket reply -->
                    <div id="show3" style="display:none;text-align: center;">
                        <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}"><br/><br/><br/>
                    </div>

                    <form id="form3">
                        
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div id="t1">
                            
                            <div id="reply-response"></div>
                            
                            <div class="form-group">
                                
                            <!-- to -->
                                <input type="hidden" name="ticket_ID" value="{{$tickets->id}}">
                                
                                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                    <div class="row">
                                        <div class="col-md-2">
                                            {!! Form::label('To', Lang::get('lang.to').':') !!}
                                        </div>
                                        <div class="col-md-10">
                                            <div id="refreshTo">
                                            {!! Form::text('To',$user->email,['disabled'=>'disabled','id'=>'email','class'=>'form-control','style'=>'width:55%'])!!}
                                            {!! $errors->first('To', '<spam class="help-block text-red">:message</spam>') !!}
                                                <a href="#" data-toggle="modal" data-target="#addccc"> {!! Lang::get('lang.add_cc') !!} </a>
                                                <div id="recepients">
                                                    <?php
                                                    $Collaborator = App\Model\helpdesk\Ticket\Ticket_Collaborator::where('ticket_id', '=', $tickets->id)->get();
                                                    $count_collaborator = count($Collaborator);
                                                    ?>
                                                    @if($count_collaborator > 0)
                                                    <a href="#" data-toggle="modal" data-target="#surrender2">({!! $count_collaborator !!}) {!! Lang::get('lang.recepients') !!} </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php \Illuminate\Support\Facades\Event::dispatch(new App\Events\TimeLineFormEvent($tickets)); ?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{!! Lang::get('lang.response') !!}</label>
                                </div>
                                <div class="col-md-10">
                                    <select class="form-control" style="width:55%" id="select" onchange="addCannedResponse()">

                                        <?php
                                        $canneds = App\Model\helpdesk\Agent_panel\Canned::where('user_id', '=', Auth::user()->id)->get();
                                        ?>                                                  
                                        <option value="zzz">{!! Lang::get('lang.select_a_canned_response') !!}</option>
                                        @foreach($canneds as $canned)
                                        <option value="{!! $canned->message !!}" >{!! $canned->title !!}</option>
                                        @endforeach
                                        {{-- <option>Last Message</option> --}}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}"  id="reply_content_class">
                            <div class="row">
                                <!-- reply content -->
                                    <div class="col-md-2">
                                        {!! Form::label('Reply Content', Lang::get('lang.reply_content').':') !!}<span class="text-red"> *</span>
                                    </div>
                                    <div class="col-md-10">
                                        <div id="newtextarea">
                                            <textarea style="width:98%;height:20%;" name="reply_content" class="form-control" id="reply_content"></textarea>
                                        </div>
                                        {!! $errors->first('reply_content', '<spam class="help-block text-red">:message</spam>') !!}
                                    </div>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}" id="reply_content_class">
                            <div class="row">
                                <div class="col-md-2">
                                        <label> {!! Lang::get('lang.attachment') !!}</label>
                                    </div>
                                    <div class="col-md-10">
                                        <div id="reset-attachment">
                                            <span class='btn btn-default btn-file'> <i class='fa fa-paperclip'></i> <span>{!! Lang::get('lang.upload') !!}</span><input type='file' name='attachment[]' id='attachment' multiple/></span>
                                            <div id='file_details'></div><div id='total-size'></div>{!! Lang::get('lang.max') !!}. {!! $max_size_in_actual !!}
                                            <div>
                                                <a href="javascript:;" id='clear-file' onClick='clearAll()' style='display:none; cursor:pointer;'><i class='fas fa-times'></i> Clear all</a>
                                            </div>
                                        </div>
                                        
                                    </div>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-10">
                                    <div id="t5">
                                        <button id="replybtn" type="submit" class="btn btn-primary"><i class="fas fa-check-square" style="color:white;"> </i> {!! Lang::get('lang.update') !!}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!!Form::close()!!}
                </div>

                <div class="tab-pane" id="Internal">
                    <!-- ticket reply -->
                    <div id="show5" class="text-center" style="display:none;">
                         <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}">
                        
                    </div>
                    <div id="t2">
                        {!! Form::model($tickets->id, ['id'=>'form2','method' => 'PATCH'] )!!}
                        <div id="t4">
                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}" id="internal_content_class">
                                <div class="row">
                                    <!-- internal note -->
                                   <div class="col-md-2">
                                            <label>{!! Lang::get('lang.internal_note') !!}:<span class="text-red"> *</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <div id="newtextarea1">
                                                <textarea class="form-control" name="InternalContent" id="InternalContent" style="width:98%; height:150px;"></textarea>
                                            </div>
                                            {!! $errors->first('InternalContent', '<spam class="help-block text-red">:message</spam>') !!}
                                        </div>
                                </div>
                            </div>
                        
                                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                    <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-10">
                                            <button type="submit"  class="btn btn-primary"><i class="fas fa-check-square" style="color:white;"> </i> {!! Lang::get('lang.update') !!}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!!Form::close()!!}
                    </div>
                </div>
                <?php \Illuminate\Support\Facades\Event::dispatch('timeline.tab.content',[$tickets]); ?>
            </div>
        </div>

            <!-- ticket  conversations -->
            <?php
            $conversations = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $tickets->id)->orderBy('id', 'DESC')->simplePaginate(10);
            $ij = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $tickets->id)->first();
            ?>

            <div class="card card-light">
                
                <div class="card-header">
                    <h3 class="card-title">{{trans('lang.ticket_conversation')}}</h3>
                </div>

                <div class="card-body">
                    
                    <div id="refresh1">
                      
                        <style type="text/css">
                            .pagination{
                                margin-bottom: -20px;
                                margin-top: 0px;
                            }
                        </style>
                       
                        <ul class="float-right" style="padding-right:40px" >
                            <?php echo $conversations->setPath(url('/thread/' . $tickets->id))->render(); ?>
                        </ul>

                        <div class="col-md-12" >
                            <link rel="stylesheet" type="text/css" href="{{asset("lb-faveo/css/faveo-css.css")}}">
                            <link href="{{asset("lb-faveo/css/jquery.rating.css")}}" rel="stylesheet" type="text/css" />
                            
                    <!-- The time line -->
                    <div class="timeline timeline-inverse">
                        <!-- timeline time label -->
                        <?php
                       
                        foreach ($conversations as $conversation) {
                             
                            if ($conversation == null) {      
                            } else {
                                ?>
                                <div class="time-label">
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
                                    if($conversation->user_id != null) {
                                        $role = $conversation->user;
                                    } else {
                                        $role = null;
                                    }
                                    ?>
                                </div>

                                <div>
                                    <?php if ($conversation->is_internal) { ?>
                                        <i class="fas fa-tag bg-purple" title="<?= Lang::get('lang.posted_by_system') ?>"></i>
                                    <?php
                                    } else {
                                        if($conversation->user_id != null) {
                                            if ($role->role == 'agent' || $role->role == 'admin') {
                                                ?>
                                                <i class="fas fa-reply-all bg-yellow" title="<?= Lang::get('lang.posted_by_support_team') ?>"></i>
                                            <?php } elseif ($role->role == 'user') { ?>
                                                <i class="fas fa-user bg-aqua" title="<?= Lang::get('lang.posted_by_customer') ?>"></i>
                                            <?php } else { ?>
                                                <i class="fas fa-reply-all bg-purple" title="<?= Lang::get('lang.posted_by_system') ?>"></i>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <i class="fas fa-tag bg-purple" title="<?= Lang::get('lang.posted_by_system')?>"></i>
                                            <?php
                                        }
                                    }

                                    if($conversation->user_id != null) {
                                        if ($conversation->is_internal) {
                                            $color = '#A19CFF';
                                            // echo $color; 
                                        } else {
                                            if ($role->role == 'agent' || $role->role == 'admin') {
                                                $color = '#F9B03B';
                                            } elseif ($role->role == 'user') {
                                                $color = '#38D8FF';
                                            } else {
                                                $color = '#605CA8';
                                            }
                                        }
                                    }
                                    
                                    ?>
                                    <div class="timeline-item">
                                        <span style="color:#fff;">
                                            <div class="float-right" style="position: relative;top: -13px;">   
                                                <table>
                                                    <tbody>
                                            @if($role)
                                                @if($role->role != null)
                                                    @if($role->role != 'user' && $conversation->is_internal != 1)
                                                        @foreach($ratings as $rating) 
                                                        @if($rating->rating_area == 'Comment Area')
                                                        <?php
                                                        $rating_value = App\Model\helpdesk\Ratings\RatingRef::where('rating_id', '=', $tickets->rating_id)->where('thread_id', '=', $conversation->id)->select('rating_value')->first();
                                                        if ($rating_value == null) {
                                                            $ratingval = '0';
                                                        } else {
                                                            $ratingval = $rating_value->rating_value;
                                                        }
                                                        ?>
                                                        <tr>
                                                            <th><div class="ticketratingtitle" style="color:#3c8dbc;" >{!! $rating->name !!} &nbsp;</div></th>&nbsp
                                                        <td style="button:disabled;">
                                                        <?php for ($i = 1; $i <= $rating->rating_scale; $i++) { ?>
                                                            <input type="radio" class="star star-rating-readonly not-apply" id="star5" name="{!! $rating->name !!},{!! $conversation->id !!}" value="{!! $i !!}"<?php echo ($ratingval == $i) ? 'checked' : '' ?> />
                                                        <?php } ?>&nbsp;&nbsp;&nbsp;&nbsp;   
                                                        </td> 
                                                        </tr>
                                                        @endif
                                                        @endforeach
                                                    @endif
                                                @endif
                                            @endif
                                                    </tbody>
                                                </table>
                                            </div>  
                                        </span>

                                        <h3 class="timeline-header">
                                            <?php
                                            
                                            if($conversation->user_id != null) {
                                                if ($role->first_name == '' || $role->first_name == null) {
                                                    $usernam = $role->user_name;
                                                } else {
                                                    $usernam = $role->first_name . " " . $role->last_name;
                                                }
                                            } else {
                                                $usernam = Lang::get('lang.system');
                                            }
                                            
                                            ?>
                                            
                                            @if($conversation->user_id != null) 
                                                <img src="{{$role->profile_pic}}" class="img-circle img-bordered-sm" alt="User Image" width="25" height="25" />
                                            @else 
                                                <img src="{{asset('lb-faveo/media/images/avatar_1.png')}}" class="img-circle img-bordered-sm" width="25" height="25"  
                                                    alt="img-circle img-bordered-sm">
                                            @endif
                                            
                                            @if($conversation->user_id != null) 
                                                <a href='{!! url("/user/".$role->id) !!}'>{!! Str::limit($usernam,30) !!}</a>
                                            @else
                                                {!! Str::limit($usernam,30) !!}
                                            @endif

                                            @if($conversation->id == $ij->id)
                                            <a href="{{url('genereate-pdf/'.$conversation->id)}}" class= "float-right" title="{!! Lang::get('lang.generate_pdf_thread') !!}">
                                                &nbsp;&nbsp;<i class="fas fa-newspaper"></i>
                                            </a>
                                            @endif

                                            <span style="float: right;font-size: 12px;color: #999;margin: 4px;"><i class="far fa-clock"></i> {{UTC::usertimezone($conversation->created_at)}}</span>
                                            
                                        </h3>
                                        @if(\Lang::getLocale()=='ar')
                                        <div class="timeline-body{{$conversation -> id}} arindam"   style="padding-right:30px !important;margin-bottom:-20px;margin-top: 15px;">
                                        @else
                                        <div class="timeline-body{{$conversation -> id}} arindam"   style="padding-left:30px;margin-bottom:-20px;margin-top: 15px;">
                                        @endif



                                            @if($conversation->poster=='client')


                                            <script>
                                                                if ('{{Lang::getLocale()}}' != 'ar'){
                                                        $('body').css('display', 'block');
                                                                setTimeout(function(){
                                                                var $iframe = "Id{{$conversation->id}}";
                                                                        $('<iframe src="about:blank" id=' + $iframe + ' class="iframe" frameborder="0"  scrolling="no" width="100%" style="height:1px"></iframe>').appendTo(".timeline-body{{$conversation->id}}");
                                                                        setTimeout(function(){
                                                                        $('#' + $iframe).contents().find('body').append('<body><style>body{display:inline-block;}</style>{!!$conversation->purify(true)!!}<body>');
                                                                        }, 100);
                                                                        setTimeout(function(){
                                                                        var frameid = document.getElementById($iframe);
                                                                                $("#" + $iframe).contents().find('a').attr('target', '_blank')
                                                                                if (parseInt($("#" + $iframe).contents().find('img').css('width')) > 700){
                                                                        $("#" + $iframe).contents().find('img').css('width', '96%');
                                                                        }
                                                                        frameid.contentWindow.document.body.style.width = "96%";
                                                                                var iframe_height = frameid.contentWindow.document.body.scrollHeight;
                                                                                frameid.style.height = iframe_height + "px";
                                                                        }, 1000);
                                                                }, 0);
                                                        }
                                                        else{

                                                        setTimeout(function(){
                                                        $('body').css('display', 'block');
                                                                var $iframe = "Id{{$conversation->id}}";
                                                                $('<iframe src="about:blank" id=' + $iframe + ' class="iframe" frameborder="0"  scrolling="no" width="100%" style="height:1px"></iframe>').appendTo(".timeline-body{{$conversation->id}}");
                                                                setTimeout(function(){
                                                                $('#' + $iframe).contents().find('body').append('<body><style>body{display:inline-block;}</style>{!!$conversation->purify(true)!!}<body>');
                                                                }, 100);
                                                                setTimeout(function(){
                                                                var frameid = document.getElementById($iframe);
                                                                        $("#" + $iframe).contents().find('a').attr('target', '_blank')
                                                                        if (parseInt($("#" + $iframe).contents().find('img').css('width')) > 700){
                                                                $("#" + $iframe).contents().find('img').css('width', '96%');
                                                                }
                                                                frameid.contentWindow.document.body.style.width = "100%";
                                                                        var iframe_height = frameid.contentWindow.document.body.scrollHeight;
                                                                        frameid.style.height = iframe_height + "px";
                                                                }, 1000);
                                                        }, 0);
                                                        }
                                            </script>
                                            @else 
                                            {!! $conversation->body !!}
                                            @endif
                                           
                   

                                            @if($conversation->id == $ij->id)
        <?php $ticket_form_datas = App\Model\helpdesk\Ticket\Ticket_Form_Data::where('ticket_id', '=', $tickets->id)->get();
        ?>
                                        @if(isset($ticket_form_datas))
                                        
                                            <br/>
                                            <table class="table table-bordered">
                                                <tbody>
                                                    @foreach($ticket_form_datas as $ticket_form_data)
                                                    <tr>
                                                        <td style="width: 30%">{!! $ticket_form_data->getFieldKeyLabel() !!}</td>
                                                        <td>{!! removeUnderscore($ticket_form_data->content) !!}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody></table>
                                        
                                        @endif
                                        @endif
                                        
                                        </div>
                                        
                                        <div class="timeline-footer" style="margin-bottom:-5px">
                                            @if(!$conversation->is_internal)
                                                @if($conversation->user_id != null)
                                                    <?php \Illuminate\Support\Facades\Event::dispatch(new App\Events\Timeline($conversation, $role)); ?>
                                                @endif
                                            @endif
                                           
                                            <ul class='mailbox-attachments clearfix'>
                                                
                                                @forelse ($conversation->attach as $attachment) 
                                                    {!! $attachment->getFile() !!}
                                                @empty
                                                @endforelse
                                            </ul>
                                        </div>
                                        
                                    </div>
                                </div>
                                <?php $lastid = $conversation->id ?>
                                <?php
                            }
                        }
                        ?>
                        <div>
                            <i class="fas fa-history bg-gray"></i>
                        </div>
                        <ul class="float-right" style="padding-right:40px" >
                            <?php echo $conversations->setPath(url('/thread/' . $tickets->id))->render(); ?>
                        </ul>
                    </div>               
                </div><!-- /.col -->
            </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- </section>/.content -->

<!-- page modals -->
<div>
    <!-- Edit Ticket modal -->
    <?php if ($group->can_edit_ticket == 1) { ?>
        <div class="modal fade" id="Edit">
            <div class="modal-dialog modal-lg" style="width:60%;height:70%;">
                <div class="modal-content">
                    {!! Form::model($tickets->id, ['id'=>'form','method' => 'PATCH'] )!!}
                    <div class="modal-header">
                        <h4 class="modal-title">{!! Lang::get('lang.edit') !!} <b>[#{!! $tickets->ticket_number !!}]</b></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidd en="true">&times;</span></button>
                    </div>
                    <div class="modal-body" id="hide">
                        <div class="form-group">
                            <label>{!! Lang::get('lang.title') !!} <span class="text-red"> *</span></label>
                            <input type="text" name="subject" class="form-control" value="{{$thread->title}}" >
                            <spam id="error-subject" style="display:none" class="help-block text-red">This is a required field</spam>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{!! Lang::get('lang.sla_plan') !!} <span class="text-red"> *</span></label>
    <?php $sla_plans = App\Model\helpdesk\Manage\Sla_plan::where('status', '=', 1)->get() ?>
                                    <select class="form-control" name="sla_paln">
                                        @foreach($sla_plans as $sla_plan)
                                        <option value="{!! $sla_plan->id !!}" <?php
                                        if ($SlaPlan->id == $sla_plan->id) {
                                            echo "selected";
                                        }
                                        ?> >{!! $sla_plan->grace_period !!}</option>
                                        @endforeach
                                    </select>
                                    <spam id="error-sla" style="display:none" class="help-block text-red">This is a required field</spam>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{!! Lang::get('lang.help_topic') !!} <span class="text-red"> *</span></label>

    <?php $help_topics = App\Model\helpdesk\Manage\Help_topic::where('status', '=', 1)->get(); ?>
                                    <select class="form-control" name="help_topic">
                                        @foreach($help_topics as $helptopic)
                                        <option value="{!! $helptopic->id !!}" <?php
                                        if ($help_topic->id == $helptopic->id) {
                                            echo 'selected';
                                        }
                                        ?> >{!! $helptopic->topic !!}</option>
                                        @endforeach
                                    </select>
                                    <spam id="error-help" style="display:none" class="help-block text-red">This is a required field</spam>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{!! Lang::get('lang.ticket_source') !!} <span class="text-red"> *</span></label>
    <?php $ticket_sources = App\Model\helpdesk\Ticket\Ticket_source::all() ?>
                                    <select class="form-control" name="ticket_source">
                                        @foreach($ticket_sources as $ticketsource)
                                        <option value="{!! $ticketsource->id !!}" <?php
                                        if ($tickets->source == $ticketsource->id) {
                                            echo "selected";
                                        }
                                        ?> >{!! $ticketsource->value !!}</option>
                                        @endforeach 
                                    </select>
                                    <spam id="error-source" style="display:none" class="help-block text-red">This is a required field</spam>
                                </div>
                            </div>
    <?php ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{!! Lang::get('lang.priority') !!} <span class="text-red"> *</span></label>
    <?php $ticket_prioritys = App\Model\helpdesk\Ticket\Ticket_Priority::where('status','=',1)->get(); ?>
                                    <select class="form-control" name="ticket_priority">
                                        @foreach($ticket_prioritys as $ticket_priority)
                                        <option value="{!! $ticket_priority->priority_id !!}" <?php
                                        if ($tickets->priority_id == $ticket_priority->priority_id) {
                                            echo "selected";
                                        }
                                        ?> >{!! $ticket_priority->priority_desc !!}</option>
                                        @endforeach
                                    </select>
                                    <spam id="error-priority" style="display:none" class="help-block text-red">This is a required field</spam>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="show" style="display:none;text-align: center;">
                        <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}">
                    </div>
                    <script>
                        $('#Edit').on('hidden.bs.modal', function (e) {
                            $(this).find('form')[0].reset();

                        });
                    </script>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="dismis">{!! Lang::get('lang.close') !!}</button>
                        <input type="submit" class="btn btn-primary" value="{!! Lang::get('lang.update') !!}">
                    </div>
                    {!! Form::close() !!}
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    <?php }
    ?>
<?php if ($group->can_ban_email == 1) { ?>
        <!-- ban email modal -->
        <div class="modal fade" id="banemail">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{!! Lang::get('lang.ban_email') !!} </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        {!! Lang::get('lang.are_you_sure_to_ban') !!} {!! $user->email !!}
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="dismis2">{!! Lang::get('lang.close') !!}</button>
                        <button id="ban" type="button" class="btn btn-warning" >{{trans('lang.ban_email')}}</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    <?php }
    \Illuminate\Support\Facades\Event::dispatch('ticket.detail.modelpopup',[$tickets]);
    ?>
    <!-- Change Owner Modal -->
    <div class="modal fade" id="ChangeOwner">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {!! Form::open(['id'=>'form4','method' => 'PATCH'] )!!}
                <div class="modal-header">
                    <h4 class="modal-title">{!! Lang::get('lang.change_owner_for_ticket') !!} <b>#{!! $tickets->ticket_number !!}</b></h4>
                    <button type="button" class="close" id="close101" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="p-2">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#ahah1" data-toggle="tab" style="color:green;" id="aa"><i class="fas fa-users"> </i> {!! Lang::get('lang.search_existing_users') !!}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#haha2" data-toggle="tab" style="color:orange;"><i class="fas fa-user-plus" > </i> {!! Lang::get('lang.add_new_user') !!}</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-2">
                        <div class="tab-pane active" id="ahah1">
                            <div id="change_alert" class="alert alert-danger alert-dismissable" style="display:none;">
                                <button id="change_dismiss" type="button" class="close" data-dismiss="alert"  aria-hidden="true">×</button>
                                <b><i class="icon fa fa-exclamation-circle"></i>Alert!</b>
                                <div id="message-success42"></div>
                            </div>
                            <div>
                                <div class="text-center" id="change_loader" style="display:none;">
                                    <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}">
                                </div>
                                <div id="change_body" class="p-2">
<?php $users = App\User::where('role', '=', 'user')->get(); ?>
                                    <label>{!! Lang::get('lang.add_another_owner') !!}</label>
                                    <input type="text" class="form-control" id="tags2" name="email" placeholder="{!! Lang::get('lang.search_user') !!}"\>
                                    <input type="hidden" name="ticket_id" value="{!! $tickets->id !!}">
                                    <input type="hidden" name="action" value="change-owner">
                                    <div class="row">
                                        <div class="col-md-2"><spam class="glyphicon glyphicon-user fa-5x"></spam></div>
                                        <div id="change-refresh" class="col-md-10">
<?php $user = App\User::where('id', '=', $tickets->user_id)->first(); ?>
                                            <!-- <b>{!! Lang::get('lang.user_details') !!}User Details</b><br/> -->
                                            <b>Current owner</b><br/>
                                            {!! $user->user_name !!}<br/>{!! $user->email !!}<br/>
                                            @if($user->phone != null)
                                            <b>{!! Lang::get('lang.contact_informations') !!}Contact Informations</b><br/>
                                            {!! $user->phone !!}
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal" id="dismis42">{!! Lang::get('lang.close') !!}</button>
                                <!--<input type='checkbox' name='send-mail' class='icheckbox_flat-blue' value='".$ticket->id."'><span disabled class="btn btn-sm">Check to notify user</span></input>-->
                                <button type="submit" class="btn btn-primary" id="submt2">{!! Lang::get('lang.update') !!}</button>
                            </div>
                            {!! Form::close()!!}
                        </div><!--tab-pane active-->
                        <div class="tab-pane" id="haha2">
                            <div id="change_alert2" class="alert alert-danger alert-dismissable" style="display:none;">
                                <button id="change_dismiss" type="button" class="close" data-dismiss="alert"  aria-hidden="true">×</button>
                                <b><i class="icon fa fa-check"></i>Alert!</b>
                                <div id="message-success422"></div>
                            </div>
                            <div id="abc" class="p-2">
                                <label>{!! Lang::get('lang.add_new_user') !!}</label>            
             
                                <div id="here2"></div>
                                {!! Form::model($tickets->id, ['id'=>'change-add-owner','method' => 'PATCH'] )!!} 
                                <div id="add-change-loader" class="text-center" style="display:none;">
                                    <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}"> 
                                </div>
                                <div id="add-change-body">
                                    <input type="text" name="name" class="form-control" placeholder="{!! Lang::get('lang.name') !!}" required>
                                    <input type="email" name="email" class="form-control" placeholder="{!! Lang::get('lang.e-mail') !!}" required> 
                                    <input type="hidden" name="ticket_id" value="{!! $tickets->id !!}">
                                    <input type="hidden" name="action" value="change-add-owner">
                                    <input type="submit" class="btn btn-primary" value="{!! Lang::get('lang.submit') !!}">
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div><!--tab-content-->    
                </div><!--nav-tabs-custom-->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<?php if ($group->can_assign_ticket == 1) { ?>
        <!-- Ticket Assign Modal -->
        <div class="modal fade" id="assign{{$tickets->id}}">
            <div class="modal-dialog">
                <div class="modal-content">
                    {!! Form::open(['id'=>'form1','method' => 'PATCH'] )!!}
                    <div class="modal-header">
                        <h4 class="modal-title">{!! Lang::get('lang.assign') !!}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div id="assign_alert" class="alert alert-success alert-dismissable" style="display:none;">
                        <button id="assign_dismiss" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i>Alert!</h4>
                        <div id="message-success1"></div>
                    </div>
                    <div class="modal-body">
                        <div class="text-center" id="assign_loader" style="display:none;">
                            <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}">
                        </div>
                        <div id="assign_body">
                            <p>{!! Lang::get('lang.whome_do_you_want_to_assign_ticket') !!}?</p>
                            <select id="asssign" class="form-control" name="assign_to">
                                <?php
                                $assign = App\User::where('role', '!=', 'user')->where('active', '=', '1')->orderBy('first_name')->get();
                                $count_assign = count($assign);
                                $teams = App\Model\helpdesk\Agent\Teams::where('status', '=', '1')->get();
                                $count_teams = count($teams);
                                ?>
                               
                                <optgroup label="Agents ( {!! $count_assign !!} )">
                                    @foreach($assign as $user)
                                    <option  value="user_{{$user->id}}">{{$user->first_name." ".$user->last_name}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="dismis4">{!! Lang::get('lang.close') !!}</button>
                        <button type="submit" class="btn btn-success" id="submt2">{!! Lang::get('lang.assign') !!}</button>
                    </div>
                    {!! Form::close()!!}
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    <?php }
    ?>
    <!-- Surrender Modal -->
    <div class="modal fade" id="surrender">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{!! Lang::get('lang.surrender') !!}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <span>{!! Lang::get('lang.are_you_sure_you_want_to_surrender_this_ticket') !!}?</span>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="dismis6">{!! Lang::get('lang.close') !!}</button>
                    <button type="button" class="btn btn-warning" id="Surrender">{!! Lang::get('lang.surrender') !!}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <?php \Illuminate\Support\Facades\Event::dispatch('show-add-calendar-model', ['id' => $tickets->id])?>
    <!-- add or search user Modal -->
    <div class="modal fade" id="addccc">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{!! Lang::get('lang.add_collaborator') !!}</h4>
                    <button type="button" id="cc-close" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="nav-tabs-custom mt-1 p-1">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a  class="nav-link active" href="#ahah" data-toggle="tab" style="color:green;" id="aa"><i class="fa fa-users"> </i> {!! Lang::get('lang.search_existing_users') !!}</a></li>
                        <li  class="nav-item"><a  class="nav-link" href="#haha" data-toggle="tab" style="color:orange;"><i class="fa fa-user-plus" > </i> {!! Lang::get('lang.add_new_user') !!}</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="ahah">
                            <div class="modal-body" id="def">
                                <div id="here"></div>
                                <div id="show7" style="display:none;text-align:center;">
                                   <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}"> 
                                </div>
                                
                                {!! Form::model($tickets->id, ['id'=>'search-user','method' => 'PATCH'] )!!}    
                                <div id="hide1234">
                                    <input type="text" class="form-control" name="search" id="tags" placeholder="{!! Lang::get('lang.search_by_email') !!}">
                                    <input type="hidden" name="ticket_id" value="{!! $tickets->id !!}">
                                    <input type="submit" class="btn btn-primary" value="{!! Lang::get('lang.submit') !!}">
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                        <div class="tab-pane" id="haha">
                            <div class="modal-body" id="abc">           
                                <div id="here_new"></div>
                                {!! Form::model($tickets->id, ['id'=>'add-user','method' => 'PATCH'] )!!} 
                                <div id="show8" style="display:none;text-align:center;">
                                    <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}"> 
                                </div>
                                <div id="hide12345">
                                    <input type="text" name="name" class="form-control" placeholder="{!! Lang::get('lang.name') !!}" required>
                                    <input type="email" name="email" class="form-control" placeholder="{!! Lang::get('lang.e-mail') !!}" required> 
                                    <input type="hidden" name="ticket_id" value="{!! $tickets->id !!}">
                                    <input type="submit" class="btn btn-primary" value="{!! Lang::get('lang.submit') !!}">
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="modal-footer"> --}}
                {{-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis9" data-dismiss="alert">Close</button> --}}
                {{-- <button type="button" class="btn btn-warning pull-right" id="Surrender">Add User</button> --}}
                {{-- </div> --}}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- Surrender Modal -->
    <div class="modal fade" id="surrender2">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{!! Lang::get('lang.list_of_collaborators_of_this_ticket') !!}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="surrender22">
                    @foreach($Collaborator as $ccc)
                    <?php
                    $collab_user_id = $ccc->user_id;
                    $collab_user = App\User::where('id', '=', $collab_user_id)->first();
                    ?>
                    <div id="alert11" class="alert alert-dismissable" style="background-color:#F2F2F2">
                        <meta name="_token" content="{{ csrf_token() }}"/>
                        <button id="dismiss11" type="button" class="close" data-dismiss="alert" onclick="remove_collaborator({!! $ccc->id !!})" aria-hidden="true">×</button>
                        @if($collab_user->role == 'agent' || $collab_user->role == 'admin')
                        <i class="icon fa fa-user"></i>{!! $collab_user->first_name . " " . $collab_user->last_name !!}
                        @elseif($collab_user->role == 'user')
                        <i class="icon fa fa-user"></i>{!! $collab_user->user_name !!}
                        @endif
                        <div id="message-success1">{!! $collab_user->email !!}</div>
                    </div>
                    @endforeach
                </div>
                {{--  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis6">Close</button>
                    <button type="button" class="btn btn-warning pull-right" id="Surrender">Surrender</button>
                </div> --}}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div style="display:none">
        <form id="auto-submit">
            <input type="hidden" name="now" value="1">
        </form>
    </div>
</div>



<!-- merge tickets modal -->
<div class="modal fade" id="MergeTickets">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{!! Lang::get('lang.merge-ticket') !!} <b>[#{!! $tickets->ticket_number !!}]</b> </h4>
                <button type="button" class="close" data-dismiss="modal" id="merge-close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                
            </div><!-- /.modal-header-->
            <div class ="modal-body">
                <div class="text-center" id="merge_loader"  style="display:none;">
                    <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}">
                </div>
                <div id="merge_body">
                    <div id="merge-body-alert">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="merge-succ-alert" class="alert alert-success alert-dismissable" style="display:none;" >
                                    <!-- <button id="dismiss-merge" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
                                    <b><i class="icon fa fa-check"></i>Alert!</b>
                                    <div id="message-merge-succ"></div>
                                </div>
                                <div id="merge-err-alert" class="alert alert-danger alert-dismissable" style="display:none;">
                                    <!-- <button id="dismiss-merge2" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
                                    <h4><i class="icon fas fa-ban"></i>Alert!</h4>
                                    <div id="message-merge-err"></div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.merge-alert -->
                    <div id="merge-body-form">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::open(['id'=>'merge-form','method' => 'PATCH'] )!!}
                                <label>{!! Lang::get('lang.title') !!}</label>
                                <input type="text" name='title' class="form-control" value="<?php
                                       $ticket_data = App\Model\helpdesk\Ticket\Ticket_Thread::select('title')->where('ticket_id', "=", $tickets->id)->first();
                                       echo $ticket_data->title;
                                       ?>"/>
                            </div>
                            <div class="col-md-6">
                                <label>{!! Lang::get('lang.select-pparent-ticket') !!}</label>
                                <div id="parent-loader" style="display:none;">
                                    <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}" height="30px" width="30px">
                                </div>
                                <div id="parent-body" >

                                    <select class="form-control" id="select-merge-parent"  name='p_id' data-placeholder="{!! Lang::get('lang.select_tickets') !!}" style="width: 100%;"><option value="{{$tickets->id}}"><?php
                                       $ticket_data = App\Model\helpdesk\Ticket\Ticket_Thread::select('title')->where('ticket_id', "=", $tickets->id)->first();
                                       echo strip_tags($ticket_data->title);
                                       ?></option></select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">

                                <label>{!! Lang::get('lang.select_tickets') !!}</label>
                                <select class="form-control select2" id="select-merge-tickts" name="t_id[]" multiple="multiple" data-placeholder="{!! Lang::get('lang.select_tickets') !!}" style="width: 100%;">

                                </select>

                            </div>

                            <div class="col-md-6">
                                <label>{!! Lang::get('lang.merge-reason') !!}</label>
                                <textarea  name="reason" class="form-control"></textarea>
                            </div>
                        </div>
                    </div><!-- mereg-body-form -->
                </div><!-- merge-body -->
            </div><!-- /.modal-body -->
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="dismis2">{!! Lang::get('lang.close') !!}</button>
                <input  type="submit" id="merge-btn" class="btn btn-primary" value="{!! Lang::get('lang.merge') !!}"></input>
                {!! Form::close() !!}
            </div><!-- /.modal-footer -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->   
<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; padding-right: 15px;background-color: rgba(0, 0, 0, 0.7);">
    <div class="modal-dialog" role="document">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close closemodal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body" id="custom-alert-body" >
                </div>
                <div class="modal-footer">
                    <a href="{!! URL::route('ticket.thread',$tickets->id) !!}"><button type="button" class="btn btn-primary yes" data-dismiss="modal">{{Lang::get('lang.reload-now')}}</button></a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $var = App\Model\helpdesk\Settings\Ticket::where('id', '=', 1)->first(); ?>

<!-- scripts used on page -->
<script type="text/javascript">
            function clearAll() {
                $("#file_details").html("");
                $("#total-size").html("");
                $("#attachment").val('');
                $("#clear-file").hide();
                $("#replybtn").removeClass('disabled');
            }
            
            $(function () {
            $("#InternalContent").summernote({
                height: 150,
                    tabsize: 2,
                    toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']]
                  ]
            });
            $("#reply_content").summernote({
                height: 250,        
            });
            });
            jQuery('.star').attr('disabled', true);
            
            $(function() {
                $("#tags, #tags2").autocomplete({
                    source: 'auto/<?php echo $tickets->id; ?>'
                });
            });
            jQuery(document).ready(function() {
    $("#cc_page").on('click', '.search_r', function(){
    var search_r = $('a', this).attr('id');
            $.ajax({
            type: "GET",
                    url: "../ticket/status/{{$tickets->id}}/" + search_r,
                    beforeSend: function () {
                    $("#refresh").hide();
                            $("#loader").show();
                    },
                    success: function (response) {

                    $("#refresh").load("../thread/{{$tickets->id}}  #refresh");
                            $("#refresh").show();
                            $("#loader").hide();
                            var message = response;
                            $("#alert11").show();
                            $('#message-success1').html(message);
                            setInterval(function(){$("#alert11").hide(); }, 4000);
                    }
            });
            return false;
    });
    });
            $(document).ready(function () {

    //Initialize Select2 Elements
    $(".select2").select2();
            setInterval(function(){
            $("#auto-submit").submit(function(){
            $.ajax({
            type: "POST",
                    url: "{!! URL::route('lock',$tickets->id) !!}",
            })
                    return false;
            });
            }, 180000);
    });
            jQuery(document).ready(function() {
    // Close a ticket
    $('#close').on('click', function(e) {
    $.ajax({
    type: "POST",
            url: "../ticket/close/{{$tickets->id}}",
            beforeSend: function() {
            $("#hidespin").hide();
                    $("#spin").show();
                    $("#hide2").hide();
                    $("#show2").show();
            },
            success: function(response) {
            $("#refresh").load("../thread/{{$tickets->id}}   #refresh");
                    $("#show2").hide();
                    $("#spin").hide();
                    $("#hide2").show();
                    $("#hidespin").show();
                    $("#d1").trigger("click");
                    var message = "{!! Lang::get('lang.your_ticket_have_been_closed') !!}";
                    $("#alert10").css('display','block');
                    $('#message-success0').html(message);
                   location.reload();
            }
    })
            return false;
    });
    
    // approval close ticket
 $('#approval_close').on('click', function(e) {
     
    $.ajax({
    type: "POST",
            url: "../ticket/close/get-approval/{{$tickets->id}}",//route 600
            beforeSend: function() {
            $("#hidespin").hide();
                    $("#spin").show();
                    $("#hide2").hide();
                    $("#show2").show();
            },

            success: function(response) {
           
            $("#refresh").load("../thread/{{$tickets->id}}   #refresh");
             
                    $("#show2").hide();
                    $("#spin").hide();
                    $("#hide2").show();
                    $("#hidespin").show();
                    $("#d1").trigger("click");
                    var message = "successfull approval";
                    $("#alert10").css('display','block');
                    $('#message-success0').html(message);
                    setInterval(function(){
                    $("#alert10").css('display','none');
                    }, 2000);
                    location.reload();
            }
    })
            return false;
    });

            // Resolved  a ticket
            $('#resolved').on('click', function(e) {
    $.ajax({
    type: "POST",
            url: "../ticket/resolve/{{$tickets->id}}",
            beforeSend: function() {
            $("#hide2").hide();
                    $("#show2").show();
            },
            success: function(response) {
            $("#refresh").load("../thread/{{$tickets->id}}  #refresh");
                    $("#d1").trigger("click");
                    $("#hide2").show();
                    $("#show2").hide();
                    var message = "{!! Lang::get('lang.your_ticket_have_been_resolved') !!}";
                    console.log(message,'message')
                    $("#alert10").css('display','block');
                    $('#message-success0').html(message);
                    setInterval(function(){$("#alert10").css('display','none');
                    }, 2000);
                    location.reload();
            }
    })
            return false;
    });
            // Open a ticket
            $('#open').on('click', function(e) {
    $.ajax({
    type: "POST",
            url: "../ticket/open/{{$tickets->id}}",
            beforeSend: function() {
            $("#hide2").hide();
                    $("#show2").show();
            },
            success: function(response) {
            $("#refresh").load("../thread/{{$tickets->id}}   #refresh");
                    $("#d1").trigger("click");
                    $("#hide2").show();
                    $("#show2").hide();
                    var message = "{!! Lang::get('lang.your_ticket_have_been_opened') !!}";
                    $("#alert10").css('display','block');
                    $('#message-success0').html(message);
                    setInterval(function(){$("#alert10").css('display','none');
                     }, 4000);
                    location.reload();
            }
    })
            return false;
    });
            // delete a ticket
            $('#delete').on('click', function(e) {
    $.ajax({
    type: "POST",
            url: "../ticket/delete/{{$tickets->id}}",
            beforeSend: function() {
            $("#hide2").hide();
                    $("#show2").show();
            },
            success: function(response) {
            $("#refresh").load("../thread/{{$tickets->id}}   #refresh");
                    $("#d2").trigger("click");
                    $("#hide2").show();
                    $("#show2").hide();
                    var message = "{!! Lang::get('lang.your_ticket_have_been_moved_to_trash') !!}";
                    $("#alert10").css('display','block');
                    $('#message-success0').html(message);
                    //alert(document.referrer);
                    setInterval(function(){$("#alert10").css('display','none');
                    }, 2000);
                    location.reload();
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
                    var message = "{!! Lang::get('lang.this_email_have_been_banned') !!}";
                    $("#alert10").css('display','block');
                    $('#message-success0').html(message);
                    setInterval(function(){$("#alert10").css('display','none'); 
                    }, 4000);
                    location.reload();
            }
    })
            return false;
    });
            // internal note
            // $('#internal').click(function() {
            //     $('#t1').hide();
            //     $('#t2').show();
            // });

            // comment a ticket
            // $('#aa').click(function() {
            //     $('#t1').show();
            //     $('#t2').hide();
            // });

// Edit a ticket
            $('#form').on('submit', function() {
    $.ajax({
    type: "POST",
            url: "../ticket/post/edit/{{$tickets->id}}",
            dataType: "html",
            data: $(this).serialize(),
            beforeSend: function() {
            $("#hide").hide();
                    $("#show").show();
            },
            success: function(response) {
            $("#show").hide();
                    $("#hide").show();
                    if (response == 0) {
            message = "{!! Lang::get('lang.ticket_updated_successfully') !!}"
            $('#Edit').modal('hide');
            //         $("#refresh1").load("../thread/{{$tickets->id}}   #refresh1");
            //         $("#refresh2").load("../thread/{{$tickets->id}}   #refresh2");
                    $("#alert10").css('display','block');
                    $('#message-success0').html(message);
                    setInterval(function(){$("#alert10").css('display','none'); }, 4000);
                location.reload();
            }
            else if (response == 1) {
            $("#error-subject").show();
            }
            else if (response == 2) {
            $("#error-sla").show();
            }
            else if (response == 3) {
            $("#error-help").show();
            }
            else if (response == 4) {
            $("#error-source").show();
            }
            else if (response == 5) {
            $("#error-priority").show();
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
            beforeSend: function() {
            $("#assign_body").hide();
                    $("#assign_loader").show();
            },
            success: function(response) {
            if (response == 1)
            {
            // $("#assign_body").show();
            // var message = "Success";
            // $('#message-success1').html(message);
            // setInterval(function(){$("#alert11").hide(); },4000);   
            location.reload();
            var message = "Success!";
                    $("#alert10").css('display','block');
                    $('#message-success0').html(message);
                    setInterval(function(){$("#dismiss10").trigger("click"); }, 2000);
            }
            $("#assign_body").show();
                    $("#assign_loader").hide();
                    $("#dismis4").trigger("click");
                    // $("#RefreshAssign").load( "../thread/{{$tickets->id}} #RefreshAssign");
                    // $("#General").load( "../thread/{{$tickets->id}} #General");
            }
    })
            return false;
    });
            // Change owner of a ticket
            $('#form4').on('submit', function() {
    $.ajax({
    type: "POST",
            url: "../change-owner/{{ $tickets->id }}",
            dataType: "html",
            data: $(this).serialize(),
            beforeSend: function() {
            $("#change_body").hide();
                    $("#change_loader").show();
            },
            success: function(response) {
            if (response != 1) {
                // $("#assign_body").show();
                var message = "{{Lang::get('lang.user-not-found')}}";
                if (response == 400) {
                    message = "{{Lang::get('lang.selected-user-is-already-the-owner')}}";
                }
                $('#change_alert').css('display','block');
                $('#message-success42').html(message);
                setInterval(function(){$("#change_alert").css('display','none'); }, 5000);
                $("#change_body").show();
                $("#change_loader").hide();
            } else {
            $("#change_body").show();
                    $("#change_loader").hide();
                    $("#dismis42").trigger("click");
                    // $("#RefreshAssign").load( "../thread/{{$tickets->id}} #RefreshAssign");
                    // $("#General").load( "../thread/{{$tickets->id}} #General");
                    $("#hide2").load("../thread/{{$tickets->id}}  #hide2");
                    $("#refresh").load("../thread/{{$tickets->id}}  #refresh");
                    $("#refresh1").load("../thread/{{$tickets->id}}  #refresh1");
                    $("#refresh3").load("../thread/{{$tickets->id}}  #refresh3");
                    $("#refreshTo").load("../thread/{{$tickets->id}}  #refreshTo");
                    $("#change-refresh").load("../thread/{{$tickets->id}}  #change-refresh");
                    var message = "{{Lang::get('lang.change-success')}}";
                    $("#alert10").css('display','block');
                    $('#message-success0').html(message);
                    setInterval(function(){$("#alert10").css('display','none'); }, 4000);
                    location.reload();
            }
            }
    })
            return false;
    });
// Add and change owner of a ticket
            $('#change-add-owner').on('submit', function(){
    $.ajax({
    type: "POST",
            url: "../change-owner/{{ $tickets->id }}", //url: "../add-user",
            dataType: "html",
            data: $(this).serialize(),
            beforeSend: function() {
            $('#add-change-loader').show();
                    $('#add-change-body').hide();
            },
            success: function(response) {
            if (response == 1){
            $('#add-change-loader').hide();
                    $('#add-change-body').show();
                    $("#close101").trigger("click");
                    $("#hide2").load("../thread/{{$tickets->id}}  #hide2");
                    $("#refresh").load("../thread/{{$tickets->id}}  #refresh");
                    $("#refresh1").load("../thread/{{$tickets->id}}  #refresh1");
                    $("#refresh3").load("../thread/{{$tickets->id}}  #refresh3");
                    $("#refreshTo").load("../thread/{{$tickets->id}}  #refreshTo");
                    var message = "{{Lang::get('lang.change-success')}}";
                     $("#alert10").css('display','block');
                    $('#message-success0').html(message);
                    setInterval(function(){$("#alert10").css('display','none'); }, 4000);
                    location.reload();
            } else {
            if (response == 4){
            var message = "{{Lang::get('lang.user-exists')}}";
            } else if (response == 5){
            var message = "{{Lang::get('lang.valid-email')}}";
            } else {
            //var message = "Can't process your request. Try after some time.";
            }
            $('#change_alert2').show();
                    $('#message-success422').html(message);
                    setInterval(function(){$("#change_alert2").hide(); }, 8000);
                    $('#add-change-loader').hide();
                    $('#add-change-body').show();
            }
            }
    })
            return false;
    });
            // Internal Note
            $('#form2').on('submit', function() {
                var internal_content = document.getElementById('InternalContent').value;
                if(internal_content) {
                    $("#internal_content_class").removeClass('has-error');
                    $("#alert23").hide();
                } else {
                    var message = "<li>{!! Lang::get('lang.internal_content_is_a_required_field') !!}</li>";
                    $("#internal_content_class").addClass('has-error');
                    $("#alert23").show();
                    $('#message-danger2').html(message);
                    $("#show3").hide();
                    $("#t1").show();
                    return false;
                }
    $.ajax({
    type: "POST",
            url: "../internal/note/{{ $tickets->id }}",
            dataType: "html",
            data: $(this).serialize(),
            beforeSend: function() {
            $("#t2").hide();
                    $("#show5").show();
            },
            success: function(response) {

            if (response == 1)
            {
            $("#refresh1").load("../thread/{{$tickets->id}}   #refresh1");
            $(".embed-responsive-item").load("../thread/{{$tickets->id}}   .embed-responsive-item");
            
                    // $("#t4").load("../thread/{{$tickets->id}}   #t4");
                    var message = "{!! Lang::get('lang.internal-note-has-been-added') !!}";
                    $("#alert21").show();
                    $('#message-success2').html(message);
                    setInterval(function(){$("#alert21").hide(); }, 4000);
                    $("#show5").hide();
                    $("#t2").show();
                    $('#InternalContent').summernote('reset');
                    setInterval(function(){
                            var head= document.getElementsByTagName('head')[0];
                            var script= document.createElement('script');
                            script.type= 'text/javascript';
                            script.src= '{{asset("lb-faveo/js/jquery.rating.pack.js")}}';
                            head.appendChild(script);
//                            $('.rating-cancel').hide();
//                            $(".star-rating-control").attr("disabled", "disabled").off('hover');
//                            $(".star-rating-control").addClass("disabled")
                        }, 4000);
            } else {
            // alert('fail');
            var message = "{!! Lang::get('lang.for_some_reason_your_message_was_not_posted_please_try_again_later') !!}";
                    $("#alert23").show();
                    $("#show5").hide();
                    $("#t2").show();
                    $('#message-danger2').html(message);
                    setInterval(function(){$("#alert23").hide(); }, 4000);
                    // $( "#dismis4" ).trigger( "click" );
            }
            $("#t2").show();
                    $("#show5").hide();
            }
    })
            return false;
    });
// Ticket Reply
            $('#attachment').change(function() {
                input = document.getElementById('attachment');
                if (!input) {
                    alert("Um, couldn't find the fileinput element.");
                } else if (!input.files) {
                    alert("This browser doesn't seem to support the `files` property of file inputs.");
                } else if (!input.files[0]) {
                } else {
                    $("#file_details").html("");
                    var total_size = 0;
                    for(i = 0; i < input.files.length; i++) {
                        file = input.files[i];
                        var supported_size = "{!! $max_size_in_bytes !!}";
                        var supported_actual_size = "{!! $max_size_in_actual !!}";
                        if(file.size < supported_size) {
                            $("#file_details").append("<tr> <td> " + file.name + " </td><td> " + formatBytes(file.size) + "</td> </tr>");
                        } else {
                            $("#file_details").append("<tr style='color:red;'> <td> " + file.name + " </td><td> " + formatBytes(file.size) + "</td> </tr>");
                        }
                        total_size += parseInt(file.size);
                    }
                    if(total_size > supported_size) {
                        $("#total-size").append("<span style='color:red'>Your total file upload size is greater than "+ supported_actual_size +"</span>");
                        $("#replybtn").addClass('disabled');
                        $("#clear-file").show();
                    } else {
                        $("#total-size").html("");
                        $("#replybtn").removeClass('disabled');
                        $("#clear-file").show();
                    }
                }
            });
            
            function formatBytes(bytes,decimals) {
                if(bytes == 0) return '0 Byte';
                var k = 1000;
                var dm = decimals + 1 || 3;
                var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
                var i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
            }

            $('#form3').on('submit', function() {
            var fd = new FormData(document.getElementById("form3"));
            var reply_content = document.getElementById('reply_content').value;
            if(reply_content) {
                $("#reply_content_class").removeClass('has-error');
                $("#alert23").hide();
            } else {
                var message = "<li>{!! Lang::get('lang.reply_content_is_a_required_field') !!}</li>";
                $("#reply_content_class").addClass('has-error');
                $("#alert23").show();
                $('#message-danger2').html(message);
                $("#show3").hide();
                $("#t1").show();
                $('html, body').animate({
                    scrollTop: $("#inboxactions").offset().top
                }, 500);
                return false;
            }
            var reply_content = document.getElementById('reply_content').value;
            $.ajax({
            type: "POST",
                    url: "../thread/reply/{{ $tickets->id }}",
                    enctype: 'multipart/form-data',
                    dataType: "json",
                    data: fd,
                    processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType
                    beforeSend: function() {
                    $("#t1").hide();
                    $("#show3").show();
                    $('html, body').animate({
                    scrollTop: $("#inboxactions").offset().top
                }, 500);
            },
            success: function(json) {
                $("#show3").hide();
                $("#t1").show();
                setTimeout(function () {
                    location.reload();
                }, 4000);

                $("#alert21").show();
                $('#message-success2').html(json.result.success);
            },

                error: function(json) {
                    $("#show3").hide();
                    $("#t1").show();
                    var res = "";
                    $.each(json.responseJSON, function (idx, topic) {
                    res += "<li>" + topic + "</li>";
                    });
                    $("#reply-response").html("<div class='alert alert-danger'><strong>Whoops!</strong> There were some problems with your input.<br><br><ul>" + res + "</ul></div>");
                    //$('html, body').animate({ scrollTop: $("#heading").offset().top }, 500);
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
            // alert('ticket has been un assigned');
            var message = "{!! Lang::get('lang.you_have_unassigned_your_ticket') !!}";
                    $("#alert10").css('display','block');
                    $('#message-success0').html(message);
                    setInterval(function(){$("#dismiss11").trigger("click"); }, 2000);
                    // $("#refresh1").load( "http://localhost/faveo/public/thread/{{$tickets->id}}   #refresh1");
                    $('#surrender_button').hide();
                    location.reload();
            }
            else
            {
            var message = "{!! Lang::get('lang.for_some_reason_your_request_failed') !!}";
                    $("#alert13").show();
                    $('#message-danger1').html(message);
                    setInterval(function(){$("#dismiss13").trigger("click"); }, 2000);
                    // alert('fail');
                    // $( "#dismis4" ).trigger( "click" );
            }
            $("#dismis6").trigger("click");
            }
    })
            return false;
    });
            $("#search-user").on('submit', function(e) {
    $.ajax({
    type: "POST",
            url: "../search-user",
            dataType: "html",
            data: $(this).serialize(),
            beforeSend: function() {
                $('#here').html("");
                $('#show7').show();
                $('#hide1234').hide();
            },
            success: function(response) {
            $('#show7').hide();
                    $('#hide1234').show();
                    $('#here').html(response);
                    $("#recepients").load("../thread/{{$tickets->id}}   #recepients");
                    $("#surrender22").load("../thread/{{$tickets->id}}   #surrender22");
                    setTimeout(function() {
                    // var link = document.querySelector('#load-inbox');
                    // if(link) {
                    //     link.click();
                    // }
//                    $('#cc-close').trigger('click');
                    }, 500);
            }
    })
            return false;
    });
            $("#add-user").on('submit', function(e) {
    $.ajax({
    type: "POST",
            url: "../add-user",
            dataType: "html",
            data: $(this).serialize(),
            beforeSend: function() {
            $('#here_new').html("");
            $('#show8').show();
            $('#hide12345').hide();
            },
            success: function(response) {
            $('#show8').hide();
                    $('#hide12345').show();
                    $('#here_new').html(response);
                    $("#recepients").load("../thread/{{$tickets->id}}   #recepients");
                    $("#surrender22").load("../thread/{{$tickets->id}}   #surrender22");
                    setTimeout(function() {
                    // var link = document.querySelector('#load-inbox');
                    // if(link) {
                    //     link.click();
                    // }
                    // $('#cc-close').trigger('click');
                    }, 500);
            }
    })
            return false;
    });
            // checking merge
            $('#MergeTickets').on('show.bs.modal', function (id) {
    $.ajax({
    type: "GET",
            url: "../check-merge-ticket/{{ $tickets->id }}",
            dataType: "html",
            data:$(this).serialize(),
            beforeSend: function() {
            $("#merge_body").hide();
                    $("#merge_loader").show();
            },
            success: function(response) {
            if (response == 0) {
            $("#merge_body").show();
                    $("#merge-succ-alert").hide();
                    $("#merge-body-alert").show();
                    $("#merge-body-form").hide();
                    $("#merge_loader").hide();
                    $("#merge-btn").attr('disabled', true);
                    var message = "{{Lang::get('lang.no-tickets-to-merge')}}";
                    $("#merge-err-alert").show();
                    $('#message-merge-err').html(message);
            } else {
            $("#merge_body").show();
                    $("#merge-body-alert").hide();
                    $("#merge-body-form").show();
                    $("#merge_loader").hide();
                    $("#merge-btn").attr('disabled', false);
                    $("#merge_loader").hide();
                    $.ajax({
                    url: "../get-merge-tickets/{{ $tickets->id}}",
                            type: 'GET',
                            data: $(this).serialize(),
                            success: function(data) {

                            $('#select-merge-tickts').html(data);
                            }
                    // return false;
                    });
            }
            }
    });
    });
            //submit merging form
            $('#merge-form').on('submit', function(){
    $.ajax({
    type: "POST",
            url: "../merge-tickets/{{ $tickets->id }}",
            dataType: "html",
            data: $(this).serialize(),
            beforeSend: function() {
            $("#merge_body").hide();
                    $("#merge_loader").show();
            },
            success: function(response) {
            if (response == 0) {
            $("#merge_body").show();
                    $("#merge-succ-alert").hide();
                    $("#merge-body-alert").show();
                    $("#merge-body-form").hide();
                    $("#merge_loader").hide();
                    $("#merge-btn").attr('disabled', true);
                    var message = "{{Lang::get('lang.merge-error')}}";
                    $("#merge-err-alert").show();
                    $('#message-merge-err').html(message);
            } else if (response == 2) {
            $("#merge_body").show();
                    $("#merge-succ-alert").hide();
                    $("#merge-body-alert").show();
                    $("#merge-body-form").hide();
                    $("#merge_loader").hide();
                    $("#merge-btn").attr('disabled', true);
                    var message = "{{Lang::get('lang.merge-error2')}}";
                    $("#merge-err-alert").show();
                    $('#message-merge-err').html(message);
            } else {
            $("#merge_body").show();
                    $("#merge-err-alert").hide();
                    $("#merge-body-alert").show();
                    $("#merge-body-form").hide();
                    $("#merge_loader").hide();
                    $("#merge-btn").attr('disabled', true);
                    $("#hide2").load("../thread/{{$tickets->id}}  #hide2");
                    $("#refresh").load("../thread/{{$tickets->id}}  #refresh");
                    $("#refresh1").load("../thread/{{$tickets->id}}  #refresh1");
                    $("#refresh3").load("../thread/{{$tickets->id}}  #refresh3");
                    $("#refreshTo").load("../thread/{{$tickets->id}}  #refreshTo");
                    $("#more-option").load("../thread/{{$tickets->id}}  #more-option");
                    var message = "{{Lang::get('lang.merge-success')}}";
                    $("#merge-succ-alert").show();
                    $('#message-merge-succ').html(message);
                    location.reload();
            }
            }
    })
            return false;
    });
    });
            function remove_collaborator(id) {
            var data = id;
                    $.ajax({
                    headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content'),
                    },
                            type: "POST",
                            url: "../remove-user",
                            dataType: "html",
                            data: {data1:data},
                            success: function(response) {
                            if (response == 1) {
                            $("#recepients").load("../thread/{{$tickets->id}}   #recepients");
                            };
                                    // $('#here2').html(response);

                                    // $("#surrender22").load("../thread/{{$tickets->id}}   #surrender22");
                            }
                    })
                    return false;
            }

    $(document).ready(function() {

    var Vardata = "";
            var count = 0;
            $(".select2").on('select2:select', function(){
    parentAjaxCall();
    });
            $(".select2").on('select2:unselect', function(){
    parentAjaxCall();
    });
    function parentAjaxCall(){
            // alert();
            var arr = $("#select-merge-tickts").val();
        if (arr == null) {
            document.getElementById("select-merge-parent").innerHTML = "<option value='{{$tickets->id}}'><?php
$ticket_data = App\Model\helpdesk\Ticket\Ticket_Thread::select('title')->where('ticket_id', "=", $tickets->id)->first();
echo $ticket_data->title;
?></option>"
        } else {
            $.ajax({
            type: "GET",
                    url: "../get-parent-tickets/{{ $tickets->id }}",
                    dataType: "html",
                    data:{data1:arr},
                    beforeSend: function() {
                    $("#parent-loader").show();
                            $("#parent-body").hide();
                    },
                    success: function(data) {
                    $("#parent-loader").hide();
                            $("#parent-body").show();
                            // $("#select-merge-parent").focus();
                            $('#select-merge-parent').html(data);
                            // $( this ).off( event );
                    }
            });
        }

    }
        var locktime = '<?php echo $var->collision_avoid; ?>' * 60 * 1000;
        var ltf = '<?php echo $var->lock_ticket_frequency;?>';
        if (locktime > 0 && ltf != 0) {
            lockAjaxCall(locktime);
            if (ltf == 2) {
                var myVar = setInterval(function() {// to call ajax for ticket lock repeatedly after defined lock time interval
                lockAjaxCall(locktime);
                    return false;
                }, locktime);
                $(window).on("blur focus", function(e) {
                    var prevType = $(this).data("prevType");
                    if (prevType != e.type) {   //  reduce double fire issues
                        switch (e.type) {
                        case "blur":
                            // do work
                            setTimeout(function(){
                                clearInterval(myVar);
                                $("#myModalLabel").html("{!! Lang::get('lang.alert') !!}");
                                $("#custom-alert-body").html("{!! Lang::get('lang.ticket-lock-inactive') !!}");
                                $("#myModal").css("display", "block");
                            }, locktime);
                            break;
                        case "focus":
                            break;
                        }
                    }

                    $(this).data("prevType", e.type);
                });
            }
        }
    });
//ajax call to check ticket and lock ticket
            function lockAjaxCall(locktime){
            $.ajax({
            type: "GET",
                    url: "{{URL::route('lock',$tickets->id)}}",
                    dataType: "html",
                    data: $(this).serialize(),
                    success: function(response) {
                    if (response == 2) {
                    // alert(response);
                    // var message = "{{Lang::get('lang.access-ticket')}}"+locktime/(60*1000)
                    // +"{{Lang::get('lang.minutes')}}";
                    $("#alert22").hide();
                            $("#hide2").load("../thread/{{$tickets->id}}  #hide2");
                            $("#refresh").load("../thread/{{$tickets->id}}  #refresh");
                            $("#refresh1").load("../thread/{{$tickets->id}}  #refresh1");
                            $("#refresh3").load("../thread/{{$tickets->id}}  #refresh3");
                            $("#t5").load("../thread/{{$tickets->id}}  #t5");
                            // $("#alert21").show();
                            // $('#message-success2').html(message);
                            $('#replybtn').attr('disabled', false);
                            // setInterval(function(){$("#alert21").hide(); },8000);
                    } else if (response == 1 || response == 4){
                    // alert(response);
                    // var message = "{{Lang::get('lang.access-ticket')}}"+locktime/(60*1000)
                    // +"{{Lang::get('lang.minutes')}}";
                    $("#alert22").hide();
                            $("#refresh").load("../thread/{{$tickets->id}}  #refresh");
                            // $("#refresh1").load("../thread/{{$tickets->id}}  #refresh1");
                            $("#refresh3").load("../thread/{{$tickets->id}}  #refresh3");
                            $("#t5").load("../thread/{{$tickets->id}}  #t5");
                            // $("#alert21").show();
                            // $('#message-success2').html(message);
                            $('#replybtn').attr('disabled', false);
                            // setInterval(function(){$("#alert21").hide(); },8000); 
                    } else {
                    var message = response;
                            $("#alert22").show();
                            $('#message-warning2').html(message);
                            $('#replybtn').attr('disabled', true);
                            //setInterval(function(){$("#alert23").hide(); },10000);
                    }
                    }
            })
            }

    $(function() {

    $('h5').html('<span class="stars">' + parseFloat($('input[name=amount]').val()) + '</span>');
            $('span.stars').stars();
    });
            $.fn.stars = function() {
            return $(this).each(function() {
            $(this).html($('<span />').width(Math.max(0, (Math.min(5, parseFloat($(this).html())))) * 16));
            });
            }

    function addCannedResponse() {
        var selectedResponse = document.getElementById( "select" );
        var response = selectedResponse.options[selectedResponse.selectedIndex ].value;
        if (response == 'zzz') {
           $('#reply_content').summernote('insertText', '');
        } else {
           $('#reply_content').summernote('pasteHTML', response);
        }
    }
</script>
@stop