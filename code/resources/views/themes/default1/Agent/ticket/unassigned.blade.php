@extends('themes.default1.layouts.agentblank')

@section('Tickets')
class="active"
@stop

@section('ticket-bar')
active
@stop

@section('unassigned')
class="active"
@stop

@section('content')
                <!-- <section class="content-header"> -->
{{-- <h3>
    Tickets
</h3> --}}
<!-- </section> -->

<!-- Main content -->
<div class="box box-info">
    <div class="box-header with-border">
<?php $counted = count(App\Model\Ticket\Tickets::where('assigned_to', '=', 0)->get());?>
        <h3 class="box-title">Unassigned </h3> <small> {{$counted}} Messages</small>
        <!-- <div class="box-tools pull-right">
            <div class="has-feedback">
                <input type="text" class="form-control input-sm" placeholder="Search Mail"/>
                <span class="glyphicon glyphicon-search form-control-feedback"></span>
            </div>
        </div> --><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body no-padding">
        <div class="mailbox-controls">
            <!-- Check all button -->
            <button class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
            <button class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
            <button class="btn btn-default btn-sm" onclick="click()" id="click"><i class="fa fa-refresh"></i></button>
            <div class="pull-right">
                <?php
$counted = count(App\Model\Ticket\Tickets::where('assigned_to', '=', 0)->get());
if ($counted < 10) {
	echo $counted . "/" . $counted;
} else {
	echo "10/" . $counted;
}
?>
            </div>
        </div>
        <div class=" table-responsive mailbox-messages"  id="refresh">
            <table class="table table-hover table-striped">
                <thead>
                <th>
                </th>
                <th>subject</th>
                <th>Ticket ID</th>
                <th>Priority</th>
                <th>last Replier</th>
                <th>Replies</th>
                <th>Last Activity</th>
                <th>Reply Due</th>
                </thead>
                <tbody id="hello">
                    <?php $tickets = App\Model\Ticket\Tickets::where('assigned_to', '=', 0)->paginate(10);?>

                    @foreach ($tickets  as $ticket )
                    <tr>
                        <td><input type="checkbox" value="{{$ticket->id}}"/></td>
                        <?php $title = App\Model\Ticket\Ticket_Thread::where('ticket_id', '=', $ticket->id)->first();?>
                        <td class="mailbox-name"><a class="text-red" href="{!! route('ticket.thread',[$ticket->id]) !!}">{{$title->title}}</a></td>
                        <td class="mailbox-Id">#{!! $ticket->ticket_number !!}</td>
                        <td class="mailbox-priority"><spam class="btn btn-warning btn-xs">NONE</spam></td>
                <td class="mailbox-last-reply">client</td>
                <td class="mailbox-replies">11</td>
                <td class="mailbox-last-activity">11h 59m 23s</td>
                <td class="mailbox-date">5h 23m 03s</td>
                </tr>
                @endforeach
                </tbody>
            </table><!-- /.table -->
            <div class="pull-right">
                <?php echo $tickets->setPath(url('/ticket'))->render();?>&nbsp;
            </div>
        </div><!-- /.mail-box-messages -->
    </div><!-- /.box-body -->
</div><!-- /. box -->


<script>
    $(function() {
        //Enable iCheck plugin for checkboxes
        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });

        //Enable check and uncheck all functionality
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

        //Handle starring for glyphicon and font awesome
        $(".mailbox-star").click(function(e) {
            e.preventDefault();
            //detect type
            var $this = $(this).find("a > i");
            var glyph = $this.hasClass("glyphicon");
            var fa = $this.hasClass("fa");

            //Switch states
            if (glyph) {
                $this.toggleClass("glyphicon-star");
                $this.toggleClass("glyphicon-star-empty");
            }

            if (fa) {
                $this.toggleClass("fa-star");
                $this.toggleClass("fa-star-o");
            }
        });
    });


    $(document).ready(function() { /// Wait till page is loaded
        $('#click').click(function() {
            $('#refresh').load('open #refresh');
        });
    });


    // //  check box get data
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