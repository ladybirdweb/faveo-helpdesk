@extends('themes.default1.agent.layout.agent')

@section('Tickets')
class="active"
@stop

@section('ticket-bar')
active
@stop

@section('trash')
class="active"
@stop

@section('content')
<?php
    $date_time_format = UTC::getDateTimeFormat();
    if(Auth::user()->role == 'agent') {
        $dept = App\Model\helpdesk\Agent\Department::where('id','=',Auth::user()->primary_dpt)->first();
        $tickets = App\Model\helpdesk\Ticket\Tickets::where('status', '=', 5)->where('dept_id','=',$dept->id)->orderBy('id', 'DESC')->paginate(20);
    } else {
        $tickets = App\Model\helpdesk\Ticket\Tickets::where('status', '=', 5)->orderBy('id', 'DESC')->paginate(20);
    }
?>
<!-- Main content -->
<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.trash') !!} </h3> <small id="title_refresh">{!! $tickets->total() !!} {!! Lang::get('lang.tickets') !!}</small>
    </div><!-- /.box-header -->
    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"> </i> 
            <b> Success </b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"> </i> 
            <b> Fail! </b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif
    <div class="box-body">
        
    {!! Form::open(['id'=>'modalpopup', 'route'=>'select_all','method'=>'post']) !!}
        <div class="mailbox-controls">
            <!-- Check all button -->
            <a class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></a>
            <input type="submit" class="btn btn-default text-blue btn-sm" id="delete"  name="submit" value="{!! Lang::get('lang.open') !!}">
            <input type="submit" class="btn btn-default text-yellow btn-sm" name="submit"  id="close" value="{!! Lang::get('lang.close') !!}">
            <input type="submit" class="btn btn-default text-yellow btn-sm" name="submit"  id="hard-delete" value="{{Lang::get('lang.clean-up')}}" title="{{Lang::get('lang.trash-delete-title-msg')}}">
            
        </div>
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
        ->setUrl(route('get.trash.ticket'))
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
     var option = null;
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
            $('#refresh').load('trash #refresh');
            $('#title_refresh').load('trash #title_refresh');
            $('#count_refresh').load('trash #count_refresh');
            $("#show").show();
        });

          $('#delete').on('click', function(){
            option = 0;
            $('#myModalLabel').html("{{Lang::get('lang.open-tickets')}}");
        });

        $('#close').on('click', function(){
            option = 1;
            $('#myModalLabel').html("{{Lang::get('lang.close-tickets')}}");
        });

        $('#hard-delete').on('click', function(){
            option = 2;
            $('#myModalLabel').html("{{Lang::get('lang.trash-delete-ticket')}}");
        });

         $("#modalpopup").on('submit', function(e){
            e.preventDefault();
            var msg ="{{Lang::get('lang.confirm')}}";
            var values = getValues();
            if(values == ""){
                msg = "{{Lang::get('lang.select-ticket')}}";
                $('.yes').html("{{Lang::get('lang.ok')}}");
                $('#myModalLabel').html("{{Lang::get('lang.alert')}}");
            } else {
                $('.yes').html("Yes");
            }
            $('#custom-alert-body').html(msg);
            $("#myModal").css("display", "block");
        });
        $(".closemodal, .no").click(function(){

            $("#myModal").css("display", "none");

        });

        $('.yes').click(function(){
            var values = getValues();
            if(values == ""){
                $("#myModal").css("display", "none");
            } else {
                $("#myModal").css("display", "none");
                $("#modalpopup").unbind('submit');
                if (option == 0) {
                    //alert('delete');
                    $('#delete').click();
                } else if(option ==1) {
                    //alert('close');
                    $('#close').click();
                } else {
                    $('#hard-delete').click();
                }
            }
        });

        function getValues(){
            var values = $('.selectval:checked').map(function() {
                    return $(this).val();
                }).get();
            return values;
        }

    });

</script>
@stop
