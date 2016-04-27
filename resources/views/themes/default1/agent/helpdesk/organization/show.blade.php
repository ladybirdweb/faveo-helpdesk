@extends('themes.default1.agent.layout.agent')

@section('Users')
class="active"
@stop

@section('user-bar')
active
@stop

@section('organizations')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
{{-- <div><h1 style="margin-top:-10px;margin-bottom:-10px;">Organization Profile</h1></div>
<a href="{{route('organizations.edit', $orgs->id)}}" class="btn btn-info btn-xs btn-flat"><i class="fa fa-edit" style="color:black;"> </i> Edit</a>
 --}}
<div class="box-header" style="margin-top:-15px;margin-bottom:-15px;"><h3 class="box-title">{!! Lang::get('lang.organization_profile') !!}</h3><a href="#"  data-toggle="modal" data-target="#assign" class="btn btn-info btn-sm btn-flat pull-right"><i class="fa fa-user-plus" style="color:black;"> </i> {!! Lang::get('lang.add_user_to_this_organization') !!}</a></div>
<!-- Organisation Assign Modal -->
    <div class="modal fade" id="assign">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::model($orgs->id, ['id'=>'user_assign','method' => 'PATCH'] )!!}
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
                        <p>{!! Lang::get('lang.please_select_an_user') !!}</p>
                        <select id="org" class="form-control" name="org">
<?php
$users = App\User::all();
?>
                            <optgroup label="Select Users">
                                @foreach($users as $user)
                                    <option  value="{{$user->id}}">{!! $user->user_name !!}</option>
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

<div class="row">

<?php  $org_hd = App\Model\helpdesk\Agent_panel\Organization::where('id','=',$orgs->id)->first();  ?>
<div id="alert-success" class="alert alert-success alert-dismissable" style="display:none;">
        <i class="fa  fa-check-circle"> </i> <b> Success <span id="get-success"></span></b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    </div>
        <div class="col-md-4">
                <div class="box box-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua">
                    <a href="{{route('organizations.edit', $orgs->id)}}" data-toggle="tooltip" data-placement="left" class="pull-right" title="Edit"><i class="fa fa-edit" style="color:black;"> </i></a>
                  <h3 class="widget-user-username">{{$orgs->name}}</h3>
                  <h5 class="widget-user-desc">{!! $orgs->website !!}</h5>
                </div>
                <div class="box-footer no-padding">
                    <ul class="nav nav-stacked">
                        @if($orgs->phone)<li><a>
                        <b>{!! Lang::get('lang.phone') !!}</b>  
                        <span class="pull-right"> {{$orgs->phone}}</span></a></li>@endif
                        @if($orgs->address)<li><a>
                        <b>{!! Lang::get('lang.address') !!}</b>  
                        <br/> <center>{!! $orgs->address !!}</center></a></li>@endif
                        @if($orgs->internal_notes)<li><a>
                        <b>{!! Lang::get('lang.internal_notes') !!}</b>  
                        <br/> <center>{!! $orgs->internal_notes !!}</center></a></li>@endif
                    </ul>
                    <button data-toggle="modal" data-target="#assign_head" id="button_select" class="btn btn-primary btn-flat btn-block">{!! Lang::get('lang.select_department_manager') !!}</button>
                </div>
              </div>

              <div id="refresh"> 
              @if($org_hd->head > 0)
              <?php $users = App\User::where('id','=',$org_hd->head)->first();  ?>
              <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-yellow">
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
              
              @endif
              </div>

              

        </div>
        <div class="col-md-8">
            <div class="box box-primary">
            <?php
                $user_orgs = App\Model\helpdesk\Agent_panel\User_org::where('org_id','=',$orgs->id)->paginate(5);
                ?>
                <div class="box-header">
                    <h3 class="box-title">{!! Lang::get('lang.users_of') !!} {{$orgs->name}}</h3>
                    <div class="pull-right" style="margin-top:-25px;margin-bottom:-25px;">
                        <?php echo $user_orgs->setPath('../organizations/'.$orgs->id)->render(); ?>
                    </div>
                </div>   
                <hr style="margin-top:0px;margin:bottom:0px;"> 
                
                <div class="box-body">
                        <table class="table table-hover table-bordered">
                              @if(count($user_orgs))
                            <tbody><tr>
                              <th>{!! Lang::get('lang.name') !!}</th>
                              <th>{!! Lang::get('lang.email') !!}</th>
                              <th>{!! Lang::get('lang.phone') !!}</th>
                              <th>{!! Lang::get('lang.status') !!}</th>
                              <th>{!! Lang::get('lang.ban') !!}</th>
                            </tr>

                            @foreach($user_orgs as $user_org)
                            <?php 
                            $user_detail = App\User::where('id','=',$user_org->user_id)->first();
                             ?>
                            <tr>
                                <td><a href="{!! URL::route('organizations.edit',$user_org->org_id) !!}" >{!! $user_detail->user_name !!}</a></td>
                              <td>{!! $user_detail->email !!}</td>
                              <td>{!! $user_detail->phone_number !!}</td>
                                @if($user_detail->active == 1)
                                    <td><span class="label label-success">{!! Lang::get('lang.active') !!}</span></td>
                                @elseif($user_detail->active == 0)
                                    <td><span class="label label-warning">{!! Lang::get('lang.inactive') !!}</span></td>
                                @endif
                              <td>{!! $user_detail->ban !!}</td>
                            </tr>
                            @endforeach
                            </tbody>
                             @else
                                             <tr><td>
                                                     <p>No Records Found! </p>
                                         </td>
                                             </tr>
                                             @endif
                        </table>
                </div>    
                <div class="box-footer">
                    
                </div>                    
            </div>
        </div>
    
     <div class="col-md-8">
                                        <div class="box box-primary">
            <?php 
             $opened = \App\Model\helpdesk\Ticket\Tickets::join('users', 'users.id', '=', 'tickets.user_id')
    ->join('user_assign_organization', 'user_assign_organization.user_id', '=', 'users.id')
                    
    ->where('user_assign_organization.org_id', '=', $orgs->id)
                     ->where('tickets.status', '=', '1')
                     ->select('tickets.id','tickets.user_id')
    ->orderBy('tickets.id', 'DESC')->paginate(20);
                  $closed = \App\Model\helpdesk\Ticket\Tickets::join('users', 'users.id', '=', 'tickets.user_id')
    ->join('user_assign_organization', 'user_assign_organization.user_id', '=', 'users.id')
    ->where('user_assign_organization.org_id', '=', $orgs->id)
                          ->select('tickets.id','tickets.ticket_number','tickets.user_id')
                     ->where('tickets.status', '=', '2')
    ->orderBy('tickets.id', 'DESC')->paginate(20);
              //dd($closed);
                                    $deletes = \App\Model\helpdesk\Ticket\Tickets::join('users', 'users.id', '=', 'tickets.user_id')
    ->join('user_assign_organization', 'user_assign_organization.user_id', '=', 'users.id')
    ->where('user_assign_organization.org_id', '=', $orgs->id)
                     ->where('tickets.status', '=', '5')
                                            ->select('tickets.id','tickets.ticket_number','tickets.user_id')
    ->orderBy('tickets.id', 'DESC')->paginate(20);
   
//            $users = \App\Model\Agent\User_Org_Relationship::where('org_id','=',$orgs->id)->first();
//            $user = App\User::where('id',$users->id)->first(); ?>
<?php $countopened = count($opened);
$countclosed = count($closed);
$countdeleted = count($deletes); ?>
          <div class="row">
            <div class="col-md-12">
              <!-- Custom Tabs -->
                    <div class="box-header">
                    <h3 class="box-title">{!! Lang::get('lang.Tickets_of') !!} {{$orgs->name}}</h3>
                   
                </div>   
              
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab">{!! Lang::get('lang.open_tickets') !!} ({{$countopened}})</a></li>
                  <li><a href="#tab_2" data-toggle="tab">{!! Lang::get('lang.closed_tickets') !!} ({{$countclosed}})</a></li>
                  <li><a href="#tab_3" data-toggle="tab">{!! Lang::get('lang.deleted_tickets') !!} ({{$countdeleted}})</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                    {{-- open tab --}}
						    
						        @if(Session::has('success'))
						        <div id="success-alert" class="alert alert-success alert-dismissable">
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
						            <input type="submit" class="btn btn-default text-orange btn-sm" name="submit" value="{!! Lang::get('lang.delete') !!}">
						            <input type="submit" class="btn btn-default text-yellow btn-sm" name="submit" value="{!! Lang::get('lang.close') !!}">
						            <div class="pull-right">
						                <?php
						$counted = count($opened);
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
                                                                @if(count($opened))
						                <thead>
						                <th>
						                </th>
						                <th>{!! Lang::get('lang.subject') !!}</th>
						                <th>{!! Lang::get('lang.ticket_id') !!}</th>
						                
						                <th>{!! Lang::get('lang.from') !!}</th>
						                <th>{!! Lang::get('lang.last_replier') !!}</th>
						                <th>{!! Lang::get('lang.assigned_to') !!}</th>
						                <th>{!! Lang::get('lang.last_activity') !!}</th>
						                </thead>
						                <tbody id="hello">
						                   @foreach ($opened  as $open)
						                    <tr <?php if ($open->seen_by == null) {?> style="color:green;" <?php }
						?> >
						                        <td ><input type="checkbox" class="icheckbox_flat-blue" name="select_all[]" value="{{$open->id}}"/></td>
						                        <?php 
						                        //  collaborators
						                        $collaborators = App\Model\helpdesk\Ticket\Ticket_Collaborator::where('ticket_id','=',$open->id)->get();
						                        $collab = count($collaborators);
						                        //  title
						                        $title = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $open->id)->first();
                                                           
						                        $string = strip_tags($title->title);
						                        // check atatchments
						                        $attachments = App\Model\helpdesk\Ticket\Ticket_attachments::where('thread_id','=',$open->id)->first();
						                        $attach = count($attachments);

						                        if (strlen($string) > 40) {
						                            $stringCut = substr($string, 0, 40);
						                            $string = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...'; 
						                        }
						                        $TicketData = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $open->id)->max('id');
						                        $TicketDatarow = App\Model\helpdesk\Ticket\Ticket_Thread::where('id', '=', $TicketData)->first();
						                        $LastResponse = App\User::where('id', '=', $TicketDatarow->user_id)->first(); 
						                        if($LastResponse->role == "user") {
						                            $rep = "#F39C12";
						                            $username = $LastResponse->user_name;
						                            } else { $rep = "#000"; $username = $LastResponse->full_name; 
						                            if($LastResponse->full_name==null) {
						                                $username = $LastResponse->user_name;
						                            }}   
						                        $titles = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $open->id)->get();
						                        $count = count($titles);
						                        foreach($titles as $title) {
						                            $title = $title;
						                        }  
						                        $assigned_to = App\User::where('id','=',$open->assigned_to)->first();
						                        if($assigned_to == null) {
						                            $assigned = "Unassigned";
						                        } else {
						                            $assigned = $assigned_to->full_name;
						                        }
						                        ?>
                                                                        
                                                                        <td class="mailbox-name"><a href="{!! route('ticket.thread',$open->id) !!}" title="{!! $title->title !!}">{{$string}}   </a> ({!! $count!!}) <i class="fa fa-comment"></i>
						                        @if($collab > 0)&nbsp;<i class="fa fa-users"></i>@endif 
						                        @if($attach > 0)&nbsp;<i class="fa fa-paperclip"></i>@endif</td>
						                        <td class="mailbox-Id"><a href="{!! route('ticket.thread',$open->id) !!}" title="{!! $title->title !!}">#{!! $open->ticket_number !!}</a></td>
						                       <?php $from = App\User::where('id','=',$open->user_id)->first();   ?> 
						                        @if($from->role == "client")
						                <td class="mailbox-from" >{!! $from->user_name !!}</td>        
						                        @else
						                <td class="mailbox-from" >{!! $from->full_name !!}</td>        
						                        @endif
						                <td class="mailbox-last-reply" style="color:{!! $rep !!}">{!! $username !!}</td>
						                <td>{!! $assigned !!}</td>
						                <td class="mailbox-last-activity">{!! UTC::usertimezone($title->updated_at) !!}</td>
						                </tr>
						                @endforeach
						                </tbody>
                                                                 @else
                                             <tr><td>
                                                     <p>No Records Found! </p>
                                         </td>
                                             </tr>
                                             @endif
						            </table><!-- /.table -->
						            <div class="pull-right">
						                <?php echo $opened->setPath(url('/ticket/open'))->render();?>&nbsp;
						            </div>
						        </div><!-- /.mail-box-messages -->
						        {!! Form::close() !!}

                   {{-- end deleted tickets --}}
                   </div>
                  </div><!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_2">
                    {{-- open tab --}}
						   
						        @if(Session::has('success'))
						        <div id="success-alert" class="alert alert-success alert-dismissable">
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
						    <div class="box-body no-padding">
						    {!! Form::open(['route'=>'select_all','method'=>'post']) !!}
						        <div class="mailbox-controls">
						            <!-- Check all button -->
						            <a class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></a>
						            <a class="btn btn-default btn-sm" id="click"><i class="fa fa-refresh"></i></a>
						            <input type="submit" class="btn btn-default text-orange btn-sm" name="submit" value="{!! Lang::get('lang.delete') !!}">
						            <input type="submit" class="btn btn-default text-yellow btn-sm" name="submit" value="{!! Lang::get('lang.close') !!}">
						            <div class="pull-right">
						                <?php
						$counted = count($closed);
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
                                                                 @if(count($closed))
						                <thead>
						                <th>
						                </th>
						                <th>{!! Lang::get('lang.subject') !!}</th>
						                <th>{!! Lang::get('lang.ticket_id') !!}</th>
				
						                <th>{!! Lang::get('lang.from') !!}</th>
						                <th>{!! Lang::get('lang.last_replier') !!}</th>
						                <th>{!! Lang::get('lang.assigned_to') !!}</th>
						                <th>{!! Lang::get('lang.last_activity') !!}</th>
						                </thead>
						                <tbody id="hello">
                                                                  
						                    @foreach ($closed  as $close)
						                    <tr <?php if ($close->seen_by == null) {?> style="color:green;" <?php } ?> >
						                        <td ><input type="checkbox" class="icheckbox_flat-blue" name="select_all[]" value="{{$close->id}}"/></td>
						                        <?php 
						                        //  collaborators
						                        $collaborators = App\Model\helpdesk\Ticket\Ticket_Collaborator::where('ticket_id','=',$close->id)->get();
						                        $collab = count($collaborators);
						                        //  title
						                        $title = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $close->id)->first();
						                        $string = strip_tags($title->title);
						                        // check atatchments
						                        $attachments = App\Model\helpdesk\Ticket\Ticket_attachments::where('thread_id','=',$close->id)->first();
						                        $attach = count($attachments);

						                        if (strlen($string) > 40) {
						                            $stringCut = substr($string, 0, 40);
						                            $string = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...'; 
                                                                            
						                        }
						                        $TicketData = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $close->id)->max('id');
						                        $TicketDatarow = App\Model\helpdesk\Ticket\Ticket_Thread::where('id', '=', $TicketData)->first();
						                        $LastResponse = App\User::where('id', '=', $TicketDatarow->user_id)->first(); 
                                                                        
						                        if($LastResponse->role == "client") {
						                            $rep = "#F39C12";
						                            $username = $LastResponse->user_name;
						                            } else { $rep = "#000"; $username = $LastResponse->full_name; 
						                            if($LastResponse->full_name==null) {
						                                $username = $LastResponse->user_name;
						                            }}   
						                        $titles = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $close->id)->get();
						                       
                                                                        $count = count($titles);
						                        foreach($titles as $title) {
						                            $title = $title;
						                        }  
                                                                        
						                        $assigned_to = App\User::where('id','=',$close->assigned_to)->first();
                                                                        
						                        if($assigned_to == null) {
						                            $assigned = "Unassigned";
						                        } else {
						                            $assigned = $assigned_to->full_name;
						                        }
						                        ?>
						                        <td class="mailbox-name"><a href="{!! URL('check_ticket',[Crypt::encrypt($close->id)]) !!}" title="{!! $title->title !!}">{{$string}}   </a> ({!! $count!!}) <i class="fa fa-comment"></i>
						                        @if($collab > 0)&nbsp;<i class="fa fa-users"></i>@endif 
						                        @if($attach > 0)&nbsp;<i class="fa fa-paperclip"></i>@endif</td>
						                        <td class="mailbox-Id"><a href="#" title="{!! $title->title !!}">#{!! $close->ticket_number !!}</a></td>
						                      <?php $from = App\User::where('id','=',$close->user_id)->first(); ?> 
						                        @if($from->role == "client")
						                <td class="mailbox-from" >{!! $from->user_name !!}</td>        
						                        @else
						                <td class="mailbox-from" >{!! $from->full_name !!}</td>        
						                        @endif
                                                                             <td class="mailbox-last-reply" style="color:{!! $rep !!}">{!! $username !!}</td>
						                <td>{!! $assigned !!}</td>
						                <td class="mailbox-last-activity">{!! UTC::usertimezone($title->updated_at) !!}</td>
						                </tr>
                                                                
						                @endforeach
						                </tbody>
                                                               @else
                                             <tr><td>
                                                     <p>No Records Found! </p>
                                         </td>
                                             </tr>
                                             @endif  
						            </table><!-- /.table -->
						            
						            <div class="pull-right">
						                <?php echo $closed->setPath(url('/ticket/open'))->render(); ?>&nbsp;
						            </div>
						        </div><!-- /.mail-box-messages -->
						        {!! Form::close() !!}

                   {{-- end deleted tickets --}}
                   </div>
                   </div>
                  <div class="tab-pane" id="tab_3">
                    {{-- open tab --}}
						      @if(Session::has('success'))
						        <div id="success-alert" class="alert alert-success alert-dismissable">
						            <i class="fa  fa-check-circle"> </i> <b> Success </b>
						            <button type="button" id="close-alert" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
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
						            <input type="submit" class="btn btn-default text-orange btn-sm" name="submit" value="{!! Lang::get('lang.delete') !!}">
						            <input type="submit" class="btn btn-default text-yellow btn-sm" name="submit" value="{!! Lang::get('lang.close') !!}">
						            <div class="pull-right">
						                <?php
						$counted = count($deletes);
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
                                                                 @if(count($deletes))
						                <thead>
						                <th>
						                </th>
						              	<th>{!! Lang::get('lang.subject') !!}</th>
						                <th>{!! Lang::get('lang.ticket_id') !!}</th>
						    
						                <th>{!! Lang::get('lang.from') !!}</th>
						                <th>{!! Lang::get('lang.last_replier') !!}</th>
						                <th>{!! Lang::get('lang.assigned_to') !!}</th>
						                <th>{!! Lang::get('lang.last_activity') !!}</th>
						                </thead>
						                <tbody id="hello">
						                   @foreach ($deletes  as $delete)
						                    <tr <?php if ($delete->seen_by == null) {?> style="color:green;" <?php }
						?> >
						                        <td ><input type="checkbox" class="icheckbox_flat-blue" name="select_all[]" value="{{$delete->id}}"/></td>
						                        <?php 
						                        //  collaborators
						                        $collaborators = App\Model\helpdesk\Ticket\Ticket_Collaborator::where('ticket_id','=',$delete->id)->get();
						                        $collab = count($collaborators);
						                        //  title
						                        $title = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $delete->id)->first();
						                        $string = strip_tags($title->title);
						                        // check atatchments
						                        $attachments = App\Model\helpdesk\Ticket\Ticket_attachments::where('thread_id','=',$delete->id)->first();
						                        $attach = count($attachments);

						                        if (strlen($string) > 40) {
						                            $stringCut = substr($string, 0, 40);
						                            $string = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...'; 
						                        }
						                        $TicketData = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $delete->id)->max('id');
						                        $TicketDatarow = App\Model\helpdesk\Ticket\Ticket_Thread::where('id', '=', $TicketData)->first();
						                        $LastResponse = App\User::where('id', '=', $TicketDatarow->user_id)->first(); 
						                        if($LastResponse->role == "user") {
						                            $rep = "#F39C12";
						                            $username = $LastResponse->user_name;
						                            } else { $rep = "#000"; $username = $LastResponse->full_name; 
						                            if($LastResponse->full_name==null) {
						                                $username = $LastResponse->user_name;
						                            }}   
						                        $titles = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $delete->id)->get();
						                        $count = count($titles);
						                        foreach($titles as $title)
						                        {
						                            $title = $title;
						                        }  
						                        $assigned_to = App\User::where('id','=',$delete->assigned_to)->first();
						                        if($assigned_to == null)
						                        {
						                            $assigned = "Unassigned";
						                        }
						                        else
						                        {
						                            $assigned = $assigned_to->full_name;
						                        }
						                        ?>
						                        <td class="mailbox-name"><a href="{!! URL('check_ticket',[Crypt::encrypt($delete->id)]) !!}" title="{!! $title->title !!}">{{$string}}   </a> ({!! $count!!}) <i class="fa fa-comment"></i>
						                        @if($collab > 0)&nbsp;<i class="fa fa-users"></i>@endif 
						                        @if($attach > 0)&nbsp;<i class="fa fa-paperclip"></i>@endif</td>
						                        <td class="mailbox-Id"><a href="#" title="{!! $title->title !!}">#{!! $delete->ticket_number !!}</a></td>
						                         <?php $from = App\User::where('id','=',$delete->user_id)->first();   ?> 
						                        @if($from->role == "user")
						                <td class="mailbox-from" >{!! $from->user_name !!}</td>        
						                        @else
						                <td class="mailbox-from" >{!! $from->full_name !!}</td>        
						                        @endif
						                <td class="mailbox-last-reply" style="color:{!! $rep !!}">{!! $username !!}</td>
						                <td>{!! $assigned !!}</td>
						                <td class="mailbox-last-activity">{!! UTC::usertimezone($title->updated_at) !!}</td>
						                </tr>
						                @endforeach
						                </tbody>
                                                                 @else
                                             <tr><td>
                                                     <p>No Records Found! </p>
                                         </td>
                                             </tr>
                                             @endif
						            </table><!-- /.table -->
						            
						            <div class="pull-right">
						                <?php echo $deletes->setPath(url('/ticket/open'))->render();?>&nbsp;
						            </div>
						        </div><!-- /.mail-box-messages -->
						        {!! Form::close() !!}

                  </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
              </div><!-- nav-tabs-custom -->
            </div><!-- /.col -->      
            </div>
          </div> <!-- /.row -->
          </div>
        </div>

</div>


<!-- Organisation Assign Modal -->
    <div class="modal fade" id="assign_head">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::model($orgs->id, ['id'=>'org_head','method' => 'PATCH'] )!!}
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
                            <img src="{{asset("lb-faveo/dist/img/gifloader.gif")}}"><br/><br/><br/>
                        </div>
                    </div>
                    <div id="assign_body">
                        <p>{!! Lang::get('lang.please_select_an_user') !!}</p>
                        <select id="user" class="form-control" name="user">
<?php
$org_heads = App\Model\helpdesk\Agent_panel\User_org::where('org_id','=',$orgs->id)->get();
?>
                            <optgroup label="Select Organizations">
                                @foreach($org_heads as $org_head)
                                <?php  $user_org_heads = App\User::where('id','=',$org_head->user_id)->first();  ?>
                                    <option  value="{{$user_org_heads->id}}">{!! $user_org_heads->user_name !!}</option>
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
                        $("#refresh").load("../organizations/{!! $orgs->id !!}  #refresh");
                        // $("#refresh2").load("../thread/1  #refresh2");
                        // $("#show").show();
                        $("#alert-success").show();
                        $('#get-success').html(message);
                        setInterval(function(){$("#alert-success").hide(); },4000);   
                    }
                }
            })
            return false;
        });
    });

</script>
<script type="text/javascript">
// Assign a ticket
    jQuery(document).ready(function($) {
// create org
        $('#user_assign').on('submit', function() {
            $.ajax({
                type: "POST",
                url: "../org-assign-user/{{$orgs->id}}",
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
                        $("#refresh-org").load("../organizations/{{ $orgs->id }}  #refresh-org");
                
                        // $("#show").show();
                        $("#alert-success").show();
                        $('#get-success').html(message);
                        setInterval(function(){$("#alert-success").hide(); },4000);   
                    }
                }
            })
            return false;
        });
    });

</script>
@stop

<!-- /content -->