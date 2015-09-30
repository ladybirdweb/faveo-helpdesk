@extends('themes.default1.agent.layout.agent')

@section('Tickets')
class="active"
@stop

@section('ticket-bar')
active
@stop

@section('answered')
class="active"
@stop

@section('content')
<?php 
    if(Auth::user()->role == 'agent')
    {
        $dept = App\Model\helpdesk\Agent\Department::where('name','=',Auth::user()->primary_dpt)->first();
        $tickets = App\Model\helpdesk\Ticket\Tickets::where('status', '=', 1)->where('isanswered', '=', 1)->where('dept_id','=',$dept->id)->orderBy('id', 'DESC')->paginate(20);
    } else {
        $tickets = App\Model\helpdesk\Ticket\Tickets::where('status', '=', 1)->where('isanswered', '=', 1)->orderBy('id', 'DESC')->paginate(20);
    }   
?>
<!-- Main content -->
<div class="box box-primary">
     <div class="box-header with-border">
        <h3 class="box-title">Answered </h3> <small>{!! $tickets->total() !!} tickets</small>
        <div class="box-tools pull-right">
        <div class="has-feedback">
              
            </div>
        </div>
    </div><!-- /.box-header -->
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
        <h3 class="pull-right" style="margin-top:0;margin-bottom:0;"> {!! $tickets->count().'-'.$tickets->total(); !!}</h3>
            <!-- Check all button -->
            <a class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></a>
            <a class="btn btn-default btn-sm" id="click"><i class="fa fa-refresh"></i></a>
            <input type="submit" class="btn btn-default text-orange btn-sm" name="submit" value="Delete">
            <input type="submit" class="btn btn-default text-yellow btn-sm" name="submit" value="Close">
           
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
                </thead>
                <tbody id="hello">
                    
                    @foreach ($tickets  as $ticket)
                        <?php 
                        //  title
                        $title = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $ticket->id)->get();

                        $title = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $ticket->id)->first();
                        $string = strip_tags($title->title);
                        if($title)
                        if($title == null){

                        } else {
                            ?>
                    <tr <?php if ($ticket->seen_by == null) {?> style="color:green;" <?php } ?> >
                        <td ><input type="checkbox" class="icheckbox_flat-blue" name="select_all[]" value="{{$ticket->id}}"/></td>
                        <?php 
                        //  collaborators
                        $collaborators = App\Model\helpdesk\Ticket\Ticket_Collaborator::where('ticket_id','=',$ticket->id)->get();
                        $collab = count($collaborators);
                        
                        // check atatchments
                        $attachments = App\Model\helpdesk\Ticket\Ticket_attachments::where('thread_id','=',$title->id)->first();
                        $attach = count($attachments);

                        if (strlen($string) > 40) {
                            $stringCut = substr($string, 0, 40);
                            $string = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...'; 
                        }
                        $TicketData = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $ticket->id)->max('id');
                        $TicketDatarow = App\Model\helpdesk\Ticket\Ticket_Thread::where('id', '=', $TicketData)->first();
                        $LastResponse = App\User::where('id', '=', $TicketDatarow->user_id)->first(); 
                        if($LastResponse->role == "user") {
                            $rep = "#F39C12";
                            $username = $LastResponse->user_name;
                            } else { $rep = "#000"; $username = $LastResponse->first_name ." ". $LastResponse->last_name; 
                            if($LastResponse->first_name==null || $LastResponse->last_name==null) {
                                $username = $LastResponse->user_name;
                            }}   
                        $titles = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $ticket->id)->get();
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
                        <?php $priority = App\Model\helpdesk\Ticket\Ticket_Priority::where('priority_id', '=', $ticket->priority_id)->first();?>
                        <td class="mailbox-priority"><spam class="btn btn-{{$priority->priority_color}} btn-xs">{{$priority->priority_desc}}</spam></td>
                        <?php $from = App\User::where('id','=',$ticket->user_id)->first();   ?> 
                        @if($from->role == "user")
                <td class="mailbox-from" >{!! $from->user_name !!}</td>        
                        @else
                <td class="mailbox-from" >{!! $from->first_name." ".$from->last_name !!}</td>        
                        @endif
                <td class="mailbox-last-reply" style="color:{!! $rep !!}">{!! $username !!}</td>
                <td>{!! $assigned !!}</td>

                <td class="mailbox-last-activity">{!! UTC::usertimezone($title->updated_at) !!}</td>
                
                </tr>
                <?php } ?>
                @endforeach
                </tbody>
            </table><!-- /.table -->
            
            <div class="pull-right">
                <?php echo $tickets->setPath(url('/ticket/open'))->render();?>&nbsp;
            </div>
        </div><!-- /.mail-box-messages -->
        {!! Form::close() !!}
    </div><!-- /.box-body -->
</div><!-- /. box -->


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
@stop