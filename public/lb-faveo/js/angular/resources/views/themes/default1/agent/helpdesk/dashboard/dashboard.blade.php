@extends('themes.default1.agent.layout.agent')

@section('Dashboard')
class="active"
@stop

@section('dashboard-bar')
active
@stop

@section('PageHeader')
<h1>{!! Lang::get('lang.dashboard_reports') !!}</h1>
@stop

@section('dashboard')
class="active"
@stop

@section('content')
<!-- check whether success or not -->
{{-- Success message --}}
@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <i class="fa  fa-check-circle"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('success')}}
</div>
@endif
{{-- failure message --}}
@if(Session::has('fails'))
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <b>{!! Lang::get('lang.alert') !!}!</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('fails')}}
</div>
@endif
<link type="text/css" href="{{asset("lb-faveo/css/bootstrap-datetimepicker4.7.14.min.css")}}" rel="stylesheet">
{{-- <script src="{{asset("lb-faveo/dist/js/bootstrap-datetimepicker4.7.14.min.js")}}" type="text/javascript"></script> --}}
<div class="row">
    <!-- <div class="col-md-3 col-sm-6 col-xs-12"> -->
    <div class="col-md-2" style="width:20%;">
        <a href="{!! url('/tickets?show=inbox') !!}">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{!! Lang::get('lang.inbox') !!}</span>
                    <span class="info-box-number"><?php echo $tickets->count() ?> <small> {!! Lang::get('lang.tickets') !!}</small></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </a>
    </div><!-- /.col -->
    <!-- <div class="col-md-3 col-sm-6 col-xs-12"> -->
    <div class="col-md-2" style="width:20%;">
        <a href="{!! url('/tickets?assigned[]=0') !!}">
            <div class="info-box">
                <span class="info-box-icon bg-orange"><i class="fa fa-user-times"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{!! Lang::get('lang.unassigned') !!}</span>
                    <span class="info-box-number">{{$unassigned->count() }} <small> {!! Lang::get('lang.tickets') !!}</small></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </a>
    </div><!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <!-- <div class="col-md-3 col-sm-6 col-xs-12"> -->
    <div class="col-md-2" style="width:20%;">
        <a href="{!! url('/tickets?show=overdue') !!}">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-calendar-times-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{!! Lang::get('lang.overdue') !!}</span>
                    <span class="info-box-number">{{ $overdues->count() }} <small> {!! Lang::get('lang.tickets') !!}</small></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </a>
    </div><!-- /.col -->
    <!-- <div class="col-md-3 col-sm-6 col-xs-12"> -->
    <div class="col-md-2" style="width:20%;">
        <a href="{!! url('/tickets?show=mytickets') !!}">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{!! Lang::get('lang.my_tickets') !!}</span>
                    <span class="info-box-number">{{$myticket->count() }} <small> {!! Lang::get('lang.tickets') !!}</small></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </a>
    </div><!-- /.col -->


     <div class="col-md-2" style="width:20%;">
        <a href="{!! url('/tickets?due-on=today') !!}">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="glyphicon glyphicon-eye-open"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{!! Lang::get('lang.duetoday') !!}</span>
                    <span class="info-box-number">{{ $due_today->count() }} <small> Tickets</small></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </a>
          <!-- /.info-box -->
        </div>

</div>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.report') !!}</h3>
    </div>
    <div class="box-body">
        <form id="filter">
            <div  class="form-group">
                <div class="row">
                    <div class='col-sm-2'>
                        {!! Form::label('date', 'Start Date:',['class' => 'lead']) !!}
                        {!! Form::text('start_date',null,['class'=>'form-control','id'=>'datepicker4', 'placeholder' => 'YYYY/mm/dd'])!!}
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
                    
                    <div class='col-sm-2'>
                        {!! Form::label('start_time', 'End Date:' ,['class' => 'lead']) !!}
                        {!! Form::text('end_date',null,['class'=>'form-control','id'=>'datetimepicker3', 'placeholder' => 'YYYY/mm/dd'])!!}
                    </div>
                    <script type="text/javascript">
                        $(function () {
                            $('#datepicker4, #datetimepicker3').on('focus', function(){
                                $('.col-sm-2').removeClass('has-error');
                            });
                            $('#datepicker4, #datetimepicker3').keypress(function (e) {
                                var regex = new RegExp("^[0-9-/]+$");
                                var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                                if (regex.test(str)) {
                                    return true;
                                }

                                e.preventDefault();
                                return false;
                            });

                            var timestring1 = "{!! $start_date !!}";
                            var timestring2 = "{!! date('Y-m-d') !!}";
                            $('#datepicker4').datetimepicker({
                                format: 'YYYY/MM/DD',
                                maxDate: moment(timestring2).startOf('day'),

                            });
                            $('#datetimepicker3').datetimepicker({
                                format: 'YYYY/MM/DD',
                                useCurrent: false, //Important! See issue #1075
                                maxDate: moment(timestring2).startOf('day')
                            });

                            $("#datepicker4").on("dp.change", function (e) {
                                $('#datetimepicker3').data("DateTimePicker").minDate(e.date).maxDate(moment(timestring2).startOf('day'));
                            });
                            $("#datetimepicker3").on("dp.change", function (e) {
                                $('#datepicker4').data("DateTimePicker").maxDate(e.date);
                            });
                        });
                    </script>
                    <div class='col-sm-1'>
                        {!! Form::label('filter', 'Filter:',['class' => 'lead']) !!}<br>
                        <button class="btn btn-primary" id="filter-form">Submit</button>
                    </div>
                </div>
                <div class="row">
                    <style>
                        #legend-holder { border: 1px solid #ccc; float: left; width: 25px; height: 25px; margin: 1px; }
                    </style>
                    <div class="col-md-3"><span id="legend-holder" style="background-color: #6C96DF;"></span>&nbsp; <span class="lead"> <span id="total-created-tickets" ></span> {!! Lang::get('lang.tickets') !!} {!! Lang::get('lang.created') !!}</span></div> 
                    <div class="col-md-3"><span id="legend-holder" style="background-color: #6DC5B2;"></span>&nbsp; <span class="lead"> <span id="total-reopen-tickets" class="lead"></span> {!! Lang::get('lang.tickets') !!} {!! Lang::get('lang.reopen') !!}</span></div> 
                    <div class="col-md-3"><span id="legend-holder" style="background-color: #E3B870;"></span>&nbsp; <span class="lead"> <span id="total-closed-tickets" class="lead"></span> {!! Lang::get('lang.tickets') !!} {!! Lang::get('lang.closed') !!}</span></div> 
                    <div class="col-md-3"><span id="legend-holder" style="background-color: #A3B952;"></span>&nbsp; <span class="lead"> <span id="total-due-tickets" class="lead"></span> {!! Lang::get('lang.tickets') !!} {!! Lang::get('lang.due') !!}</span></div> 
                </div>
            </div>
            <div class="row" id="no-data-msg" style="display: none">
                <center><h4><span style="color: red">{{Lang::get('lang.invalid-date-range')}}</span></h4></center>
            </div>
        </form>
        <!--<div id="legendDiv"></div>-->
        <div class="chart">
            <canvas class="chart-data" id="tickets-graph" width="1000" height="250"></canvas>   
        </div>
        <div class="overlay" id='show-report-loader'>
            <i class="fa ion ion-load-d fa-spin"></i>
            <center><p>{{Lang::get('lang.please-wait-while-we-are-crunching-your-data')}}</p></center>
        </div>
    </div><!-- /.box-body -->
   
</div><!-- /.box -->

<!-- statics -->
<div class="box box-info">
    <div class="box-header with-border  ">
        <h1 class="box-title">{!! Lang::get('lang.statistics') !!}</h1>
    </div>
    <div class="box-body" id="department-statics">
        <ul class="nav nav-tabs" >
            <li class="active"><a href="#tab_1" id="departments" data-toggle="tab" onclick="pushData('departments')">{!! Lang::get('lang.departments') !!}</a></li>
            <li><a href="#tab_2" id="agents" data-toggle="agents" onclick="pushData('agents')">{!! Lang::get('lang.agents') !!}</a></li>
            <li><a href="#tab_3" id="teams" data-toggle="teams" onclick="pushData('teams')">{!! Lang::get('lang.teams') !!}</a></li>
        </ul>
        <br/>
        <div id="table-display">
            <table class="table table-hover table-bordered" id="myTable"></table>
        </div>
        <center><div id="no-data-table" style="display: none">{{Lang::get('lang.no-data-to-show')}}</div></center>
    </div>
    <div class="overlay" id='show-static-loader'>
        <i class="fa ion ion-load-d fa-spin"></i>
        <center><p>{{Lang::get('lang.please-wait-while-we-are-crunching-your-data')}}</p></center>
    </div>
</div>
@stop
@section('FooterInclude')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.js"></script>
<script src="{{asset("lb-faveo/plugins/moment-develop/moment.js")}}" type="text/javascript"></script>
<script src="{{asset("lb-faveo/js/bootstrap-datetimepicker4.7.14.min.js")}}" type="text/javascript"></script>
<script>
    var options_bar = {
        maintainAspectRatio: true,
        responsive: true,
        legend: {
            display: false
        },
    };

    var tcolumn = 'departments';
    var tstart  = '';
    var tend    = '';
    
    thisAjax();
    
    tableAjax(setTableDataOption(tcolumn, tstart, tend));
    
    function thisAjax(data="") {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('agen')}}",
            data:data,
            beforeSend: function() {
                $("#show-report-loader").css('display', 'block');
            },
            success: function (data) {
                $("#show-report-loader").css('display', 'none');
                var ctx = $("#tickets-graph").get(0).getContext("2d");
                var myBarChart = new Chart(ctx,
                {
                    type: 'line',
                    data: data.data,
                    options: options_bar
                });
                var open = data.count.open;
                var closed = data.count.closed;
                var reopen = data.count.reopened;
                var due = data.count.due;
                $("#total-created-tickets").html(open);
                $("#total-closed-tickets").html(closed);
                $("#total-reopen-tickets").html(reopen);
                $("#total-due-tickets").html(due);
            },
            error: function (error) {
                $("#show-report-loader").css('display', 'none');
                $('#no-data-msg').css('display', 'block');
                setTimeout(function(){ 
                    $('#no-data-msg').css('display', 'none');
                }, 5000);
            }
        });
    }

    $("#filter-form").on('click',function(event){
        if ($('#datetimepicker3').val() == '' || $('#datepicker4').val() == '') {
            $('.col-sm-2').addClass('has-error');
            $('#no-data-msg').css('display', 'block');
                setTimeout(function(){ 
                    $('#no-data-msg').css('display', 'none');
            }, 5000);
            alert('{{Lang::get("lang.please-select-a-valid-date-range")}}');
        } else {
            event.preventDefault();
            var data = $("#filter").serialize();
            thisAjax(data);
            var data2 = $("#filter").serializeArray();
            tstart = data2[0].value;
            tend = data2[1].value;
            $("#myTable").dataTable().fnDestroy();
            tableAjax(setTableDataOption(tcolumn, tstart, tend));
        }
    });

    function tableAjax(data="") {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('dashboard/getDepartment')}}",
            data:data,
            beforeSend: function() {
                $('#show-static-loader').css('display', 'block');
            },
            success: function (json) {
                var table = "";
                var thead = "<thead><tr><th>{{Lang::get('lang.name')}}</th>";
                var thead_array = [];
                var prev_name = '';
                var trow = '';
                if (json.length > 0) {
                    for (var i = 0; i < json.length; i++) {
                        if (prev_name == '') {
                            trow = '<tr><td>'+json[i].name+'</td><td>'+json[i].count+'</td></tr>';
                            thead += '<th>'+json[i].status+'</th>';
                            prev_name = json[i].name;
                            thead_array.push(json[i].status);
                        } else if (prev_name != '' && prev_name != json[i].name) {
                            table = table+trow;
                            trow = '';
                            prev_name = json[i].name;
                            if(!isAlreeadyInThead(thead, json[i].status)) {
                                thead += '<th>'+json[i].status+'</th>';
                                table = table.replaceAll_1('</tr>', '<td>0</td></tr>');
                                trow = '<tr><td>'+json[i].name+'</td>'+addEmptyCells(thead_array.length)+'<td>'+json[i].count+'</td></tr>';
                                thead_array.push(json[i].status);
                            } else {
                                trow = '<tr><td>'+json[i].name+'</td>'+addEmptyCells(thead_array.indexOf(json[i].status))+'<td>'+json[i].count+'</td>'+addEmptyCells(thead_array.length - (thead_array.indexOf(json[i].status)+1))+'</tr>';
                            }                
                        } else if (prev_name != '' && prev_name == json[i].name) {
                            if(!isAlreeadyInThead(thead, json[i].status)) {
                                thead += '<th>'+json[i].status+'</th>';
                                thead_array.push(json[i].status);
                                table = table.replaceAll_1('</tr>', '<td>0</td></tr>');
                                trow = trow.replace('</tr>', '<td>'+json[i].count+'</td></tr>')
                            } else {
                                trow = editRow(trow, thead_array.length, thead_array.indexOf(json[i].status), json[i].count);
                            }
                        }
                    }
                    table = table+trow;
                    table = thead+'</thead><tbody>'+table+'</tbody>';
                    $('#myTable').html(table);
                    formatTable();
                    $('#table-display').css('display', 'block');
                    $('#no-data-table').css('display', 'none');
                    $('#show-static-loader').css('display', 'none');
                } else {
                    $('#show-static-loader').css('display', 'none');
                    $('#table-display').css('display', 'none');
                    $('#no-data-table').css('display', 'block');
                }
            }
        });
    } 

    function isAlreeadyInThead(thead, value) {
        if (thead.search(value) == -1)  {
            return false;
        }
        return true;
    }

    function formatTable() {
        jQuery('#myTable').dataTable({});            
    }

    function addEmptyCells(times) {
        var str = '';
        for (var i =0; i < times; i++) {
            str += '<td>0</td>';
        }
        return str;
    }

    function editRow(str, length, index, value){
        res = str.split("</td>");
        res[index+1]="<td>"+value;
        str = res.join("</td>");
        return str;
    }

    String.prototype.replaceAll_1 = function(search, replacement) {
        var target = this;
        return target.replace(new RegExp(search, 'g'), replacement);
    };

    function pushData(id) {
        dates = getSetDates();
        $("#myTable").dataTable().fnDestroy();
        $('.active').removeClass('active');
        $('#'+id).parent('li').addClass('active');
        tableAjax(setTableDataOption(id, dates[0], dates[1]));
    }

    function setTableDataOption(column, start_date, end_date) {
        tableData = {'column': column, 'start_date': start_date, 'end_date': end_date};
        tcolumn = column;
        tstart = start_date;
        tend = end_date;
        return tableData;
    }

    function getSetDates() {
        return [tstart, tend];
    }
</script>
@stop