@extends('themes.default1.admin.layout.admin')

@section('Manage')
active
@stop

@section('manage-bar')
active
@stop

@section('workflow')
class="active"
@stop

@section('HeadInclude')
@stop

<!-- header -->
@section('PageHeader')
<h1>{!! trans('lang.edit_workflow') !!}</h1>
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')
<ol class="breadcrumb">
    <li><a href="{!! URL::route('setting') !!}"><i class="fa fa-dashboard"></i> {!! trans('lang.home') !!}</a></li>
    <li><a href="{!! URL::route('workflow') !!}">{!! trans('lang.ticket_workflow') !!}</a></li>
    <li class="active"><a href="">{!! trans('lang.edit_workflow') !!}</a></li>
</ol>
@stop
<!-- /breadcrumbs -->
<!-- content -->
@section('content')
<form class="form-horizontal" action="{!! URL::route('workflow.update', $id) !!}" method="POST">
    {{ csrf_field() }}
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
            <!-- check whether success or not -->
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
                <i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <b>{!! trans('lang.alert') !!} !</b><br>
                {{Session::get('fails')}}
            </div>
            @endif
            @if(Session::has('errors'))
            <div class="alert alert-danger alert-dismissable">
                <i class="fa fa-ban"></i>
                <b>{!! trans('lang.alert') !!}!</b>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <br/>
                @if($errors->first('name'))
                <li class="error-message-padding">{!! $errors->first('name', ':message') !!}</li>
                @endif
                @if($errors->first('execution_order'))
                <li class="error-message-padding">{!! $errors->first('execution_order', ':message') !!}</li>
                @endif
                @if($errors->first('target_channel'))
                <li class="error-message-padding">{!! $errors->first('target_channel', ':message') !!}</li>
                @endif
                @if($errors->first('rule'))
                <li class="error-message-padding">{!! $errors->first('rule', ':message') !!}</li>
                @endif
                @if($errors->first('action'))
                <li class="error-message-padding">{!! $errors->first('action', ':message') !!}</li>
                @endif
            </div>
            @endif
            <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
                <label for="inputName" class="col-sm-2 control-label">{!! trans('lang.name') !!}</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" placeholder="Name" id="name" name="name" value="{!! $workflow->name !!}" required>
                </div>
            </div>
            <div class="form-group {!! $errors->has('status') ? 'has-error' : '' !!}">
                <label class="col-sm-2 control-label"> {!! trans('lang.status') !!}</label>
                <div class="col-sm-6">
                    <input type="radio" id="inputEmail2" name="status" value="1" <?php
                    if ($workflow->status == 1) {
                        echo "checked";
                    }
                    ?> >&nbsp;&nbsp;<label class="control-label" for="inputEmail2">{!! trans('lang.active') !!}</label>&nbsp;&nbsp;
                    <input type="radio" id="inputEmail1" name="status" value="0" <?php
                    if ($workflow->status == 0) {
                        echo "checked";
                    }
                    ?> >&nbsp;&nbsp;<label class="control-label" for="inputEmail1">{!! trans('lang.inactive') !!}</label>&nbsp;&nbsp;
                </div>
            </div>
            <div class="form-group {!! $errors->has('execution_order') ? 'has-error' : '' !!}">
                <div>
                    <label for="Exceution" class="col-sm-2 control-label">{!! trans('lang.execution_order') !!}</label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control" id="execution_order" name="execution_order" placeholder="{!! trans('lang.execution_order') !!}" value="{!! $workflow->order !!}" required>
                    </div>
                </div>
            </div>
            <div class="form-group {!! $errors->has('target_channel') ? 'has-error' : '' !!}">
                <label class="col-sm-2 control-label">{!! trans('target_channel') !!}</label>
                <div class="col-sm-6">
                    <select class="form-control" name="target_channel" required>
                        <option value=""> -- {!! trans('lang.select_a_channel') !!} -- </option>
                        <option value="A-0" <?php
                        if ($workflow->target == "A-0") {
                            echo "selected='selected'";
                        }
                        ?> >Any</option>
                        <option value="A-1" <?php
                        if ($workflow->target == "A-1") {
                            echo "selected='selected'";
                        }
                        ?> >Web Forms</option>
                        <option value="A-4" <?php
                        if ($workflow->target == "A-4") {
                            echo "selected='selected'";
                        }
                        ?> >API Calls</option>
                        <option value="A-2" <?php
                        if ($workflow->target == "A-2") {
                            echo "selected='selected'";
                        }
                        ?> >Emails</option>

                    </select>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#open" data-toggle="tab">{!! trans('lang.workflow_rules') !!}</a>
                    </li>
                    <li><a href="#close" data-toggle="tab">{!! trans('lang.workflow_action') !!}</a>
                    </li>
                    <li><a href="#delect" data-toggle="tab">{!! trans('lang.internal_notes') !!}</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="open">
                        <div>
                            <div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <table  class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <td>{!! trans('lang.rules') !!}</td>
                                                <td>{!! trans('lang.condition') !!}</td>
                                                <td>{!! trans('lang.statement') !!}</td>
                                                <td>{!! trans('lang.action') !!}</td>
                                            </tr>
                                        </thead>
                                        <tbody class="button1">
                                            <?php $j = 0; ?>
                                            @foreach($workflow_rules as $workflow_rule)
                                            <?php $j++; ?>
                                            <tr id="firstdata{!! $j !!}">
                                                <td>
                                                    <select class="form-control" name="rule[{!! $j-1 !!}][a]" required>
                                                        <option value="">-- {!! trans('lang.select_one') !!} --</option>
                                                        <option value="email" <?php
                                                        if ($workflow_rule->matching_scenario == 'email') {
                                                            echo "selected='selected'";
                                                        }
                                                        ?> >{!! trans('lang.email') !!}</option>
                                                        <option value="email_name" <?php
                                                        if ($workflow_rule->matching_scenario == 'email_name') {
                                                            echo "selected='selected'";
                                                        }
                                                        ?> >{!! trans('lang.email_name') !!}</option>
                                                        <option value="subject" <?php
                                                        if ($workflow_rule->matching_scenario == 'subject') {
                                                            echo "selected='selected'";
                                                        }
                                                        ?>>{!! trans('lang.subject') !!}</option>
                                                        <option value="message"  <?php
                                                        if ($workflow_rule->matching_scenario == 'message') {
                                                            echo "selected='selected'";
                                                        }
                                                        ?> >{!! trans('lang.message') !!}/{!! trans('lang.body') !!}</option>
                                                    </select>
                                                </td>
                                                <td class="col-md-3">
                                                    <select class="form-control" name="rule[{!! $j-1 !!}][b]" required>
                                                        <option value="">-- {!! trans('lang.select_one') !!} --</option>
                                                        <option value="equal" <?php
                                                        if ($workflow_rule->matching_relation == 'equal') {
                                                            echo "selected='selected'";
                                                        }
                                                        ?> >{!! trans('lang.equal_to') !!}</option>
                                                        <option value="not_equal" <?php
                                                        if ($workflow_rule->matching_relation == 'not_equal') {
                                                            echo "selected='selected'";
                                                        }
                                                        ?> >{!! trans('lang.not_equal_to') !!}</option>
                                                        <option value="contains" <?php
                                                        if ($workflow_rule->matching_relation == 'contains') {
                                                            echo "selected='selected'";
                                                        }
                                                        ?> >{!! trans('lang.contains') !!}</option>
                                                        <option value="dn_contain" <?php
                                                        if ($workflow_rule->matching_relation == 'dn_contain') {
                                                            echo "selected='selected'";
                                                        }
                                                        ?> >{!! trans('lang.does_not_contain') !!}</option>
                                                        <option value="starts" <?php
                                                        if ($workflow_rule->matching_relation == 'starts') {
                                                            echo "selected='selected'";
                                                        }
                                                        ?> >{!! trans('lang.starts_with') !!}</option>
                                                        <option value="ends" <?php
                                                        if ($workflow_rule->matching_relation == 'ends') {
                                                            echo "selected='selected'";
                                                        }
                                                        ?> >{!! trans('lang.ends_with') !!}</option>
                                                        <!--                                                        <option value="match" <?php
                                                        if ($workflow_rule->matching_relation == 'match') {
                                                            echo "selected='selected'";
                                                        }
                                                        ?> >Match Regular Expressions</option>
                                                                                                                <option value="not_match" <?php
                                                        if ($workflow_rule->matching_relation == 'not_match') {
                                                            echo "selected='selected'";
                                                        }
                                                        ?> >Does not match Regular Expression</option>-->
                                                    </select>
                                                </td>
                                                <td class="col-md-3">
                                                    <input class="form-control" type="text" name="rule[{!! $j-1 !!}][c]" value="{!! $workflow_rule->matching_value !!}" required>
                                                </td>
                                                <td style="text-align: center">
                                                    <div class="tools"> 
                                                        <span class="btnRemove1" data-toggle="modal" data-target="#">
                                                            <a data-toggle="tooltip" data-placement="top" title="{!! trans('lang.delete') !!}" onclick="document.getElementById('firstdata{!! $j !!}').innerHTML = ''">
                                                                <i class="fa fa-trash-o"></i>
                                                            </a>
                                                        </span> 
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="row" style="padding: 10px 15px 0px">
                                        <div class="pull-right" >
                                            <a class="btn btn-primary btnAdd1">{!! trans('lang.add') !!}</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="close">
                        <div>
                            <div class="box-body">
                                <table  class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td>{!! trans('lang.condition') !!}</td>
                                            <td>{!! trans('lang.rules') !!}</td>
                                            <td>{!! trans('lang.action') !!}</td>
                                        </tr>
                                    </thead>
                                    <tbody class="buttons">
                                        <?php $i = 0; ?>
                                        @foreach($workflow_actions as $workflow_action)
                                        <?php $i++; ?>
                                        <tr id="seconddata{!! $i !!}">
                                            <td>
                                                <select class="form-control" onChange="selectdata({!! $i !!})" id="selected{!! $i !!}" name="action[{!! $i !!}][a]" required>
                                                    <option value="">-- {!! trans('lang.select_an_action') !!} --</option>
                                                    <optgroup label="Ticket">        
                                                        <option value="reject" <?php
                                                        if ($workflow_action->condition == 'reject') {
                                                            echo "selected='selected'";
                                                        }
                                                        ?> >{!! trans('lang.reject_ticket') !!}</option>
                                                        <option value="department" <?php
                                                        if ($workflow_action->condition == 'department') {
                                                            echo "selected='selected'";
                                                        }
                                                        ?> >{!! trans('lang.set_department') !!}</option>
                                                        <option value="priority" <?php
                                                        if ($workflow_action->condition == 'priority') {
                                                            echo "selected='selected'";
                                                        }
                                                        ?> >{!! trans('lang.set_priority') !!}</option>
                                                        <option value="sla" <?php
                                                        if ($workflow_action->condition == 'sla') {
                                                            echo "selected='selected'";
                                                        }
                                                        ?> >{!! trans('lang.set_sla_plan') !!}</option>
                                                        <option value="team" <?php
                                                        if ($workflow_action->condition == 'team') {
                                                            echo "selected='selected'";
                                                        }
                                                        ?> >{!! trans('lang.assign_team') !!}</option>
                                                        <option value="agent" <?php
                                                        if ($workflow_action->condition == 'agent') {
                                                            echo "selected='selected'";
                                                        }
                                                        ?> >{!! trans('lang.assign_agent') !!}</option>
                                                        <option value="helptopic" <?php
                                                        if ($workflow_action->condition == 'helptopic') {
                                                            echo "selected='selected'";
                                                        }
                                                        ?> >{!! trans('lang.set_help_topic') !!}</option>
                                                        <option value="status" <?php
                                                        if ($workflow_action->condition == 'status') {
                                                            echo "selected='selected'";
                                                        }
                                                        ?> >{!! trans('lang.set_ticket_status') !!}</option>
                                                    </optgroup> 
                                                </select>
                                            </td>
                                            <td id="fill{!! $i !!}">
                                                <?php
                                                if ($workflow_action->condition == 'reject') {
                                                    echo "<input type='hidden' name='action[" . $i . "][b]' class='form-control' value='reject'><span text-red>Reject</span>";
                                                } elseif ($workflow_action->condition == 'department') {
                                                    $departments = App\Model\helpdesk\Agent\Department::all();
                                                    $var = "<select name='action[" . $i . "][b]' class='form-control' required>";
                                                    foreach ($departments as $department) {
                                                        if ($workflow_action->action == $department->id) {
                                                            $depart = "selected";
                                                        } else {
                                                            $depart = "";
                                                        }
                                                        $var .= "<option value='" . $department->id . "' " . $depart . ">" . $department->name . "</option>";
                                                    }
                                                    $var .= "</select>";
                                                    echo $var;
                                                } elseif ($workflow_action->condition == 'priority') {
                                                    $priorities = App\Model\helpdesk\Ticket\Ticket_Priority::all();
                                                    $var = "<select name='action[" . $i . "][b]' class='form-control' required>";
                                                    foreach ($priorities as $priority) {
                                                        if ($workflow_action->action == $priority->priority_id) {
                                                            $priority1 = "selected";
                                                        } else {
                                                            $priority1 = "";
                                                        }
                                                        $var .= "<option value='" . $priority->priority_id . "' " . $priority1 . ">" . $priority->priority_desc . "</option>";
                                                    }
                                                    $var .= "</select>";
                                                    echo $var;
                                                } elseif ($workflow_action->condition == 'sla') {
                                                    $sla_plans = App\Model\helpdesk\Manage\Sla_plan::where('status', '=', 1)->get();
                                                    $var = "<select name='action[" . $i . "][b]' class='form-control' required>";
                                                    foreach ($sla_plans as $sla_plan) {
                                                        if ($workflow_action->action == $sla_plan->id) {
                                                            $sla = "selected";
                                                        } else {
                                                            $sla = "";
                                                        }
                                                        $var .= "<option value='" . $sla_plan->id . "' " . $sla . ">" . $sla_plan->grace_period . "</option>";
                                                    }
                                                    $var .= "</select>";
                                                    echo $var;
                                                } elseif ($workflow_action->condition == 'team') {
                                                    $teams = App\Model\helpdesk\Agent\Teams::where('status', '=', 1)->get();
                                                    $var = "<select name='action[" . $i . "][b]' class='form-control' required>";
                                                    foreach ($teams as $team) {
                                                        if ($workflow_action->action == $team->id) {
                                                            $team1 = "selected";
                                                        } else {
                                                            $team1 = "";
                                                        }
                                                        $var .= "<option value='" . $team->id . "' " . $team1 . ">" . $team->name . "</option>";
                                                    }
                                                    $var .= "</select>";
                                                    echo $var;
                                                } elseif ($workflow_action->condition == 'agent') {
                                                    $users = App\User::where('role', '!=', 'user')->where('active', '=', 1)->get();
                                                    $var = "<select name='action[" . $i . "][b]' class='form-control' required>";
                                                    foreach ($users as $user) {
                                                        if ($workflow_action->action == $user->id) {
                                                            $user1 = "selected";
                                                        } else {
                                                            $user1 = "";
                                                        }
                                                        $var .= "<option value='" . $user->id . "' " . $user1 . ">" . $user->first_name . " " . $user->last_name . "</option>";
                                                    }
                                                    $var .= "</select>";
                                                    echo $var;
                                                } elseif ($workflow_action->condition == 'helptopic') {
                                                    $help_topics = App\Model\helpdesk\Manage\Help_topic::where('status', '=', 1)->get();
                                                    $var = "<select name='action[" . $i . "][b]' class='form-control' required>";
                                                    foreach ($help_topics as $help_topic) {
                                                        if ($workflow_action->action == $help_topic->id) {
                                                            $help_topic1 = "selected";
                                                        } else {
                                                            $help_topic1 = "";
                                                        }
                                                        $var .= "<option value='" . $help_topic->id . "' " . $help_topic1 . ">" . $help_topic->topic . "</option>";
                                                    }
                                                    $var .= "</select>";
                                                    echo $var;
                                                } elseif ($workflow_action->condition == 'status') {
                                                    $ticket_status = App\Model\helpdesk\Ticket\Ticket_Status::all();
                                                    $var = "<select name='action[" . $i . "][b]' class='form-control' required>";
                                                    foreach ($ticket_status as $status) {
                                                        if ($workflow_action->action == $status->id) {
                                                            $status1 = "selected";
                                                        } else {
                                                            $status1 = "";
                                                        }
                                                        $var .= "<option value='" . $status->id . "' " . $status1 . ">" . $status->name . "</option>";
                                                    }
                                                    $var .= "</select>";
                                                    echo $var;
                                                }
                                                ?>

                                            </td>
                                            <td style="text-align: center">
                                                <div class="tools"> 
                                                    <span class="btnRemove" data-toggle="modal" data-target="#">
                                                        <a data-toggle="tooltip" data-placement="top" title="Delete" onclick="document.getElementById('seconddata{!! $i !!}').innerHTML = ''">
                                                            <i class="fa fa-trash-o"></i>
                                                        </a>
                                                    </span> 
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="row" style="padding: 10px 15px 0px">
                                    <div class="pull-right">
                                        <a class="btn btn-primary btnAdd">{!! trans('lang.add') !!}</a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="delect">
                        <div>
                            <textarea name="internal_note" class="textarea" placeholder="Please Enter an internal note for your team!" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>       
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
                <div class="box-footer">
                    <input type="submit" class="btn btn-primary" value="{!! trans('lang.submit') !!}">
                </div>
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</form>
<script>
            $(function() {
            $("#example1").DataTable();
                    $('#example2').DataTable({
            "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false
            });
            });
            function getSelectVal(val) {

            $.ajax({
            type: "POST",
                    url: "",
                    data: 'select_box=' + val,
                    success: function(data) {
                    $("#select-list").html(data);
                    }
            });
            }


    $(document).ready(function() {
    var x = 0;
            var n = {!! $i !!};
            $('.btnAdd').click(function() {
    n++;
            $('.buttons').append('<tr id="firstdata1">' +
            '<td>' +
            '<select class="form-control" onChange="selectdata(' + n + ')" name="action[' + n + '][a]" id="selected' + n + '" required>' +
            '<option value="">-- {!! trans("lang.select_an_action") !!} --</option>' +
            '<optgroup label="Ticket">' +
            '<option value="reject">{!! trans("lang.reject_ticket") !!}</option>' +
            '<option value="department">{!! trans("lang.set_department") !!}</option>' +
            '<option value="priority">{!! trans("lang.set_priority") !!}</option>' +
            '<option value="sla">{!! trans("lang.set_sla_plan") !!}</option>' +
            '<option value="team">{!! trans("lang.assign_team") !!}</option>' +
            '<option value="agent">{!! trans("lang.assign_agent") !!} </option>' +
            '<option value="helptopic">{!! trans("lang.set_help_topic") !!} </option>' +
            '<option value="status">{!! trans("lang.set_ticket_status") !!} </option>' +
            '</select>' +
            '</td>' +
            '<td id="fill' + n + '">' +
            '</td>' +
            '<td style="text-align: center">' +
            '<div class="tools">' +
            '<span class="btnRemove" data-toggle="modal" data-target="#">' +
            '<a data-toggle="tooltip" data-placement="top" title="Delete">' +
            '<i class="fa fa-trash-o"></i>' +
            '</a>' +
            '</span>' +
            '</div>' +
            '</td>' +
            '</tr>'); // end append
            $('div .btnRemove').last().click(function(e) {
    e.preventDefault();
            $(this).closest('tr').remove();
            x--;
    });
    });
    });
            $(document).ready(function() {
    var x = 0;
            var n = {!! $j !!};
            $('.btnAdd1').click(function() {
    n++;
            $('.button1').append('<tr>' +
            '<td>' +
            '<select class="form-control" name="rule[' + n + '][a]" required>' +
            '<option>-- {!! trans("lang.select_one") !!} --</option>' +
            '<option value="email">{!! trans("lang.email") !!}</option>' +
            '<option value="email_name">{!! trans("lang.email_name") !!}</option>' +
            '<option value="subject">{!! trans("lang.subject") !!}</option>' +
            '<option value="message">{!! trans("lang.message") !!}/{!! trans("lang.body") !!}</option>' +
            '</select>' +
            '</td>' +
            '<td class="col-md-3">' +
            '<select class="form-control" name="rule[' + n + '][b]" required>' +
            '<option value="">-- {!! trans("lang.select_one") !!} --</option>' +
            '<option value="equal">{!! trans("lang.equal_to") !!}</option>' +
            '<option value="not_equal">{!! trans("lang.not_equal_to") !!}</option>' +
            '<option value="contains">{!! trans("lang.contains") !!}</option>' +
            '<option value="dn_contain">{!! trans("lang.does_not_contain") !!}</option>' +
            '<option value="starts">{!! trans("lang.starts_with") !!}</option>' +
            '<option value="ends">{!! trans("lang.ends_with") !!}</option>' +
            '</select>' +
            '</td>' +
            '<td class="col-md-3"> <input class="form-control" type="text" name="rule[' + n + '][c]" required> </td>' +
            '<td style="text-align: center">' +
            '<div class="tools"> <span class="btnRemove1" data-toggle="modal" data-target="#"><a data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-o"></i></a></span> </div>' +
            '</td>' +
            '</tr>'); // end append
            $('div .btnRemove1').last().click(function(e) {
    e.preventDefault();
            $(this).closest('tr').remove();
            x--;
    });
    });
    });
            function selectdata(id) {
            var selected_data = document.getElementById('selected' + id).value;
                    $.ajax({
                    url: "{!! url('workflow/action-rule') !!}" + "/" + id,
                            type: "get",
                            data: {option: selected_data},
                            headers: {
                            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                            },
                            success: function(data) {
                            //adds the echoed response to our container
                            $("#fill" + id).html(data);
                            }
                    });
            }

</script>

@stop
