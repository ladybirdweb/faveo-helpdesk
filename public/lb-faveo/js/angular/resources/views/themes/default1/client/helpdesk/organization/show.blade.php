@extends('themes.default1.client.layout.orgclient')

@section('HeadInclude')
<link href="{{asset("lb-faveo/css/AdminLTE.css")}}" rel="stylesheet" type="text/css" />
@stop

@section('profile')
class="active"
@stop

@section('content')

       

<div class="row">


    <?php $org_hd = App\Model\helpdesk\Agent_panel\Organization::where('id', '=', $orgs->id)->first(); ?>
    <div id="alert-success" class="alert alert-success alert-dismissable" style="display:none;">
        <i class="fa  fa-check-circle"> </i> <b> Success <span id="get-success"></span></b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    </div>
    <div class="col-md-4">
        <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua">
                <!--<div class="box-header">-->
                <!-- <a style="color:#fff" href="{{route('organizations.edit', $orgs->id)}}" data-toggle="tooltip" data-placement="left" class="pull-right" title="Edit"><i class="fa fa-edit"></i></a> -->
                <!--</div>-->
                 <!--  -->
                <h3 class="widget-user-username" title="{{$orgs->name}}">{{str_limit($orgs->name, 10)}}</h3>
                <h5 class="widget-user-desc" title="{{$orgs->website}}">{{str_limit($orgs->name, 15)}}</h5>
            </div>
            <div class="box-footer no-padding">
                <ul class="nav nav-stacked">
                    @if($orgs->phone)<li><a>
                            <b>{!! Lang::get('lang.phone') !!}</b>  
                            <span class="pull-right" title="{{$orgs->phone}}">{{str_limit($orgs->phone, 13)}}</span></a></li>@endif
                    @if($orgs->address)<li><a>
                            <b>{!! Lang::get('lang.address') !!}</b>  
                            <br/><span style="word-wrap: break-word;"><?php  echo ($orgs->address);?></span></a></li>@endif
                    @if($orgs->internal_notes)<li><a>
                            <b>{!! Lang::get('lang.internal_notes') !!}</b>  
                           <br/> <span  style="word-wrap: break-word;"><?php  echo ($orgs->internal_notes);?></span></a></li>@endif
                </ul>
                
                  @if(Auth::user()->role == 'admin')
                <div class='myDiv'>

                <button data-toggle="modal" data-target="#assign_head" id="button_select" class="btn btn-primary">{!! Lang::get('lang.select_organization_manager') !!}</button>
                 @if($userss!=0)
                 <button data-toggle="modal" data-target="#assign_head1" id="button_select1" class="btn btn-danger">{!! Lang::get('lang.edit_organization_manager') !!}</button>
                 @endif
            </div>
             @endif
            </div>
        </div>
        <br/>
       <div id="refresh1"> 

            @if($userss!=0)  

            @foreach($userss as $users)

            <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-yellow">
                  
                    <input type="hidden" name="user_id" id="user_id" value="{{$users->id}}">
                    <div class="widget-user-image">
                        <img class="img-circle"  src="{{ Gravatar::src( $users->email) }}" alt="User Avatar">
                    </div><!-- /.widget-user-image -->
                    <h3 class="widget-user-username">{!! $users->user_name !!}</h3>
                    <h5 class="widget-user-desc">{!! Lang::get('lang.organization-s_head') !!}</h5>
                </div>
                <div class="box-footer no-padding">
                    <ul class="nav nav-stacked">
                        <li><a href="#">{!! Lang::get('lang.e-mail') !!} <span class="pull-right">{!! $users->email !!}</span></a></li>
                        <li><a href="#">{!! Lang::get('lang.phone') !!} <span class="pull-right">{!! $users->phone_number !!}</span></a></li>
                    </ul>
                </div>
            </div>


            @endforeach
            @endif
            
    </div>
    </div>
    <div class="col-md-8">
        <div class="box box-primary">
            <?php
            $user_orgs = App\Model\helpdesk\Agent_panel\User_org::where('org_id', '=', $orgs->id)->paginate(20);
            ?>



            <div class="box-header with-border">
                <h3 class="box-title">{!! Lang::get('lang.users_of') !!} {{$orgs->name}}</h3>
                <div class="pull-right" style="margin-top:-25px;margin-bottom:-25px;">
                    <?php echo $user_orgs->setPath(route('organizations.show', $orgs->id))->render(); ?>
                </div>

                <a href="{{route('client.manager.usercreate')}}" class="btn btn-primary pull-right btn-sm">{{Lang::get('lang.create_user')}}</a>  

   </div> 


   <div class="box-body">
 <table id="myTable1" class="display" cellspacing="0" width="100%">
               <thead>
                          <tr>
                            <th>{!! Lang::get('lang.name') !!}</th>
                            <th>{!! Lang::get('lang.email') !!}</th>
                            <th>{!! Lang::get('lang.phone') !!}</th>
                            <th>{!! Lang::get('lang.status') !!}</th>
                            <th>{!! Lang::get('lang.ban') !!}</th>
                            <th>{!! Lang::get('lang.last_activity') !!}</th>
                            <th>{!! Lang::get('lang.action') !!}</th>
                        </tr>
                </thead>
                       
                         <tbody>
                          @foreach($user_orgs as $user_org)
                        <?php
                        $user_detail = App\User::where('id', '=', $user_org->user_id)->first();
                        ?>
                        <tr>
                             @if($user_detail->first_name && $user_detail->last_name)
                            <td>
                            <!-- <a href="{!! route('client.manager.userview',$user_detail->id) !!}"> -->
                            {!! $user_detail->first_name.' '.$user_detail->last_name !!}
                            <!-- </a> -->
                            </td>
                            @else
                            <td>
                           <!-- <a href="{!! route('client.manager.userview',$user_detail->id) !!}"> -->
                            {!! $user_detail->user_name !!}
                            <!-- </a> -->
                            </td>
                            @endif                            
                            <td>
                            <!-- <a href="{!! route('user.show',$user_detail->id) !!}"> -->
                            {!! $user_detail->email !!}
                            <!-- </a> -->
                            </td>
                            <td>{!! $user_detail->phone_number !!}</td>
                            @if($user_detail->active == 1)
                            <td><span class="label label-success">{!! Lang::get('lang.active') !!}</span></td>
                            @elseif($user_detail->active == 0)
                            <td><span class="label label-warning">{!! Lang::get('lang.inactive') !!}</span></td>
                            @endif
                            <td>
                                @if($user_detail->ban=='1')
                    <span class="label label-danger">{!! Lang::get('lang.yes') !!}</span>
                    @else
                    <span class="label label-success">{!! Lang::get('lang.no') !!}</span>
                    @endif


                            </td>
<td>{{$user_detail->updated_at}}</td>
                             <td>
                                      <a href="{!! route('client.organizations.edituser',$user_detail->id) !!}"><button class="btn btn-info btn-xs" title="{!! Lang::get('lang.edit') !!}"> <i class='fa fa-edit'> </i></button></a>
                        <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#{{$user_detail->id}}delete"> <i class='fa fa-trash'> </i></button>



                        <div class="modal fade" id="{{$user_detail->id}}delete">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">{!! Lang::get('lang.delete') !!}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>{!! Lang::get('lang.are_you_sure_you_want_to_delete') !!} ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                     <!--     <a href="{!! route('client.organizations.edituser',$user_detail->id) !!}"><button class="btn btn-info btn-xs"> <i class='fa fa-edit'> </i></button></a> -->
                                        {!! link_to_route('client.org.deleteuser',Lang::get('lang.delete'),[$user_detail->id],['id'=>'delete','class'=>'btn btn-danger btn-sm']) !!}
                                    </div>
                                </div> 
                            </div>
                        </div>


                      

<!--  <button type="button" href="#myPopup" data-rel="popup" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewCategoryModal" title="{!! Lang::get('lang.reset_password') !!}"><i class='fa fa-refresh'> </i></button> -->




                    </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="box-footer">
    </div>
            </div>  

        </div>

 <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables.css">
   <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables_themeroller.css">
   <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
   <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/jquery.dataTables.min.js"></script>





    <!-- Change password -->

    <div class="modal fade" id="addNewCategoryModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="titleLabel">{{Lang::get('lang.change_password')}}:</h4>
                </div>

                <div class="modal-body">

                    <button class="btn btn-warning pull-right" id="changepassword">{{Lang::get('lang.password_generator')}}</button>

                    <br/>
                    <form name="myForm" action="{!!URL::route('user.post.changepassword', $users->id)!!}" method="post" role="form" onsubmit="return validateForm()">
                        <div class="form-group">

                            <!-- <div class="form-group {{ $errors->has('change_password') ? 'has-error' : '' }}"> -->
                            {!! Form::label('New password',Lang::get('lang.new_password')) !!} <span class="text-red"> *</span>
                            <input type="text" class="form-control" name="change_password" id="changepassword1" >

                            <p id="demo" style="color:red"></p>

                            <!-- </div> -->

                        </div>

                </div>

            </div>
            <div class="box-footer">
                {!! Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary','id'=>'savepassword'])!!}
            </div>
            </form>
        </div>
    </div>








        <?php
        $user_orga_relation_id = "";
        $user_orga_relations = App\Model\helpdesk\Agent_panel\User_org::where('org_id', '=', $orgs->id)->get();
        foreach ($user_orga_relations as $user_orga_relation) {
            $user_orga_relation_id[] = $user_orga_relation->user_id;
        }
//        dd($user_orga_relation_id);
//        $models = \App\Model\helpdesk\Ticket\Tickets::whereIn('user_id', $user_orga_relation_id)->get();

        $open = count(\App\Model\helpdesk\Ticket\Tickets::whereIn('user_id', $user_orga_relation_id)->where('status', '=', '1')->get());
        $counted = count(\App\Model\helpdesk\Ticket\Tickets::whereIn('user_id', $user_orga_relation_id)->where('status', '=', '3')->get());
        $deleted = count(\App\Model\helpdesk\Ticket\Tickets::whereIn('user_id', $user_orga_relation_id)->where('status', '=', '5')->get());
//        dd($open);
        ?>
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">{!! Lang::get('lang.open_tickets') !!} ({{$open}})</a></li>
                <li><a href="#tab_2" data-toggle="tab">{!! Lang::get('lang.closed_tickets') !!} ({{$counted}})</a></li>
                <li><a href="#tab_3" data-toggle="tab">{!! Lang::get('lang.deleted_tickets') !!} ({{$deleted}})</a></li>
            </ul>
            <div class="tab-content no-padding">
                <div class="tab-pane active" id="tab_1">
                    <?php $open = count(App\Model\helpdesk\Ticket\Tickets::whereIn('user_id', $user_orga_relation_id)->where('status', '=', '1')->get()); ?>
                    @if(Session::has('success12'))
                    <div id="success-alert" class="alert alert-success alert-dismissable">
                        <i class="fa  fa-check-circle"> </i>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{Session::get('success12')}}
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
                        {!! Form::open(['route'=>'clientpanel.select_all','method'=>'post']) !!}
                        <div class="mailbox-controls">
                            <!-- Check all button -->
                            <a class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></a>
                            <input type="submit" class="btn btn-default text-orange btn-sm" name="submit" value="{!! Lang::get('lang.delete') !!}">
                            <input type="submit" class="btn btn-default text-yellow btn-sm" name="submit" value="{!! Lang::get('lang.close') !!}">
                            <div class="pull-right">
                                <?php
                                $counted = count(App\Model\helpdesk\Ticket\Tickets::whereIn('user_id', $user_orga_relation_id)->where('status', '=', '1')->get());
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
                                    <?php $tickets = App\Model\helpdesk\Ticket\Tickets::whereIn('user_id', $user_orga_relation_id)->where('status', '=', '1')->orderBy('id', 'DESC')->paginate(20); ?>
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
                                        <td class="mailbox-name"><a href="{!! URL('check_ticket',[Crypt::encrypt($ticket->id)]) !!}" title="{!! $title->title !!}">{{$string}}   </a> ({!! $count!!}) <i class="fa fa-comment"></i>
                                            @if($collab > 0)&nbsp;<i class="fa fa-users"></i>@endif 
                                            @if($attach > 0)&nbsp;<i class="fa fa-paperclip"></i>@endif</td>
                                        <td class="mailbox-Id"><a href="{!! URL('check_ticket',[Crypt::encrypt($ticket->id)]) !!}" title="{!! $title->title !!}">#{!! $ticket->ticket_number !!}</a></td>
                                        <?php $priority = App\Model\helpdesk\Ticket\Ticket_Priority::where('priority_id', '=', $ticket->priority_id)->first(); ?>
                                        <td class="mailbox-priority">@if($priority != null)<spam class="btn btn-{{$priority->priority_color}} btn-xs">{{$priority->priority}}</spam>@endif</td>
                                <?php $from = App\User::where('id', '=', $ticket->user_id)->first(); ?> 
                                <td class="mailbox-last-reply" style="color:{!! $rep !!}">{!! $username !!}</td>
                                <td>{!! $assigned !!}</td>
                                <td class="mailbox-last-activity">{!! faveoDate($title->updated_at) !!}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table><!-- /.table -->
                            <div class="pull-right">
                                <?php echo $tickets->setPath(url('/organizations/' . $orgs->id))->render(); ?>&nbsp;
                            </div>
                        </div><!-- /.mail-box-messages -->
                        {!! Form::close() !!}

                        {{-- end deleted tickets --}}
                    </div>
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    {{-- open tab --}}
                    <?php $closed = count(App\Model\helpdesk\Ticket\Tickets::whereIn('user_id', $user_orga_relation_id)->where('status', 2)->get()); ?>
                    @if(Session::has('success12'))
                    <div id="success-alert" class="alert alert-success alert-dismissable">
                        <i class="fa  fa-check-circle"> </i>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{Session::get('success12')}}
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
                        {!! Form::open(['route'=>'clientpanel.select_all','method'=>'post']) !!}
                        <div class="mailbox-controls">
                            <!-- Check all button -->
                            <a class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></a>
                            <input type="submit" class="btn btn-default text-orange btn-sm" name="submit" value="{!! Lang::get('lang.delete') !!}">
                            <input type="submit" class="btn btn-default text-yellow btn-sm" name="submit" value="{!! Lang::get('lang.open') !!}">
                            <div class="pull-right">
                                <?php
                                $counted = count(App\Model\helpdesk\Ticket\Tickets::whereIn('user_id', $user_orga_relation_id)->where('status', '=', '3')->get());
                                if ($counted < 20) {
                                    echo $counted ;
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
                                    <?php $tickets = App\Model\helpdesk\Ticket\Tickets::whereIn('user_id', $user_orga_relation_id)->where('status', '=', '3')->orderBy('id', 'DESC')->paginate(20); ?>
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
                                        <td class="mailbox-name"><a href="{!! URL('check_ticket',[Crypt::encrypt($ticket->id)]) !!}" title="{!! $title->title !!}">{{$string}}   </a> ({!! $count!!}) <i class="fa fa-comment"></i>
                                            @if($collab > 0)&nbsp;<i class="fa fa-users"></i>@endif 
                                            @if($attach > 0)&nbsp;<i class="fa fa-paperclip"></i>@endif</td>
                                        <td class="mailbox-Id"><a href="{!! URL('check_ticket',[Crypt::encrypt($ticket->id)]) !!}" title="{!! $title->title !!}">#{!! $ticket->ticket_number !!}</a></td>
                                        <?php $priority = App\Model\helpdesk\Ticket\Ticket_Priority::where('priority_id', '=', $ticket->priority_id)->first(); ?>
                                        <td class="mailbox-priority">@if($priority != null)<spam class="btn btn-{{$priority->priority_color}} btn-xs">{{$priority->priority}}</spam>@endif</td>
                                <?php $from = App\User::where('id', '=', $ticket->user_id)->first(); ?> 
                                <td class="mailbox-last-reply" style="color:{!! $rep !!}">{!! $username !!}</td>
                                <td>{!! $assigned !!}</td>
                                <td class="mailbox-last-activity">{!!faveoDate($title->updated_at) !!}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table><!-- /.table -->

                            <div class="pull-right">
                                <?php echo $tickets->setPath(url('/organizations/' . $orgs->id))->render(); ?>&nbsp;
                            </div>
                        </div><!-- /.mail-box-messages -->
                        {!! Form::close() !!}

                        {{-- end deleted tickets --}}
                    </div>
                </div>
                <div class="tab-pane" id="tab_3">
                    {{-- open tab --}}
                    <?php $deleted = count(App\Model\helpdesk\Ticket\Tickets::whereIn('user_id', $user_orga_relation_id)->where('status', '=', '5')->get()); ?>

                    @if(Session::has('success12'))
                    <div id="success-alert" class="alert alert-success alert-dismissable">
                        <i class="fa  fa-check-circle"> </i>
                        <button type="button" id="close-alert" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{Session::get('success12')}}
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

                        {!! Form::open(['route'=>'clientpanel.select_all','method'=>'post']) !!}
                        <div class="mailbox-controls">
                            <!-- Check all button -->
                            <a class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></a>
                            <input type="submit" class="btn btn-default text-orange btn-sm" name="submit" value="{!! Lang::get('lang.open') !!}">
                            <input type="submit" class="btn btn-default text-yellow btn-sm" name="submit" value="{!! Lang::get('lang.close') !!}">
                            <div class="pull-right">
                                <?php
                                $counted = count(App\Model\helpdesk\Ticket\Tickets::whereIn('user_id', $user_orga_relation_id)->where('status', '=', '5')->get());
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
                                    <?php $tickets = App\Model\helpdesk\Ticket\Tickets::whereIn('user_id', $user_orga_relation_id)->where('status', '=', '5')->orderBy('id', 'DESC')->paginate(20); ?>
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
                                        <td class="mailbox-name"><a href="{!! URL('check_ticket',[Crypt::encrypt($ticket->id)]) !!}" title="{!! $title->title !!}">{{$string}}   </a> ({!! $count!!}) <i class="fa fa-comment"></i>
                                            @if($collab > 0)&nbsp;<i class="fa fa-users"></i>@endif 
                                            @if($attach > 0)&nbsp;<i class="fa fa-paperclip"></i>@endif</td>
                                        <td class="mailbox-Id"><a href="{!! URL('check_ticket',[Crypt::encrypt($ticket->id)]) !!}" title="{!! $title->title !!}">#{!! $ticket->ticket_number !!}</a></td>
                                        <?php $priority = App\Model\helpdesk\Ticket\Ticket_Priority::where('priority_id', '=', $ticket->priority_id)->first(); ?>
                                        <td class="mailbox-priority">@if($priority != null)<spam class="btn btn-{{$priority->priority_color}} btn-xs">{{$priority->priority}}</spam>@endif</td>
                                <?php $from = App\User::where('id', '=', $ticket->user_id)->first(); ?> 
                                <td class="mailbox-last-reply" style="color:{!! $rep !!}">{!! $username !!}</td>
                                <td>{!! $assigned !!}</td>
                                <td class="mailbox-last-activity">{!! faveoDate($title->updated_at) !!}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table><!-- /.table -->

                            <div class="pull-right">
                                <?php echo $tickets->setPath(url('/organizations/' . $orgs->id))->render(); ?>&nbsp;
                            </div>
                        </div><!-- /.mail-box-messages -->
                        {!! Form::close() !!}
                    </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
            </div><!-- nav-tabs-custom -->
        </div>













          @if(Auth::user()->role == 'admin')
        <!--  Report of organization  -->  
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    {!! Lang::get('lang.report_of') !!} {!! $orgs->name !!}
                </h3>
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
                            <div class='col-sm-2'>
                                {!! Form::label('filter', Lang::get("lang.filter").':') !!}<br>
                                <input type="submit" value="{!! Lang::get('lang.submit') !!}" class="btn btn-primary">
                            </div>
                            <div class="col-sm-10">
                                <label class="lead">{!! Lang::get('lang.Legend') !!}:</label>
                                <div class="row">
                                    <style>
                                        #legend-holder { border: 1px solid #ccc; float: left; width: 25px; height: 25px; margin: 2px; }
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
                    <canvas class="chart-data" id="tickets-graph" width="1000" height="270"></canvas>   
                </div>
            </div>
        </div>
        @endif
  <?php  \Event::fire('licenses.show', array($org_id=$orgs->id)); ?> 
  <?php  \Event::fire('orgdocs.show', array($org_id=$orgs->id)); ?> 


        <!--<script type="text/javascript">-->
        <div id = "refresh">
            <script src = "{{asset("lb-faveo/plugins/chartjs/Chart.min.js")}}" type = "text/javascript" ></script>
        </div>
        <script src="{{asset("lb-faveo/plugins/chartjs/Chart.min.js")}}" type="text/javascript"></script>

        <link type="text/css" href="{{asset("lb-faveo/css/bootstrap-datetimepicker4.7.14.min.css")}}" rel="stylesheet">
        <script type="text/javascript">
                                $(document).ready(function() {
                                      $.getJSON(" {{route('clientpanel.user-agen', $users->id)}}", function(result) {
                                    
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
                                            url: '../org-chart-range/<?php echo $orgs->id; ?>/' + dateData + '/' + formData, // the url where we want to POST
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
                                                    responsive: true
                                                });
                                                myLineChart.options.responsive = false;
                                                $("#tickets-graph").remove();
                                                $(".chart").html("<canvas id='tickets-graph' width='1000' height='270'></canvas>");
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
                                                    responsive: true
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
        <script src="{{asset("lb-faveo/js/bootstrap-datetimepicker4.7.14.min.js")}}" type="text/javascript"></script>
        <script src="{{asset("lb-faveo/plugins/moment-develop/moment.js")}}" type="text/javascript"></script>

    </div>
</div>

<!-- Organisation Assign Modal -->
<div class="modal fade" id="assign_head">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- {!! Form::model($orgs->id, ['id'=>'org_head','method' => 'PATCH'] )!!} -->
            {!! Form::open(['action' => 'Agent\helpdesk\OrganizationController@Head_Org', 'method' => 'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="dismiss" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{!! Lang::get('lang.assign_manager') !!}</h4>
            </div>
            <div id="assign_alert" class="alert alert-success alert-dismissable" style="display:none;">
                <button id="assign_dismiss" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i>Alert!</h4>
                <div id="message-success1"></div>
            </div>
<link rel="stylesheet" href="{{asset('lb-faveo/plugins/hailhood-tag/demo/css/jquery-ui-base-1.8.20.css')}}">
<link rel="stylesheet" href="{{asset('lb-faveo/plugins/hailhood-tag/css/tagit-stylish-yellow.css')}}">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-6" id="assign_loader" style="display:none;">
                        <img src="{{asset("lb-faveo/dist/img/gifloader.gif")}}"><br/><br/><br/>
                    </div>
                </div>
                 <input type="hidden" name="org_id" value="{{$orgs->id}}">

                <div id="assign_body" >
                     <div id="filter-box">
                        <div>
                            <div class="row">

                                <!-- /.col -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{!! Lang::get('lang.user') !!}</label>
                                        <!-- <ul id="user" class="form-group" data-name="nameOfSelect" name="user[]" ></ul> -->
                                        <ul class="form-group tagit-plgn" data-name="nameOfSelect" name="user[]" tagvalue="tagvalue" >
                                        @if($org_heads_emails!=0)
                                         @forelse($org_heads_emails as $org_heads_email)
                                                         <li>{!! $org_heads_email !!}</li>
                                                                   @empty 
            
                                        @endforelse
                                        @endif
                                   
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
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



<!-- edit maneger -->

<div class="modal fade" id="assign_head1">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- {!! Form::model($orgs->id, ['id'=>'org_head','method' => 'PATCH'] )!!} -->
            {!! Form::open(['action' => 'Agent\helpdesk\OrganizationController@EditHead_Org', 'method' => 'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="dismiss" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{!! Lang::get('lang.edit_assign_manrger') !!}</h4>
            </div>
            <div id="assign_alert" class="alert alert-success alert-dismissable" style="display:none;">
                <button id="assign_dismiss" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i>Alert!</h4>
                <div id="message-success1"></div>
            </div>
<link rel="stylesheet" href="{{asset('lb-faveo/plugins/hailhood-tag/demo/css/jquery-ui-base-1.8.20.css')}}">
<link rel="stylesheet" href="{{asset('lb-faveo/plugins/hailhood-tag/css/tagit-stylish-yellow.css')}}">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-6" id="assign_loader" style="display:none;">
                        <img src="{{asset("lb-faveo/dist/img/gifloader.gif")}}"><br/><br/><br/>
                    </div>
                </div>
                 <input type="hidden" name="org_id" value="{{$orgs->id}}">

                <div id="assign_body" >
                     <div id="filter-box">
                        <div>
                            <div class="row">

                                <!-- /.col -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{!! Lang::get('lang.user') !!}</label>
                                        <!-- <ul id="user" class="form-group" data-name="nameOfSelect" name="user[]" ></ul> -->
                                        <ul class="form-group tagit-plgn" data-name="nameOfSelect" name="user[]" tagvalue="tagvalue" >
                                        @if($org_heads_emails!=0)
                                         @forelse($org_heads_emails as $org_heads_email)
                                    <li>{!! $org_heads_email !!}</li>
                                                                   @empty 
            
                                        @endforelse
                                        @endif
                                   
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                 </div>

                 
            </div>
        <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis4">{!! Lang::get('lang.close') !!}</button>
                <button type="submit" class="btn btn-success pull-right" id="submt2">{!! Lang::get('lang.update') !!}</button>
            </div>
            {!! Form::close()!!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



@section('FooterInclude')


<script type="text/javascript">
            function showhidefilter()
            {
            var div = document.getElementById("filter-box");
//       
                   
                    if (div.style.display !== "none") {
            div.style.display = "none";
            } else {
            div.style.display = "block";
                    // addStyles(div,styles);
            }
            }
</script>
<script src="{{asset('lb-faveo/plugins/hailhood-tag/js/tagit.js')}}"></script>
<script type="text/javascript">

            $('.tagit-plgn').tagit({
             tagSource: "{{url('multi-head-org/autofill')}}",
            allowNewTags: false,
            placeholder: 'Enter email',
            select: true,
    });</script>
@stop






<script type="text/javascript">
// Assign a ticket
                                jQuery(document).ready(function($) {
// create org
                                    $('#org_head').on('submit', function() {
                                        $.ajax({
                                            type: "POST",
                                            url: "../head-org/{!! $orgs->id !!}",
                                            dataType: "html",
                                            data: $(this).serialize(),
                                            beforeSend: function() {
                                                $("#assign_body").hide();
                                                $("#assign_loader").show();
                                            },
                                            success: function(response) {
                                                $("#assign_loader").hide();
                                                $("#assign_body").show();

                                                if (response == 1) {
                                                    message = "Organization head added Successfully."
                                                    $("#dismiss").trigger("click");
                                                    $("#refresh1").load("../organizations/{!! $orgs->id !!}  #refresh1");
                                                    // $("#refresh2").load("../thread/1  #refresh2");
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
                    $(" input[type='checkbox']").iCheck("uncheck");
                    $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                } else {
                    //Check all checkboxes
                    $("input[type='checkbox']").iCheck("check");
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
</script>
@stop
<!-- /content -->