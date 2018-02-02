@extends('themes.default1.agent.layout.agent')

@section('Tickets')
class="active"
@stop

@section('ticket-bar')
active
@stop

@section('closed')
class="active"
@stop

@section('PageHeader')
<h1>{{trans('lang.tickets')}}</h1>
<style>
 .tooltip1 {
     position: relative;
     /*display: inline-block;*/
     /*border-bottom: 1px dotted black;*/
 }
 
 .tooltip1 .tooltiptext {
     visibility: hidden;
     width: 100%;
     background-color: black;
     color: #fff;
     text-align: center;
     border-radius: 6px;
     padding: 5px 0;
 
     /* Position the tooltip */
     position: absolute;
     z-index: 1;
 }
 
 .tooltip1:hover .tooltiptext {
     visibility: visible;
 }
 </style>
@stop

@section('content')
<?php
$date_time_format = UTC::getDateTimeFormat();
if (Auth::user()->role == 'agent') {
    $dept = App\Model\helpdesk\Agent\Department::where('id', '=', Auth::user()->primary_dpt)->first();
    $tickets = App\Model\helpdesk\Ticket\Tickets::where('status', '>', 1)->where('dept_id', '=', $dept->id)->where('status', '<', 4)->orderBy('id', 'DESC')->count();
} else {
    $tickets = App\Model\helpdesk\Ticket\Tickets::where('status', '>', 1)->where('status', '<', 4)->orderBy('id', 'DESC')->count();
}
?>
<!-- Main content -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"> {!! trans('lang.closed') !!} </h3> <small id="title_refresh">{!! $tickets !!}  {!! trans('lang.tickets') !!}</small>
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
            <i class="fa fa-ban"> </i> <b> {!! trans('lang.alert') !!}! </b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif
        
        {!! Form::open(['id'=>'modalpopup', 'route'=>'select_all','method'=>'post']) !!}
        <!--<div class="mailbox-controls">-->
        <!-- Check all button -->
        <a class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></a>
        {{-- <a class="btn btn-default btn-sm" id="click"><i class="fa fa-refresh"></i></a> --}}
        <input type="submit" class="btn btn-default text-orange btn-sm" name="submit" id="delete" value="{!! trans('lang.delete') !!}">
        <input type="submit" class="btn btn-default text-blue btn-sm" name="submit" id="close" value="{!! trans('lang.open') !!}">
        
        
        <!--</div>-->
        <p><p/>
        <div class="mailbox-messages"  id="refresh">
            <p style="display:none;text-align:center; position:fixed; margin-left:40%;margin-top:-70px;" id="show" class="text-red"><b>{!! trans('lang.loading') !!}...</b></p>
            <!-- table -->
            {!!$table->render('vendor.Chumper.template')!!}

        </div><!-- /.mail-box-messages -->
        {!! Form::close() !!}
    </div><!-- /.box-body -->
</div><!-- /. box -->

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
                    <button type="button" class="btn btn-primary pull-left yes" data-dismiss="modal">{{trans('lang.ok')}}</button>
                    <button type="button" class="btn btn-default no">{{trans('lang.cancel')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>


{!! $table->script('vendor.Chumper.ticket-javascript') !!}
<script>
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
            } else {
                //Check all checkboxes
                $("input[type='checkbox']", ".mailbox-messages").iCheck("check");
            }
            $(this).data("clicks", !clicks);
        });
    });


    $(document).ready(function() { /// Wait till page is loaded
        $('#click').click(function() {
            $('#refresh').load('closed #refresh');
            $('#title_refresh').load('closed #title_refresh');
            $('#count_refresh').load('closed #count_refresh');
            $("#show").show();
        });

        $('#delete').on('click', function() {
            option = 0;
            $('#myModalLabel').html("{{trans('lang.delete-tickets')}}");
        });

        $('#close').on('click', function() {
            option = 1;
            $('#myModalLabel').html("{{trans('lang.open-tickets')}}");
        });

        $("#modalpopup").on('submit', function(e) {
            e.preventDefault();
            var msg = "{{trans('lang.confirm')}}";
            var values = getValues();
            if (values == "") {
                msg = "{{trans('lang.select-ticket')}}";
                $('.yes').html("{{trans('lang.ok')}}");
                $('#myModalLabel').html("{{trans('lang.alert')}}");
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

    });
</script>
@stop