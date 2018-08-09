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
{!! Form::model($slas, ['url' => 'sla/'.$slas->id, 'method' => 'PATCH']) !!}
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
                   
                   
                 @if($slas->id !=1)
                  <div class="col-md-2">
                        {!! Form::radio('status','1',true) !!} {{Lang::get('lang.active')}}
                    </div>
                    <div class="col-md-2">
                        {!! Form::radio('status','0') !!} {{Lang::get('lang.inactive')}}
                    </div>
                    @else
                     <div class="col-md-2">
                        {!! Form::radio('status','1',true) !!} {{Lang::get('lang.active')}}
                    </div>
                    <div class="col-md-2 hide">
                        {!! Form::radio('status','0') !!} {{Lang::get('lang.inactive')}}
                    </div>
                    @endif

                
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
                        <option value="{!! $priority->priority_id !!}" <?php
                        if ($priority->priority_id == $sla_target_priority_id) {
                            echo 'selected';
                        }
                        ?>>{!! $priority->priority !!}</option>
                        @endforeach

                    </select>

                </td>
                <td>
                    <?php
                    $response_time = [];
                    if ($sla_target) {
                        $response_time = $sla_target->respond_within;
                        $response_time = explode('-', $response_time);
                    }
                    ?>
                    <div class="col-md-3" style="padding:0;">
                        <input type="number" name="response_count" class="form-control" value="{!! checkArray(0,$response_time) !!}">
                    </div>
                    <div class="col-md-5">
                        <select name="response_duration" class="form-control">
                            <option value="min" <?php
                            if (checkArray(1, $response_time) == 'min') {
                                echo 'selected';
                            }
                            ?> >Min</option>
                            <option value="hrs" <?php
                            if (checkArray(1, $response_time) == 'hrs') {
                                echo 'selected';
                            }
                            ?> >Hrs</option>
                            <option value="days" <?php
                            if (checkArray(1, $response_time) == 'days') {
                                echo 'selected';
                            }
                            ?> >Days</option>
                            <option value="months" <?php
                            if (checkArray(1, $response_time) == 'months') {
                                echo 'selected';
                            }
                            ?> >Months</option>
                        </select>
                    </div>
                </td>
                <td>
                    <?php
                    $resolve_time = [];
                    if ($sla_target) {
                        $resolve_time = $sla_target->resolve_within;
                        $resolve_time = explode('-', $resolve_time);
                    }
                    ?>
                    <div class="col-md-3" style="padding:0;">
                        <input type="number" name="resolve_count" class="form-control" value="{!! checkArray(0,$resolve_time)!!}">
                    </div>
                    <div class="col-md-5">
                        <select name="resolve_duration" class="form-control">
                            <option value="min" <?php
                            if (checkArray(1, $resolve_time) == 'min') {
                                echo 'selected';
                            }
                            ?> >Min</option>
                            <option value="hrs" <?php
                            if (checkArray(1, $resolve_time) == 'hrs') {
                                echo 'selected';
                            }
                            ?> >Hrs</option>
                            <option value="days" <?php
                            if (checkArray(1, $resolve_time) == 'days') {
                                echo 'selected';
                            }
                            ?> >Days</option>
                            <option value="months" <?php
                            if (checkArray(1, $resolve_time) == 'months') {
                                echo 'selected';
                            }
                            ?> >Months</option>
                        </select>
                    </div>
                </td>
                <td>
                    <select name="business_hour" class="form-control">
                        <?php $business_hours = \App\Model\helpdesk\Manage\Sla\BusinessHours::where('status', 1)->get(); ?>
                        @foreach($business_hours as $business_hour)
                        <option value="{!! $business_hour->id !!}" <?php
                        if ($sla_target && $sla_target->business_hour_id == $business_hour->id) {
                            echo 'selected';
                        }
                        ?> >{!! $business_hour->name !!}</option>
                        @endforeach
                    </select>
                </td>

                <td>
                    <select name="send_email" class="form-control">
                        <option value="1" <?= $sla_target && $sla_target->send_email == 1 ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.yes')}}</option>
                        <option value="0"  <?= $sla_target && $sla_target->send_email == 0 ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.no')}}</option>
                    </select>
                </td>

                <td>
                    <select name="send_sms" class="form-control">
                        <option value="1" <?= $sla_target && $sla_target->send_sms == 1 ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.yes')}}</option>
                        <option value="0" <?= $sla_target && $sla_target->send_sms == 0 ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.no')}}</option>

                    </select> 
                </td>
                </td>
            </tr>
        </table>
    </div>
    <div class="box-header with-border">
        <h4>{{Lang::get('lang.apply_this_to:')}}
        </h4>

        <div class="box box-default">
            <div class="box-header with-border">
                {!!Lang::get('lang.choose_when_this_SLA_policy_must_be_enforced')!!}
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="box-header with-border">
                    <div class="from-group">


                        <div class="modal-body">
                            <div class="panel-heading"> 
                                <!-- <h4>{{Lang::get('lang.apply_this_to:')}}</h4> -->
                                <!-- <br/>{{Lang::get('lang.choose_when_this_SLA_policy_must_be_enforced')}} -->
                            </div>
                            <div class="sla_policy_conditions_container">
                                <div class="panel-body">
                                    <div id="form7">

                                          @if($apply_sla_company!="")
                                          <div class="form-group value-here" id="company_id" >
                                            <div class="row">
                                                <div class="col-md-2 col-sm-2 col-xs-2">
                                                    <label class=" control-label"><span data-class="tagit-plgn-company" class="glyphicon glyphicon glyphicon-minus-sign" aria-hidden="true" style="color:#990000;"></span> {{Lang::get('lang.company')}}</label>
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


                                                                 @forelse($apply_sla_company as $values)
                                                                        <li>{!! $values !!}</li>
                                                                        @empty 
                                                                        @endforelse


                                                                      
                                                                </ul >

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>



                                                </div>

                                            </div>
                                        </div>
                                        @else
                                            <div class="form-group" id="company_id" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-2 col-sm-2 col-xs-2">
                                                    <label class=" control-label"><span data-class="tagit-plgn-company" class="glyphicon glyphicon glyphicon-minus-sign" aria-hidden="true" style="color:#990000;"></span> {{Lang::get('lang.company')}}</label>
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
                                        @endif
                                     @if($apply_sla_tickettype!="")
                                     <div class="form-group value-here" id="type_id">
                                            <div class="row">
                                                <div class="col-md-2 col-sm-2 col-xs-2">
                                                    <label class=" control-label"><span data-class="tagit-plgn-type" class="glyphicon glyphicon glyphicon-minus-sign" aria-hidden="true" style="color:#990000;"></span> {{Lang::get('lang.type')}}</label>
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

                                                                    @forelse($apply_sla_tickettype as $values)
                                                                        <li>{!! $values !!}</li>
                                                                        @empty 
                                                                        @endforelse

                                                                      
                                                                </ul >

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>



                                                </div>

                                            </div>
                                        </div>
                                        @else
                                        <div class="form-group" id="type_id" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-2 col-sm-2 col-xs-2">
                                                    <label class=" control-label"><span data-class="tagit-plgn-type" class="glyphicon glyphicon glyphicon-minus-sign" aria-hidden="true" style="color:#990000;"></span> {{Lang::get('lang.type')}}</label>
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
                                        @endif


                                        


                                        <!-- @if($apply_sla_depertment != "") -->
                                       

                                  
                                        <!-- @endif -->
                                           @if($apply_sla_ticketsource!="")
                                            <div class="form-group value-here" id="source_id">
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


                                                                    @forelse($apply_sla_ticketsource as $values)
                                                                        <li>{!! $values !!}</li>
                                                                        @empty 
                                                                        @endforelse

                                                                      
                                                                </ul >

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                                </div>
                                            </div>
                                        </div> 
                                        @else
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
                                        @endif
                                       
                                         @if($apply_sla_depertment!="")
                                              <div class="form-group value-here" id="department_id">

                                            <div class="row" >
                                                <div class="col-md-2 col-sm-2 col-xs-2">
                                                    <label class=" control-label"><span data-class="tagit-plgn-dept" class="glyphicon glyphicon glyphicon-minus-sign" aria-hidden="true"  style="color:#990000;"></span> {{Lang::get('lang.departments')}}</label>
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

                                                                 @forelse($apply_sla_depertment as $values)
                                                                        <li>{!! $values !!}</li>
                                                                        @empty 
                                                                        @endforelse


                                                                      
                                                                </ul >

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                                </div>
                                            </div>
                                        </div>
                                        @else
                                              <div class="form-group" id="department_id" style="display: none;">

                                            <div class="row" >
                                                <div class="col-md-2 col-sm-2 col-xs-2">
                                                    <label class=" control-label"><span data-class="tagit-plgn-dept" class="glyphicon glyphicon glyphicon-minus-sign" aria-hidden="true"  style="color:#990000;"></span> {{Lang::get('lang.departments')}}</label>
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
                                        @endif


                                    
                                     
                                    
                                 

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
                                                <li><a href="javascript:void(0)" data-cond="department_id" class="sla_policy_list"> {{Lang::get('lang.departments')}}</a></li>
                                            </ul>
                                        </div>
                                    </div>


                                </div>

                            </div> 
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

    </div>





    <div class="box-header with-border">
        <p>Set SLA reminders :
        <href="#" data-toggle="modal" data-target="#myModal">
            <span class="glyphicon glyphicon-bell"></span>



            <div class="box box-info">
                <div class="box-header with-border">
                    {!!Lang::get('lang.What_happens_when_this_SLA_due_time_approaches')!!}
                </div><!-- /.box-header -->
                <div class="box-body">


                    <div class="box box-default">
                        <div class="box-header with-border">
                            {!!Lang::get('lang.set_reminder_rule_when_a_ticket_response_time_approaches')!!}
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="modal-body">
                                <!-- <div class="panel-heading">{{Lang::get('lang.set_reminder_rule_when_a_ticket_response_time_approaches')}}</div> -->

                                @if(!empty($sla_approaches_response_time))
                                <?php foreach ($sla_approaches_response_persons as $key => $value): ?>
                                    <div class="panel-body">
                                        <div class="form-group" id="form11">
                                            <div class="row" >
                                                <div class="col-md-2 col-sm-2 col-xs-2">
                                                    <label class=" control-label" >
                                                        <span class="glyphicon glyphicon glyphicon-minus-sign response-approaches11" aria-hidden="true" style="color:#990000; "></span >&nbsp;&nbsp;&nbsp; 
                                                        {{Lang::get('lang.escalate')}}

                                                    </label>
                                                </div>

                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    <select class="form-control" name="approaches_response_escalate_time">
                                                        <option value="null" <?= $key == 'null' ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.select')}}</option>
                                                        <option value="-30" <?= $key == '-30' ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.before_30_minites')}}</option>
                                                        <option value="-60" <?= $key == '-60' ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.before_1_hour')}}</option>
                                                        <option value="-120" <?= $key == '-120' ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.before_2_hour')}}</option>
                                                        <option value="-1440" <?= $key == '-1440' ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.before_1_day')}}</option>
                                                        <option value="-10080" <?= $key == '-10080' ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.before_7_day')}}</option>
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
                                                                        <ul class="form-group tagit-plgn" id="tagit-plgn1" data-name="nameOfSelect" name="approaches_response_escalate_person[]" tagvalue="tagvalue" >


                                                                            @forelse($value as $values)
                                                                            <li>{!! $values !!}</li>
                                                                            @empty 

                                                                            @endforelse

                                                                        </ul>

                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                        <label class="control-label hide" id="label11" style="font-family:inherit;"><span class="glyphicon glyphicon glyphicon-plus-sign" aria-hidden="true" style="color:#009853; "></span >&nbsp; &nbsp;{{Lang::get('lang.add_rule')}}</label>                                       
                                    </div> 
                                <?php endforeach; ?>
                                @else
                                <div class="panel-body">
                                    <!-- <div class="form-group response"> -->
                                    <div class="row" id="form12" style="display: none;">
                                        <div class="col-md-2 col-sm-2 col-xs-2">
                                            <label class=" control-label" ><span class="glyphicon glyphicon glyphicon-minus-sign response-approaches12" aria-hidden="true" style="color:#990000; "></span >&nbsp;&nbsp;&nbsp; {{Lang::get('lang.escalate')}}</label>
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
                                                                   <!--  <li data-value="department manager">department manager</li>
                                                                    <li data-value="team lead">team lead</li>
                                                                    <li data-value="admin">admin</li> -->

                                                                    <!-- <li data-value="assigner">{{Lang::get('lang.assigner')}}</li>
                                                                    <li data-value="department_manager">{{Lang::get('lang.department_manager')}}</li>
                                                                    <li data-value="team_lead">{{Lang::get('lang.team_lead')}}</li>
                                                                    <li data-value="admin">{{Lang::get('lang.admin')}}</li> -->

                                                                </ul >

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>






                                        </div>

                                    </div>
                                    <!-- </div> -->
                                    <label class=" control-label" id="label12" style="font-family:inherit;"><span class="glyphicon glyphicon glyphicon-plus-sign" aria-hidden="true" style="color:#009853; "></span >&nbsp; &nbsp;{{Lang::get('lang.add_rule')}}</label>                                       
                                </div> 


                                @endif
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
                                @if(!empty($sla_approaches_resolution_time))
                                <?php foreach ($sla_approaches_resolution_persons as $key => $value): ?>
                                    <div class="panel-body">
                                        <div class="row" id="form21">

                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <label class=" control-label">
                                                    <span class="glyphicon glyphicon glyphicon-minus-sign resolution-approaches21" aria-hidden="true" style="color:#990000; "></span >&nbsp;&nbsp;&nbsp;
                                                    {{Lang::get('lang.escalate')}}</label>
                                            </div>

                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <select class="form-control" name="approaches_resolution_escalate_time">
                                                    <option value="null" <?= $key == 'null' ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.select')}}</option>
                                                    <option value="-30" <?= $key == '-30' ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.before_30_minites')}}</option>
                                                    <option value="-60" <?= $key == '-60' ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.before_1_hour')}}</option>
                                                    <option value="-120" <?= $key == '-120' ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.before_2_hour')}}</option>
                                                    <option value="-1440" <?= $key == '-1440' ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.before_1_day')}}</option>
                                                    <option value="-10080" <?= $key == '-10080' ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.before_7_day')}}</option>
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

                                                                    <ul class="form-group tagit-plgn1" id="tagit-plgn2" data-name="nameOfSelect" name="approaches_resolution_escalate_person[]" tagvalue="tagvalue" >

                                                                        @forelse($value as $values)
                                                                        <li>{!! $values !!}</li>
                                                                        @empty 

                                                                        @endforelse




                                                                    </ul>

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>



                                            </div>
                                        </div>

                                        <label class="control-label hide" id="label21" style="font-family:inherit;"><span class="glyphicon glyphicon glyphicon-plus-sign" aria-hidden="true" style="color:#009853; "></span >&nbsp; &nbsp;{{Lang::get('lang.add_rule')}}</label>                                       
                                    </div>
                                <?php endforeach; ?>
                                @else
                                <div class="panel-body">
                                    <div class="row" id="form22" style="display: none;">

                                        <div class="col-md-2 col-sm-2 col-xs-2">
                                            <label class=" control-label"><span class="glyphicon glyphicon glyphicon-minus-sign resolution-approaches22" aria-hidden="true" style="color:#990000; "></span >&nbsp;&nbsp;&nbsp; {{Lang::get('lang.escalate')}}</label>
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
                                                                   <!--  <li data-value="department manager">department manager</li>
                                                                    <li data-value="team lead">team lead</li>
                                                                    <li data-value="admin">admin</li> -->
                                                                   <!--  <li data-value="assigner">{{Lang::get('lang.assigner')}}</li>
                                                                    <li data-value="department_manager">{{Lang::get('lang.department_manager')}}</li>
                                                                    <li data-value="team_lead">{{Lang::get('lang.team_lead')}}</li>
                                                                    <li data-value="admin">{{Lang::get('lang.admin')}}</li> -->

                                                                </ul>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>






                                        </div>
                                    </div>

                                    <label class=" control-label" id="label22" style="font-family:inherit;"><span class="glyphicon glyphicon glyphicon-plus-sign" aria-hidden="true" style="color:#009853; "></span >&nbsp; &nbsp;{{Lang::get('lang.add_rule')}}</label>                                       
                                </div>
                                @endif

                            </div> 
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->




                </div><!-- /.box-body -->
            </div><!-- /.box -->



            <div class="box box-info">
                <div class="box-header with-border">
                    {!!Lang::get('lang.what_happens_when_this_SLA_is_violated?')!!}
                </div><!-- /.box-header -->
                <div class="box-body">


                    <div class="box box-default">
                        <div class="box-header with-border">
                            {!!Lang::get('lang.set_escalation_rule_when_a_ticket_is_not_responded_to_on_time')!!}
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="modal-body">
                                <!-- <div class="panel-heading">{{Lang::get('lang.set_escalation_rule_when_a_ticket_is_not_responded_to_on_time')}}</div> -->

                                <!-- violated_resolved_persons -->


                                @if(!empty($sla_violated_responded_time))

                                <?php foreach ($violated_responded_persons as $key => $value): ?>




                                    <div class="panel-body">
                                        <div class="row" id="form31">
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <label class=" control-label">
                                                    <span class="glyphicon glyphicon glyphicon-minus-sign response-violated31" aria-hidden="true" style="color:#990000;"></span>&nbsp;&nbsp;&nbsp; 
                                                    {{Lang::get('lang.escalate')}}</label>
                                            </div>

                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <select class="form-control" name="violated_response_escalate_time">
                                                    <option value="null" <?= $key == 'null' ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.select')}}</option>
                                                    <option value="+30"<?= $key == '+30' ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.after_30_minites')}}</option>
                                                    <option value="+60" <?= $key == '+60' ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.after_1_hour')}}</option>
                                                    <option value="+120" <?= $key == '+120' ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.after_2_hour')}}</option>
                                                    <option value="+1440" <?= $key == '+1440' ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.after_1_day')}}</option>
                                                    <option value="+10080" <?= $key == '+10080' ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.after_7_day')}}</option>
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

                                                                    <ul class="form-group" id="tagit-plgn3"  data-name="nameOfSelect" name="violated_response_escalate_person[]" tagvalue="tagvalue" >

                                                                        @forelse($value as $values)
                                                                        <li>{!! $values !!}</li>
                                                                        @empty 
                                                                        @endforelse




                                                                    </ul>

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>






                                            </div>
                                        </div>


                                        <label class="control-label hide" id="label31" style="font-family:inherit;"><span class="glyphicon glyphicon glyphicon-plus-sign" aria-hidden="true" style="color:#009853; "></span >&nbsp; &nbsp;{{Lang::get('lang.add_rule')}}</label>                                       
                                    </div>


                                <?php endforeach; ?>
                                @else
                                <div class="panel-body" >
                                    <div class="row" id="form32" style="display: none;">
                                        <div class="col-md-2 col-sm-2 col-xs-2">
                                            <label class=" control-label"><span class="glyphicon glyphicon glyphicon-minus-sign response-violated32" aria-hidden="true" style="color:#990000;"></span>&nbsp;&nbsp;&nbsp; {{Lang::get('lang.escalate')}}</label>
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
                                                                  <!--   <li data-value="department manager">department manager</li>
                                                                    <li data-value="team lead">team lead</li>
                                                                    <li data-value="admin">admin</li> -->
                                                                  <!--   <li data-value="assigner">{{Lang::get('lang.assigner')}}</li>
                                                                    <li data-value="department_manager">{{Lang::get('lang.department_manager')}}</li>
                                                                    <li data-value="team_lead">{{Lang::get('lang.team_lead')}}</li>
                                                                    <li data-value="admin">{{Lang::get('lang.admin')}}</li> -->

                                                                </ul>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>



                                        </div>

                                    </div>

                                    <label class="control-label" id="label32" style="font-family:inherit;"><span class="glyphicon glyphicon glyphicon-plus-sign" aria-hidden="true" style="color:#009853; "></span >&nbsp; &nbsp;{{Lang::get('lang.add_rule')}}</label>
                                </div>

                                @endif









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

                                <span class="row target-area-div " id="target-area-div"> 
                                    @if($violated_resolved_time_persons!=null)


                                    <?php foreach ($violated_resolved_time_persons as $key => $value): ?>


                                        <!-- <div class="panel-body" > -->

                                        <div class="row  source-counter">
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <label class=" control-label1"><span class="glyphicon glyphicon glyphicon-minus-sign resolved-violated" aria-hidden="true" style="color:#990000;"></span>&nbsp;&nbsp;&nbsp; {{Lang::get('lang.escalate')}}</label>
                                            </div>

                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <select class="form-control violated_time" id="violated_time" name="violated_resolution_escalate_time[]">

                                                    <option value="+30"<?= $key == '+30' ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.after_30_minites')}}</option>
                                                    <option value="+60" <?= $key == '+60' ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.after_1_hour')}}</option>
                                                    <option value="+120" <?= $key == '+120' ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.after_2_hour')}}</option>
                                                    <option value="+1440" <?= $key == '+1440' ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.after_1_day')}}</option>
                                                    <option value="+10080" <?= $key == '+10080' ? ' selected="selected"' : ''; ?>>{{Lang::get('lang.after_7_day')}}</option>
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

                                                                    <ul class="form-group edit_person violated_resolution_escalate_person violated_person1" id="edit_person" data-name="nameOfSelect" name="violated_resolution_escalate_person[]" tagvalue="tagvalue" >
                                                                        @forelse($value as $values)
                                                                        <li>{!! $values !!}</li>
                                                                        @empty 

                                                                        @endforelse



                                                                    </ul>


                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- </div> -->
                       <!-- <span class="row target-area-div1" id="target-area-div1"></span> -->
                                    <?php endforeach; ?>
                                    @endif

                                </span>




                                <div class="panel-body hide" >

                                    <div class="row source-time-track source-counter">
                                        <div class="col-md-2 col-sm-2 col-xs-2">
                                            <label class=" control-label1"><span class="glyphicon glyphicon glyphicon-minus-sign resolved-violated" aria-hidden="true" style="color:#990000;"></span>&nbsp;&nbsp;&nbsp; {{Lang::get('lang.escalate')}}</label>
                                        </div>

                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <select class="form-control violated_time" id="violated_time"  name="violated_resolution_escalate_time">
                                                <!-- <option value="null">{{Lang::get('lang.select')}}</option> -->
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

                                            <div id="filter-box55">
                                                <div>
                                                    <div class="row">

                                                        <!-- /.col -->
                                                        <div class="col-md-3">
                                                            <div class="form-group">

                                                                <ul class="form-group violated_resolution_escalate_person violated_person1" data-name="nameOfSelect" name="violated_resolution_escalate_person[]" tagvalue="tagvalue" >
                                                                <li data-value="assigner">assigner</li>
                                                                   <!--  <li data-value="department manager">department manager</li>
                                                                    <li data-value="team lead">team lead</li>
                                                                    <li data-value="admin">admin</li> -->
                                                                   <!--  <li data-value="assigner">{{Lang::get('lang.assigner')}}</li>
                                                                    <li data-value="department_manager">{{Lang::get('lang.department_manager')}}</li>
                                                                    <li data-value="team_lead">{{Lang::get('lang.team_lead')}}</li>
                                                                    <li data-value="admin">{{Lang::get('lang.admin')}}</li> -->


                                                                </ul>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>




                                        </div>
                                    </div>
                                </div>
                                <label class="control-label add-time-grid" id="label1" style="font-family:inherit;"><span class="glyphicon glyphicon glyphicon-plus-sign" aria-hidden="true" style="color:#009853; "></span >&nbsp; &nbsp;{{Lang::get('lang.add_rule')}}</label>                                        


                            </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->



                </div><!-- /.box-body -->
            </div><!-- /.box -->










            <!-- Set SLA reminders -->


            <!-- Modal content-->
            <!-- <h4 class="modal-title">{{Lang::get('lang.What_happens_when_this_SLA_due_time_approaches')}}</h4> -->



            <!-- <h4 class="modal-title">{{Lang::get('lang.what_happens_when_this_SLA_is_violated?')}}</h4> -->




            <div class="box-footer">
                {!! Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary'])!!}
            </div>
    </div>
    <!-- close form -->
    {!! Form::close() !!}



    @section('FooterInclude')

<script src="{{asset("lb-faveo/js/jquery.ui.js")}}" type="text/javascript"></script>

<script src="{{asset('lb-faveo/plugins/hailhood-tag/js/tagit.js')}}"></script>

    <script type="text/javascript">



        $('.tagit-plgn-dept').tagit({
            tagSource: "{{url('sla/department/autofill')}}",
            allowNewTags: false,
            placeholder: 'Enter department',
            select: true,
        });
       
</script>
<script src="{{asset('lb-faveo/plugins/hailhood-tag/js/tagit.js')}}"></script>

    <script type="text/javascript">

        $('.tagit-plgn-ticketsources').tagit({
            tagSource: "{{url('sla/ticketsources/autofill')}}",
            allowNewTags: false,
            placeholder: 'Enter ticketsources',
            select: true,
        });
       
</script>
<script src="{{asset('lb-faveo/plugins/hailhood-tag/js/tagit.js')}}"></script>

    <script type="text/javascript">


        $('.tagit-plgn-company').tagit({
            tagSource: "{{url('sla/company/autofill')}}",
            allowNewTags: false,
            placeholder: 'Enter company',
            select: true,
        });
     
</script>
<script src="{{asset('lb-faveo/plugins/hailhood-tag/js/tagit.js')}}"></script>

    <script type="text/javascript">


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







$(document).on("click", "#label11", function() {

    $("#form11").show();
    $("#label11").hide();
});

$(document).on("click", ".response-approaches11", function() {
    // $("response").addClass("hide");
    $("#form11").hide();

    $("#form11").find('select[name="approaches_response_escalate_time"]').val("null");
    // $("#label4").show();
    $("#label11").removeClass("hide");

});


$(document).on("click", "#label12", function() {

    $("#form12").show();
    $("#label12").hide();
});

$(document).on("click", ".response-approaches12", function() {
    // alert('pppp');
    $("#form12").find('select[name="approaches_response_escalate_time"]').val("null");
    $("#form12").hide();

    $("#label12").show();
    // $("#label11").removeClass("hide");
});

$(document).on("click", "#label21", function() {
    // alert('ppp');

    $("#form21").show();
    $("#label21").hide();
});

$(document).on("click", ".resolution-approaches21", function() {
    $("#form21").find('select[name="approaches_resolution_escalate_time"]').val("null");
    $("#form21").hide();

    // $("#label4").show();
    $("#label21").removeClass("hide");
});




$(document).on("click", "#label22", function() {

    $("#form22").show();
    $("#label22").hide();
});

$(document).on("click", ".resolution-approaches22", function() {
    $("#form22").find('select[name="approaches_resolution_escalate_time"]').val("null");
    $("#form22").hide();

    $("#label22").show();
    // $("#label4").removeClass("hide");
});







$(document).on("click", "#label31", function() {

    $("#form31").show();
    $("#labe31").hide();
});

$(document).on("click", ".response-violated31", function() {
    $("#form31").find('select[name="violated_response_escalate_time"]').val("null");
    $("#form31").hide();

    // $("#label4").show();
    $("#label31").removeClass("hide");
});

$(document).on("click", "#label32", function() {

    $("#form32").show();
    $("#label32").hide();
});

$(document).on("click", ".response-violated32", function() {
    $("#form32").find('select[name="violated_response_escalate_time"]').val("null");
    $("#form32").hide();

    $("#label32").show();
    // $("#label4").removeClass("hide");
});

// $(document).on("click", "#label4", function() {

//             $("#form1").show();
//             $("#label4").hide();
//         });

//         $(document).on("click", ".response-approaches", function() {
//             // $("response").addClass("hide");
//             $("#form1").hide();

//             // $("#label4").show();
//             $("#label4").removeClass("hide");
//         });





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

// $(document).on("click", "#label2", function() {

//     $("#form3").show();
//     $("#label2").hide();
// });

// $(document).on("click", ".response-violated", function() {

//     $("#form3").hide();
//     // $("#label2").show();
//      $("#label2").removeClass("hide");
// });




    </script>


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
    <script type="text/javascript">
        function showhidefilter()
        {
            var div = document.getElementById("filter-box1");
            if (div.style.display !== "none") {
                div.style.display = "none";
            } else {
                div.style.display = "block";

            }
        }
    </script>



    <script type="text/javascript">

        var counter = $('#target-area-div').find('.source-counter').length;


        $('#target-area-div').find('.violated_resolution_escalate_person').each(function(counter) {
            $(this).attr('id', 'edit_person' + counter);
        });


    </script>


    <script src="{{asset('lb-faveo/plugins/hailhood-tag/js/tagit.js')}}"></script> -->
    <script type="text/javascript">
        $('#edit_person0').tagit({
            tagSource: "{{url('sla/assigner/autofill')}}",
            allowNewTags: false,
            placeholder: 'Enter assigner',
            select: true,
        });
    </script>
    <script src="{{asset('lb-faveo/plugins/hailhood-tag/js/tagit.js')}}"></script> -->
    <script type="text/javascript">
        $('#edit_person1').tagit({
            tagSource: "{{url('sla/assigner/autofill')}}",
            allowNewTags: false,
            placeholder: 'Enter assigner',
            select: true,
        });
    </script>
    <script src="{{asset('lb-faveo/plugins/hailhood-tag/js/tagit.js')}}"></script> -->
    <script type="text/javascript">
        $('#edit_person2').tagit({
            tagSource: "{{url('sla/assigner/autofill')}}",
            allowNewTags: false,
            placeholder: 'Enter assigner',
            select: true,
        });
    </script>
    <script src="{{asset('lb-faveo/plugins/hailhood-tag/js/tagit.js')}}"></script> -->
    <script type="text/javascript">
        $('#edit_person3').tagit({
            tagSource: "{{url('sla/assigner/autofill')}}",
            allowNewTags: false,
            placeholder: 'Enter assigner',
            select: true,
        });
    </script>
    <script src="{{asset('lb-faveo/plugins/hailhood-tag/js/tagit.js')}}"></script> -->
    <script type="text/javascript">
        $('#edit_person4').tagit({
            tagSource: "{{url('sla/assigner/autofill')}}",
            allowNewTags: false,
            placeholder: 'Enter assigner',
            select: true,
        });
    </script>












    <script src="{{asset('lb-faveo/plugins/hailhood-tag/js/tagit.js')}}"></script>
    <script type="text/javascript">
        $('#tagit-plgn1').tagit({
            tagSource: "{{url('sla/assigner/autofill')}}",
            allowNewTags: false,
            placeholder: 'Enter assigner',
            select: true,
        });
    </script>
    <script src="{{asset('lb-faveo/plugins/hailhood-tag/js/tagit.js')}}"></script>
    <script type="text/javascript">
        $('#tagit-plgn2').tagit({
            tagSource: "{{url('sla/assigner/autofill')}}",
            allowNewTags: false,
            placeholder: 'Enter assigner',
            select: true,
        });
    </script>
    <script src="{{asset('lb-faveo/plugins/hailhood-tag/js/tagit.js')}}"></script>
    <script type="text/javascript">
        $('#tagit-plgn3').tagit({
            tagSource: "{{url('sla/assigner/autofill')}}",
            allowNewTags: false,
            placeholder: 'Enter assigner',
            select: true,
        });
    </script>

    <script type="text/javascript">
        // approaches

        // $(document).on("click", "#label3", function() {

        //     $("#form4").show();
        //     $("#label3").hide();
        // });

        // $(document).on("click", ".resolution-approaches", function() {

        //     $("#form4").hide();
        //      $("#label3").removeClass("hide");
        //     // $("#label3").show();
        // });







        // $(document).on("click", "#label4", function() {

        //     $("#form1").show();
        //     $("#label4").hide();
        // });

        // $(document).on("click", ".response-approaches", function() {
        //     $(this).parent().parent().parent().remove();
        //     $("#form1").hide();

        //     $("#label4").show();
        // });










        // $(document).on("click", "#label2", function() {

        //     $("#form3").show();
        //     $("#label2").hide();
        // });

        // $(document).on("click", ".resolution-violated", function() {

        //     $("#form3").hide();
        //     $("#label2").show();
        // });


    </script>

    <!-- 
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
    
    
    
    
        </script>
    -->

   <!--  <script src="{{asset('lb-faveo/plugins/hailhood-tag/js/tagit.js')}}"></script>
    <script type="text/javascript">

    $('#target-area-div').find('.source-counter').find('.violated_resolution_escalate_person').each(function(event) {

        $('.violated_resolution_escalate_person').tagit({
            tagSource: "{{url('sla/assigner/autofill')}}",
            allowNewTags: false,
            placeholder: 'Enter assigner',
            select: true,
        });

}


    </script> -->



    <script src="{{asset('lb-faveo/plugins/hailhood-tag/js/tagit.js')}}"></script>
    <script type="text/javascript">



        $('.add-time-grid').on('click', function(event) {

            //$('.add-time-grid').hide();




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

//alert(counter);

            $('#target-area-div').find('.violated_resolution_escalate_person').each(function(counter) {
                $(this).attr('name', 'violated_resolution_escalate_person' + counter + '[]');
            });

            $('#target-area-div').find('.violated_time').each(function(counter) {
                // var counter = $('#target-area-div').find('.source-counter').length;
                // alert(counter);

                $(this).attr('name', 'violated_resolution_escalate_time' + counter + '[]');
                //               var selectedItem = $(this).val();


                //               var $dropdown2 = $("select[name='violated_resolution_escalate_time']");
                //                var $dropdown2 = $("select[name='violated_resolution_escalate_time']");
                //                   var $dropdown4 = $("select[name='violated_resolution_escalate_time[]']");
                //                    // $dropdown3.find('option[value="' + selectedItem + '"]').prop("disabled", true)

                //                    //$dropdown4.find('option[value="' + selectedItem + '"]').prop("disabled", true);
                //               $(this).on('change', function(event) {
                //                   var selectedItem1 = $(this).val();
                // // //                       alert('hgf');
                // $('#target-area-div').find('.violated_time').not(this).find('option[value="' + selectedItem1 + '"]').prop("disabled", true);
                // $('#target-area-div').find('.violated_time').find('option[value="' + selectedItem + '"]').prop("disabled", true);

                //                   var selectedItem = $(this).val();
                //                    $dropdown2.find('option[value="' + selectedItem + '"]').prop("disabled", false);
                //                   // alert(selectedItem);
                //                   if (selectedItem) {
                //                       $dropdown2.find('option[value="' + selectedItem + '"]').prop("disabled", true);

                //                       $(this).find('option').prop("disabled", false);
                //                       $(this).find('option[value="' + selectedItem + '"]').prop("disabled", false);
                //                       //$(this).prop("disabled", true);
                //                   }








                var counter = $('#target-area-div').find('.source-counter').length;
                // if (counter == 5) {
                //     $('.add-time-grid').hide();

                // }
                // else {
                //     $('.add-time-grid').show();
                // }
                // });

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
                        // alert(selectedItem1);
                        $('#target-area-div').find('.violated_time').not(this).find('option[value="' + selectedItem1 + '"]').prop("disabled", true);

                        // $(this).find('.violated_time').find('option[value="' + selectedItem1 + '"]').prop("disabled", false);

                        $('#target-area-div').find('.violated_time').not(this).find('option[value="' + selectedItem + '"]').prop("disabled", false);
                        $dropdown3.find('option[value="' + selectedItem1 + '"]').prop("disabled", true);
                        $dropdown3.find('option[value="' + selectedItem + '"]').prop("disabled", false);
                        $dropdown4.find('option[value="' + selectedItem1 + '"]').prop("disabled", true);

                    });
                });



            });

            //           $('#target-area-div').find('.violated_time').each(function(event) {
            //                var selectedItem = $(this).val();
            //                // alert(selectedItem);
            //                  $('#target-area-div').find('.violated_time').not(this).find('option[value="' + selectedItem + '"]').prop("disabled", true);
            //                   var $dropdown3 = $("select[name='violated_resolution_escalate_time']");
            //                   var $dropdown4 = $("select[name='violated_resolution_escalate_time[]']");
            //                     $dropdown3.find('option[value="' + selectedItem + '"]').prop("disabled", true);

            //                     $(this).on('change', function(event) {
            //                        var selectedItem1 = $(this).val();
            //                       alert('fffff');
            // $('#target-area-div').find('.violated_time').not(this).find('option[value="' + selectedItem1 + '"]').prop("disabled", true);
            // $('#target-area-div').find('.violated_time').not(this).find('option[value="' + selectedItem + '"]').prop("disabled", false);
            // $dropdown3.find('option[value="' + selectedItem1 + '"]').prop("disabled", true);
            // $dropdown3.find('option[value="' + selectedItem + '"]').prop("disabled", false);
            // $dropdown4.find('option[value="' + selectedItem1 + '"]').prop("disabled", true);

            //                        }); 
            //              }); 

            if (counter == 5) {
                $('.add-time-grid').hide();

            }


        });

    </script>

    @stop 

    <script type="text/javascript">
        var counter = $('#target-area-div').find('.source-counter').length;
        if (counter != 0) {
            $('#target-area-div').find('.violated_resolution_escalate_person').each(function(counter) {
                $(this).attr('name', 'violated_resolution_escalate_person' + counter + '[]')
            });

            for (i = 0; i <= counter; i++) {
                $('#target-area-div').find('.violated_time').each(function(counter) {


                    $(this).attr('name', 'violated_resolution_escalate_time' + counter + '[]');


                    var selectedItem = $(this).val();
                    var $dropdown2 = $("select[name='violated_resolution_escalate_time']");
                    //var $dropdown3 = $("select[name='violated_resolution_escalate_time[]']");
                    // alert($dropdown2);


                    $dropdown2.find('option[value="' + selectedItem + '"]').prop("disabled", true);

                    var selectedItem = $(this).val();
                    //alert(selectedItem);
                    if (selectedItem) {
                        //$dropdown2.find('option[value="' + selectedItem + '"]').prop("disabled", true);
                        $(this).find('option').prop("disabled", false);
                        $(this).find('option[value="' + selectedItem + '"]').prop("disabled", false);
                        //$(this).prop("disabled", true);
                    }
                });
            }
            if (counter == 5) {
                $('.add-time-grid').hide()

            }
            else {
                $('.add-time-grid').show()
            }

        }


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



            // alert(selectedItem);
            // if (selectedItem) {
            //     $dropdown2.find('option[value="' + selectedItem + '"]').prop("disabled", false);
            // }

            var counter = $('#target-area-div').find('.source-counter').length;


            // alert(counter);

            $('#target-area-div').find('.violated_person1').each(function(counter) {
                $(this).attr('name', 'violated_resolution_escalate_person' + (counter) + '[]');
            });

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
               // $(this).parents('.form-group').hide();
            // $(this).parents('.row').find('.select').select2("val", "");
            $('.'+target_class).tagit("fill",[]);
         

 $(this).parents('.form-group').hide();

        });


        // <div class="sla_policy_conditions_container">
        //                         <div class="panel-body">
        //                             <div id="form7">


           $(document).ready(function() {
           $('.sla_policy_conditions_container').find('.value-here').each(function(event) {
          

            var id = $(this).attr("id");
          
            
            

            $('.add-sla-policy-bb-box').find("ul").find("[data-cond='" + id + "']").parent().hide();
       
    })

})
    </script>
    <script type="text/javascript">

        //before submit from all desable value enable     
        $(document).on('submit', function() {
            // alert('submit');
            $('#target-area-div').find('.violated_time').find('option').prop("disabled", false);

        });

    </script>



    @stop