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

<link type="text/css" href="{{asset("lb-faveo/css/bootstrap-datetimepicker4.7.14.min.css")}}" rel="stylesheet">
{{-- <script src="{{asset("lb-faveo/dist/js/bootstrap-datetimepicker4.7.14.min.js")}}" type="text/javascript"></script> --}}
<div class="row">
    <?php
    if (Auth::user()->role == 'admin') {
//$inbox = App\Model\helpdesk\Ticket\Tickets::all();
        $myticket = App\Model\helpdesk\Ticket\Tickets::where('assigned_to', Auth::user()->id)->where('status', '1')->get();
        $unassigned = App\Model\helpdesk\Ticket\Tickets::where('assigned_to', '=', null)->where('status', '=', '1')->get();
        $tickets = App\Model\helpdesk\Ticket\Tickets::where('status', '1')->get();
        $deleted = App\Model\helpdesk\Ticket\Tickets::where('status', '5')->get();
    } elseif (Auth::user()->role == 'agent') {
//$inbox = App\Model\helpdesk\Ticket\Tickets::where('dept_id','',Auth::user()->primary_dpt)->get();
        $myticket = App\Model\helpdesk\Ticket\Tickets::where('assigned_to', Auth::user()->id)->where('status', '1')->get();
        $unassigned = App\Model\helpdesk\Ticket\Tickets::where('assigned_to', '=', null)->where('status', '=', '1')->where('dept_id', '=', Auth::user()->primary_dpt)->get();
        $tickets = App\Model\helpdesk\Ticket\Tickets::where('status', '1')->where('dept_id', '=', Auth::user()->primary_dpt)->get();
        $deleted = App\Model\helpdesk\Ticket\Tickets::where('status', '5')->where('dept_id', '=', Auth::user())->get();
    }
    if (Auth::user()->role == 'agent') {
        $dept = App\Model\helpdesk\Agent\Department::where('id', '=', Auth::user()->primary_dpt)->first();
        $overdues = App\Model\helpdesk\Ticket\Tickets::where('status', '=', 1)->where('isanswered', '=', 0)->where('dept_id', '=', $dept->id)->orderBy('id', 'DESC')->get();
    } else {
        $overdues = App\Model\helpdesk\Ticket\Tickets::where('status', '=', 1)->where('isanswered', '=', 0)->orderBy('id', 'DESC')->get();
    }
    
    $i = count($overdues);
    if ($i == 0) {
        $overdue_ticket = 0;
    } else {
        $j = 0;
        foreach ($overdues as $overdue) {
            $sla_plan = App\Model\helpdesk\Manage\Sla_plan::where('id', '=', $overdue->sla)->first();

            $ovadate = $overdue->created_at;
            $new_date = date_add($ovadate, date_interval_create_from_date_string($sla_plan->grace_period)) . '<br/><br/>';
            if (date('Y-m-d H:i:s') > $new_date) {
                $j++;
                //$value[] = $overdue;
            }
        }
        // dd(count($value));
        if ($j > 0) {
            $overdue_ticket = $j;
        } else {
            $overdue_ticket = 0;
        }
    }
    ?>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="{!! route('inbox.ticket') !!}">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{!! Lang::get('lang.inbox') !!}</span>
                    <span class="info-box-number"><?php echo count($tickets); ?> <small> {!! Lang::get('lang.tickets') !!}</small></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </a>
    </div><!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="{!! route('unassigned') !!}">
            <div class="info-box">
                <span class="info-box-icon bg-orange"><i class="fa fa-user-times"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{!! Lang::get('lang.unassigned') !!}</span>
                    <span class="info-box-number">{{count($unassigned) }} <small> {!! Lang::get('lang.tickets') !!}</small></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </a>
    </div><!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="{!! route('overdue.ticket') !!}">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-calendar-times-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{!! Lang::get('lang.overdue') !!}</span>
                    <span class="info-box-number">{{ $overdue_ticket }} <small> Tickets</small></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </a>
    </div><!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="{!! route('myticket.ticket') !!}">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{!! Lang::get('lang.my_tickets') !!}</span>
                    <span class="info-box-number">{{count($myticket) }} <small> Tickets</small></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </a>
    </div><!-- /.col -->

</div>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.report') !!}</h3>
    </div>
    <div class="box-body">
        <form id="foo">
            <div  class="form-group">
                <div class="row">
                    <div class='col-sm-2'>
                        {!! Form::label('date', 'Date:') !!}
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
                    <div class='col-sm-2'>
                        {!! Form::label('start_time', 'End Date:') !!}
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
                        {!! Form::label('filter', 'Filter:') !!}<br>
                        <input type="submit" class="btn btn-primary">
                    </div>
                    <div class="col-sm-6">
                        <label>{!! Lang::get('lang.Legend') !!}:</label>
                        <div class="row">
                            <style>
                                #legend-holder { border: 2px solid #ccc; float: left; width: 25px; height: 15px; margin: 2px; }
                            </style>
                            <div class="col-md-4"><span id="legend-holder" style="background-color: #6C96DF;"> </span> {!! Lang::get('lang.created') !!} {!! Lang::get('lang.tickets') !!}</div>
                            <div class="col-md-4"><span id="legend-holder" style="background-color: #6DC5B2;"> </span> {!! Lang::get('lang.reopen') !!} {!! Lang::get('lang.tickets') !!}</div>
                            <div class="col-md-4"><span id="legend-holder" style="background-color: #E3B870;"> </span> {!! Lang::get('lang.closed') !!} {!! Lang::get('lang.tickets') !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--<div id="legendDiv"></div>-->
        <div class="chart">
            <canvas class="chart-data" id="tickets-graph" width="1000" height="250"></canvas>   
        </div>
    </div><!-- /.box-body -->
</div><!-- /.box -->
<div class="box">
    <div class="box-header with-border  ">
        <h1 class="box-title">{!! Lang::get('lang.statistics') !!}</h1>
    </div>
    <div class="box-body">
        <table class="table table-hover table-bordered">
            <tr>
                <th>{!! Lang::get('lang.department') !!}</th>
                <th>{!! Lang::get('lang.opened') !!}</th>
                <th>{!! Lang::get('lang.resolved') !!}</th>
                <th>{!! Lang::get('lang.closed') !!}</th>
                <th>{!! Lang::get('lang.deleted') !!}</th>
            </tr>

            <?php $departments = App\Model\helpdesk\Agent\Department::all(); ?>
            @foreach($departments as $department)
            <?php
            $open = App\Model\helpdesk\Ticket\Tickets::where('dept_id', '=', $department->id)->where('status', '=', 1)->count();
            $resolve = App\Model\helpdesk\Ticket\Tickets::where('dept_id', '=', $department->id)->where('status', '=', 2)->count();
            $close = App\Model\helpdesk\Ticket\Tickets::where('dept_id', '=', $department->id)->where('status', '=', 3)->count();
            $delete = App\Model\helpdesk\Ticket\Tickets::where('dept_id', '=', $department->id)->where('status', '=', 5)->count();
            ?>
            <tr>
                <td>{!! $department->name !!}</td>
                <td>{!! $open !!}</td>
                <td>{!! $resolve !!}</td>
                <td>{!! $close !!}</td>
                <td>{!! $delete !!}</td>
            </tr>
            @endforeach 
        </table>
    </div>
</div>
<div id="refresh"> 
    <script src="{{asset("lb-faveo/plugins/chartjs/Chart.min.js")}}" type="text/javascript"></script>
</div>
<script src="{{asset("lb-faveo/plugins/chartjs/Chart.min.js")}}" type="text/javascript"></script>
<script type="text/javascript">
                        $(document).ready(function() {
                            $.getJSON("agen", function(result) {
                                var labels = [], open = [], closed = [], reopened = [];
                                //,data2=[],data3=[],data4=[];
                                for (var i = 0; i < result.length; i++) {
                                    // $var12 = result[i].day;
                                    // labels.push($var12);
                                    labels.push(result[i].date);
                                    open.push(result[i].open);
                                    closed.push(result[i].closed);
                                    reopened.push(result[i].reopened);
                                    // data4.push(result[i].open);
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
                                document.getElementById("legendDiv").innerHTML = myLineChart.generateLegend();
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
                                //$('#foo').serialize();
                                // process the form
                                $.ajax({
                                    type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                                    url: 'chart-range/' + dateData + '/' + formData, // the url where we want to POST
                                    data: formData, // our data object
                                    dataType: 'json', // what type of data do we expect back from the server

                                    success: function(result2) {
                                        //  $.getJSON("agen", function (result) {
                                        var labels = [], open = [], closed = [], reopened = [];
                                        //,data2=[],data3=[],data4=[];
                                        for (var i = 0; i < result2.length; i++) {
                                            // $var12 = result[i].day;
                                            // labels.push($var12);
                                            labels.push(result2[i].date);
                                            open.push(result2[i].open);
                                            closed.push(result2[i].closed);
                                            reopened.push(result2[i].reopened);
                                            // data4.push(result[i].open);
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
                                                // ,{
                                                //       label : "Reopened Tickets",
                                                //         fillColor : "rgba(102,255,51,0.2)",
                                                //       strokeColor : "rgba(151,187,205,1)",
                                                //        pointColor : "rgba(46,184,0,1)",
                                                //         pointStrokeColor : "#fff",
                                                //         pointHighlightFill : "#fff",
                                                //         pointHighlightStroke : "rgba(151,187,205,1)",
                                                //        data : data3
                                                //     }
                                            ]
                                        };

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
                                        $(".chart").html("<canvas id='tickets-graph' width='1000' height='250'></canvas>");
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
                                        document.getElementById("legendDiv").innerHTML = myLineChart1.generateLegend();
                                    }
                                });
                                // using the done promise callback
                                // stop the form from submitting the normal way and refreshing the page
                                event.preventDefault();
                            });
                        });
</script>
<script type="text/javascript">
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
<script src="{{asset("lb-faveo/plugins/moment-develop/moment.js")}}" type="text/javascript"></script>
<script src="{{asset("lb-faveo/js/bootstrap-datetimepicker4.7.14.min.js")}}" type="text/javascript"></script>
@stop