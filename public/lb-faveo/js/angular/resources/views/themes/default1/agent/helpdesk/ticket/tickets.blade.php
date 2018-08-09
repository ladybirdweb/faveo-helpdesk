@extends('themes.default1.agent.layout.agent')

@section('Tickets')
class="active"
@stop

@section('ticket-bar')
active
@stop

<?php
$inputs = \Input::get('show');
$activepage= $inputs[0];
?>

@if($activepage == 'trash')
        @section('trash')
        class="active"
        @stop
@elseif ($activepage == 'mytickets')
        @section('myticket')
        class="active"
        @stop
@elseif ($activepage == 'followup')
        @section('followup')
        class="active"
        @stop
@elseif($activepage == 'inbox')
        @section('inbox')
        class="active"
        @stop
@elseif($activepage == 'overdue')
        @section('overdue')
        class="active"
        @stop
@elseif($activepage == 'closed')
        @section('closed')
        class="active"
        @stop
@elseif($activepage == 'approval')
        @section('approval')
        class="active"
        @stop
@endif

@section('PageHeader')
<h1>{{Lang::get('lang.tickets')}}</h1>
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
<!-- Main content -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            @if($activepage == 'trash')
                {{Lang::get('lang.trash')}}
            @elseif ($activepage == 'mytickets')
                {{Lang::get('lang.my_tickets')}}
            @elseif ($activepage == 'followup')
                {{Lang::get('lang.followup')}}
            @elseif($activepage == 'inbox')
                {{Lang::get('lang.inbox')}}
            @elseif($activepage == 'overdue')
                {{Lang::get('lang.overdue')}}
            @elseif($activepage == 'closed')
                {{Lang::get('lang.closed')}}
            @elseif($activepage == 'approval')
                {{Lang::get('lang.approval')}}
            @endif 
            @if(count(Input::all()) > 2)
            / {{Lang::get('lang.filtered-results')}}
            @else()
                @if(count(Input::get('departments')) == 1 && Input::get('departments')[0] != 'All')
                    / {{Lang::get('lang.filtered-results')}}
                @elseif (count(Input::get('departments')) > 1)
                    / {{Lang::get('lang.filtered-results')}}
                @endif
            @endif
        </h3>
    </div><!-- /.box-header -->

    <div class="box-body ">
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check-circle"> </i>
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
        <!--<div class="mailbox-controls">-->
        <!-- Check all button -->
        
        {{-- <a class="btn btn-default btn-sm" id="click"><i class="fa fa-refresh"></i></a> --}}
        <button type="button" class="btn btn-sm btn-default text-green" id="Edit_Ticket" data-toggle="modal" data-target="#MergeTickets"><i class="fa fa-code-fork"> </i> {!! Lang::get('lang.merge') !!}</button>
        <?php $inputs = Input::all();?>
        <div class="btn-group">
                <?php $statuses = Finder::getCustomedStatus(); ?>
                <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" id="d1"><i class="fa fa-exchange" style="color:teal;" id="hidespin"> </i><i class="fa fa-spinner fa-spin" style="color:teal; display:none;" id="spin"></i>
                    {!! Lang::get('lang.change_status') !!} <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    @foreach($statuses as $ticket_status)    
                    <li onclick="changeStatus({!! $ticket_status -> id !!}, '{!! $ticket_status->name !!}')"><a href="#"><i class="{!! $ticket_status->icon !!}" style="color:{!! $ticket_status->icon_color !!};"> </i>{!! $ticket_status->name !!}</a></li>
                    @endforeach
                </ul>
            </div>
        
        <button type="button" class="btn btn-sm btn-default" id="assign_Ticket" data-toggle="modal" data-target="#AssignTickets" style="display: none;"><i class="fa fa-hand-o-right"> </i> {!! Lang::get('lang.assign') !!}</button>
        @if($activepage == 'trash')
            <button form="modalpopup" class="btn btn-sm btn-danger" id="hard-delete" name="submit" type="submit"><i class="fa fa-trash"></i>&nbsp;{{Lang::get('lang.clean-up')}}</button>
        @endif
        <button type="button" class="btn btn-sm btn-default text-blue" id="filter" onclick="showhidefilter()"><i class="fa fa-filter"></i></button>
        <p><p/>
        <div class="box" style="display: none;" id="filterBox">
            <div class="box-header with-border">
                <h4 class="box-title">{{Lang::get('lang.apply-filters')}}</h4> 
            </div>
            <div class="box-body">
                {!! Form::open(array('url'=>Request::url(), 'method' => 'get', 'class' => 'form-horizontal', 'id' => 'filter-form')) !!}
                <input type="hidden" name="show" value="<?php echo $inputs['show'][0];?>">
                <div class="row">
                    <div class="col-sm-3">
                        {!! Lang::get('lang.department') !!}
                        <select class=" filter" name="departments[]" id="departments-filter" multiple="multiple" style="width: 100%" multiple="multiple">
                            <option value="all">All</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        {!! Lang::get('lang.sla-plans') !!}
                        <select class=" filter" name="sla[]" id="sla-filter" style="width: 100%" multiple="multiple"></select>
                    </div>
                    <div class="col-sm-3">
                        {!! Lang::get('lang.priority') !!}
                        <select class="select2 filter" name="priority[]" id="priority-filter" multiple="multiple" style="width: 100%"></select>
                    </div>
                    <div class="col-sm-3">
                        {!! Lang::get('lang.status') !!}
                        <select class="select2 filter" name="status[]" id="status-filter" multiple="multiple" style="width: 100%" multiple="multiple"></select>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-sm-3">
                        {!! Lang::get('lang.ticket_id-subject') !!}
                        <select class="select2 filter" multiple="multiple" id="ticket-number" name="ticket-number[]" style="width: 100%"></select>
                    </div>
                    <div class="col-sm-3">
                        {!! Lang::get('lang.owner') !!}
                        <select class="select2 filter" name="created-by[]" id="owner-filter" multiple="multiple" style="width: 100%" multiple="multiple"></select>
                    </div>
                    <div class="col-sm-3">
                        {!! Lang::get('lang.assigned') !!}
                        <select class="select2 filter select3 " id="assigned-filter" multiple="multiple" name="assigned[]" style="width: 100%">
                            <option value="0">
                                {{Lang::get("lang.no")}}
                            </option>
                            <option value="1">
                                {{Lang::get("lang.yes")}}
                            </option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        {!! Lang::get('lang.assigned_to') !!}
                        <select class="select2 filter" id="assigned-to-filter" multiple="multiple" name="assigned-to[]" style="width: 100%" multiple="multiple"></select>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-sm-3">
                        {!! Lang::get('lang.labels') !!}
                        <select class="select2 filter" name="labels[]" multiple="multiple"id="labels-filter" style="width: 100%" multiple="multiple"></select>
                    </div>
                    <div class="col-sm-3">
                        {!! Lang::get('lang.tags') !!}
                        <select class="select2 filter" id="tags-filter" multiple="multiple" name="tags[]" style="width: 100%" multiple="multiple"></select>
                    </div>
                    <div class="col-sm-3">
                        {!! Lang::get('lang.type') !!}
                        <select class="select2 filter" id="type-filter" multiple="multiple" name="types[]" style="width: 100%" multiple="multiple"></select>
                    </div>
                    <div class="col-sm-3">
                        {!! Lang::get('lang.source') !!}
                        <select class="select2 filter" name="source[]" id="source-filter" multiple="multiple" style="width: 100%" multiple="multiple"></select>
                    </div>                    
                </div><br/>
                <div class="row">
                    <div class="col-sm-3">
                        {!! Lang::get('lang.created_at') !!}
                        <select class="select2 select3  filter" multiple="multiple" id="created" name="created[]" style="width: 100%">

                        </select>
                    </div>
                    <div class="col-sm-3">
                        {!! Lang::get('lang.last-modified') !!}
                        <select class="select2  select3 filter" multiple="multiple" id="modified" name="updated[]" style="width: 100%"></select>
                    </div>
                    <div class="col-sm-3">
                        {!! Lang::get('lang.last-responsed-by') !!}
                        <select class="select2 filter select3 " id="response-filter" multiple="multiple" name="last-response-by[]" style="width: 100%">
                            <option value="Client">
                                {{Lang::get("lang.client")}}
                            </option>
                            <option value="Agent">
                                {{Lang::get("lang.agent")}}
                            </option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        {!! Lang::get('lang.due-on') !!}
                        <select class="select2 select3 filter" multiple="multiple" id="due-on-filter" style="width: 100%" name="due-on[]">
                            <option value="any-time">
                                {{Lang::get('lang.any-time')}}
                            </option>
                            <option value="next-hour">
                                {{Lang::get('lang.next-hour')}}
                            </option>
                            <option value="next-4-hours">
                                {{Lang::get('lang.next-4-hours')}}
                            </option>
                            <option value="next-8-hours">
                                {{Lang::get('lang.next-8-hours')}}
                            </option>
                            <option value="next-12-hours">
                                {{Lang::get('lang.next-12-hours')}}
                            </option>
                            <option value="today">
                                {{Lang::get('lang.today')}}
                            </option>
                            <option value="tomorrow">
                                {{Lang::get('lang.tomorrow')}}
                            </option>
                        </select>
                    </div>
                </div>
               
            </div>
            <div class="box-footer">
                <input id="apply-filter" class="btn btn-primary" type="submit" name="" value="{{Lang::get('lang.apply')}}" onclick="removeEmptyValues()">
                <input id="resetFilter" class="btn btn-default" type="reset" name="reset" value="{{Lang::get('lang.clear')}}">
            </div>
            {!! Form::close() !!}
        </div>
        <div class="mailbox-messages" id="refresh">
            <!--datatable-->
            {!! Form::open(['id'=>'modalpopup', 'route'=>'select_all','method'=>'post']) !!}
            {!!$table->render('vendor.Chumper.template')!!}
            {!! Form::close() !!} 
            
            <!-- /.datatable -->
        </div><!-- /.mail-box-messages -->
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
                            <div class="col-md-12">
                                <label>{!! Lang::get('lang.merge-reason') !!}</label>
                                <textarea  name="reason" class="form-control" height="120px"></textarea>
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
<!-- Assign ticket model-->
<div class="modal fade" id="AssignTickets">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="assign-close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{!! Lang::get('lang.assign-ticket') !!} </h4>
            </div><!-- /.modal-header-->
            <div class ="modal-body">
                <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-6" id="assign_loader"  style="display:none;">
                        <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}"><br/><br/><br/>
                    </div><!-- /.merge-loader -->
                </div>
                <div id="assign_body">
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::open(['id'=>'assign-form','method' => 'PATCH'] )!!}
                                <label>{!! Lang::get('lang.whome_do_you_want_to_assign_ticket') !!}</label>
                                <select class="form-control" id="select-assign-agent"  name="assign_to" data-placeholder="{!! Lang::get('lang.select_agent') !!}" style="width: 100%;"><option value=""></option></select>
                            </div>
                        </div>
                    </div><!-- mereg-body-form -->
                </div><!-- merge-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis2">{!! Lang::get('lang.close') !!}</button>
                <input  type="submit" id="merge-btn" class="btn btn-primary pull-right" value="{!! Lang::get('lang.assign') !!}"></input>
                {!! Form::close() !!}
            </div><!-- /.modal-footer -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Assign ticket model-->
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
{!! $table->script('vendor.Chumper.tickets-javascript') !!}
<script>
   
    var filterClick = 0;
    var clearlist = 0;
    var t_id = [];
    var submit_form = 0;
    var c_status = '';
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

    $(function () {
        // Enable check and uncheck all functionality

        $(".checkbox-toggle").click(function () {
            var clicks = $(this).data('clicks');
            // alert(clicks);
            if (clicks) {
                //Uncheck all checkboxes
                $("input[type='checkbox']", ".mailbox-messages").iCheck("uncheck");
                // alert($("input[type='checkbox']").val());
                t_id = $('.selectval').map(function () {
                    return $(this).val();
                }).get();
                showAssign(t_id);
                // alert(checkboxValues);
            } else {
                //Check all checkboxes
                $("input[type='checkbox']", ".mailbox-messages").iCheck("check");
                // alert('Hallo');
                t_id = [];
                showAssign(t_id);
            }
            $(this).data("clicks", !clicks);

        });


    });

    function getValues() {
        return t_id;
    }

    $(".closemodal, .no").click(function () {
        $("#myModal").css("display", "none");
    });

    $(".closemodal, .no").click(function () {
        $("#myModal").css("display", "none");
    });

    $('.yes').click(function () {
        var values = getValues();
        if (values == "") {
            $("#myModal").css("display", "none");
        } else {
            $("#myModal").css("display", "none");
            if(c_status != 'hard-delete'){
                var url = '{{url("ticket/change-status/")}}/'+values+'/'+c_status;
                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: "html",
                    data: $(this).serialize(),
                    beforeSend: function() {
                        $("#hidespin").hide();
                        $("#spin").show();
                        $("#hide2").hide();
                        $("#show2").show();
                    },
                    success: function(response) {
                    $("#hide2").show();
                    $("#show2").hide();
                    $("#hidespin").show();
                    $("#spin").hide();
                    location.reload();
                    },
                    error: function(response) {
                    }
                })
                return false;
            } else{
                $("#modalpopup").unbind('submit');
                submit_form = 1;
                $('#hard-delete').click();
            }
        }
    });


    function changeStatus(id, name) {
        $('#myModalLabel').html('{{Lang::get("lang.change-ticket-status-to")}}'+name);
        var msg = "{{Lang::get('lang.confirm-to-proceed')}}";
        var values = getValues();
        if (values == "") {
            msg = "{{Lang::get('lang.select-ticket')}}";
            $('.yes').html("{{Lang::get('lang.ok')}}");
            $('#myModalLabel').html("{{Lang::get('lang.alert')}}");
        } else {
            c_status = id;
            $('.yes').html("Yes");
        }
        $('#custom-alert-body').html(msg);
        $("#myModal").css("display", "block");
    }

    $(document).ready(function () { /// Wait till page is loaded
        $('#click').click(function () {
            $('#refresh').load('inbox #refresh');
            $('#title_refresh').load('inbox #title_refresh');
            $('#count_refresh').load('inbox #count_refresh');
            $("#show").show();
        });

        //checking merging tickets
        $('#MergeTickets').on('show.bs.modal', function () {

            // alert("hi");
            $.ajax({
                type: "GET",
                url: "{{route('check.merge.tickets',0)}}",
                dataType: "html",
                data: {data1: t_id},
                beforeSend: function () {
                    $("#merge_body").hide();
                    $("#merge_loader").show();
                },
                success: function (response) {
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
                        $.ajax({
                            url: "{{ route('get.merge.tickets',0) }}",
                            dataType: "html",
                            data: {data1: t_id},
                            success: function (data) {
                                $("#merge_body").show();
                                $("#merge-body-alert").hide();
                                $("#merge-body-form").show();
                                $("#merge_loader").hide();
                                $("#merge-btn").attr('disabled', false);
                                $("#merge_loader").hide();
                                $('#select-merge-parent').html(data);
                            }
                            // return false;
                        });
                    }
                }
            });
        });

        //submit merging form
        $('#merge-form').on('submit', function () {
            $.ajax({
                type: "POST",
                url: "{!! url('merge-tickets/') !!}/" + t_id,
                dataType: "json",
                data: $(this).serialize(),
                beforeSend: function () {
                    $("#merge_body").hide();
                    $("#merge_loader").show();
                },
                success: function (response) {
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
                        setTimeout(function () {
                            $("#alert11").hide();
                            location.reload();
                        }, 1000);
                    }
                }
            })
            return false;
        });
        
        $('#AssignTickets').on('show.bs.modal', function() {
            $.ajax({
                type: "POST",
                url: "{{route('get-agents')}}",
                dataType: "html",
                beforeSend: function() {
                    $("#assign_body").hide();
                    $("#assign_loader").show();
                },
                success: function(data) {
                    $("#assign_loader").hide();
                    $("#assign_body").show();
                    $('#select-assign-agent').html(data);
                }
            });
        });

        

        $('#assign-form').on('submit', function() {
            $.ajax({
                type: "PATCH",
                url: "{{url('ticket/assign')}}",
                dataType: "html",
                data: $(this).serialize()+'&ticket_id='+t_id,
                beforeSend: function() {
                $("#assign_body").hide();
                    $("#assign_loader").show();
                },
                success: function(response) {
                    if (response == 1)
                    {
                        location.reload();
                        var message = "Success!";
                            $("#alert11").show();
                            $('#message-success1').html(message);
                            setInterval(function(){$("#dismiss11").trigger("click"); }, 2000);
                    }
                    $("#assign_body").show();
                    $("#assign_loader").hide();
                    $("#dismis4").trigger("click");
                }
            })
            return false;
        });

        var date_options = '<option value="any-time">{{Lang::get("lang.any-time")}}</option><option value="5-minutes">{{Lang::get("lang.5-minutes")}}</option><option value="10-minutes">{{Lang::get("lang.10-minutes")}}</option><option value="15-minutes">{{Lang::get("lang.15-minutes")}}</option><option value="30-minutes">{{Lang::get("lang.30-minutes")}}</option><option value="1-hour">{{Lang::get("lang.1-hour")}}</option><option value="4-hours">{{Lang::get("lang.4-hours")}}</option><option value="8-hours">{{Lang::get("lang.8-hours")}}</option><option value="12-hours">{{Lang::get("lang.12-hours")}}</option><option value="24-hours">{{Lang::get("lang.24-hours")}}</option><option value="today">{{Lang::get("lang.today")}}</option><option value="yesterday">{{Lang::get("lang.yesterday")}}</option><option value="this-week">{{Lang::get("lang.this-week")}}</option><option value="last-week">{{Lang::get("lang.last-week")}}</option><option value="15-days">{{Lang::get("lang.15-days")}}</option><option value="30-days">{{Lang::get("lang.30-days")}}</option><option value="this-month">{{Lang::get("lang.this-month")}}</option><option value="last-month">{{Lang::get("lang.last-month")}}</option><option value="last-2-months">{{Lang::get("lang.last-2-months")}}</option><option value="last-3-months">{{Lang::get("lang.last-3-months")}}</option><option value="last-6-months">{{Lang::get("lang.last-6-months")}}</option><option value="last-year">{{Lang::get("lang.last-year")}}</option>';
        $('#modified, #created').append(date_options);
        $('#modified, #created').trigger("change"); 

        var create_dropdown = $("#created").select2({maximumSelectionLength : 1});
        valueSelected(create_dropdown);
        var update_dropdown = $("#modified").select2({maximumSelectionLength : 1});
        valueSelected(update_dropdown);
        var due_dropdown = $("#due-on-filter").select2({maximumSelectionLength : 1});
        valueSelected(due_dropdown);
        var assign_dropdown = $("#assigned-filter").select2({maximumSelectionLength : 1});
        valueSelected(assign_dropdown);
        var response_dropdown = $('#response-filter').select2({maximumSelectionLength : 1});
        valueSelected(response_dropdown);
        $('.select2-selection').css('border-radius','0px');
        $('.select2-selection').css('border-color','#D2D6DE')
        $('.select2-container').children().css('border-radius','0px');

        @if(array_key_exists('assigned', $inputs))
            assign_dropdown.val(JSON.parse('<?= json_encode($inputs["assigned"])?>')).trigger("change");
            if(JSON.parse('<?= json_encode($inputs["assigned"])?>') == '1' || JSON.parse('<?= json_encode($inputs["assigned"])?>') == 1) {
            }
        @endif

        @if(array_key_exists('created', $inputs))
            create_dropdown.val(JSON.parse('<?= json_encode($inputs["created"])?>')).trigger("change");
        @endif

        @if(array_key_exists('updated', $inputs))
            update_dropdown.val(JSON.parse('<?= json_encode($inputs["updated"])?>')).trigger("change");
        @endif

        @if(array_key_exists('due-on', $inputs))
            due_dropdown.val(JSON.parse('<?= json_encode($inputs["due-on"])?>')).trigger("change");
        @endif

        @if(array_key_exists('last-response-by', $inputs))
            response_dropdown.val(JSON.parse('<?= json_encode($inputs["last-response-by"])?>')).trigger("change");
        @endif

        $('#resetFilter').on("click", function (){ 
            $('.filter, #assigned-to-filter, #departments-filter, #sla-filter, #priority-filter, #source-filter').val(null).trigger("change"); 
            clearlist += 1;
            clearfilterlist();
        });
    });

    function someFunction(id) {
        if (document.getElementById(id).checked) {
            t_id.push(id);
            // alert(t_id);
        } else if (document.getElementById(id).checked === undefined) {
            var index = t_id.indexOf(id);
            if (index === -1) {
                t_id.push(id);
            } else {
                t_id.splice(index, 1);
            }
        } else {
            var index = t_id.indexOf(id);
            t_id.splice(index, 1);
            // alert(t_id);
        }
        showAssign(t_id);
    }

    function showAssign(t_id)
    {
        if (t_id.length >= 1) {
            $('#assign_Ticket').css('display', 'inline');
        } else {
            $('#assign_Ticket').css('display', 'none');
        }
    }

    function showhidefilter()
    {
        if (filterClick == 0) {
            $('#filterBox').css('display', 'block');
            filterClick += 1;
        } else {
            $('#filterBox').css('display', 'none');
            filterClick = 0;
        }
    }

    function removeEmptyValues()
    {
        $(':input[value=""]').attr('disabled', true);
    }
 
</script>
@include('themes.default1.agent.helpdesk.selectlists.selectlistjavascript')
<script type="text/javascript">
    var $dept_list = $( "#departments-filter" ).addSelectlist({maximumSelectionLength : 5});
    valueSelected($dept_list);
    @if(array_key_exists('departments', $inputs))
        addFilters($dept_list, '<?= json_encode($inputs["departments"])?>');
    @endif

    var $sla_list = $( "#sla-filter" ).addSelectlist({maximumSelectionLength : 5});
    valueSelected($sla_list);
    @if(array_key_exists('sla', $inputs))
        addFilters($sla_list, '<?= json_encode($inputs["sla"])?>');
    @endif

    var $priority_list = $( "#priority-filter" ).addSelectlist({maximumSelectionLength : 5});
    valueSelected($priority_list);
    @if(array_key_exists('priority', $inputs))
        addFilters($priority_list, '<?= json_encode($inputs["priority"])?>');
    @endif

    var $labels_list = $( "#labels-filter" ).addSelectlist({maximumSelectionLength : 5});
    valueSelected($labels_list);
    @if(array_key_exists('labels', $inputs))
        addFilters($labels_list, '<?= json_encode($inputs["labels"])?>');
    @endif

    var $tags_list = $( "#tags-filter" ).addSelectlist({maximumSelectionLength : 5});
    valueSelected($tags_list);
    @if(array_key_exists('tags', $inputs))
        addFilters($tags_list, '<?= json_encode($inputs["tags"])?>');
    @endif

    var $owner_list = $( "#owner-filter" ).addSelectlist({maximumSelectionLength : 5});
    valueSelected($owner_list);
    @if(array_key_exists('created-by', $inputs))
        filteredUsersList($owner_list, '<?= json_encode($inputs["created-by"])?>');
    @endif

    var $assignee_list = $( "#assigned-to-filter" ).addSelectlist({maximumSelectionLength : 5});
    valueSelected($assignee_list);
    @if(array_key_exists('assigned-to', $inputs))
        filteredUsersList($assignee_list, '<?= json_encode($inputs["assigned-to"])?>')
    @endif

    var $status_list = $( "#status-filter" ).addSelectlist({maximumSelectionLength : 5});
    valueSelected($status_list);
    @if(array_key_exists('status', $inputs))
        addFilters($status_list, '<?= json_encode($inputs["status"])?>');
    @endif

    var $source_list = $( "#source-filter" ).addSelectlist({maximumSelectionLength : 5});
    valueSelected($source_list);
    @if(array_key_exists('source', $inputs))
        addFilters($source_list, '<?= json_encode($inputs["source"])?>');
    @endif

    var $type_list = $( "#type-filter" ).addSelectlist({maximumSelectionLength : 5});
    valueSelected($type_list);
    @if(array_key_exists('types', $inputs))
        addFilters($type_list, '<?= json_encode($inputs["types"])?>');
    @endif

    var $number_list = $( "#ticket-number" ).addSelectlist({maximumSelectionLength : 5});
    valueSelected($number_list);
    @if(array_key_exists('ticket-number', $inputs))
        var input = JSON.parse('<?= json_encode($inputs["ticket-number"])?>');
        var $request = $.ajax({
            url: "{{URL::route('get-filtered-ticket-numbers')}}",
            dataType: 'html',
            data: {name:input},
            type: "GET",
        });

        $request.then(function (data) {
            data = JSON.parse(data);
            // This assumes that the data comes back as an array of data objects
            // The idea is that you are using the same callback as the old `initSelection`
            for (var d = 0; d < data.length; d++) {
                var item = data[d];
                // Create the DOM option that is pre-selected by default
                var option = new Option(item.text, item.id, true, true);
                // Append it to the select
                $number_list.append(option);
            }
            // Update the selected options that are displayed
            $number_list.trigger('change');
        });
    @endif

    function addFilters($element, $data){
        var obj = JSON.parse($data);
        if (obj.length > 0) {
            for (var d = 0; d < obj.length; d++) {
                var option = new Option(obj[d], obj[d], true, true);
                $element.append(option);
            }
            $element.trigger('change');
        }
    }

    function clearfilterlist() {
        $dept_list.val(null).trigger("change");
        $sla_list.val(null).trigger("change");
        $priority_list.val(null).trigger("change");
        $source_list.val(null).trigger("change");
        $owner_list.val(null).trigger("change");
        $status_list.val(null).trigger("change");
        $assignee_list.val(null).trigger("change");
        $labels_list.val(null).trigger("change");
        $tags_list.val(null).trigger("change");
        $type_list.val(null).trigger("change");
        $number_list.val(null).trigger("change");
    }

    function valueSelected($obj) {
        $obj.on("select2:select", function (e) { clearlist = 0; });
    }

    $('#filter-form').on('submit', function(e){
        if(clearlist > 0) {
            $('#departments-filter, #sla-filter, #priority-filter, #source-filter, #owner-filter, #status-filter, #assigned-filter, #assigned-to-filter, #labels-filter, #tags-filter, #type-filter, #due-on-filter, #created, #modified, #ticket-number').remove();
            $(this).children();
        }
    });

    function filteredUsersList($element, $data) { 
        var input = JSON.parse($data);
        var $request = $.ajax({
            url: "{{URL::route('api-get-assignees-2')}}",
            dataType: 'html',
            data: {name:input},
            type: "GET",
        });

        $request.then(function (data) {
            data = JSON.parse(data);
            // This assumes that the data comes back as an array of data objects
            // The idea is that you are using the same callback as the old `initSelection`
            for (var d = 0; d < data.length; d++) {
                var item = data[d];
                // Create the DOM option that is pre-selected by default
                var option = new Option(item.text, item.id, true, true);
                // Append it to the select
                $element.append(option);
            }
            // Update the selected options that are displayed
            $element.trigger('change');
        });
    }

    $('#modalpopup').on('submit', function(e){
        if(submit_form == 0) {
            e.preventDefault();
            changeStatus('hard-delete', '{{Lang::get("lang.clean-")}}');
        }
        $('#hard-delete').val('Delete forever')
    })
</script>
@stop