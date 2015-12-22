@extends('themes.default1.agent.layout.agent')

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
        <h3 class="box-title">{!! Lang::get('lang.create_ticket') !!}</h3>
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
                <b>Success</b>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{Session::get('success')}}
            </div>
        @endif
        <!-- failure message -->
        @if(Session::has('fails'))
            <div class="alert alert-danger alert-dismissable">
                <i class="fa fa-ban"></i>
                <b>Fail!</b>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{Session::get('fails')}}
            </div>
        @endif
        <div class="form-group">
            <h4><b>{!! Lang::get('lang.user_details') !!}:<b></h4>
                {{-- <div class="row"> --}}
                    {{-- <div class="col-md-6"> --}}
                            {{-- <div class="has-feedback"> --}}
                            {{-- <input type="text" class="form-control input-ls" placeholder="Search Users"/> --}}
                                {{-- <span class="glyphicon glyphicon-search form-control-feedback"></span> --}}
                            {{-- </div> --}}
                        {{-- <input type="text" name="email" id="" class="form-control" placeholder="Search User"> --}}
                    {{-- </div> --}}
                {{-- </div> --}}
                <br/>
            <div class="row">
                <div class="col-md-4">
                <!-- email -->
                    <div class="form-group">
                        <label>{!! Lang::get('lang.email') !!}:</label>
                        <input type="text" name="email" id="" class="form-control">
                        {!! $errors->first('email', '<spam class="help-block text-red">:message</spam>') !!}
                    </div>
                </div>
           
                <div class="col-md-4">
                <!-- full name -->
                    <div class="form-group">
                        <label>{!! Lang::get('lang.full_name') !!}:</label>
                        <input type="text" name="fullname" id="" class="form-control">
                        {!! $errors->first('fullname', '<spam class="help-block text-red">:message</spam>') !!}
                    </div>
                </div>
                <div class="col-md-4">
                <!-- phone -->
                    <div class="form-group">
                        <label>{!! Lang::get('lang.phone') !!}:</label>
                        <input type="number" name="phone" id="" class="form-control">
                        {!! $errors->first('phone', '<spam class="help-block text-red">:message</spam>') !!}
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
                <h4><b>{!! Lang::get('lang.ticket_option') !!}<b></h4>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>{!! Lang::get('lang.help_topic') !!}:</label>
                            <!-- helptopic -->
                            <select class="form-control" name="helptopic">
                            <!-- <option>--select--</option> -->
                                <?php $helptopic = App\Model\helpdesk\Manage\Help_topic::all();?>
                                    @foreach($helptopic as $topic)
                                   <option value="{!! $topic->id !!}">{!! $topic->topic !!}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('helptopic', '<spam class="help-block text-red">:message</spam>') !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                <!-- sla plan -->
                                    <div class="form-group">
                                        <label>{!! Lang::get('lang.sla_plan') !!}:</label>
                                        <select class="form-control" name="sla">
                                            <!-- <option>--select--</option> -->
                                            <?php $sla_plan = App\Model\helpdesk\Manage\Sla_plan::all();?>
                                            @foreach($sla_plan as $sla)
                                            <option value="{!! $sla->id !!}">{!! $sla->grace_period !!}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('sla', '<spam class="help-block text-red">:message</spam>') !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                <!-- due date -->
                                    <div class="form-group">
                                        <label>{!! Lang::get('lang.due_date') !!}:</label>
                                        <input type="text" class="form-control" name="duedate" id="datemask">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                <!-- assign to -->
                                    <div class="form-group">
                                        <label>{!! Lang::get('lang.assign_to') !!}:</label>
                                        <select class="form-control" name="assignto">
                                            <!-- <option>--select--</option> -->
                                            <?php $agents = App\User::where('role','!=','user')->get();?>
                                                <option value="">--- select ---</option>
                                            @foreach($agents as $agent)
                                                <option value="{!! $agent->id !!}">
                                                    {!! $agent->first_name !!} {!! $agent->last_name !!}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            </div>
                                <!-- ticket details -->
                                <div class="form-group">
                                    <h4><b>{!! Lang::get('lang.ticket_detail') !!}<b></h4>
                                        <!-- subject -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label>{!! Lang::get('lang.subject') !!}:</label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="text" name="subject" class="form-control">
                                                            {!! $errors->first('subject', '<spam class="help-block text-red">:message</spam>') !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                <!-- details -->
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label>{!! Lang::get('lang.detail') !!}:</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <textarea class="form-control" id="body" name="body" style="width:100%; height:100px;"></textarea>
                                                            {!! $errors->first('body', '<spam class="help-block text-red">:message</spam>') !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                <!-- priority -->
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label>{!! Lang::get('lang.priority') !!}:</label>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <select class="form-control" name="priority">
                                                                <!-- <option>--select--</option> -->
                                                                <?php $Priority = App\Model\helpdesk\Ticket\Ticket_Priority::all();?>
                                                                @foreach($Priority as $priority)
                                                                <option value="{{$priority->priority_id}}">{!! $priority->priority_desc !!}</option>
                                                                @endforeach
                                                            </select>
                                                            {!! $errors->first('priority', '<spam class="help-block text-red">:message</spam>') !!}
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
                                                        <input type="submit" value="{!! Lang::get('lang.create_ticket') !!}" class="btn btn-primary">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /. box -->
                                {!! Form::close() !!}

                                <script type="text/javascript">
                                    $(function() {
                                        $('#datemask').datepicker({changeMonth: true, changeYear: true}).mask('99/99/9999');
                                    });
                                </script>
                            @stop