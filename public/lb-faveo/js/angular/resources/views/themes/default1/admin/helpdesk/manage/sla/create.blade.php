@extends('themes.default1.admin.layout.admin')

@section('Manage')
active
@stop

@section('manage-bar')
active
@stop

@section('sla')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{!! Lang::get('lang.sla_plan') !!}</h1>
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')
<ol class="breadcrumb">
</ol>
@stop
<style type="text/css">

    ul.tagit {
        width: 450%!important;
    }


</style>

<!-- /breadcrumbs -->
<!-- content -->
@section('content')
<!-- open a form -->
{!! Form::open(['action' => 'SLA\SlaController@store', 'method' => 'post']) !!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h2 class="box-title">{{Lang::get('lang.create')}}</h2>
    </div>
    <div class="box-body with-border">
        @if(Session::has('errors'))
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>Alert!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @if($errors->first('name'))
            <li class="error-message-padding">{!! $errors->first('name', ':message') !!}</li>
            @endif
            @if($errors->first('grace_period'))
            <li class="error-message-padding">{!! $errors->first('grace_period', ':message') !!}</li>
            @endif
            @if($errors->first('status'))
            <li class="error-message-padding">{!! $errors->first('status', ':message') !!}</li>
            @endif
        </div>
        @endif
        <!-- <table class="table table-hover" style="overflow:hidden;"> -->
        <div class="row">
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <div class="col-md-3">
                    {!! Form::label('name',Lang::get('lang.name')) !!} <span class="text-red"> *</span>
                </div>
                <div class="col-md-9">
                    {!! Form::text('name',null,['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group {{ $errors->has('grace_period') ? 'has-error' : '' }}">
                <div class="col-md-3">
                    {!! Form::label('admin_note',Lang::get('lang.admin_notes')) !!}
                </div>
                <div class="col-md-9">
                    {!! Form::textarea('admin_note',null,['class' => 'form-control','size' => '30x5']) !!}
                </div>
            </div>

            <!-- status radio: required: Active|Dissable -->
            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                <div class="col-md-3">
                    {!! Form::label('status',Lang::get('lang.status')) !!}&nbsp;
                </div>
                <div class="col-md-9">
                    <div class="col-md-2">
                        {!! Form::radio('status','1',true) !!} {{Lang::get('lang.active')}}
                    </div>
                    <div class="col-md-2">
                        {!! Form::radio('status','0') !!} {{Lang::get('lang.inactive')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-header with-border">
        <h2 class="box-title">{{Lang::get('lang.sla_targets')}}</h2>
    </div>
    <div class="box-body">
        <table class="table">
            <tr>
                <th>{{Lang::get('lang.Priority')}}</th>
                <th>{{Lang::get('lang.respond_Within')}}</th>
                <th>{{Lang::get('lang.resolve_within')}}</th>
                <th>{{Lang::get('lang.operational_hrs')}}</th>
                <th>{{Lang::get('lang.send_report_email')}}</th>
                <th>{{Lang::get('lang.send_report_SMS')}}</th>
            </tr>
            <tr>

                <td>
                    <select name="sla_priority" class="form-control">
                        <?php $prioritys = \App\Model\helpdesk\Ticket\Ticket_Priority::where('status', 1)->get(); ?>
                        @foreach($prioritys as $priority)
                        <option value="{!! $priority->priority_id !!}">{!! $priority->priority !!}</option>
                        @endforeach

                    </select>

                </td>
                <td>
                    <div class="col-md-3" style="padding:0;">
                        <input type="text" name="response_count" class="form-control">
                    </div>
                    <div class="col-md-5">
                        <select name="response_duration" class="form-control">
                            <option value="min">{{Lang::get('lang.min')}}</option>
                            <option value="hrs">{{Lang::get('lang.hrs')}}</option>
                            <option value="days">{{Lang::get('lang.days')}}</option>
                            <option value="months">{{Lang::get('lang.months')}}</option>
                        </select>
                    </div>
                </td>
                <td>
                    <div class="col-md-3" style="padding:0;">
                        <input type="text" name="resolve_count" class="form-control">
                    </div>
                    <div class="col-md-5">
                        <select name="resolve_duration" class="form-control">
                            <option value="min">{{Lang::get('lang.min')}}</option>
                            <option value="hrs">{{Lang::get('lang.hrs')}}</option>
                            <option value="days">{{Lang::get('lang.days')}}</option>
                            <option value="months">{{Lang::get('lang.months')}}</option>
                        </select>
                    </div>
                </td>
                <td>
                    <select name="business_hour" class="form-control">
                        <?php $business_hours = \App\Model\helpdesk\Manage\Sla\BusinessHours::where('status', 1)->get(); ?>
                        @foreach($business_hours as $business_hour)
                        <option value="{!! $business_hour->id !!}">{!! $business_hour->name !!}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="send_email" class="form-control">
                        <option value="1">{{Lang::get('lang.yes')}}</option>
                        <option value="0">{{Lang::get('lang.no')}}</option>
                    </select>
                </td>
                <td>
                    <select name="send_sms" class="form-control">
                        <option value="1">{{Lang::get('lang.yes')}}</option>
                        <option value="0">{{Lang::get('lang.no')}}</option>

                    </select> 

                </td>
            </tr>

        </table>
    </div>

    <!--  work follow this --> 


    <!-- <div class="box box-info"> -->
    <div class="box-header with-border">
        <h4>{{Lang::get('lang.apply_this_to:')}}
        </h4>
        <!-- /.box-header -->
        <!-- <div class="box-body"> -->


        <div class="box box-default">
            <div class="box-header with-border">
                {{Lang::get('lang.choose_when_this_SLA_policy_must_be_enforced')}}
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="box-header with-border">
                    <div class="from-group">


                        <!-- <div class="modal-body"> -->
                        <!-- <div class="panel-heading"> -->
                        <!-- <h4>{{Lang::get('lang.apply_this_to:')}}</h4><br/> -->
                        <!-- {{Lang::get('lang.choose_when_this_SLA_policy_must_be_enforced')}} -->
                        <!-- </div> -->
                        <div class="sla_policy_conditions_container">
                            <div class="panel-body">
                                <div id="form7">

                                    <div class="form-group" id="company_id" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <label class=" control-label"><span data-class="tagit-plgn-company"class="glyphicon glyphicon glyphicon-minus-sign" aria-hidden="true" style="color:#990000;"></span> {{Lang::get('lang.company')}}</label>
                                            </div>


                                            <div class="col-md-10 col-sm-10 col-xs-10">




                                                  <link rel="stylesheet" href="{{asset('lb-faveo/plugins/hailhood-tag/demo/css/jquery-ui-base-1.8.20.css')}}">
                                            <link rel="stylesheet" href="{{asset('lb-faveo/plugins/hailhood-tag/css/tagit-stylish-yellow.css')}}">

                                            <div id="filter-box">
                                                <div>
                                                    <div class="row">

                                                        <!-- /.col -->
                                                        <div class="col-md-3">
                                                            <div class="form-group">

                                                                <ul class="form-group tagit-plgn-company" data-name="nameOfSelect" name="apply_sla_companys[]" tagvalue="tagvalue" >

                                                                      
                                                                </ul >

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>



                                               













                                            </div>









                                        </div>
                                    </div>
                                    <div class="form-group" id="type_id" style="display: none;">
                                        <div class="row" >
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <label class=" control-label"><span data-class="tagit-plgn-type" class="glyphicon glyphicon glyphicon-minus-sign" aria-hidden="true"  style="color:#990000;"></span> {{Lang::get('lang.type')}}</label>
                                            </div>


                                            <div class="col-md-10 col-sm-10 col-xs-10">





                                         <link rel="stylesheet" href="{{asset('lb-faveo/plugins/hailhood-tag/demo/css/jquery-ui-base-1.8.20.css')}}">
                                            <link rel="stylesheet" href="{{asset('lb-faveo/plugins/hailhood-tag/css/tagit-stylish-yellow.css')}}">

                                            <div id="filter-box">
                                                <div>
                                                    <div class="row">

                                                        <!-- /.col -->
                                                        <div class="col-md-3">
                                                            <div class="form-group">

                                                                <ul class="form-group tagit-plgn-type" data-name="nameOfSelect" name="apply_sla_tickettypes[]" tagvalue="tagvalue" >

                                                                      
                                                                </ul >

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>









                                             
                                            </div>

                                        </div>
                                    </div>


                                    <div class="form-group" id="department_id" style="display: none;">
                                        <div class="row" >
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <label class=" control-label"><span data-class="tagit-plgn-dept" class="glyphicon glyphicon glyphicon-minus-sign" aria-hidden="true"  style="color:#990000;"></span> {{Lang::get('lang.department')}}</label>
                                            </div>


                                            <div class="col-md-10 col-sm-10 col-xs-10">





                                         <link rel="stylesheet" href="{{asset('lb-faveo/plugins/hailhood-tag/demo/css/jquery-ui-base-1.8.20.css')}}">
                                            <link rel="stylesheet" href="{{asset('lb-faveo/plugins/hailhood-tag/css/tagit-stylish-yellow.css')}}">

                                            <div id="filter-box">
                                                <div>
                                                    <div class="row">

                                                        <!-- /.col -->
                                                        <div class="col-md-3">
                                                            <div class="form-group">

                                                                <ul class="form-group tagit-plgn-dept" data-name="nameOfSelect" name="apply_sla_depertments[]" tagvalue="tagvalue" >

                                                                      
                                                                </ul >

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>


















                                                
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group" id="source_id" style="display: none;"> 
                                        <div class="row">
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <label class=" control-label" style="font-family:inherit;"><span data-class="tagit-plgn-ticketsources" class="glyphicon glyphicon glyphicon-minus-sign" aria-hidden="true"  style="color:#990000; "></span > {{Lang::get('lang.source')}}</label>
                                            </div>
                                            <div class="col-md-10 col-sm-10 col-xs-10">



                                                  <link rel="stylesheet" href="{{asset('lb-faveo/plugins/hailhood-tag/demo/css/jquery-ui-base-1.8.20.css')}}">
                                            <link rel="stylesheet" href="{{asset('lb-faveo/plugins/hailhood-tag/css/tagit-stylish-yellow.css')}}">

                                            <div id="filter-box">
                                                <div>
                                                    <div class="row">

                                                        <!-- /.col -->
                                                        <div class="col-md-3">
                                                            <div class="form-group">

                                                                <ul class="form-group tagit-plgn-ticketsources" data-name="nameOfSelect" name="apply_sla_ticketsources[]" tagvalue="tagvalue" >

                                                                      
                                                                </ul >

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
















                                               
                                            </div>

                                        </div>
                                    </div> 
                                </div> 
                                <div> 
                                </div>
                                <!-- <label class=" control-label" id="label7" style="font-family:inherit;"><span class="glyphicon glyphicon glyphicon-plus-sign" aria-hidden="true" style="color:#009853; "></span >&nbsp; &nbsp;Add New</label>  -->
                                <div class="add-sla-policy-bb-box">
                                    <div class="btn-group">
                                        <a class="btn dropdown-toggle" data-toggle="dropdown">
                                            <span class="glyphicon glyphicon glyphicon-plus-sign" aria-hidden="true" style="color:#009853; "></span >&nbsp;&nbsp;{{Lang::get('lang.add_new')}}
                                            <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="javascript:void(0)" data-cond="type_id" class="sla_policy_list"> {{Lang::get('lang.type')}}</a></li>
                                            <li><a href="javascript:void(0)" data-cond="source_id" class="sla_policy_list"> {{Lang::get('lang.source')}}</a></li>
                                            <li><a href="javascript:void(0)" data-cond="company_id" class="sla_policy_list"> {{Lang::get('lang.company')}}</a></li>
                                            <li><a href="javascript:void(0)" data-cond="department_id" class="sla_policy_list"> {{Lang::get('lang.department')}}</a></li>
                                        </ul>
                                    </div>
                                </div>


                            </div>

                        </div> 
                        <!-- </div> -->
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->






    </div>

    <!-- </div>/.box-body -->
    <!-- </div>/.box
    -->






    <div class="box-header with-border">
        <p>Set SLA reminders :
        <href="#" data-toggle="modal" data-target="#myModal">
            <span class="glyphicon glyphicon-bell"></span>



            <!-- Set SLA reminders -->

            <div class="box box-info">
                <div class="box-header with-border">
                    <!-- <h3 class="box-title">Collapsable</h3> -->
                    <!-- <div class="box-tools pull-right">
                      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div><! -->
                    <h4 class="modal-title"> {!!Lang::get('lang.What_happens_when_this_SLA_due_time_approaches')!!}</h4>
                </div><!-- /.box-header -->
                <div class="box-body">


                    <div class="box box-default">
                        <div class="box-header with-border">
                            {!!Lang::get('lang.set_reminder_rule_when_a_ticket_response_time_approaches')!!}
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="modal-body">
                                <!-- <div class="panel-heading">{{Lang::get('lang.set_reminder_rule_when_a_ticket_response_time_approaches')}}</div> -->
                                <div class="panel-body">
                                    <!-- <div class="form-group response"> -->
                                    <div class="row" id="form1" style="display: none;">
                                        <div class="col-md-2 col-sm-2 col-xs-2">
                                            <label class=" control-label" ><span class="glyphicon glyphicon glyphicon-minus-sign response-approaches " aria-hidden="true" style="color:#990000; "></span >&nbsp;&nbsp;&nbsp; {{Lang::get('lang.escalate')}}</label>
                                        </div>

                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <select class="form-control" name="approaches_response_escalate_time">

                                                <option value="null">{{Lang::get('lang.select')}}</option>

                                                <option value="-30">{{Lang::get('lang.before_30_minites')}}</option>
                                                <option value="-60">{{Lang::get('lang.before_1_hour')}}</option>
                                                <option value="-120">{{Lang::get('lang.before_2_hour')}}</option>
                                                <option value="-1440">{{Lang::get('lang.before_1_day')}}</option>
                                                <option value="-10080">{{Lang::get('lang.before_7_day')}}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6">


                                            <link rel="stylesheet" href="{{asset('lb-faveo/plugins/hailhood-tag/demo/css/jquery-ui-base-1.8.20.css')}}">
                                            <link rel="stylesheet" href="{{asset('lb-faveo/plugins/hailhood-tag/css/tagit-stylish-yellow.css')}}">

                                            <div id="filter-box">
                                                <div>
                                                    <div class="row">

                                                        <!-- /.col -->
                                                        <div class="col-md-3">
                                                            <div class="form-group">

                                                                <ul class="form-group tagit-plgn" data-name="nameOfSelect" name="approaches_response_escalate_person[]" tagvalue="tagvalue" >

                                                                     <li data-value="assigner">assigner</li>
                                                                  <!--   <li data-value="department manager">department manager</li>
                                                                    <li data-value="team lead">team lead</li>
                                                                    <li data-value="admin">admin</li> -->

                                                                </ul >

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>






                                        </div>

                                    </div>
                                    <!-- </div> -->
                                    <label class=" control-label" id="label4" style="font-family:inherit;"><span class="glyphicon glyphicon glyphicon-plus-sign" aria-hidden="true" style="color:#009853; "></span >&nbsp; &nbsp;{{Lang::get('lang.add_rule')}}</label>                                       
                                </div> 
                            </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->



                    <div class="box box-default">
                        <div class="box-header with-border">
                            {!!Lang::get('lang.Set_reminder_rule_when_a_ticket_resolution_time_approaches')!!}
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="modal-body">
                                <!-- <div class="panel-heading">{{Lang::get('lang.Set_reminder_rule_when_a_ticket_resolution_time_approaches')}}</div> -->
                                <div class="panel-body">
                                    <div class="row" id="form4" style="display: none;">

                                        <div class="col-md-2 col-sm-2 col-xs-2">
                                            <label class=" control-label"><span class="glyphicon glyphicon glyphicon-minus-sign resolution-approaches" aria-hidden="true" style="color:#990000; "></span >&nbsp;&nbsp;&nbsp; {{Lang::get('lang.escalate')}}</label>
                                        </div>

                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <select class="form-control" name="approaches_resolution_escalate_time">
                                                  <option value="null">{{Lang::get('lang.select')}}</option>
                                                <option value="-30">{{Lang::get('lang.before_30_minites')}}</option>
                                                <option value="-60">{{Lang::get('lang.before_1_hour')}}</option>
                                                <option value="-120">{{Lang::get('lang.before_2_hour')}}</option>
                                                <option value="-1440">{{Lang::get('lang.before_1_day')}}</option>
                                                <option value="-10080">{{Lang::get('lang.before_7_day')}}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6">



                                            <link rel="stylesheet" href="{{asset('lb-faveo/plugins/hailhood-tag/demo/css/jquery-ui-base-1.8.20.css')}}">
                                            <link rel="stylesheet" href="{{asset('lb-faveo/plugins/hailhood-tag/css/tagit-stylish-yellow.css')}}">

                                            <div id="filter-box">
                                                <div>
                                                    <div class="row">

                                                        <!-- /.col -->
                                                        <div class="col-md-3">
                                                            <div class="form-group">

                                                                <ul class="form-group tagit-plgn1" data-name="nameOfSelect" name="approaches_resolution_escalate_person[]" tagvalue="tagvalue" >

                                                                 <li data-value="assigner">assigner</li>
                                                                    <!-- <li data-value="department manager">department manager</li>
                                                                    <li data-value="team lead">team lead</li>
                                                                    <li data-value="admin">admin</li> -->
                                                                     <!--  <li data-value="assigner">{{Lang::get('lang.assigner')}}</li>
                                                                    <li data-value="department_manager">{{Lang::get('lang.department_manager')}}</li>
                                                                    <li data-value="team_lead">team_lead</li>
                                                                    <li data-value="admin">{{Lang::get('lang.admin')}}</li> -->

                                                                </ul>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>






                                        </div>
                                    </div>

                                    <label class=" control-label" id="label3" style="font-family:inherit;"><span class="glyphicon glyphicon glyphicon-plus-sign" aria-hidden="true" style="color:#009853; "></span >&nbsp; &nbsp;{{Lang::get('lang.add_rule')}}</label>                                       
                                </div>

                            </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->


                    <!-- Modal content-->


                </div><!-- /.box-body -->
            </div><!-- /.box -->



            <div class="box box-info">
                <div class="box-header with-border">
                    <!-- <h3 class="box-title">Collapsable</h3> -->
                    <!-- <div class="box-tools pull-right">
                      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div><!-- /.box-tools --> 
                    <h4 class="modal-title">{!!Lang::get('lang.what_happens_when_this_SLA_is_violated?')!!}</h4>

                </div><!-- /.box-header -->
                <div class="box-body">


                    <div class="box box-default">
                        <div class="box-header with-border">
                            {!!Lang::get('lang.set_escalation_rule_when_a_ticket_is_not_responded_to_on_time')!!}
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="modal-body">
                                <!-- <div class="panel-heading">{{Lang::get('lang.set_escalation_rule_when_a_ticket_is_not_responded_to_on_time')}}</div> -->



                                <div class="panel-body" >
                                    <div class="row" id="form3" style="display: none;">
                                        <div class="col-md-2 col-sm-2 col-xs-2">
                                            <label class=" control-label"><span class="glyphicon glyphicon glyphicon-minus-sign response-violated" aria-hidden="true" style="color:#990000;"></span>&nbsp;&nbsp;&nbsp; {{Lang::get('lang.escalate')}}</label>
                                        </div>

                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <select class="form-control" name="violated_response_escalate_time">
                                                 <option value="null">{{Lang::get('lang.select')}}</option>
                                                <option value="+30">{{Lang::get('lang.after_30_minites')}}</option>
                                                <option value="+60">{{Lang::get('lang.after_1_hour')}}</option>
                                                <option value="+120">{{Lang::get('lang.after_2_hour')}}</option>
                                                <option value="+1440">{{Lang::get('lang.after_1_day')}}</option>
                                                <option value="+10080">{{Lang::get('lang.after_7_day')}}</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-6">


                                            <link rel="stylesheet" href="{{asset('lb-faveo/plugins/hailhood-tag/demo/css/jquery-ui-base-1.8.20.css')}}">
                                            <link rel="stylesheet" href="{{asset('lb-faveo/plugins/hailhood-tag/css/tagit-stylish-yellow.css')}}">

                                            <div id="filter-box">
                                                <div>
                                                    <div class="row">

                                                        <!-- /.col -->
                                                        <div class="col-md-3">
                                                            <div class="form-group">

                                                                <ul class="form-group tagit-plgn2" data-name="nameOfSelect" name="violated_response_escalate_person[]" tagvalue="tagvalue" >
                                                                  <li data-value="assigner">assigner</li>
                                                                   <!--  <li data-value="department manager">department manager</li>
                                                                    <li data-value="team lead">team lead</li>
                                                                    <li data-value="admin">admin</li> -->
                                                                  <!--  <li data-value="assigner">{{Lang::get('lang.assigner')}}</li>
                                                                    <li data-value="department_manager">{{Lang::get('lang.department_manager')}}</li>
                                                                    <li data-value="team_lead">{{Lang::get('lang.team_lead')}}</li>
                                                                    <li data-value="admin">{{Lang::get('lang.admin')}}</li>
 -->
                                                                </ul>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>



                                        </div>

                                    </div>





                                    <label class="control-label " id="label2" style="font-family:inherit;"><span class="glyphicon glyphicon glyphicon-plus-sign" aria-hidden="true" style="color:#009853; "></span >&nbsp; &nbsp;{{Lang::get('lang.add_rule')}}</label>
                                </div>



                            </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->


                    <div class="box box-default">
                        <div class="box-header with-border">
                            {!!Lang::get('lang.set_escalation_hierarchy_when_a_ticket_is_not_resolved_on_time')!!}
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="modal-body">
                                <!-- <div class="panel-heading">{{Lang::get('lang.set_escalation_hierarchy_when_a_ticket_is_not_resolved_on_time')}}</div> -->
                                <span class="row target-area-div" id="target-area-div">

                                </span>

                                <div class="panel-body hide" >

                                    <div class="row source-time-track source-counter">
                                        <div class="col-md-2 col-sm-2 col-xs-2">
                                            <label class=" control-label1"><span class="glyphicon glyphicon glyphicon-minus-sign resolved-violated" aria-hidden="true" style="color:#990000;"></span>&nbsp;&nbsp;&nbsp; {{Lang::get('lang.escalate')}}</label>
                                        </div>

                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <select class="form-control violated_time" id="violated_time"  name="violated_resolution_escalate_time">
                                                <!-- <option value=" ">{{Lang::get('lang.select')}}</option> -->
<!--                                                 <option value="null">{{Lang::get('lang.select')}}</option> -->
                                                <option value="+30">{{Lang::get('lang.after_30_minites')}}</option>
                                                <option value="+60">{{Lang::get('lang.after_1_hour')}}</option>
                                                <option value="+120">{{Lang::get('lang.after_2_hour')}}</option>
                                                <option value="+1440">{{Lang::get('lang.after_1_day')}}</option>
                                                <option value="+10080">{{Lang::get('lang.after_7_day')}}</option>
                                            </select>
                                        </div>


                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <link rel="stylesheet" href="{{asset('lb-faveo/plugins/hailhood-tag/demo/css/jquery-ui-base-1.8.20.css')}}">
                                            <link rel="stylesheet" href="{{asset('lb-faveo/plugins/hailhood-tag/css/tagit-stylish-yellow.css')}}">

                                            <div id="filter-box">
                                                <div>
                                                    <div class="row">

                                                        <!-- /.col -->
                                                        <div class="col-md-3">
                                                            <div class="form-group">

                                                                <ul class="form-group violated_resolution_escalate_person violated_person1" data-name="nameOfSelect" name="violated_resolution_escalate_person" tagvalue="tagvalue" >
                                                                 <li data-value="assigner">assigner</li>
                                                                   <!--  <li data-value="department manager">department manager</li>
                                                                    <li data-value="team lead">team lead</li>
                                                                    <li data-value="admin">admin</li> -->
                                                                  <!--  <li data-value="assigner">{{Lang::get('lang.assigner')}}</li>
                                                                    <li data-value="department_manager">{{Lang::get('lang.department_manager')}}</li>
                                                                    <li data-value="team_lead">{{Lang::get('lang.team_lead')}}</li>
                                                                    <li data-value="admin">{{Lang::get('lang.admin')}}</li> -->


                                                                    <!--  <li >Assigner</li>
                                                                     <li>Department Manager</li>
                                                                     <li>Team Lead</li>
                                                                      <li>Admin</li>  -->

                                                                </ul>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>




                                        </div>
                                    </div>
                                </div>
                                <label class=" control-label add-time-grid" id="label1" style="font-family:inherit;"><span class="glyphicon glyphicon glyphicon-plus-sign" aria-hidden="true" style="color:#009853; "></span >&nbsp; &nbsp;{{Lang::get('lang.add_rule')}}</label>                                        


                            </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->




                </div><!-- /.box-body -->
            </div><!-- /.box -->


            <div class="box-footer">
                {!! Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary'])!!}
            </div>
    </div>






    <!-- close form -->
    {!! Form::close() !!}




    @section('FooterInclude')
<script src="{{asset("lb-faveo/js/jquery.ui.js")}}" type="text/javascript"></script>

    <script type="text/javascript">
        function showhidefilter()
        {
            var div = document.getElementById("filter-box");
            if (div.style.display !== "none") {
                div.style.display = "none";
            } else {
                div.style.display = "block";

            }
        }
    </script>




<script src="{{asset('lb-faveo/plugins/hailhood-tag/js/tagit.js')}}"></script>

    <script type="text/javascript">



        $('.tagit-plgn-dept').tagit({
            tagSource: "{{url('sla/department/autofill')}}",
            allowNewTags: false,
            placeholder: 'Enter department',
            select: true,
        });
       


        $('.tagit-plgn-ticketsources').tagit({
            tagSource: "{{url('sla/ticketsources/autofill')}}",
            allowNewTags: false,
            placeholder: 'Enter ticketsources',
            select: true,
        });
       


        $('.tagit-plgn-company').tagit({
            tagSource: "{{url('sla/company/autofill')}}",
            allowNewTags: false,
            placeholder: 'Enter company',
            select: true,
        });
     


        $('.tagit-plgn-type').tagit({
            tagSource: "{{url('sla/type/autofill')}}",
            allowNewTags: false,
            placeholder: 'Enter type',
            select: true,
        });
        </script>



















    <script src="{{asset('lb-faveo/plugins/hailhood-tag/js/tagit.js')}}"></script>

    <script type="text/javascript">



        $('.tagit-plgn').tagit({
            tagSource: "{{url('sla/assigner/autofill')}}",
            allowNewTags: false,
            placeholder: 'Enter assigner',
            select: true,
        });



        // approaches


        $(document).on("click", "#label4", function() {

            $("#form1").show();
            $("#label4").hide();
        });

        $(document).on("click", ".response-approaches", function() {
            // $("response").addClass("hide");
            // console.log("before>> "+$("#form1").find('select[name="approaches_response_escalate_time"]').val());
            $("#form1").find('select[name="approaches_response_escalate_time"]').val("null");
//alert(time);
// console.log("after>> "+$("#form1").find('select[name="approaches_response_escalate_time"]').val());
            $("#form1").hide();

            $("#label4").show();
        });

   $(document).on("click", "#label3", function() {

            $("#form4").show();
            $("#label3").hide();
        });

        $(document).on("click", ".resolution-approaches", function() {

            $("#form4").find('select[name="approaches_resolution_escalate_time"]').val("null");

            $("#form4").hide();
            $("#label3").show();
        });
 // $(document).on("click", "#label2", function() {

        //     $("#form3").show();
        //     $("#label2").hide();
        // });

        // $(document).on("click", ".response-violated", function() {

        //     $("#form3").hide();
        //     $("#label2").show();
        // });


    </script>
 <script src="{{asset('lb-faveo/plugins/hailhood-tag/js/tagit.js')}}"></script>

    <script type="text/javascript">
  $('.tagit-plgn1').tagit({
            tagSource: "{{url('sla/assigner/autofill')}}",
            allowNewTags: false,
            placeholder: 'Enter assigner',
            select: true,
        });
 </script>
    <script src="{{asset('lb-faveo/plugins/hailhood-tag/js/tagit.js')}}"></script>

    <script type="text/javascript">
          $('.tagit-plgn2').tagit({
            tagSource: "{{url('sla/assigner/autofill')}}",
            allowNewTags: false,
            placeholder: 'Enter assigner',
            select: true,
        });

        $(document).on("click", "#label2", function() {

            $("#form3").show();
            $("#label2").hide();
        });

        $(document).on("click", ".response-violated", function() {
            
              $("#form3").find('select[name="violated_response_escalate_time"]').val("null");

            $("#form3").hide();
            $("#label2").show();
        });




    </script>
    <script src="{{asset('lb-faveo/plugins/hailhood-tag/js/tagit.js')}}"></script>
    <script type="text/javascript">



        $('.add-time-grid').on('click', function(event) {

            // $('.add-time-grid').hide();
            var counter = $('#target-area-div').find('.source-counter').length;

            $('#target-area-div').append($(".source-time-track").clone());
            $('#target-area-div').find('.source-time-track').find('.violated_resolution_escalate_person').attr('name', 'violated_resolution_escalate_person' + counter + '[]')
            $('.panel-body').find('.violated_person1').val('');
            $('#target-area-div').find('.violated_resolution_escalate_person').tagit({
                tagSource: "{{url('sla/assigner/autofill')}}",
                allowNewTags: false,
                placeholder: 'Enter assigner',
                select: true,
            });






            $('#target-area-div').find('.source-time-track').removeClass("source-time-track");

            var counter = $('#target-area-div').find('.source-counter').length;
            $('#target-area-div').find('.violated_resolution_escalate_person').each(function(counter) {
                $(this).attr('name', 'violated_resolution_escalate_person' + counter + '[]');
            });

            $('#target-area-div').find('.violated_time').each(function(counter) {


                $(this).attr('name', 'violated_resolution_escalate_time' + counter + '[]');


            });
            $('#target-area-div').find('.violated_time').each(function(event) {

                // var counter = $('#target-area-div').find('.source-counter').length;
                // alert(counter);
                var selectedItem = $(this).val();
                // alert(selectedItem);
                $('#target-area-div').find('.violated_time').not(this).find('option[value="' + selectedItem + '"]').prop("disabled", true);
                var $dropdown3 = $("select[name='violated_resolution_escalate_time']");
                var $dropdown4 = $("select[name='violated_resolution_escalate_time[]']");
                $dropdown3.find('option[value="' + selectedItem + '"]').prop("disabled", true);

                $(this).on('change', function(event) {
                    var selectedItem1 = $(this).val();
                    // alert('ooooo');
                    $('#target-area-div').find('.violated_time').not(this).find('option[value="' + selectedItem1 + '"]').prop("disabled", true);
                    $('#target-area-div').find('.violated_time').not(this).find('option[value="' + selectedItem + '"]').prop("disabled", false);
                    $dropdown3.find('option[value="' + selectedItem1 + '"]').prop("disabled", true);
                    $dropdown3.find('option[value="' + selectedItem + '"]').prop("disabled", false);
                    $dropdown4.find('option[value="' + selectedItem1 + '"]').prop("disabled", true);

                    // $('.add-time-grid').show();

                });
            });



            if (counter == 5) {
                $('.add-time-grid').hide();

            }



        });






    </script>


    @stop 

    <script type="text/javascript">


        var counter = $('#target-area-div').find('.source-counter').length;


        //alert(counter);
        if (counter != 0) {
            $('#target-area-div').find('.violated_resolution_escalate_person').each(function(counter) {
                $(this).attr('name', 'violated_resolution_escalate_person' + counter + '[]')
            });
            $('#target-area-div').find('.violated_time').each(function(counter) {


                $(this).attr('name', 'violated_resolution_escalate_time' + counter + '[]');


            });
        }



        if (counter == 5) {
            $('.add-time-grid').hide()

        }


        $('#target-area-div').find('.violated_time').each(function(event) {
            // var counter = $('#target-area-div').find('.source-counter').length;
            // alert(counter);
            var selectedItem = $(this).val();
            alert(selectedItem);
            $('#target-area-div').find('.violated_time').not(this).find('option[value="' + selectedItem + '"]').prop("disabled", true);
            var $dropdown3 = $("select[name='violated_resolution_escalate_time']");
            var $dropdown4 = $("select[name='violated_resolution_escalate_time[]']");
            $dropdown3.find('option[value="' + selectedItem + '"]').prop("disabled", true);

            $(this).on('change', function(event) {
                var selectedItem1 = $(this).val();
                // alert('ooooo');
                $('#target-area-div').find('.violated_time').not(this).find('option[value="' + selectedItem1 + '"]').prop("disabled", true);
                $('#target-area-div').find('.violated_time').not(this).find('option[value="' + selectedItem + '"]').prop("disabled", false);
                $dropdown3.find('option[value="' + selectedItem1 + '"]').prop("disabled", true);
                $dropdown3.find('option[value="' + selectedItem + '"]').prop("disabled", false);
                $dropdown4.find('option[value="' + selectedItem1 + '"]').prop("disabled", true);

            });
        });

      
        $(document).on("click", ".resolved-violated", function(event) {
            // $(this).parent().parent().parent().remove();
            var $dropdown2 = $("select[name='violated_resolution_escalate_time']");
            var selectedItem = $(this).parent().parent().parent().find('.violated_time').val();
            // alert(selectedItem)
            $(this).parent().parent().parent().remove();
            var $dropdown4 = $("select[name='violated_resolution_escalate_time[]']");

            $('#target-area-div').find('.violated_time').find('option').prop("disabled", false);
            $dropdown2.find('option').prop("disabled", false);


            $('#target-area-div').find('.violated_time').each(function(event) {
                var selectedItem = $(this).val();
                $('#target-area-div').find('.violated_time').not(this).find('option[value="' + selectedItem + '"]').prop("disabled", true);
                $dropdown2.find('option[value="' + selectedItem + '"]').prop("disabled", false);



            });



            var counter = $('#target-area-div').find('.source-counter').length;

            // alert(counter);
            if (counter != 0) {
                $('#target-area-div').find('.violated_resolution_escalate_person').each(function(counter) {
                    $(this).attr('name', 'violated_resolution_escalate_person' + counter + '[]')
                });
            }


            $('#target-area-div').find('.violated_time').each(function(counter) {

                var selectedItem = $(this).val();
                $(this).attr('name', 'violated_resolution_escalate_time' + (counter) + '[]');

                var $dropdown = $("select[name='violated_resolution_escalate_time']");
                //  var $dropdown4 = $("select[name='violated_resolution_escalate_time[]']");
                $dropdown.find('option[value="' + selectedItem + '"]').prop("disabled", true)
            });

            if (counter != 5) {
                $('.add-time-grid').show()

            }
        });
    </script>

    <script type="text/javascript">
        $(function() {
            //Initialize Select2 Elements
            $(".select2").select2();
        });
        $(document).on("click", ".sla_policy_list", function() {
            $("#" + $(this).attr('data-cond')).show();
            $(this).parent().hide();
            if (!$('.sla_policy_list').is(':visible')) {
                $('.add-sla-policy-bb-box').hide();
            }
        });
        $(document).on("click", ".glyphicon-minus-sign", function() {
           var target_class = $(this).data("class")
            var id = $(this).parents('.form-group').attr("id");
            // console.log("id>> "+id);
            $('.add-sla-policy-bb-box').find("ul").find("[data-cond='" + id + "']").parent().show();
            if (!$('.add-sla-policy-bb-box').is(':visible')) {
                $('.add-sla-policy-bb-box').show();
            }
              $('.'+target_class).tagit("fill",[]);
 $(this).parents('.form-group').hide();
            // $(this).parents('.row').find('.select2').select2("val", "");

        });



    </script>


    
    <script type="text/javascript">

        //before submit from all desable value enable     
        $(document).on('submit', function() {
            // alert('submit');
            $('#target-area-div').find('.violated_time').find('option').prop("disabled", false);

        });

    </script>


    @stop