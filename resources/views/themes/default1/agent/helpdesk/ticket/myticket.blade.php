@extends('themes.default1.agent.layout.agent')

@section('Tickets')
class="active"
@stop

@section('ticket-bar')
active
@stop

@section('myticket')
class="active"
@stop
@section('PageHeader')
<h1>{{Lang::get('lang.tickets')}}</h1>
@stop
@section('content')
<?php
$date_time_format = UTC::getDateTimeFormat();
if (Auth::user()->role == 'agent') {
    $dept = App\Model\helpdesk\Agent\Department::where('id', '=', Auth::user()->primary_dpt)->first();
    $tickets = App\Model\helpdesk\Ticket\Tickets::where('status', '=', 1)->where('assigned_to', '=', Auth::user()->id)->orderBy('id', 'ASC')->paginate(20);
} else {
    $tickets = App\Model\helpdesk\Ticket\Tickets::where('status', '=', 1)->where('assigned_to', '=', Auth::user()->id)->orderBy('id', 'ASC')->paginate(20);
}
?>
<!-- Main content -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.my_tickets') !!}</h3> <small id="title_refresh">{!! $tickets->total() !!} {!! Lang::get('lang.tickets') !!}</small>
    </div><!-- /.box-header -->

    <div class="box-body">
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"> </i> 
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"> </i> <b> {!! Lang::get('lang.alert') !!}! </b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif

        {!! Form::open(['id'=>'modalpopup', 'route'=>'select_all','method'=>'post']) !!}
        <!--<div class="mailbox-controls">-->
        <!-- Check all button -->
        <a class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></a>
        {{-- <a class="btn btn-default btn-sm" id="click"><i class="fa fa-refresh"></i></a> --}}
        <input type="submit" class="submit btn btn-default text-orange btn-sm" id="delete" name="submit" value="{!! Lang::get('lang.delete') !!}">
        <input type="submit" class="submit btn btn-default text-yellow btn-sm" id="close" name="submit" value="{!! Lang::get('lang.close') !!}">
        <button type="button" class="btn btn-sm btn-default text-green" id="Edit_Ticket" data-toggle="modal" data-target="#MergeTickets"><i class="fa fa-code-fork"> </i> {!! Lang::get('lang.merge') !!}</button>
        <!--</div>-->
        <div class="mailbox-messages"  id="refresh">
            <p style="display:none;text-align:center; position:fixed; margin-left:40%;margin-top:-70px;" id="show" class="text-red"><b>{!! Lang::get('lang.loading') !!}...</b></p>
            <!-- table -->
            {!! Datatable::table()
            ->addColumn(
            "",
            Lang::get('lang.subject'),
            Lang::get('lang.ticket_id'),
            Lang::get('lang.priority'),
            Lang::get('lang.from'),
            Lang::get('lang.assigned_to'),
            Lang::get('lang.last_activity'))
            ->setUrl(route('get.myticket.ticket'))
            ->setOptions('aoColumnDefs',array(
            array(
            'render' => "function ( data, type, row ) {
            var t = row[6].split(/[- :,/ :,. /]/);
            var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
            <!--  -->
            var dtf= '$date_time_format';
            if(dtf==1) {
            dtf = 'D/MMM/YYYY hh:mm:ss A';
            } else if(dtf==2) {
            dtf = 'D MMM, YYYY hh:mm:ss A';
            } else if(dtf==3) {
            dtf = 'D-MMM-YYYY hh:mm:ss A';
            } else if(dtf==4) {
            dtf = 'MMM/D/YYYY hh:mm:ss A';
            } else if(dtf==5) {
            dtf = 'MMM D, YYYY hh:mm:ss A';
            } else if(dtf==6) {
            dtf = 'MMM-D-YYYY hh:mm:ss A';
            } else if(dtf==7) {
            dtf = 'YYYY/MMM/D hh:mm:ss A';
            } else if(dtf==8) {
            dtf = 'YYYY, MMM D hh:mm:ss A';
            } else if(dtf==9) {
            dtf = 'YYYY-MMM-D hh:mm:ss A';
            }
            return  moment(d).format(dtf);
            <!-- //return d; -->
            }", 
            'aTargets' => array(6))
            )) 
            ->setOrder(array(6=>'desc'))  
            ->setClass('table table-hover table-bordered table-striped')
            ->setCallbacks("fnRowCallback",'function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            var str = aData[3];
            if(str.search("#000") == -1) {
            $("td", nRow).css({"background-color":"#F3F3F3", "font-weight":"600", "border-bottom":"solid 0.5px #ddd", "border-right":"solid 0.5px #F3F3F3"});
            $("td", nRow).mouseenter(function(){
            $("td", nRow).css({"background-color":"#DEDFE0", "font-weight":"600", "border-bottom":"solid 0.5px #ddd", "border-right":"solid 0.5px #DEDFE0"});
            });
            $("td", nRow).mouseleave(function(){
            $("td", nRow).css({"background-color":"#F3F3F3", "font-weight":"600", "border-bottom":"solid 0.5px #ddd","border-right":"solid 0.5px #F3F3F3"});
            });
            } else {
            $("td", nRow).css({"background-color":"white", "border-bottom":"solid 0.5px #ddd", "border-right":"solid 0.5px white"});
            $("td", nRow).mouseenter(function(){
            $("td", nRow).css({"background-color":"#DEDFE0", "border-bottom":"solid 0.5px #ddd", "border-right":"solid 0.5px #DEDFE0"});
            });
            $("td", nRow).mouseleave(function(){
            $("td", nRow).css({"background-color":"white", "border-bottom":"solid 0.5px #ddd", "border-right":"solid 0.5px white"});
            });   
            }
            }')             
            ->render();!!}

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
                                    <!--<button id="dismiss-merge" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>-->
                                    <h4><i class="icon fa fa-check"></i>{!! Lang::get('lang.alert') !!}!</h4>
                                    <div id="message-merge-succ"></div>
                                </div>
                                <div id="merge-err-alert" class="alert alert-danger alert-dismissable" style="display:none;">
                                    <!--<button id="dismiss-merge2" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>-->
                                    <h4><i class="icon fa fa-ban"></i>{!! Lang::get('lang.alert') !!}!</h4>
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


<!-- Modal -->   
<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; padding-right: 15px;background-color: rgba(0, 0, 0, 0.7);">
    <div class="modal-dialog" role="document">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close closemodal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body" id="custom-alert-body" >
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary pull-left yes" data-dismiss="modal">{{Lang::get('lang.ok')}}</button>
                    <button type="button" class="btn btn-default no">{{Lang::get('lang.cancel')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    var t_id = [];
    var option = null;
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
                // alert($("input[type='checkbox']").val());
                t_id = $('.selectval').map(function() {
                    return $(this).val();
                }).get();
                // alert(checkboxValues);
            } else {
                //Check all checkboxes
                $("input[type='checkbox']", ".mailbox-messages").iCheck("check");
                // alert('Hallo');
                t_id = [];
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

        $('#delete').on('click', function() {
            option = 0;
            $('#myModalLabel').html("{{Lang::get('lang.delete-tickets')}}");
        });

        $('#close').on('click', function() {
            option = 1;
            $('#myModalLabel').html("{{Lang::get('lang.close-tickets')}}");
        });

        $("#modalpopup").on('submit', function(e) {
            e.preventDefault();
            var msg = "{{Lang::get('lang.confirm')}}";
            var values = getValues();
            if (values == "") {
                msg = "{{Lang::get('lang.select-ticket')}}";
                $('.yes').html("{{Lang::get('lang.ok')}}");
                $('#myModalLabel').html("{{Lang::get('lang.alert')}}");
            } else {
                $('.yes').html("Yes");
            }
            $('#custom-alert-body').html(msg);
            $("#myModal").css("display", "block");
        });

        $(".closemodal, .no").click(function() {

            $("#myModal").css("display", "none");

        });

        $('.yes').click(function() {
            var values = getValues();
            if (values == "") {
                $("#myModal").css("display", "none");
            } else {
                $("#myModal").css("display", "none");
                $("#modalpopup").unbind('submit');
                if (option == 0) {
                    //alert('delete');
                    $('#delete').click();
                } else {
                    //alert('close');
                    $('#close').click();
                }
            }
        });

        function getValues() {
            var values = $('.selectval:checked').map(function() {
                return $(this).val();
            }).get();
            return values;
        }




        //checking merging tickets
        $('#MergeTickets').on('show.bs.modal', function() {

            // alert("hi");
            $.ajax({
                type: "GET",
                url: "{{route('check.merge.tickets',0)}}",
                dataType: "html",
                data: {data1: t_id},
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
                        var message = "{{Lang::get('lang.select-tickets-to merge')}}";
                        $("#merge-err-alert").show();
                        $('#message-merge-err').html(message);

                    } else if (response == 2) {
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
                            url: "{{ route('get.merge.tickets',0) }}",
                            dataType: "html",
                            data: {data1: t_id},
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
        $('#merge-form').on('submit', function() {
            $.ajax({
                type: "POST",
                url: "{!! url('merge-tickets/') !!}/" + t_id,
                dataType: "json",
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
                        setInterval(function() {
                            $("#alert11").hide();
                            setTimeout(function() {
                                var link = document.querySelector('#load-myticket');
                                if (link) {
                                    link.click();
                                }
                            }, 500);
                        }, 2000);

                    }

                }
            })
            return false;

        });
    });





    function someFunction(id) {
        if (document.getElementById(id).checked) {
            t_id.push(id);
            // alert(t_id);
        } else if(document.getElementById(id).checked === undefined){
            var index = t_id.indexOf(id);
            if (index === -1){
                t_id.push(id);
            } else{
                t_id.splice(index, 1);
            }
        } else {
            var index = t_id.indexOf(id);
            t_id.splice(index, 1);
            // alert(t_id);
        }
    }

</script>
@stop