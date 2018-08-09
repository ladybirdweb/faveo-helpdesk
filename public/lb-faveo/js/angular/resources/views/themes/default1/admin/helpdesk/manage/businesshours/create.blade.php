@extends('themes.default1.admin.layout.admin')

@section('Manage')
active
@stop

@section('manage-bar')
active
@stop

@section('business_hours')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{!! Lang::get('lang.business_hours') !!}</h1>
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
<style>
    .cursor-pointer { cursor: pointer;}
    /*.container {width: 750px !important;}*/
    .col-xs-2-custom {width: 9% !important;}
    .row.copyied-time-default {
        border:1px solid blue;
        margin-left:18%;width:73.5%;

    }
    .fa-trash-o{color:red;}

    /*.col-xs-2.minus-custom {float: right;}*/
    .fa-minus-circle::before {color: red;}
</style>
{!! Form::open(array('url' => route("sla.business.hours.store") , 'method' => 'post') )!!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.create') !!} {!! Lang::get('lang.business_hours') !!}</h3>
    </div>
    <div class="box-body">
        @if(Session::has('errors'))
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @if($errors->first('name'))
            <li class="error-message-padding">{!! $errors->first('name', ':message') !!}</li>
            @endif
            @if($errors->first('description'))
            <li class="error-message-padding">{!! $errors->first('description', ':message') !!}</li>
            @endif
            @if($errors->first('time_zone'))
            <li class="error-message-padding">{!! $errors->first('time_zone', ':message') !!}</li>
            @endif

        </div>
        @endif
        @if(Session::has('fails2'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>Alert!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            <li class="error-message-padding">{!! Session::get('fails2') !!}</li>
        </div>
        @endif
        <div class="row">
            <!-- Name -->
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <div class="col-md-3">
                    {!! Form::label('name',Lang::get('lang.name')) !!} <span class="text-red"> *</span>
                </div>
                <div class="col-md-9">
                    {!! Form::text('name',null,['class' => 'form-control']) !!}
                </div>
            </div>
            <!-- Description -->
            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                <div class="col-md-3">
                    {!! Form::label('description',Lang::get('lang.description')) !!} <span class="text-red"> *</span>
                </div>
                <div class="col-md-9">
                    {!! Form::textarea('description',null,['class' => 'form-control','size' => '30x5']) !!}
                </div>
            </div>
            <!-- Time zone -->
             <div class="form-group {{ $errors->has('time_zone') ? 'has-error' : '' }}">
                <div class="col-md-3">
                    {!! Form::label('timezone',Lang::get('lang.timezone')) !!} <span class="text-red"> *</span>
                </div>
                <div class="col-md-9">
                    {!! Form::select('time_zone', [''=>Lang::get('lang.select_a_time_zone'),Lang::get('lang.time_zones')=>$timezones],null,['class' => 'form-control select']) !!}
                </div>
            </div> 
            <!-- Time zone -->
            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                <div class="col-md-3">
                    {!! Form::label('status',Lang::get('lang.status')) !!} <span class="text-red"> *</span>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-3">
                            {!! Form::radio('status', '1', true, ['id' => 'status']) !!} {{Lang::get('lang.active')}}
                        </div>
                        <div class="col-md-3">
                            {!! Form::radio('status', '0', false, ['id' => 'status']) !!} {{Lang::get('lang.inactive')}}
                        </div>
                    </div>
                    <br/>

                </div>
            </div>
            <!-- Time zone -->
            <div class="form-group {{ $errors->has('hours') ? 'has-error' : '' }}">
                <div class="col-md-3">
                    {!! Form::label('Hours',Lang::get('lang.hours')) !!} <span class="text-red"> *</span>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-xs-3">
                            {!! Form::radio('hours', '0', true, ['id' => 'custom_hours1']) !!} {{Lang::get('lang.247hours')}}
                        </div>
                        <div class="col-xs-3">
                            {!! Form::radio('hours', '1', false, ['id' => 'custom_hours2']) !!} {{Lang::get('lang.select_working_days/hours')}}
                        </div>
                    </div>
                    <div id="hide" style="display:none;">
                        <div class="box-header with-border">
                        </div>
                        <!-- title: text -->
                        <div class="box-body">
                            <div class="row">
                                <?php for ($i = 0; $i < 7; $i++) { ?>
                                    <div class="col-xs-2">
                                        <label class="col-sm-2">{!! Lang::get('lang.day'.$i) !!}</label>
                                    </div>
                                    <div class="col-xs-10">
                                        <div onclick="adddates(0, {!! $i !!})" class="btn btn-default btn-checkbox-custom6" id="custom_button0{!! $i !!}" style="width:30%;text-align:left;">
                                            <input type="radio" class="input-checkbox-custom6" name="type{!! $i !!}" id="type0{!! $i !!}" value="Open_custom">Open(Custom) 
                                            <span class="glyphicon glyphicon-hand-right pull-right">
                                                <span class="fa fa-plus-circle fa-lg cursor-pointer add-time-grid6"></span>
                                            </span>
                                        </div>&nbsp;

                                        <div onclick="adddates(1, {!! $i !!})" class="btn btn-default btn-checkbox-custom6" id="custom_button1{!! $i !!}" style="width:30%;text-align:left;">
                                            <input type="radio" class="input-checkbox-custom6" name="type{!! $i !!}" id="type1{!! $i !!}" value="Open_fixed">
                                            Open(24 Hours)
                                        </div>&nbsp;

                                        <div onclick="adddates(2, {!! $i !!})" class="btn btn-success btn-checkbox-custom6" id="custom_button2{!! $i !!}" style="width:30%;text-align:left;">
                                            <input type="radio" class="input-checkbox-custom6" name="type{!! $i !!}" id="type2{!! $i !!}" value="Closed" checked>
                                            Closed
                                        </div>&nbsp;
                                    </div>
                                    <br/><br/>
                                    <div id="addhere{!! $i !!}" style="padding-left:1%;"></div>
                                <?php } ?>
                            </div>
                        </div>      
                    </div> 
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group"> 
                <div class="col-md-3">
                    <label>{!! Lang::get('lang.yearly_holiday_list') !!}</label>
                    <p>
                        <span class="text-muted">{!! Lang::get('lang.holidays_will_be_ignored_when_calculating_SLA_for_a_ticket') !!}</span>
                    </p>
                </div>

                <div class="col-md-9">
                    <div class="box-body" id="welcomeDiv">
                        <table id="example2" class="table table-bordered table-striped">
                            <thead class="inputField">    
                                <tr>
                                    <td> 
                                        <div class="row form-group" id='show_date_error'>
                                            <div class="col-md-7">
                                                <select class="form-control" name="month" id="month">
                                                    <!-- <option>Select month</option> -->

                                                    <option value="">{!! Lang::get('lang.select_month') !!}</option>>
                                                    <option value="01">{!! Lang::get('lang.january') !!}</option>
                                                    <option value="02">{!! Lang::get('lang.february') !!}</option>
                                                    <option value="03">{!! Lang::get('lang.march') !!}</option>
                                                    <option value="04">{!! Lang::get('lang.april') !!}</option>
                                                    <option value="05">{!! Lang::get('lang.may') !!}</option>
                                                    <option value="06">{!! Lang::get('lang.june') !!}</option>
                                                    <option value="07">{!! Lang::get('lang.july') !!}</option>
                                                    <option value="08">{!! Lang::get('lang.august') !!}</option>
                                                    <option value="09">{!! Lang::get('lang.september') !!}</option>
                                                    <option value="10">{!! Lang::get('lang.october') !!}</option>
                                                    <option value="11">{!! Lang::get('lang.november') !!}</option>
                                                    <option value="12">{!! Lang::get('lang.december') !!}</option>
                                                </select>
                                                <b><div id="show_invalid" class="text-red">    
                                                    </div></b>
                                            </div>

                                            <div class="col-md-5">

                                                <select class="form-control" name="day" id="day">
                                                    <option value="">{!! Lang::get('lang.select_date') !!}</option>
                                                    <!-- <option value=""></option> -->
                                                    <option value="01">{!! Lang::get('lang.1') !!}</option>
                                                    <option value="02">{!! Lang::get('lang.2') !!}</option>
                                                    <option value="03">{!! Lang::get('lang.3') !!}</option>
                                                    <option value="04">{!! Lang::get('lang.4') !!}</option>
                                                    <option value="05">{!! Lang::get('lang.5') !!}</option>
                                                    <option value="06">{!! Lang::get('lang.6') !!}</option>
                                                    <option value="07">{!! Lang::get('lang.7') !!}</option>
                                                    <option value="08">{!! Lang::get('lang.8') !!}</option>
                                                    <option value="09">{!! Lang::get('lang.9') !!}</option>
                                                    <option value="10">{!! Lang::get('lang.10') !!}</option>
                                                    <option value="11">{!! Lang::get('lang.11') !!}</option>
                                                    <option value="12">{!! Lang::get('lang.12') !!}</option>
                                                    <option value="13">{!! Lang::get('lang.13') !!}</option>
                                                    <option value="14">{!! Lang::get('lang.14') !!}</option>
                                                    <option value="15">{!! Lang::get('lang.15') !!}</option>
                                                    <option value="16">{!! Lang::get('lang.16') !!}</option>
                                                    <option value="17">{!! Lang::get('lang.17') !!}</option>
                                                    <option value="18">{!! Lang::get('lang.18') !!}</option>
                                                    <option value="19">{!! Lang::get('lang.19') !!}</option>
                                                    <option value="20">{!! Lang::get('lang.20') !!}</option>
                                                    <option value="21">{!! Lang::get('lang.21') !!}</option>
                                                    <option value="22">{!! Lang::get('lang.22') !!}</option>
                                                    <option value="23">{!! Lang::get('lang.23') !!}</option>
                                                    <option value="24">{!! Lang::get('lang.24') !!}</option>
                                                    <option value="25">{!! Lang::get('lang.25') !!}</option>
                                                    <option value="26">{!! Lang::get('lang.26') !!}</option>
                                                    <option value="27">{!! Lang::get('lang.27') !!}</option>
                                                    <option value="28">{!! Lang::get('lang.28') !!}</option>
                                                    <option value="29">{!! Lang::get('lang.29') !!}</option>
                                                    <option value="30">{!! Lang::get('lang.30') !!}</option>
                                                    <option value="31">{!! Lang::get('lang.31') !!}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="form-group" id="holi_day_error">

                                        <input type="text" name="holyday_name" id="holyday_name" placeholder="Holiday name" class="form-control">
                                    </td>
                                    <td>

                                        <a type="button" class="btn btn-primary btn-xs" onclick="addHoliday(0)" title='Add holiday'>  <i class="fa fa-plus-circle">&nbsp;</i> {!! Lang::get('lang.confirm') !!} </a>&nbsp;
                                        <a type="button" class="btn btn-primary btn-xs" onclick="addHoliday(1)" title='Remove all holiday'> <i class="fa fa-trash"></i> </a>
                                    </td>
                                </tr>
                            </thead>
                            <tbody class="inputField" id="holiday_list">
                            </tbody> 
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-9">
                {!! Form::submit(Lang::get('lang.submit'),['class'=>'form-group btn btn-primary','id'=>'form_submit'])!!}
            </div>
        </div>
    </div>
</div>
{!!Form::close()!!}

<div id="get-content" style="display:none;">
    <div id="masterParent">
        <div  class="row copyied-time-default source-time-track4 form-group" style="padding-top:1%;">
            <div class="col-xs-2 col-xs-2-custom">
                <span class="fa fa-trash-o fa-lg cursor-pointer" onclick="removed(this)"></span>
            </div>
            <div class="col-xs-2 col-xs-2-custom">
                From
            </div>
            <div class="col-xs-2 col-xs-2-custom">
                <select class="from-hours from-time" name="fromHoursXalpha">
                                                    <option value="00">{!! Lang::get('lang.00') !!}</option>
                                                   <option value="01">{!! Lang::get('lang.1') !!}</option>
                                                    <option value="02">{!! Lang::get('lang.2') !!}</option>
                                                    <option value="03">{!! Lang::get('lang.3') !!}</option>
                                                    <option value="04">{!! Lang::get('lang.4') !!}</option>
                                                    <option value="05">{!! Lang::get('lang.5') !!}</option>
                                                    <option value="06">{!! Lang::get('lang.6') !!}</option>
                                                    <option value="07">{!! Lang::get('lang.7') !!}</option>
                                                    <option value="08">{!! Lang::get('lang.8') !!}</option>
                                                    <option value="09">{!! Lang::get('lang.9') !!}</option>
                                                    <option value="10">{!! Lang::get('lang.10') !!}</option>
                                                    <option value="11">{!! Lang::get('lang.11') !!}</option>
                                                    <option value="12">{!! Lang::get('lang.12') !!}</option>
                                                    <option value="13">{!! Lang::get('lang.13') !!}</option>
                                                    <option value="14">{!! Lang::get('lang.14') !!}</option>
                                                    <option value="15">{!! Lang::get('lang.15') !!}</option>
                                                    <option value="16">{!! Lang::get('lang.16') !!}</option>
                                                    <option value="17">{!! Lang::get('lang.17') !!}</option>
                                                    <option value="18">{!! Lang::get('lang.18') !!}</option>
                                                    <option value="19">{!! Lang::get('lang.19') !!}</option>
                                                    <option value="20">{!! Lang::get('lang.20') !!}</option>
                                                    <option value="21">{!! Lang::get('lang.21') !!}</option>
                                                    <option value="22">{!! Lang::get('lang.22') !!}</option>
                                                    <option value="23">{!! Lang::get('lang.23') !!}</option>
                </select>
            </div>
            <div class="col-xs-2 col-xs-2-custom">
                <select class="from-minutes from-time"  name="fromMinutesXalpha">
                    <option value="00">{!! Lang::get('lang.00') !!}</option>
                    <option value="05">{!! Lang::get('lang.05') !!}</option>
                    <option value="10">{!! Lang::get('lang.10') !!}</option>
                    <option value="15">{!! Lang::get('lang.15') !!}</option>
                    <option value="20">{!! Lang::get('lang.20') !!}</option>
                    <option value="25">{!! Lang::get('lang.25') !!}</option>
                    <option value="30">{!! Lang::get('lang.30') !!}</option>
                    <option value="35">{!! Lang::get('lang.35') !!}</option>
                    <option value="40">{!! Lang::get('lang.40') !!}</option>
                    <option value="45">{!! Lang::get('lang.45') !!}</option>
                    <option value="50">{!! Lang::get('lang.50') !!}</option>
                    <option value="55">{!! Lang::get('lang.55') !!}</option>
                </select>
            </div>
            <div class="col-xs-2 col-xs-2-custom">
                To
            </div>
            <div class="col-xs-2 col-xs-2-custom">
                <select class="to-hours to-time"  name="toHoursXalpha">
                                                    <option value="00">{!! Lang::get('lang.00') !!}</option>
                                                    <option value="01">{!! Lang::get('lang.1') !!}</option>
                                                    <option value="02">{!! Lang::get('lang.2') !!}</option>
                                                    <option value="03">{!! Lang::get('lang.3') !!}</option>
                                                    <option value="04">{!! Lang::get('lang.4') !!}</option>
                                                    <option value="05">{!! Lang::get('lang.5') !!}</option>
                                                    <option value="06">{!! Lang::get('lang.6') !!}</option>
                                                    <option value="07">{!! Lang::get('lang.7') !!}</option>
                                                    <option value="08">{!! Lang::get('lang.8') !!}</option>
                                                    <option value="09">{!! Lang::get('lang.9') !!}</option>
                                                    <option value="10">{!! Lang::get('lang.10') !!}</option>
                                                    <option value="11">{!! Lang::get('lang.11') !!}</option>
                                                    <option value="12">{!! Lang::get('lang.12') !!}</option>
                                                    <option value="13">{!! Lang::get('lang.13') !!}</option>
                                                    <option value="14">{!! Lang::get('lang.14') !!}</option>
                                                    <option value="15">{!! Lang::get('lang.15') !!}</option>
                                                    <option value="16">{!! Lang::get('lang.16') !!}</option>
                                                    <option value="17">{!! Lang::get('lang.17') !!}</option>
                                                    <option value="18">{!! Lang::get('lang.18') !!}</option>
                                                    <option value="19">{!! Lang::get('lang.19') !!}</option>
                                                    <option value="20">{!! Lang::get('lang.20') !!}</option>
                                                    <option value="21">{!! Lang::get('lang.21') !!}</option>
                                                    <option value="22">{!! Lang::get('lang.22') !!}</option>
                                                    <option value="23">{!! Lang::get('lang.23') !!}</option>
                </select>
            </div>
            <div class="col-xs-2 col-xs-2-custom">
                <select  class="to-minutes to-time"  name="toMinutesXalpha">
                   <option value="00">{!! Lang::get('lang.00') !!}</option>
                    <option value="05">{!! Lang::get('lang.05') !!}</option>
                    <option value="10">{!! Lang::get('lang.10') !!}</option>
                    <option value="15">{!! Lang::get('lang.15') !!}</option>
                    <option value="20">{!! Lang::get('lang.20') !!}</option>
                    <option value="25">{!! Lang::get('lang.25') !!}</option>
                    <option value="30">{!! Lang::get('lang.30') !!}</option>
                    <option value="35">{!! Lang::get('lang.35') !!}</option>
                    <option value="40">{!! Lang::get('lang.40') !!}</option>
                    <option value="45">{!! Lang::get('lang.45') !!}</option>
                    <option value="50">{!! Lang::get('lang.50') !!}</option>
                    <option value="55">{!! Lang::get('lang.55') !!}</option>
                </select>
            </div>
            <div class="col-xs-2 minus-custom hide">
                <span class="fa fa-minus-circle fa-lg cursor-pointer"></span>
            </div>
        </div>
    </div>
</div>
<script>


            $(document).on("click", "#form_submit", function(e){


            var month = $("#month").val();
            var day = $("#day").val();
            var holyday_name = $("#holyday_name").val();
            // alert(month);
            if (holyday_name){
    if (!month){
    alert('{!! Lang::get('lang.select_month') !!}');
            return false;
    }
    if (!day){
    alert('{!! Lang::get('lang.select_date') !!}');
            return false;
    }

    alert('{!! Lang::get('lang.confirm_your_holiday') !!}');
            return false;
    }
    else if (month){
    alert('{!! Lang::get('lang.select_date_holiday_name_And_also_confirm_your_holiday') !!}');
            return false;
    }

    else if (day){
    alert('{!! Lang::get('lang.select_month_holiday_name_And_also_confirm_your_holiday') !!}');
            return false;
        }
            else{
            return true;
            }


    });


            //form submit//
            $(document).on("click", ".sla-form-submit", function(e){

    // alert('ok');
    e.preventDefault();
            var isAnyError = false;
            $('.minus-custom').each(function(index, minusObj) {
    if (!$(minusObj).hasClass('hide')){
    isAnyError = true;
    }
    });
    });
            var date_array = new Array();
            // this function is used to delete all the rows
                    function removeHoliday() {
                    $("#holiday_list").html(' ');
                            date_array.reset();
//        var date_array = new Array();
                    }

            // this function is used to show or hide the custom 
            $(document).ready(function() {
            $("#custom_hours1").click(function() {
            $("#hide").hide();
            });
                    $("#custom_hours2").click(function() {
            $("#hide").show();
            });
            });
                    // this function is used to add holiday
                            function addHoliday(check) {
                            if (check == 1) {
                            $("#holiday_list").html(' ');
                                    while (date_array.length > 0) {
                            date_array.pop();
                            }
                            $("#show_date_error").removeClass('has-error');
                                    $("#show_invalid").html('');
                            } else {



                            var month_value = document.getElementById("month").value;
                                    var month = $("#month option:selected").text();
                                    var day = document.getElementById("day").value;
                                    var holyday_name = document.getElementById("holyday_name").value;
                                    if (holyday_name){
                            if (!month_value || month_value == ""){
                            alert('{!! Lang::get('lang.select_month') !!}');
                                    return false;
                            }
                            if (!day || day == ""){
                            alert('{!! Lang::get('lang.select_date') !!}');
                                    return false;
                            }
                            }


                            if (holyday_name == '') {
                            $("#holi_day_error").addClass('has-error');
                                    return false;
                            } else {
                            $("#holi_day_error").removeClass('has-error');
                            }

                            var date = month + day;
                                    var result = contains.call(date_array, date);
                                    if (result == false) {
                            date_array.push(date);
                                    $("#show_date_error").removeClass('has-error');
                                    $("#show_invalid").html('');
                            } else {
                            $("#show_invalid").html('Invalid Date');
                                    $("#show_date_error").addClass('has-error');
                                    return false;
                            }


                            var input = "<input type='hidden' name='month[]' value='" + month_value + "'>" +
                                    "<input type='hidden' name='day[]' value='" + day + "'>" +
                                    "<input type='hidden' name='holyday_name[]' value='" + holyday_name + "'>";
                                    var data_add = "<tr id='remove_me'><td><center> " + month + "  " + day + " </center></td><td> " + holyday_name + " </td><td><a class='btn btn-danger btn-xs' title='Remove holiday' onclick='deleteHolidayRow(this)' value='" + date + "'><i class='fa fa-trash'></i></a> " + input + " </td><tr>";
                                    $("#holiday_list").append(data_add);
                                    $("#holyday_name").val('');
                                    $("#month").val('');
                                    $("#day").val('');
                            }
                            }

                    // this function is used to delete a particular row
                    function deleteHolidayRow(o) {
                    var o;
                            var p = o.parentNode.parentNode;
                            p.parentNode.removeChild(p);
                            date_array.remove('seven');
                    }


                    // code to check if an array contains a value
                    var contains = function(needle) {
                    // Per spec, the way to identify NaN is that it is not equal to itself
                    var findNaN = needle !== needle;
                            var indexOf;
                            if (!findNaN && typeof Array.prototype.indexOf === 'function') {
                    indexOf = Array.prototype.indexOf;
                    } else {
                    indexOf = function(needle) {
                    var i = - 1, index = - 1;
                            for (i = 0; i < this.length; i++) {
                    var item = this[i];
                            if ((findNaN && item !== item) || item === needle) {
                    index = i;
                            break;
                    }
                    }
                    return index;
                    };
                    }
                    return indexOf.call(this, needle) > - 1;
                    };
                            // this funcion is used to remove a particular value in an array
                            Array.prototype.remove = function() {
                            var what, a = arguments, L = a.length, ax;
                                    while (L && this.length) {
                            what = a[--L];
                                    while ((ax = this.indexOf(what)) !== - 1) {
                            this.splice(ax, 1);
                            }
                            }
                            return this;
                            };
              function adddates(id, id2) {
                                var count=0;
                                count++;
                                 
                                if(count==1 && id==0){
                                   
                                   
                                    document.getElementById("custom_button"+id+id2).setAttribute("disabled", true);
                                    
                                }
                                if(count==1 && id==1){
                                     $("#custom_button0"+id2). removeAttr("disabled");
                                    
                              }
                                if(count==1 && id==2){
                                    $("#custom_button0"+id2). removeAttr("disabled");
                                    
                                  }
                                
                                var array_data_unique = [0, 1, 2];
                                    var position = id;
                                    var option = id2;
                                    document.getElementById("type" + position + option).checked = true;
                                    $("#custom_button" + position + option).addClass('btn-success');
                                    $("#custom_button" + position + option).removeClass('btn-default');
                                    var new_array = array_data_unique.remove(position);
                                    new_array.forEach(function(item){
                                    $("#custom_button" + item + option).removeClass('btn-success');
                                            $("#custom_button" + item + option).addClass('btn-default');
                                    });
                                    if (position == 0) {
                            var get_content = document.getElementById('get-content');
                                    console.log(get_content.innerHTML.replace("fromHoursXalpha", "fromHour" + '[' + option + ']' + '[]'));
                                    var get_content1 = get_content.innerHTML;
                                    var get_content2 = get_content1.replace("fromHoursXalpha", "fromHour" + '[' + option + ']' + '[]');
                                    var get_content3 = get_content2.replace("fromMinutesXalpha", "fromMinute" + '[' + option + ']' + '[]');
                                    var get_content4 = get_content3.replace("toHoursXalpha", "toHour" + '[' + option + ']' + '[]');
                                    var get_content5 = get_content4.replace("toMinutesXalpha", "toMinute" + '[' + option + ']' + '[]');
                                    $("#addhere" + option).append(get_content5);
                                    
                                    $("#addhere" + option).show();
                            } else {
                            $("#addhere" + option).html('');
                            }
                            
                        
                            }


                    $(document).on("change", ".from-time,.to-time", function(){
                    var $currentRow = $(this).parents(".copyied-time-default");
                            var status = check_from_to_difference($currentRow.find(".from-hours").val(), $currentRow.find(".from-minutes").val(), $currentRow.find(".to-hours").val(), $currentRow.find(".to-minutes").val())
                            if (status){$currentRow.find('.minus-custom').removeClass("hide"); }
                    else{$currentRow.find('.minus-custom').addClass("hide"); }
                    });
                            function check_from_to_difference(fromHrs, fromMin, toHrs, toMin){
                            var status = false;
                                    if (fromHrs > toHrs){
                            status = true;
                            } else if ((fromHrs == toHrs) && (fromMin > toMin)){
                            status = true;
                            }
                            return status;
                            }


                    $(document).ready(function(){
                    new_array = [0, 1, 2, 3, 4, 5, 6];
                            new_array.forEach(function(item){

                            switch ('1' + item) {
                            case '11':
                                    document.getElementById("type" + 1 + item).checked = true;
                                    console.log(document.getElementById("type" + 1 + item));
                                    $("#custom_button1" + item).addClass('btn-success');
                                    $("#custom_button1" + item).removeClass('btn-default');
                                    break;
                                    case '12':
                                    document.getElementById("type" + 1 + item).checked = true;
                                    console.log(document.getElementById("type" + 1 + item));
                                    $("#custom_button1" + item).addClass('btn-success');
                                    $("#custom_button1" + item).removeClass('btn-default');
                                    break;
                                    case '13':
                                    document.getElementById("type" + 1 + item).checked = true;
                                    console.log(document.getElementById("type" + 1 + item));
                                    $("#custom_button1" + item).addClass('btn-success');
                                    $("#custom_button1" + item).removeClass('btn-default');
                                    break;
                                    case '14':
                                    document.getElementById("type" + 1 + item).checked = true;
                                    console.log(document.getElementById("type" + 1 + item));
                                    $("#custom_button1" + item).addClass('btn-success');
                                    $("#custom_button1" + item).removeClass('btn-default');
                                    break;
                                    case '15':
                                    document.getElementById("type" + 1 + item).checked = true;
                                    console.log(document.getElementById("type" + 1 + item));
                                    $("#custom_button1" + item).addClass('btn-success');
                                    $("#custom_button1" + item).removeClass('btn-default');
                                    break;
                            }
                            switch ('2' + item) {
                            case '21':
                                    $("#custom_button2" + item).removeClass('btn-success');
                                    $("#custom_button2" + item).addClass('btn-default');
                                    break;
                                    case '22':
                                    $("#custom_button2" + item).removeClass('btn-success');
                                    $("#custom_button2" + item).addClass('btn-default');
                                    break;
                                    case '23':
                                    $("#custom_button2" + item).removeClass('btn-success');
                                    $("#custom_button2" + item).addClass('btn-default');
                                    break;
                                    case '24':
                                    $("#custom_button2" + item).removeClass('btn-success');
                                    $("#custom_button2" + item).addClass('btn-default');
                                    break;
                                    case '25':
                                    $("#custom_button2" + item).removeClass('btn-success');
                                    $("#custom_button2" + item).addClass('btn-default');
                                    break;
                            }
                            });
                    });
               function removed(x) {
                         var id=x.parentNode.parentNode.parentNode.parentNode.getAttribute("id");
                            
                            console.log(id);
                   
                           
                            
                            if(id=="addhere0"){
                                
                                 $("#custom_button00"). removeAttr("disabled");
                                
                                 $("#addhere0").find('#masterParent').remove();
                            }
                            else if(id=="addhere1"){
                                
                                $("#custom_button01"). removeAttr("disabled");
                                
                                $("#addhere1").find('#masterParent').remove();
                               
                            }
                            else if(id=="addhere2"){
                            $("#custom_button02"). removeAttr("disabled");
                             
                                $("#addhere2").find('#masterParent').remove();
                               
                            }
                            else if(id=="addhere3"){
                            $("#custom_button03"). removeAttr("disabled");
                             
                                $("#addhere3").find('#masterParent').remove();
                              
                            }
                            else if(id=="addhere4"){
                            $("#custom_button04"). removeAttr("disabled");
                             
                                $("#addhere4").find('#masterParent').remove();
                                
                            }
                            else if(id=="addhere5"){
                            $("#custom_button05"). removeAttr("disabled");
                              
                                 $("#addhere5").find('#masterParent').remove();
                                
                            }
                            else if(id=="addhere6"){
                            $("#custom_button06"). removeAttr("disabled");
                             
                                $("#addhere6").find('#masterParent').remove();
                               
                            }
                       
       }

</script>


@stop