@extends('themes.default1.agent.layout.agent')

@section('Tickets')
class="active"
@stop

@section('ticket-bar')
active
@stop

@section('inbox')
class="active"
@stop

@section('content')
<?php 
    if(Auth::user()->role == 'agent') {
        $dept = App\Model\helpdesk\Agent\Department::where('id','=',Auth::user()->primary_dpt)->first();
        $tickets = App\Model\helpdesk\Ticket\Tickets::where('status', '=', 1)->where('dept_id','=',$dept->id)->orderBy('id', 'DESC')->paginate(20);
    } else {
        $tickets = App\Model\helpdesk\Ticket\Tickets::where('status', '=', 1)->orderBy('id', 'DESC')->paginate(20);
    }   
?>
<!-- Main content -->
<div class="box box-primary">
     <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.inbox') !!} </h3> <small id="title_refresh">{!! $tickets->total() !!} {!! Lang::get('lang.tickets') !!}</small>
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
            <i class="fa fa-ban"> </i> <b> Fail! </b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif
    <div class="box-body ">
    {!! Form::open(['route'=>'select_all','method'=>'post']) !!}
        <div class="mailbox-controls">
            <!-- Check all button -->
            <a class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></a>
            {{-- <a class="btn btn-default btn-sm" id="click"><i class="fa fa-refresh"></i></a> --}}
            <input type="submit" class="btn btn-default text-orange btn-sm" name="submit" value="{!! Lang::get('lang.delete') !!}">
            <input type="submit" class="btn btn-default text-yellow btn-sm" name="submit" value="{!! Lang::get('lang.close') !!}">
            <button type="button" class="btn btn-sm btn-default text-yellow" id="Edit_Ticket" data-toggle="modal" data-target="#MergeTickets"><i class="fa fa-chain"> </i> {!! Lang::get('lang.merge') !!}</button>
           
        </div>
        <div class="mailbox-messages" id="refresh">
            <!--datatable-->
            {!! Datatable::table()
        ->addColumn(
                    "",
                    Lang::get('lang.subject'),
                    Lang::get('lang.ticket_id'),
                    Lang::get('lang.priority'),
                    Lang::get('lang.from'),
                    Lang::get('lang.last_replier'),
                    Lang::get('lang.assigned_to'),
                    Lang::get('lang.last_activity'))
        ->setUrl(route('get.inbox.ticket')) 
        ->setOrder(array(7=>'desc'))  
        ->setClass('table table-hover table-bordered table-striped')       
        ->render();!!}
        <!-- /.datatable -->
        </div><!-- /.mail-box-messages -->
        {!! Form::close() !!}
    </div><!-- /.box-body -->
</div><!-- /. box -->

<!-- merge tickets modal -->
    <div class="modal fade" id="MergeTickets">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" id="merge-close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{!! Lang::get('lang.merge-ticket') !!} </h4>
                </div><!-- /.modal-header-->
                <div class ="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-6" id="merge_loader"  style="display:none;">
                            <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}"><br/><br/><br/>
                        </div><!-- /.merge-loader -->
                    </div>
                    <div id="merge_body">
                        <div id="merge-body-alert">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="merge-succ-alert" class="alert alert-success alert-dismissable" style="display:none;" >
                                        <button id="dismiss-merge" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h4><i class="icon fa fa-check"></i>Alert!</h4>
                                        <div id="message-merge-succ"></div>
                                    </div>
                                    <div id="merge-err-alert" class="alert alert-danger alert-dismissable" style="display:none;">
                                        <button id="dismiss-merge2" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h4><i class="icon fa fa-ban"></i>Alert!</h4>
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
                                    <input type="text" name='title' class="form-control" value="" placeholder="Optional" />
                                </div>
                                <div class="col-md-6">
                                    <label>{!! Lang::get('lang.select-pparent-ticket') !!}</label>
                                    <select class="form-control" id="select-merge-parent"  name='p_id' data-placeholder="{!! Lang::get('lang.select_tickets') !!}" style="width: 100%;"><option value=""></option></select>
                                </div>
                            </div>
                           
                            <div class="row">
                                <div class="col-md-8">
                                    <label>{!! Lang::get('lang.merge-reason') !!}</label>
                                    <textarea  name="reason" class="form-control"></textarea>
                                </div>
                          
                            </div>
                        </div><!-- mereg-body-form -->
                    </div><!-- merge-body -->
                </div><!-- /.modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis2">{!! Lang::get('lang.close') !!}</button>
                    <input  type="submit" id="merge-btn" class="btn btn-primary pull-right" value="{!! Lang::get('lang.merge') !!}"></input>
                    {!! Form::close() !!}
                </div><!-- /.modal-footer -->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


<script>
    var t_id =[];
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
            $('#refresh').load('inbox #refresh');
            $('#title_refresh').load('inbox #title_refresh');
            $('#count_refresh').load('inbox #count_refresh');
            $("#show").show();
        });

        $(".select2").select2();
//checking merging tickets
        $('#MergeTickets').on('show.bs.modal', function () {
            
            // alert("hi");
            $.ajax({
                type: "GET",
                url: "../check-merge-ticket/"+0,
                dataType: "html",
                data:{data1: t_id},
                beforeSend: function() {
                    $("#merge_body").hide();
                    $("#merge_loader").show();
                },
                success: function(response) {
                     if(response == 0) {
                        $("#merge_body").show();
                        $("#merge-succ-alert").hide();
                        $("#merge-body-alert").show();
                        $("#merge-body-form").hide();
                        $("#merge_loader").hide();
                        $("#merge-btn").attr('disabled', true);
                       var message = "{{Lang::get('lang.select-tickets-to merge')}}";
                        $("#merge-err-alert").show();
                        $('#message-merge-err').html(message);  

                    }  else if(response == 2) {
                        $("#merge_body").show();
                        $("#merge-succ-alert").hide();
                        $("#merge-body-alert").show();
                        $("#merge-body-form").hide();
                        $("#merge_loader").hide();
                        $("#merge-btn").attr('disabled', true);
                       var message = "{{Lang::get('lang.different-users')}}";
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
                            url: "../get-merge-tickets/"+0,
                            dataType: "html",
                            data:{data1: t_id},
                            success: function(data) {
            
                                $('#select-merge-parent').html(data);
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
                url: "../merge-tickets/"+t_id,
                dataType: "json",
                data: $(this).serialize(),
                beforeSend: function() {
                    $("#merge_body").hide();
                    $("#merge_loader").show();
                   
                },
                success: function(response) {
                    if(response == 0) {
                        $("#merge_body").show();
                        $("#merge-succ-alert").hide();
                        $("#merge-body-alert").show();
                        $("#merge-body-form").hide();
                        $("#merge_loader").hide();
                        $("#merge-btn").attr('disabled', true);
                       var message = "{{Lang::get('lang.merge-error')}}";
                        $("#merge-err-alert").show();
                        $('#message-merge-err').html(message);  
                    
                    } else {
                        $("#merge_body").show();
                        $("#merge-err-alert").hide();
                        $("#merge-body-alert").show();
                        $("#merge-body-form").hide();
                        $("#merge_loader").hide();
                        $("#merge-btn").attr('disabled', true);
                       var message = "{{Lang::get('lang.merge-success')}}";
                        $("#merge-succ-alert").show();
                        $('#message-merge-succ').html(message);  
                        setInterval(function(){
                        $("#alert11").hide();
                        setTimeout(function() {
                            var link = document.querySelector('#load-inbox');
                            if(link) {
                                link.click();
                            }
                        }, 500);
                    },2000);

                    }
                  
                }
            })
            return false;

    });




    
    });



  

    function someFunction(id){
    if(document.getElementById(id).checked) {
        t_id.push(id);
        // alert(t_id);
    } else {
        var index = t_id.indexOf(id);
         t_id.splice(index, 1);
         // alert(t_id);
    }

    // thisid.push(id);
    // alert(thisid);
  //  document.getElementById("demo").innerHTML = thisid;


    // push.thisid;
    // alert(thisid);

    // document.getElementByID('demo').innerHTML = thisid;
}

</script>
@stop