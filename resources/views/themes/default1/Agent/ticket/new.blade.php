@extends('themes.default1.layouts.agentblank')

@section('Tickets')
class="active"
@stop

@section('ticket-bar')
active
@stop

@section('newticket')
class="active"
@stop


@section('content')

<!-- Main content -->
{!! Form::open(['route'=>'post.newticket','method'=>'post']) !!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Create Ticket</h3>
        <!-- <div class="box-tools pull-right">
            <div class="has-feedback">
                <input type="text" class="form-control input-sm" placeholder="Search Mail"/>
                <span class="glyphicon glyphicon-search form-control-feedback"></span>
            </div>
        </div> --><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">

<!-- user detail -->
    @if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <i class="fa  fa-check-circle"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('success')}}
    </div>
    @endif
    <!-- failure message -->
    @if(Session::has('fails'))
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('fails')}}
    </div>
    @endif
            <div class="form-group">
                <h4><b>User Details:<b></h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="text" name="email" id="" class="form-control">
                            {!! $errors->first('email', '<spam class="help-block text-red">:message</spam>') !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Full Name:</label>
                            <input type="text" name="fullname" id="" class="form-control">
                            {!! $errors->first('fullname', '<spam class="help-block text-red">:message</spam>') !!}
                        </div>
                    </div>
                   <!--  <div class="form-group">
                        <div class="col-md-2">
                            <label>Ticket Notice:</label>
                        </div>
                        <div class="col-md-6">
                            <input type="checkbox" name="notice" id=""> Send alert to User
                        </div>
                    </div> -->
                </div>
            </div>
<!-- ticket options -->
            <div class="form-group">
                <h4><b>Ticket Option<b></h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Help Topic:</label>
                            <select class="form-control" name="helptopic">
<!--                                 <option>--select--</option> -->
<?php $helptopic = App\Model\Manage\Help_topic::all();?>
@foreach($helptopic as $topic)
                                <option value="{!! $topic->id !!}">{!! $topic->topic !!}</option>
@endforeach
                            </select>
                            {!! $errors->first('helptopic', '<spam class="help-block text-red">:message</spam>') !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Department:</label>
                            <select class="form-control" name="dept">
                                <!-- <option>--select--</option> -->
<?php $dept = App\Model\Agent\Department::all();?>
@foreach($dept as $dep)
                                <option value="{!! $dep->id !!}">{!! $dep->name !!}</option>
@endforeach
                            </select>
                            {!! $errors->first('dept', '<spam class="help-block text-red">:message</spam>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>SLA Plan:</label>
                            <select class="form-control" name="sla">
                                <!-- <option>--select--</option> -->
<?php $sla_plan = App\Model\Manage\Sla_plan::all();?>
@foreach($sla_plan as $sla)
                                <option value="{!! $sla->id !!}">{!! $sla->grace_period !!}</option>
@endforeach
                            </select>
                            {!! $errors->first('sla', '<spam class="help-block text-red">:message</spam>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Due Date:</label>
                            <input type="text" class="form-control" name="duedate" id="datemask">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Assign To:</label>
                            <select class="form-control" name="assignto">
                                <!-- <option>--select--</option> -->
<?php $agents = App\User::all();?>
@foreach($agents as $agent)
                                <option value="{!! $agent->id !!}">{!! $agent->user_name !!}</option>
@endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
<!-- ticket details -->
            <div class="form-group">
                <h4><b>Ticket Detail<b></h4>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1">
                            <label>Subject:</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="subject" class="form-control">
                            {!! $errors->first('subject', '<spam class="help-block text-red">:message</spam>') !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1">
                            <label>Detail:</label>
                        </div>
                        <div class="col-md-9">
                            <textarea class="form-control" name="body"></textarea>
                            {!! $errors->first('body', '<spam class="help-block text-red">:message</spam>') !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1">
                            <label>Priority:</label>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" name="priority">
                                <!-- <option>--select--</option> -->
<?php $Priority = App\Model\Ticket\Ticket_Priority::all();?>
@foreach($Priority as $priority)
                                <option value="{{$priority->priority_id}}">{!! $priority->priority !!}</option>
@endforeach
                            </select>
                            {!! $errors->first('priority', '<spam class="help-block text-red">:message</spam>') !!}
                        </div>
                    </div>
                </div>
            </div>
    </div>
            <div class="box-footer">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1">
                        </div>
                        <div class="col-md-3">
                        <input type="submit" value="Create Ticket" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            </div>
    </div><!-- /. box -->
{!! Form::close() !!}


<script type="text/javascript">
$(function() {
      $('#datemask').datepicker({changeMonth: true, changeYear: true}).
            mask('99/99/9999');
});
</script>


@stop