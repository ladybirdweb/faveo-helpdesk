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

@section('PageHeader')
<h1>{{Lang::get('lang.tickets')}}</h1>
@stop

@section('content')
<!-- Main content -->
{!! Form::open(['route'=>'post.newticket','method'=>'post','id'=>'form']) !!}
<div class="box box-primary">
    <div class="box-header with-border" id='box-header1'>
        <h3 class="box-title">{!! Lang::get('lang.create_ticket') !!}</h3>
        @if(Session::has('success'))
        <br><br>        
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('fails'))
        <br><br>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif
        @if(Session::has('errors'))
        <br><br>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @if($errors->first('email'))
            <li class="error-message-padding">{!! $errors->first('email', ':message') !!}</li>
            @endif
            @if($errors->first('user_name'))
            <li class="error-message-padding">{!! $errors->first('user_name', ':message') !!}</li>
            @endif
            @if($errors->first('phone'))
            <li class="error-message-padding">{!! $errors->first('phone', ':message') !!}</li>
            @endif
            @if($errors->first('subject'))
            <li class="error-message-padding">{!! $errors->first('subject', ':message') !!}</li>
            @endif
            @if($errors->first('body'))
            <li class="error-message-padding">{!! $errors->first('body', ':message') !!}</li>
            @endif
        </div>
        @endif
    </div><!-- /.box-header -->
    <div class="box-header with-border">
        <h4 class="box-title">{!! Lang::get('lang.user_details') !!}:</h4>
    </div>
    <div class="box-body">

        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <!-- email -->
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        {!! Form::label('email',Lang::get('lang.email')) !!} <span class="text-red"> *</span>
                        {!! Form::text('email',null,['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- full name -->
                    <div class="form-group {{ $errors->has('user_name') ? 'has-error' : '' }}">
                        {!! Form::label('user_name',Lang::get('lang.user_name')) !!} <span class="text-red"> *</span>
                        {!! Form::text('user_name',null,['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1 form-group {{ Session::has('country_code_error') ? 'has-error' : '' }}">

                    {!! Form::label('code',Lang::get('lang.country-code')) !!}
                    {!! Form::text('code',null,['class' => 'form-control', 'placeholder' => $phonecode, 'title' => Lang::get('lang.enter-country-phone-code')]) !!}
                </div>
                <div class="col-md-5">
                    <!-- phone -->
                    <div class="form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
                        <label>{!! Lang::get('lang.mobile_number') !!}:</label>
                        {!! Form::input('number','mobile',null,['class' => 'form-control']) !!}
                        {!! $errors->first('mobile', '<spam class="help-block text-red">:message</spam>') !!}
                    </div>
                </div>
                <div class="col-md-5">
                    <!-- phone -->
                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                        <label>{!! Lang::get('lang.phone') !!}:</label>
                        {!! Form::input('number','phone',null,['class' => 'form-control']) !!}
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
    </div>
    <div class="box-header with-border">
        <h4 class="box-title">{!! Lang::get('lang.ticket_option') !!}:</h4>
    </div>
    <div class="box-body">
        <!-- ticket options -->
        <div class="form-group">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>{!! Lang::get('lang.help_topic') !!}:</label>
                        <!-- helptopic -->
                        <?php $helptopic = App\Model\helpdesk\Manage\Help_topic::where('status', '=', 1)->get(); ?>
                        {!! Form::select('helptopic', ['Helptopic'=>$helptopic->lists('topic','id')->toArray()],null,['class' => 'form-control select','id'=>'selectid']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <!-- sla plan -->
                    <div class="form-group">
                        <label>{!! Lang::get('lang.sla_plan') !!}:</label>
                        <?php $sla_plan = App\Model\helpdesk\Manage\Sla_plan::all(); ?>
                        {!! Form::select('sla', ['SLA'=>$sla_plan->lists('grace_period','id')->toArray()],null,['class' => 'form-control select']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <!-- due date -->
                    <div class="form-group" id="duedate">
                        <label>{!! Lang::get('lang.due_date') !!}:</label>
                        {!! Form::text('duedate',null,['class' => 'form-control','id'=>'datemask']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <!-- assign to -->
                    <div class="form-group">
                        <label>{!! Lang::get('lang.assign_to') !!}:</label>
                        <?php $agents = App\User::where('role', '!=', 'user')->get(); ?>
                        {!! Form::select('assignto', [''=>'Select an Agent','Agents'=>$agents->lists('first_name','id')->toArray()],null,['class' => 'form-control select']) !!}
                    </div>
                </div>
                <div id="response" class="col-md-6 form-group"></div>
            </div>
        </div>
    </div>
    <div class="box-header with-border">
        <h4 class="box-title">{!! Lang::get('lang.ticket_detail') !!}:</h4>
    </div>
    <div class="box-body">
        <!-- ticket details -->
        <div class="form-group">
            <!-- subject -->
            <div class="form-group {{ $errors->has('subject') ? 'has-error' : '' }}">
                <div class="row">
                    <div class="col-md-1">
                        <label>{!! Lang::get('lang.subject') !!}:<span class="text-red"> *</span></label>
                    </div>
                    <div class="col-md-4">
                        {!! Form::text('subject',null,['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
                <!-- details -->
                <div class="row">
                    <div class="col-md-1">
                        <label>{!! Lang::get('lang.detail') !!}:<span class="text-red"> *</span></label>
                    </div>
                    <div class="col-md-9">
                        {!! Form::textarea('body',null,['class' => 'form-control','id' => 'body', 'style'=>"width:100%; height:150px;"]) !!}

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
                        <?php $Priority = App\Model\helpdesk\Ticket\Ticket_Priority::all(); ?>
                        {!! Form::select('priority', ['Priority'=>$Priority->lists('priority_desc','priority_id')->toArray()],null,['class' => 'form-control select']) !!}
                    </div>
                    
                </div>
            </div>
             
        </div>
    </div>
    <div class="box-footer">
        <div class="row">
            <div class="col-md-1">
            </div>
            <div class="col-md-3">
                <input type="submit" value="{!! Lang::get('lang.create_ticket') !!}" class="btn btn-primary">
            </div>
        </div>
    </div>
</div><!-- /. box -->
{!! Form::close() !!}
<script type="text/javascript">
    $(document).ready(function () {
        var helpTopic = $("#selectid").val();
        send(helpTopic);
        $("#selectid").on("change", function () {
            helpTopic = $("#selectid").val();
            send(helpTopic);
        });
        function send(helpTopic) {
            $.ajax({
                url: "{{url('/get-helptopic-form')}}",
                data: {'helptopic': helpTopic},
                type: "GET",
                dataType: "html",
                success: function (response) {
                    $("#response").html(response);
                },
                error: function (response) {
                    $("#response").html(response);
                }
            });
        }
    });
    $(function () {
        $("textarea").wysihtml5();
    });

    $(document).ready(function () {
        $('#form').submit(function () {
            var duedate = document.getElementById('datemask').value;
            if (duedate) {
                var pattern = /^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/;
                if (pattern.test(duedate) === true) {
                    $('#duedate').removeClass("has-error");
                    $('#clear-up').remove();
                } else {
                    $('#duedate').addClass("has-error");
                    $('#clear-up').remove();
                    $('#box-header1').append("<div id='clear-up'><br><br><div class='alert alert-danger alert-dismissable'><i class='fa fa-ban'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Invalid Due date</div></div>");
                    return false;
                }
            }
        });
    });

    $(function () {
        $('#datemask').datepicker({changeMonth: true, changeYear: true}).mask('99/99/9999');
    });
</script>

@stop




