@extends('themes.default1.agent.layout.agent')

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
<h1>{!! Lang::get('lang.user_profile') !!} </h1>
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')

@stop
<!-- /breadcrumbs -->
<!-- content -->
@section('content')
<!-- success message -->
<div id="alert-success" class="alert alert-success alert-dismissable" style="display:none;">
    <i class="fa fa-check-circle"> </i> <b>  <span id="get-success"></span></b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div>
@if(Session::has('success1'))
<div id="success-alert" class="alert alert-success alert-dismissable">
    <i class="fa  fa-check-circle"> </i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('success1')}}
</div>
@endif
<!-- failure message -->
@if(Session::has('fails1'))
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"> </i> <b> {!! Lang::get('lang.alert') !!} ! </b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('fails1')}}
</div>
@endif
<div class="row">
    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-header">
                <a href="{{route('user.edit', $users->id)}}" data-toggle="tooltip" data-placement="left" class="pull-right" title="{!! Lang::get('lang.edit') !!}"><i class="fa fa-edit"></i></a>
            </div>
            <div class="box-body ">
                <div>
                    <center>
                        <img src="{{ Gravatar::src($users -> email) }}" class="img-circle" alt="User Image" style="border:3px solid #CBCBDA;padding:3px;">	
                        @if($users->first_name || $users->last_name)
                        <h3 class="">{{$users->first_name}} {{$users->last_name}}</h3>
                        @else
                        <h3 class="">{{$users->user_name}}</h3>
                        @endif
                    </center>
                </div>
            </div>
            <div class="box-footer">
                <b>{{Lang::get('lang.email')}}</b>
                <a class="pull-right" href="{{route('user.show', $users->id)}}">
                    {{$users->email }}
                </a>
            </div>
            <div class="box-footer">
                <div id="refresh-org">
                    <?php
                    $user_org = App\Model\helpdesk\Agent_panel\User_org::where('user_id', '=', $users->id)->first();
                    ?>
                    @if($user_org == null)
                    <b>{!! Lang::get('lang.organization') !!}</b>
                    <a href="" class="pull-right"  data-toggle="modal" data-target="#assign"><i class="fa fa-hand-o-right" style="color:orange;"> </i> {!! Lang::get('lang.assign') !!} </a>
                    <a href="" data-toggle="modal" data-target="#create_org" class="pull-right"> {{Lang::get('lang.create')}} <b style="color:#000"> / </b>&nbsp; </a>
                    @else
                    <?php
                    $org_id = $user_org->org_id;
                    $organization = App\Model\helpdesk\Agent_panel\Organization::where('id', '=', $org_id)->first();
                    ?>
                    <b>{!! Lang::get('lang.organization') !!}</b>
                    <a class="pull-right" href="#" data-toggle="modal" data-target="#{{$org_id}}delete" title="{!! Lang::get('lang.remove') !!}"><i class="fa fa-times" style="color:red;"> </i></a> 
                    <a href="{!! URL::route('organizations.show',$organization->id) !!}" class="pull-right">{!! $organization->name !!}&nbsp;/&nbsp;</a>
                    <div class="modal fade" id="{{$org_id}}delete">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Remove user from Organization</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to Remove ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                    {!! link_to_route('removeuser.org','Remove User',[$org_id],['id'=>'delete','class'=>'btn btn-danger btn-sm']) !!}
                                </div>
                            </div> 
                        </div>
                    </div> 
                    @endif

                </div>
            </div>

            <div class="box-footer">
                <b>{{Lang::get('lang.status')}}</b>
                <a class="pull-right">
                    @if($users->active == '1')
                    <span style="color:green;">{!! Lang::get('lang.active') !!}</span>
                    @else
                    <span style="color:red;">{!! Lang::get('lang.inactive') !!}</span>
                    @endif
                </a>
            </div>
            @if($users->phone_number)
            <div class="box-footer">
                <b>{{Lang::get('lang.phone')}}</b>
                <a class="pull-right">{{$users->phone_number}}</a>
            </div>
            @endif
            @if($users->internal_note)
            <div class="box-footer">
                <b>{{Lang::get('lang.internal_notes')}}</b>
                <br/>
                {!! $users->internal_note !!}
            </div>
            @endif
        </div>
    </div>
    <div class="col-md-9">
        {{-- detals table starts --}}
        <?php $user = App\User::where('id', $users->id)->first(); ?>
        <?php
        $open = count(App\Model\helpdesk\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=', '1')->get());
        $counted = count(App\Model\helpdesk\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=', '2')->get());
        $deleted = count(App\Model\helpdesk\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=', '5')->get());
        ?>
        <div class="row">
            <div class="col-md-12">
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab">{!! Lang::get('lang.open_tickets') !!} ({{$open}})</a></li>
                        <li><a href="#tab_2" data-toggle="tab">{!! Lang::get('lang.closed_tickets') !!} ({{$counted}})</a></li>
                        <li><a href="#tab_3" data-toggle="tab">{!! Lang::get('lang.deleted_tickets') !!} ({{$deleted}})</a></li>
                    </ul>
                    <div class="tab-content no-padding">
                        <div class="tab-pane active" id="tab_1">
                            <?php $open = count(App\Model\helpdesk\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=', '1')->get()); ?>
                            @if(Session::has('success'))
                            <div id="success-alert" class="alert alert-success alert-dismissable">
                                <i class="fa  fa-check-circle"> </i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{Session::get('success')}}
                            </div>
                            @endif
                            <!-- failure message -->
                            @if(Session::has('fails'))
                            <div class="alert alert-danger alert-dismissable">
                                <i class="fa fa-ban"> </i> <b> {!! Lang::get('lang.alert') !!} ! </b>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{Session::get('fails')}}
                            </div>
                            @endif
                            <div class="box-body no-padding">
                                {!! Form::open(['route'=>'select_all','method'=>'post']) !!}
                                <div class="mailbox-controls">
                                    <!-- Check all button -->
                                    <a class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></a>
                                    <input type="submit" class="btn btn-default text-orange btn-sm" name="submit" value="{!! Lang::get('lang.delete') !!}">
                                    <input type="submit" class="btn btn-default text-yellow btn-sm" name="submit" value="{!! Lang::get('lang.close') !!}">
                                    <div class="pull-right">
                                        <?php
                                        $counted = count(App\Model\helpdesk\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=', '1')->get());
                                        if ($counted < 20) {
                                            echo $counted . "/" . $counted;
                                        } else {
                                            echo "20/" . $counted;
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="table-responsive" id="refresh">
                                    <p style="display:none;text-align:center; position:fixed; margin-left:40%;margin-top:-70px;" id="show" class="text-red"><b>Loading...</b></p>
                                    <!-- table -->
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                        <th>
                                        </th>
                                        <th>{!! Lang::get('lang.subject') !!}</th>
                                        <th>{!! Lang::get('lang.ticket_id') !!}</th>
                                        <th>{!! Lang::get('lang.priority') !!}</th>
                                        <th>{!! Lang::get('lang.last_replier') !!}</th>
                                        <th>{!! Lang::get('lang.assigned_to') !!}</th>
                                        <th>{!! Lang::get('lang.last_activity') !!}</th>
                                        </thead>
                                        <tbody id="hello">
                                            <?php $tickets = App\Model\helpdesk\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=', '1')->orderBy('id', 'DESC')->paginate(20); ?>
                                            @foreach ($tickets  as $ticket)
                                            <tr <?php if ($ticket->seen_by == null) { ?> style="color:green;" <?php }
                                            ?> >
                                                <td><input type="checkbox" class="icheckbox_flat-blue" name="select_all[]" value="{{$ticket->id}}"/></td>
                                                <?php
                                                //  collaborators
                                                $collaborators = App\Model\helpdesk\Ticket\Ticket_Collaborator::where('ticket_id', '=', $ticket->id)->get();
                                                $collab = count($collaborators);
                                                //  title
                                                $title = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $ticket->id)->first();
                                                $string = strip_tags($title->title);
                                                // check atatchments
                                                $attachments = App\Model\helpdesk\Ticket\Ticket_attachments::where('thread_id', '=', $title->id)->first();
                                                $attach = count($attachments);

                                                if (strlen($string) > 40) {
                                                    $stringCut = substr($string, 0, 40);
                                                    $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . ' ...';
                                                }
                                                $TicketData = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $ticket->id)->max('id');
                                                $TicketDatarow = App\Model\helpdesk\Ticket\Ticket_Thread::where('id', '=', $TicketData)->first();
                                                $LastResponse = App\User::where('id', '=', $TicketDatarow->user_id)->first();
                                                if ($LastResponse->role == "user") {
                                                    $rep = "#F39C12";
                                                    $username = $LastResponse->user_name;
                                                } else {
                                                    $rep = "#000";
                                                    $username = $LastResponse->first_name . " " . $LastResponse->last_name;
                                                    if ($LastResponse->first_name == null || $LastResponse->last_name == null) {
                                                        $username = $LastResponse->user_name;
                                                    }
                                                }
                                                $titles = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $ticket->id)->get();
                                                $count = count($titles);
                                                foreach ($titles as $title) {
                                                    $title = $title;
                                                }
                                                $assigned_to = App\User::where('id', '=', $ticket->assigned_to)->first();
                                                if ($assigned_to == null) {
                                                    $assigned = "Unassigned";
                                                } else {
                                                    $assigned = $assigned_to->first_name . " " . $assigned_to->last_name;
                                                }
                                                ?>
                                                <td class="mailbox-name"><a href="{!! route('ticket.thread',[$ticket->id]) !!}" title="{!! $title->title !!}">{{$string}}   </a> ({!! $count!!}) <i class="fa fa-comment"></i>
                                                    @if($collab > 0)&nbsp;<i class="fa fa-users"></i>@endif 
                                                    @if($attach > 0)&nbsp;<i class="fa fa-paperclip"></i>@endif</td>
                                                <td class="mailbox-Id"><a href="{!! route('ticket.thread',[$ticket->id]) !!}" title="{!! $title->title !!}">#{!! $ticket->ticket_number !!}</a></td>
                                                <?php $priority = App\Model\helpdesk\Ticket\Ticket_Priority::where('priority_id', '=', $ticket->priority_id)->first(); ?>
                                                <td class="mailbox-priority">@if($priority != null)<spam class="btn btn-{{$priority->priority_color}} btn-xs">{{$priority->priority}}</spam>@endif</td>
                                        <?php $from = App\User::where('id', '=', $ticket->user_id)->first(); ?> 
                                        <td class="mailbox-last-reply" style="color:{!! $rep !!}">{!! $username !!}</td>
                                        <td>{!! $assigned !!}</td>
                                        <td class="mailbox-last-activity">{!! UTC::usertimezone($title->updated_at) !!}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table><!-- /.table -->
                                    <div class="pull-right">
                                        <?php echo $tickets->setPath(url('user/' . $users->id))->render(); ?>&nbsp;
                                    </div>
                                </div><!-- /.mail-box-messages -->
                                {!! Form::close() !!}

                                {{-- end deleted tickets --}}
                            </div>
                        </div><!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2">
                            {{-- open tab --}}
                            <?php $closed = count(App\Model\helpdesk\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', 2)->get()); ?>
                            @if(Session::has('success'))
                            <div id="success-alert" class="alert alert-success alert-dismissable">
                                <i class="fa  fa-check-circle"> </i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{Session::get('success')}}
                            </div>
                            @endif
                            <!-- failure message -->
                            @if(Session::has('fails'))
                            <div class="alert alert-danger alert-dismissable">
                                <i class="fa fa-ban"> </i> <b> {!! lang::get('lang.alert') !!} ! </b>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{Session::get('fails')}}
                            </div>
                            @endif
                            <div class="box-body no-padding">
                                {!! Form::open(['route'=>'select_all','method'=>'post']) !!}
                                <div class="mailbox-controls">
                                    <!-- Check all button -->
                                    <a class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></a>
                                    <input type="submit" class="btn btn-default text-orange btn-sm" name="submit" value="{!! Lang::get('lang.delete') !!}">
                                    <input type="submit" class="btn btn-default text-yellow btn-sm" name="submit" value="{!! Lang::get('lang.close') !!}">
                                    <div class="pull-right">
                                        <?php
                                        $counted = count(App\Model\helpdesk\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=', '2')->get());
                                        if ($counted < 20) {
                                            echo $counted . "/" . $counted;
                                        } else {
                                            echo "20/" . $counted;
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class=" table-responsive" id="refresh">
                                    <p style="display:none;text-align:center; position:fixed; margin-left:40%;margin-top:-70px;" id="show" class="text-red"><b>Loading...</b></p>
                                    <!-- table -->
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                        <th>
                                        </th>
                                        <th>{!! Lang::get('lang.subject') !!}</th>
                                        <th>{!! Lang::get('lang.ticket_id') !!}</th>
                                        <th>{!! Lang::get('lang.priority') !!}</th>
                                        <th>{!! Lang::get('lang.last_replier') !!}</th>
                                        <th>{!! Lang::get('lang.assigned_to') !!}</th>
                                        <th>{!! Lang::get('lang.last_activity') !!}</th>
                                        </thead>
                                        <tbody id="hello">
                                            <?php $tickets = App\Model\helpdesk\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=', '2')->orderBy('id', 'DESC')->paginate(20); ?>
                                            @foreach ($tickets  as $ticket)
                                            <tr <?php if ($ticket->seen_by == null) { ?> style="color:green;" <?php } ?> >
                                                <td ><input type="checkbox" class="icheckbox_flat-blue" name="select_all[]" value="{{$ticket->id}}"/></td>
                                                <?php
                                                //  collaborators
                                                $collaborators = App\Model\helpdesk\Ticket\Ticket_Collaborator::where('ticket_id', '=', $ticket->id)->get();
                                                $collab = count($collaborators);
                                                //  title
                                                $title = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $ticket->id)->first();
                                                $string = strip_tags($title->title);
                                                // check atatchments
                                                $attachments = App\Model\helpdesk\Ticket\Ticket_attachments::where('thread_id', '=', $title->id)->first();
                                                $attach = count($attachments);

                                                if (strlen($string) > 40) {
                                                    $stringCut = substr($string, 0, 40);
                                                    $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . ' ...';
                                                }
                                                $TicketData = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $ticket->id)->max('id');
                                                $TicketDatarow = App\Model\helpdesk\Ticket\Ticket_Thread::where('id', '=', $TicketData)->first();
                                                $LastResponse = App\User::where('id', '=', $TicketDatarow->user_id)->first();
                                                if ($LastResponse->role == "user") {
                                                    $rep = "#F39C12";
                                                    $username = $LastResponse->user_name;
                                                } else {
                                                    $rep = "#000";
                                                    $username = $LastResponse->first_name . " " . $LastResponse->last_name;
                                                    if ($LastResponse->first_name == null || $LastResponse->last_name == null) {
                                                        $username = $LastResponse->user_name;
                                                    }
                                                }
                                                $titles = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $ticket->id)->get();
                                                $count = count($titles);
                                                foreach ($titles as $title) {
                                                    $title = $title;
                                                }
                                                $assigned_to = App\User::where('id', '=', $ticket->assigned_to)->first();
                                                if ($assigned_to == null) {
                                                    $assigned = "Unassigned";
                                                } else {
                                                    $assigned = $assigned_to->first_name . " " . $assigned_to->last_name;
                                                }
                                                ?>
                                                <td class="mailbox-name"><a href="{!! route('ticket.thread',[$ticket->id]) !!}" title="{!! $title->title !!}">{{$string}}   </a> ({!! $count!!}) <i class="fa fa-comment"></i>
                                                    @if($collab > 0)&nbsp;<i class="fa fa-users"></i>@endif 
                                                    @if($attach > 0)&nbsp;<i class="fa fa-paperclip"></i>@endif</td>
                                                <td class="mailbox-Id"><a href="{!! route('ticket.thread',[$ticket->id]) !!}" title="{!! $title->title !!}">#{!! $ticket->ticket_number !!}</a></td>
                                                <?php $priority = App\Model\helpdesk\Ticket\Ticket_Priority::where('priority_id', '=', $ticket->priority_id)->first(); ?>
                                                <td class="mailbox-priority">@if($priority != null)<spam class="btn btn-{{$priority->priority_color}} btn-xs">{{$priority->priority}}</spam>@endif</td>
                                        <?php $from = App\User::where('id', '=', $ticket->user_id)->first(); ?> 
                                        <td class="mailbox-last-reply" style="color:{!! $rep !!}">{!! $username !!}</td>
                                        <td>{!! $assigned !!}</td>
                                        <td class="mailbox-last-activity">{!! UTC::usertimezone($title->updated_at) !!}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table><!-- /.table -->

                                    <div class="pull-right">
                                        <?php echo $tickets->setPath(url('user/' . $users->id))->render(); ?>&nbsp;
                                    </div>
                                </div><!-- /.mail-box-messages -->
                                {!! Form::close() !!}

                                {{-- end deleted tickets --}}
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_3">
                            {{-- open tab --}}
                            <?php $deleted = count(App\Model\helpdesk\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=', '5')->get()); ?>

                            @if(Session::has('success'))
                            <div id="success-alert" class="alert alert-success alert-dismissable">
                                <i class="fa  fa-check-circle"> </i>
                                <button type="button" id="close-alert" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{Session::get('success')}}
                            </div>
                            @endif
                            <!-- failure message -->
                            @if(Session::has('fails'))
                            <div class="alert alert-danger alert-dismissable">
                                <i class="fa fa-ban"> </i> <b> {!! lang::get('lang.alert') !!} ! </b>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{Session::get('fails')}}
                            </div>
                            @endif
                            <div class="box-body no-padding ">

                                {!! Form::open(['route'=>'select_all','method'=>'post']) !!}
                                <div class="mailbox-controls">
                                    <!-- Check all button -->
                                    <a class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></a>
                                    <input type="submit" class="btn btn-default text-orange btn-sm" name="submit" value="{!! Lang::get('lang.delete') !!}">
                                    <input type="submit" class="btn btn-default text-yellow btn-sm" name="submit" value="{!! Lang::get('lang.close') !!}">
                                    <div class="pull-right">
                                        <?php
                                        $counted = count(App\Model\helpdesk\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=', '5')->get());
                                        if ($counted < 20) {
                                            echo $counted . "/" . $counted;
                                        } else {
                                            echo "20/" . $counted;
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class=" table-responsive" id="refresh">
                                    <p style="display:none;text-align:center; position:fixed; margin-left:40%;margin-top:-70px;" id="show" class="text-red"><b>Loading...</b></p>
                                    <!-- table -->
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                        <th>
                                        </th>
                                        <th>{!! Lang::get('lang.subject') !!}</th>
                                        <th>{!! Lang::get('lang.ticket_id') !!}</th>
                                        <th>{!! Lang::get('lang.priority') !!}</th>
                                        <th>{!! Lang::get('lang.last_replier') !!}</th>
                                        <th>{!! Lang::get('lang.assigned_to') !!}</th>
                                        <th>{!! Lang::get('lang.last_activity') !!}</th>
                                        </thead>
                                        <tbody id="hello">
                                            <?php $tickets = App\Model\helpdesk\Ticket\Tickets::where('user_id', '=', $users->id)->where('status', '=', '5')->orderBy('id', 'DESC')->paginate(20); ?>
                                            @foreach ($tickets  as $ticket)
                                            <tr <?php if ($ticket->seen_by == null) { ?> style="color:green;" <?php }
                                            ?> >
                                                <td ><input type="checkbox" class="icheckbox_flat-blue" name="select_all[]" value="{{$ticket->id}}"/></td>
                                                <?php
                                                //  collaborators
                                                $collaborators = App\Model\helpdesk\Ticket\Ticket_Collaborator::where('ticket_id', '=', $ticket->id)->get();
                                                $collab = count($collaborators);
                                                //  title
                                                $title = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $ticket->id)->first();
                                                $string = strip_tags($title->title);
                                                // check atatchments
                                                $attachments = App\Model\helpdesk\Ticket\Ticket_attachments::where('thread_id', '=', $title->id)->first();
                                                $attach = count($attachments);

                                                if (strlen($string) > 40) {
                                                    $stringCut = substr($string, 0, 40);
                                                    $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . ' ...';
                                                }
                                                $TicketData = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $ticket->id)->max('id');
                                                $TicketDatarow = App\Model\helpdesk\Ticket\Ticket_Thread::where('id', '=', $TicketData)->first();
                                                $LastResponse = App\User::where('id', '=', $TicketDatarow->user_id)->first();
                                                if ($LastResponse->role == "user") {
                                                    $rep = "#F39C12";
                                                    $username = $LastResponse->user_name;
                                                } else {
                                                    $rep = "#000";
                                                    $username = $LastResponse->first_name . " " . $LastResponse->last_name;
                                                    if ($LastResponse->first_name == null || $LastResponse->last_name == null) {
                                                        $username = $LastResponse->user_name;
                                                    }
                                                }
                                                $titles = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $ticket->id)->get();
                                                $count = count($titles);
                                                foreach ($titles as $title) {
                                                    $title = $title;
                                                }
                                                $assigned_to = App\User::where('id', '=', $ticket->assigned_to)->first();
                                                if ($assigned_to == null) {
                                                    $assigned = "Unassigned";
                                                } else {
                                                    $assigned = $assigned_to->first_name . " " . $assigned_to->last_name;
                                                }
                                                ?>
                                                <td class="mailbox-name"><a href="{!! route('ticket.thread',[$ticket->id]) !!}" title="{!! $title->title !!}">{{$string}}   </a> ({!! $count!!}) <i class="fa fa-comment"></i>
                                                    @if($collab > 0)&nbsp;<i class="fa fa-users"></i>@endif 
                                                    @if($attach > 0)&nbsp;<i class="fa fa-paperclip"></i>@endif</td>
                                                <td class="mailbox-Id"><a href="{!! route('ticket.thread',[$ticket->id]) !!}" title="{!! $title->title !!}">#{!! $ticket->ticket_number !!}</a></td>
                                                <?php $priority = App\Model\helpdesk\Ticket\Ticket_Priority::where('priority_id', '=', $ticket->priority_id)->first(); ?>
                                                <td class="mailbox-priority">@if($priority != null)<spam class="btn btn-{{$priority->priority_color}} btn-xs">{{$priority->priority}}</spam>@endif</td>
                                        <?php $from = App\User::where('id', '=', $ticket->user_id)->first(); ?> 
                                        <td class="mailbox-last-reply" style="color:{!! $rep !!}">{!! $username !!}</td>
                                        <td>{!! $assigned !!}</td>
                                        <td class="mailbox-last-activity">{!! UTC::usertimezone($title->updated_at) !!}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table><!-- /.table -->

                                    <div class="pull-right">
                                        <?php echo $tickets->setPath(url('/ticket/open'))->render(); ?>&nbsp;
                                    </div>
                                </div><!-- /.mail-box-messages -->
                                {!! Form::close() !!}
                            </div><!-- /.tab-pane -->
                        </div><!-- /.tab-content -->
                    </div><!-- nav-tabs-custom -->
                </div><!-- /.col -->          
            </div> <!-- /.row -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <link type="text/css" href="{{asset("lb-faveo/css/bootstrap-datetimepicker4.7.14.min.css")}}" rel="stylesheet">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">{!! Lang::get('lang.user_report') !!}</h3>
                    </div>
                    <div class="box-body">
                        <form id="foo">
                            <div  class="form-group">
                                <div class="row">
                                    <div class='col-sm-3'>
                                        {!! Form::label('date', Lang::get("lang.start_date").':') !!}
                                        {!! Form::text('start_date',null,['class'=>'form-control','id'=>'datepicker4'])!!}
                                    </div>
                                    <?php
                                    $start_date = App\Model\helpdesk\Ticket\Tickets::where('id', '=', '1')->first();
                                    if ($start_date != null) {
                                        $created_date = $start_date->created_at;
                                        $created_date = explode(' ', $created_date);
                                        $created_date = $created_date[0];
                                        $start_date = date("m/d/Y", strtotime($created_date . ' -1 months'));
                                    } else {
                                        $start_date = date("m/d/Y", strtotime(date("m/d/Y") . ' -1 months'));
                                    }
                                    ?>
                                    <script type="text/javascript">
                                        $(function() {
                                            var timestring1 = "{!! $start_date !!}";
                                            var timestring2 = "{!! date('m/d/Y') !!}";
                                            $('#datepicker4').datetimepicker({
                                                format: 'DD/MM/YYYY',
                                                minDate: moment(timestring1).startOf('day'),
                                                maxDate: moment(timestring2).startOf('day')
                                            });
                                            //                $('#datepicker').datepicker()
                                        });
                                    </script>
                                    <div class='col-sm-3'>
                                        {!! Form::label('start_time', Lang::get("lang.end_date").':') !!}
                                        {!! Form::text('end_date',null,['class'=>'form-control','id'=>'datetimepicker3'])!!}
                                    </div>
                                    <script type="text/javascript">
                                        $(function() {
                                            var timestring1 = "{!! $start_date !!}";
                                            var timestring2 = "{!! date('m/d/Y') !!}";
                                            $('#datetimepicker3').datetimepicker({
                                                format: 'DD/MM/YYYY',
                                                minDate: moment(timestring1).startOf('day'),
                                                maxDate: moment(timestring2).startOf('day')
                                            });
                                        });
                                    </script>
                                    <div class='col-sm-3'>
                                        {!! Form::label('filter', Lang::get("lang.filter").':') !!}<br>
                                        <input type="submit" value="{!! Lang::get('lang.submit') !!}" class="btn btn-primary">
                                    </div>
                                    <div class="col-sm-10">
                                        <label class="lead">{!! Lang::get('lang.Legend') !!}:</label>
                                        <div class="row">
                                            <style>
                                                #legend-holder { border: 1px solid #ccc; float: left; width: 25px; height: 25px; margin: 1px; }
                                            </style>
                                            <div class="col-md-4"><span id="legend-holder" style="background-color: #6C96DF;"></span>&nbsp; <span class="lead"> <span id="total-created-tickets" ></span> {!! Lang::get('lang.tickets') !!} {!! Lang::get('lang.created') !!} </span></div> 
                                            <div class="col-md-4"><span id="legend-holder" style="background-color: #6DC5B2;"></span>&nbsp; <span class="lead"> <span id="total-reopen-tickets" class="lead"></span> {!! Lang::get('lang.tickets') !!} {!! Lang::get('lang.reopen') !!}  </span></div> 
                                            <div class="col-md-4"><span id="legend-holder" style="background-color: #E3B870;"></span>&nbsp; <span class="lead"> <span id="total-closed-tickets" class="lead"></span> {!! Lang::get('lang.tickets') !!} {!! Lang::get('lang.closed') !!}  </span></div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div id="legendDiv"></div>
                        <div class="chart">
                            <canvas class="chart-data" id="tickets-graph" width="1000" height="250"></canvas>   
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </div>
    <!-- END CUSTOM TABS -->
    {{-- MODAL POPUPS --}}
    <div class="modal fade" id="create_org">
        <div class="modal-dialog" style="width:84%;height:70%;">
            <div class="modal-content">
                {!! Form::model($users->id, ['id'=>'form','method' => 'PATCH'] )!!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidd en="true">&times;</span></button>
                    <h4 class="modal-title">{!! Lang::get('lang.create_organization') !!}</h4>
                </div>
                <div class="modal-body">
                    <!-- failure message -->						        
                    <div class="alert alert-danger alert-dismissable" id="alert-danger" style="display:none;"> 
                        <i class="fa fa-ban"> </i> <b> {!! Lang::get('lang.alert') !!} ! <span id="get-danger"></span> </b>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    </div>						        
                    <div class="row" id="hide">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{!! Lang::get('lang.name') !!}</label>
                               	<input type="text" name="name" class="form-control">
                                <spam id="error-name" style="display:none;position:fixed" class="call-out text-red">This is a required field</spam>
                                <spam id="error-name1" style="display:none;position:fixed" class="call-out text-red">! Allready Taken</spam>
                                <br/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{!! Lang::get('lang.phone') !!}</label>
                                <input type="number" name="phone" class="form-control">
                                <br/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{!! Lang::get('lang.website') !!}</label>
                                <input type="url" name="website" placeholder="https://www.example.com" class="form-control">
                                <spam id="error-website" style="display:none" class="help-block text-red">! Allready Taken</spam>
                                <br/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{!! Lang::get('lang.address') !!}</label>
                                <textarea name="address" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{!! Lang::get('lang.internal_notes') !!}</label>
                                <textarea name="internal" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div id="show2" style="display:none;">
                        <div class="row row-md-12">
                            <div class="col-xs-5">
                            </div>
                            <div class="col-xs-2">
                                <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}">
                            </div>
                            <div class="col-xs-5">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis">{!! Lang::get('lang.close') !!}</button>
                    <input type="submit" class="btn btn-primary pull-right" value="{!! Lang::get('lang.update') !!}">
                </div>
                {!! Form::close() !!}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            // create org
            $('#form').on('submit', function() {
                $.ajax({
                    type: "POST",
                    url: "../user-org/{{$users->id}}",
                    dataType: "html",
                    data: $(this).serialize(),
                    beforeSend: function() {
                        $("#hide").hide();
                        $("#show2").show();
                    },
                    success: function(response) {
                        $("#show2").hide();
                        $("#hide").show();
                        if (response == 0) {
                            message = "Organization added successfully."
                            $("#dismis").trigger("click");
                            $("#refresh-org").load("../user/{{ $users->id }}  #refresh-org");
                            // $("#refresh2").load("../thread/{{$users->id}}   #refresh2");
                            // $("#show").show();
                            $("#alert-success").show();
                            $('#get-success').html(message);
                            setInterval(function() {
                                $("#alert-success").hide();
                            }, 4000);
                        } else {
                            message = response;
                            $("#alert-danger").show();
                            $('#get-danger').html(message);
                        }
                    }
                })
                return false;
            });
        });
    </script>
    <!-- Organisation Assign Modal -->
    <div class="modal fade" id="assign">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::model($users->id, ['id'=>'org_assign','method' => 'PATCH'] )!!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" id="dismiss" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{!! Lang::get('lang.assign') !!}</h4>
                </div>
                <div id="assign_alert" class="alert alert-success alert-dismissable" style="display:none;">
                    <button id="assign_dismiss" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i>Alert!</h4>
                    <div id="message-success1"></div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-6" id="assign_loader" style="display:none;">
                            <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}"><br/><br/><br/>
                        </div>
                    </div>
                    <div id="assign_body">
                        <p>{!! Lang::get('lang.please_select_an_organization') !!}</p>
                        <select id="org" class="form-control" name="org">
                            <?php
                            $orgs = App\Model\helpdesk\Agent_panel\Organization::all();
                            ?>
                            <optgroup label="Select Organizations">
                                @foreach($orgs as $org)
                                <option  value="{{$org->id}}">{!! $org->name !!}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis4">{!! Lang::get('lang.close') !!}</button>
                    <button type="submit" class="btn btn-success pull-right" id="submt2">{!! Lang::get('lang.assign') !!}</button>
                </div>
                {!! Form::close()!!}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script type="text/javascript">
        // Assign a ticket
        jQuery(document).ready(function($) {
            // create org
            $('#org_assign').on('submit', function() {
                $.ajax({
                    type: "POST",
                    url: "../user-org-assign/{{$users->id}}",
                    dataType: "html",
                    data: $(this).serialize(),
                    beforeSend: function() {
                        $("#hide").hide();
                        $("#show2").show();
                    },
                    success: function(response) {
                        $("#show2").hide();
                        $("#hide").show();

                        if (response == 1) {
                            message = "Organization added successfully."
                            $("#dismiss").trigger("click");
                            $("#refresh-org").load("../user/{{ $users->id }}  #refresh-org");
                            // $("#refresh2").load("../thread/{{$users->id}}   #refresh2");
                            // $("#show").show();
                            $("#alert-success").show();
                            $('#get-success').html(message);
                            setInterval(function() {
                                $("#alert-success").hide();
                            }, 4000);
                        }
                    }
                })
                return false;
            });
        });

        $(function() {
            //Enable check and uncheck all functionality
            $(".checkbox-toggle").click(function() {
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



        $(function() {
            $("textarea").wysihtml5();
        });
    </script>
    <div id="refresh"> 
        <script src="{{asset("lb-faveo/plugins/chartjs/Chart.min.js")}}" type="text/javascript"></script>
    </div>
    <script src="{{asset("lb-faveo/plugins/chartjs/Chart.min.js")}}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $.getJSON("../user-agen/<?php echo $users->id; ?>", function(result) {
                var labels = [], open = [], closed = [], reopened = [], open_total = 0, closed_total = 0, reopened_total = 0;
                for (var i = 0; i < result.length; i++) {
                    labels.push(result[i].date);
                    open.push(result[i].open);
                    closed.push(result[i].closed);
                    reopened.push(result[i].reopened);

                    open_total += parseInt(result[i].open);
                    closed_total += parseInt(result[i].closed);
                    reopened_total += parseInt(result[i].reopened);
                }
                var buyerData = {
                    labels: labels,
                    datasets: [
                        {
                            label: "Open Tickets",
                            fillColor: "rgba(93, 189, 255, 0.05)",
                            strokeColor: "rgba(2, 69, 195, 0.9)",
                            pointColor: "rgba(2, 69, 195, 0.9)",
                            pointStrokeColor: "#c1c7d1",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(220,220,220,1)",
                            data: open
                        }
                        , {
                            label: "Closed Tickets",
                            fillColor: "rgba(255, 206, 96, 0.08)",
                            strokeColor: "rgba(221, 129, 0, 0.94)",
                            pointColor: "rgba(221, 129, 0, 0.94)",
                            pointStrokeColor: "rgba(60,141,188,1)",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(60,141,188,1)",
                            data: closed

                        }
                        , {
                            label: "Reopened Tickets",
                            fillColor: "rgba(104, 255, 220, 0.06)",
                            strokeColor: "rgba(0, 149, 115, 0.94)",
                            pointColor: "rgba(0, 149, 115, 0.94)",
                            pointStrokeColor: "rgba(60,141,188,1)",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(60,141,188,1)",
                            data: reopened
                        }
                    ]
                };
                $("#total-created-tickets").html(open_total);
                $("#total-reopen-tickets").html(reopened_total);
                $("#total-closed-tickets").html(closed_total);
                var myLineChart = new Chart(document.getElementById("tickets-graph").getContext("2d")).Line(buyerData, {
                    showScale: true,
                    //Boolean - Whether grid lines are shown across the chart
                    scaleShowGridLines: true,
                    //String - Colour of the grid lines
                    scaleGridLineColor: "rgba(0,0,0,.05)",
                    //Number - Width of the grid lines
                    scaleGridLineWidth: 1,
                    //Boolean - Whether to show horizontal lines (except X axis)
                    scaleShowHorizontalLines: true,
                    //Boolean - Whether to show vertical lines (except Y axis)
                    scaleShowVerticalLines: true,
                    //Boolean - Whether the line is curved between points
                    bezierCurve: true,
                    //Number - Tension of the bezier curve between points
                    bezierCurveTension: 0.3,
                    //Boolean - Whether to show a dot for each point
                    pointDot: true,
                    //Number - Radius of each point dot in pixels
                    pointDotRadius: 1,
                    //Number - Pixel width of point dot stroke
                    pointDotStrokeWidth: 1,
                    //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                    pointHitDetectionRadius: 10,
                    //Boolean - Whether to show a stroke for datasets
                    datasetStroke: true,
                    //Number - Pixel width of dataset stroke
                    datasetStrokeWidth: 1,
                    //Boolean - Whether to fill the dataset with a color
                    datasetFill: true,
                    //String - A legend template
                    //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                    maintainAspectRatio: true,
                    //Boolean - whether to make the chart responsive to window resizing
                    responsive: true,
                });

            });
            $('#click me').click(function() {
                $('#foo').submit();
            });
            $('#foo').submit(function(event) {
                // get the form data
                // there are many ways to get this data using jQuery (you can use the class or id also)
                var date1 = $('#datepicker4').val();
                var date2 = $('#datetimepicker3').val();
                var formData = date1.split("/").join('-');
                var dateData = date2.split("/").join('-');
                // process the form
                $.ajax({
                    type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                    url: '../user-chart-range/<?php echo $users->id; ?>/' + dateData + '/' + formData, // the url where we want to POST
                    data: formData, // our data object
                    dataType: 'json', // what type of data do we expect back from the server

                    success: function(result2) {

                        var labels = [], open = [], closed = [], reopened = [], open_total = 0, closed_total = 0, reopened_total = 0;

                        for (var i = 0; i < result2.length; i++) {

                            labels.push(result2[i].date);
                            open.push(result2[i].open);
                            closed.push(result2[i].closed);
                            reopened.push(result2[i].reopened);

                            open_total += parseInt(result2[i].open);
                            closed_total += parseInt(result2[i].closed);
                            reopened_total += parseInt(result2[i].reopened);
                        }
                        var buyerData = {
                            labels: labels,
                            datasets: [
                                {
                                    label: "Open Tickets",
                                    fillColor: "rgba(93, 189, 255, 0.05)",
                                    strokeColor: "rgba(2, 69, 195, 0.9)",
                                    pointColor: "rgba(2, 69, 195, 0.9)",
                                    pointStrokeColor: "#c1c7d1",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(220,220,220,1)",
                                    data: open
                                }
                                , {
                                    label: "Closed Tickets",
                                    fillColor: "rgba(255, 206, 96, 0.08)",
                                    strokeColor: "rgba(221, 129, 0, 0.94)",
                                    pointColor: "rgba(221, 129, 0, 0.94)",
                                    pointStrokeColor: "rgba(60,141,188,1)",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(60,141,188,1)",
                                    data: closed

                                }
                                , {
                                    label: "Reopened Tickets",
                                    fillColor: "rgba(104, 255, 220, 0.06)",
                                    strokeColor: "rgba(0, 149, 115, 0.94)",
                                    pointColor: "rgba(0, 149, 115, 0.94)",
                                    pointStrokeColor: "rgba(60,141,188,1)",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(60,141,188,1)",
                                    data: reopened
                                }
                            ]
                        };
                        $("#total-created-tickets").html(open_total);
                        $("#total-reopen-tickets").html(reopened_total);
                        $("#total-closed-tickets").html(closed_total);
                        var myLineChart = new Chart(document.getElementById("tickets-graph").getContext("2d")).Line(buyerData, {
                            showScale: true,
                            //Boolean - Whether grid lines are shown across the chart
                            scaleShowGridLines: true,
                            //String - Colour of the grid lines
                            scaleGridLineColor: "rgba(0,0,0,.05)",
                            //Number - Width of the grid lines
                            scaleGridLineWidth: 1,
                            //Boolean - Whether to show horizontal lines (except X axis)
                            scaleShowHorizontalLines: true,
                            //Boolean - Whether to show vertical lines (except Y axis)
                            scaleShowVerticalLines: true,
                            //Boolean - Whether the line is curved between points
                            bezierCurve: true,
                            //Number - Tension of the bezier curve between points
                            bezierCurveTension: 0.3,
                            //Boolean - Whether to show a dot for each point
                            pointDot: true,
                            //Number - Radius of each point dot in pixels
                            pointDotRadius: 1,
                            //Number - Pixel width of point dot stroke
                            pointDotStrokeWidth: 1,
                            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                            pointHitDetectionRadius: 10,
                            //Boolean - Whether to show a stroke for datasets
                            datasetStroke: true,
                            //Number - Pixel width of dataset stroke
                            datasetStrokeWidth: 1,
                            //Boolean - Whether to fill the dataset with a color
                            datasetFill: true,
                            //String - A legend template
                            //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                            maintainAspectRatio: true,
                            //Boolean - whether to make the chart responsive to window resizing
                            responsive: true,
                        });
                        myLineChart.options.responsive = false;
                        $("#tickets-graph").remove();
                        $(".chart").html("<canvas id='tickets-graph' width='1000' height='250'></canvas>");
                        var myLineChart1 = new Chart(document.getElementById("tickets-graph").getContext("2d")).Line(buyerData, {
                            showScale: true,
                            //Boolean - Whether grid lines are shown across the chart
                            scaleShowGridLines: true,
                            //String - Colour of the grid lines
                            scaleGridLineColor: "rgba(0,0,0,.05)",
                            //Number - Width of the grid lines
                            scaleGridLineWidth: 1,
                            //Boolean - Whether to show horizontal lines (except X axis)
                            scaleShowHorizontalLines: true,
                            //Boolean - Whether to show vertical lines (except Y axis)
                            scaleShowVerticalLines: true,
                            //Boolean - Whether the line is curved between points
                            bezierCurve: true,
                            //Number - Tension of the bezier curve between points
                            bezierCurveTension: 0.3,
                            //Boolean - Whether to show a dot for each point
                            pointDot: true,
                            //Number - Radius of each point dot in pixels
                            pointDotRadius: 1,
                            //Number - Pixel width of point dot stroke
                            pointDotStrokeWidth: 1,
                            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                            pointHitDetectionRadius: 10,
                            //Boolean - Whether to show a stroke for datasets
                            datasetStroke: true,
                            //Number - Pixel width of dataset stroke
                            datasetStrokeWidth: 1,
                            //Boolean - Whether to fill the dataset with a color
                            datasetFill: true,
                            //String - A legend template
                            //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                            maintainAspectRatio: true,
                            //Boolean - whether to make the chart responsive to window resizing
                            responsive: true,
                        });


                    }
                });
                // using the done promise callback
                // stop the form from submitting the normal way and refreshing the page
                event.preventDefault();
            });
        });

        jQuery(document).ready(function() {
            // Close a ticket
            $('#close').on('click', function(e) {
                $.ajax({
                    type: "GET",
                    url: "agen",
                    beforeSend: function() {
                    },
                    success: function(response) {
                    }
                })
                return false;
            });
        });
    </script>
    <script src="{{asset("lb-faveo/plugins/moment-develop/moment.js")}}" type="text/javascript"></script>
    <script src="{{asset("lb-faveo/js/bootstrap-datetimepicker4.7.14.min.js")}}" type="text/javascript"></script>
    @stop
    <!-- /content -->