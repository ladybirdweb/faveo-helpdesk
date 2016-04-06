@extends('themes.default1.admin.layout.admin')

@section('Emails')
class="active"
@stop

@section('emails-bar')
active
@stop

@section('emails')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{Lang::get('lang.add_an_email')}}</h1> 
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
<!-- open a form -->
<form id="form">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{!! Lang::get('lang.email_information_and_settings') !!}</h3>
        </div>
        <div class="box-body">
            <div id="alert" style="display:none;">
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <div id="alert-message"></div>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <!-- email address -->
                <div class="col-xs-4 form-group {!! $errors->has('email_address') ? 'has-error' : '' !!}" id = "email_address_error">
                    {!! Form::label('email_address',Lang::get('lang.email_address')) !!}
                    {!! $errors->first('email_address', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('email_address',null,['class' => 'form-control', 'id' => 'email_address']) !!}
                </div>
                <!-- Email name -->
                <div class="col-xs-4 form-group {!! $errors->has('email_name') ? 'has-error' : ''!!}" id="email_name_error">
                    {!! Form::label('email_name',Lang::get('lang.from_name')) !!}
                    {!! $errors->first('email_name', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('email_name',null,['class' => 'form-control', 'id' => 'email_name']) !!}
                </div>
                <!-- password -->
                <div class="col-xs-4 form-group {!! $errors->has('password') ? 'has-error' : ''!!}" id="password_error">
                    {!! Form::label('password',Lang::get('lang.password')) !!}
                    {!! $errors->first('password', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::password('password',['class' => 'form-control', 'id' => 'password']) !!}
                </div>
            </div>
        </div>
        <div class="box-header with-border">
            <h3 class="box-title">{!! Lang::get('lang.new_ticket_settings') !!}</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <!-- department -->
                <div class="col-xs-4 form-group {!! $errors->has('department') ? 'has-error' : ''!!}" id="department_error">
                    {!! Form::label('department',Lang::get('lang.department')) !!}
                    {!! $errors->first('department', '<spam class="help-block">:message</spam>') !!}
                    {!!Form::select('department', [''=>'--System Default--','departments'=>$departments->lists('name','id')],null,['class' => 'form-control select', 'id' => 'department' ]) !!}
                </div>
                <!-- Priority -->
                <div class="col-xs-4 form-group {!! $errors->has('priority') ? 'has-error' : ''!!}" id="priority_error">
                    {!! Form::label('priority',Lang::get('lang.priority')) !!}
                    {!! $errors->first('priority', '<spam class="help-block">:message</spam>') !!}
                    {!!Form::select('priority', [''=>'--System Default--','Priorities'=>$priority->lists('priority_desc','priority_id')],null,['class' => 'form-control select', 'id' => 'priority']) !!}
                </div>
                <!-- Help topic -->
                <div class="col-xs-4 form-group {!! $errors->has('help_topic') ? 'has-error' : ''!!}" id="help_topic_error">
                    {!! Form::label('help_topic',Lang::get('lang.help_topic')) !!}
                    {!! $errors->first('help_topic', '<spam class="help-block">:message</spam>') !!}
                    {!!Form::select('help_topic', [''=>'--System Default--','Help Topics'=>$helps->lists('topic','id')],null,['class' => 'form-control select', 'id' => 'help_topic']) !!}
                </div>
                <!-- status -->
                <div class="col-xs-2 form-group">
                    {!! Form::label('auto_response',Lang::get('lang.auto_response')) !!}
                </div>
                <div class="col-xs-3 form-group">
                
                    <input type="checkbox" name="auto_response" id="auto_response"> {{Lang::get('lang.disable_for_this_email_address')}}
                </div>
            </div>
        </div>
        <div class="box-header with-border">
            <h3 class="box-title">{!! Lang::get('lang.incoming_email_information') !!}</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="form-group">
                    <!-- status -->
                    <div class="col-xs-1 form-group">
                        {!! Form::label('fetching_status',Lang::get('lang.status')) !!}
                    </div>
                    <div class="col-xs-2 form-group">
                        <!--{!! Form::radio('fetching_status','1',true) !!} {{Lang::get('lang.enable')}}-->
                        <input type="checkbox" name="fetching_status" id="fetching_status"> {{Lang::get('lang.enable')}}
                    </div>
                    <div class="col-xs-2 form-group">
                        <!--<input type="radio" name="fetching_status" id="fetching_status" value="0"> {{Lang::get('lang.disabled')}}-->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-3 form-group {!! $errors->has('fetching_protocol') ? 'has-error' : ''!!}" id="fetching_protocol_error">
                    {!! Form::label('fetching_protocol',Lang::get('lang.fetching_protocol')) !!}
                    {!! $errors->first('fetching_protocol', '<spam class="help-block">:message</spam>') !!}
                    {!!Form::select('fetching_protocol',['imap' => 'IMAP'],null,['class' => 'form-control select', 'id' => 'fetching_protocol']) !!}
                </div>
                <div class="col-xs-3 form-group  {!! $errors->has('fetching_host') ? 'has-error' : ''!!}" id="fetching_host_error">
                    {!! Form::label('fetching_host',Lang::get('lang.host_name')) !!}
                    {!! $errors->first('fetching_host', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('fetching_host',null,['class' => 'form-control', 'id' => 'fetching_host']) !!}
                </div>
                <div class="col-xs-3 form-group {!! $errors->has('fetching_port') ? 'has-error' : ''!!}" id="fetching_port_error">
                    {!! Form::label('fetching_port',Lang::get('lang.port_number')) !!}
                    {!! $errors->first('fetching_port', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('fetching_port',null,['class' => 'form-control', 'id' => 'fetching_port']) !!}
                </div>
                <div class="col-xs-3 form-group {!! $errors->has('fetching_encryption') ? 'has-error' : ''!!}" id="fetching_encryption_error">
                    {!! Form::label('fetching_encryption',Lang::get('lang.encryption')) !!}
                    {!! $errors->first('fetching_encryption', '<spam class="help-block">:message</spam>') !!}
                    {!!Form::select('fetching_encryption',['none' => 'None', 'ssl' => 'SSL', 'tls' => 'TLS', 'ssl/novalidate-cert' => 'SSL (Accept all certificates)', 'tls/novalidate-cert' => 'TLS (Accept all certificates)'],null,['class' => 'form-control select', 'id' => 'fetching_encryption']) !!}
                </div>
            </div>
        </div>
        <div class="box-header with-border">
            <h3 class="box-title">{!! Lang::get('lang.outgoing_email_information') !!}</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <!-- status -->
                <div class="form-group">
                    <div class="col-xs-1 form-group"> 
                        {!! Form::label('sending_status',Lang::get('lang.status')) !!} 
                    </div> 
                    <div class="col-xs-2 form-group"> 
                        <input type="checkbox" name="sending_status" id="sending_status"> {!! Lang::get('lang.enable') !!} 
                    </div> 
                    <div class="col-xs-2 form-group"> 
                        <!--<input type="radio" name="sending_status" id="sending_status" value=""> {!! Lang::get('lang.disabled') !!}--> 
                    </div> 
                </div>
            </div>
            <div class="row">
                <!-- Encryption -->
                <div class="col-xs-3 form-group {!! $errors->has('sending_protocol') ? 'has-error' : ''!!}" id="sending_protocol_error">
                    {!! Form::label('sending_protocol',Lang::get('lang.transfer_protocol')) !!}
                    {!! $errors->first('sending_protocol', '<spam class="help-block">:message</spam>') !!} 
                    {!!Form::select('sending_protocol',['smtp'=>'SMTP'],null,['class' => 'form-control select']) !!}
                </div> 
                <!-- sending hoost -->
                <div class="col-xs-3 form-group {!! $errors->has('sending_host') ? 'has-error' : ''!!}" id="sending_host_error">
                    {!! Form::label('sending_host',Lang::get('lang.host_name')) !!}
                    {!! $errors->first('sending_host', '<spam class="help-block">:message</spam>') !!} 
                    {!! Form::text('sending_host',null,['class' => 'form-control']) !!}
                </div> 
                <!-- sending port -->
                <div class="col-xs-3 form-group {!! $errors->has('sending_port') ? 'has-error' : ''!!}" id="sending_port_error">
                    {!! Form::label('sending_port',Lang::get('lang.port_number')) !!}
                    {!! $errors->first('sending_port', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('sending_port',null,['class' => 'form-control']) !!}
                </div>
                <!-- Encryption -->
                <div class="col-xs-3 form-group {!! $errors->has('sending_encryption') ? 'has-error' : ''!!}" id="sending_encryption_error">
                    {!! Form::label('sending_encryption',Lang::get('lang.encryption')) !!}
                    {!! $errors->first('sending_encryption', '<spam class="help-block">:message</spam>') !!} 
                    {!!Form::select('sending_encryption',['ssl'=>'SSL','tls'=>'TLS'],null,['class' => 'form-control select']) !!}
                </div> 
            </div>
            <!-- Internal notes -->
            <div class="form-group">
                {!! Form::label('internal_notes',Lang::get('lang.internal_notes')) !!}
                {!! Form::textarea('internal_notes',null,['class' => 'form-control','size' => '30x10']) !!}
            </div>
        </div>
        <div class="box-footer">
            {!! Form::button('<i id="spin" class="fa fa-spinner" style="display:none;"></i> <b>' . Lang::get("lang.create").'</b>' ,['class'=>'btn btn-primary', 'type' => 'submit'])!!}

        </div>
    </div>
</form>

<div class="modal fade" id="loadingpopup" style="padding:200px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div id="head">
                    <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close" style="display:none;"><span aria-hidden="true">×</span></button>
                    <div class="col-md-5"></div><div class="col-md-2"><img src="{{asset("lb-faveo/media/images/gifloader.gif")}}" ></div><div class="col-md-5"></div>
                    <br/>
                    <br/>
                    <br/>
                    <center><h3 style="color:#80DE02;">Testing incoming & outgoing mail server</h3></center>
                    <br/>
                    <center><h4>Please wait while testing is in progress ...</h4></center>
                    <center><h4>(Please do not use "Refresh" or "Back" button)</h4></center>
                    <br/>
                </div>
            </div>
        </div>
    </div>
</div>

<button style="display:none" data-toggle="modal" data-target="#loadingpopup" id="click"></button>

<script type="text/javascript">
    //submit form
    $('#form').on('submit', function () {
        var form_data = $(this).serialize();
        $("#spin").addClass("fa-spin");
        var email_address = document.getElementById('email_address').value;
        var email_name = document.getElementById('email_name').value;
        var department = document.getElementById('department').value;
        var priority = document.getElementById('priority').value;
        var help_topic = document.getElementById('help_topic').value;
        var password = document.getElementById('password').value;
        var fetching_status = $('input#fetching_status[type="checkbox"]:checked', this).val();
        var fetching_protocol = document.getElementById('fetching_protocol').value;
        var fetching_host = document.getElementById('fetching_host').value;
        var fetching_port = document.getElementById('fetching_port').value;
        var fetching_encryption = document.getElementById('fetching_encryption').value;
        var sending_status = $('input#sending_status[type="checkbox"]:checked', this).val();
        var sending_protocol = document.getElementById('sending_protocol').value;
        var sending_host = document.getElementById('sending_host').value;
        var sending_port = document.getElementById('sending_port').value;
        var sending_encryption = document.getElementById('sending_encryption').value;


        var filter_number = /^([0-9])/;
        var error_list = [];
        var error = "";
        // checking for validation of email
        if (email_address) {
            var filter_email = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!filter_email.test(email_address)) {
                var error = "Please provide a valid email address";
                error_list.push(error);
                $("#email_address_error").addClass("has-error");
            }
        } else if (email_address == "") {
            var error = "Email Address is a required field";
            error_list.push(error);
            $("#email_address_error").addClass("has-error");
        }
        // checking for validation of email name
        if (email_name == "") {
            var error = "Email Name is a required field";
            error_list.push(error);
            $("#email_name_error").addClass("has-error");
        }
        // checking for validation of department
        if (department == "") {
        } else if (department) {
            if (!filter_number.test(department)) {
                var error = "Please provide a valid department";
                error_list.push(error);
                $("#department_error").addClass("has-error");
            }
        }
        // checking for validation of priority
        if (priority == "") {
        } else if (priority) {
            if (!filter_number.test(priority)) {
                var error = "Please provide a valid priority";
                error_list.push(error);
                $("#priority_error").addClass("has-error");
            }
        }
        // checking for validation of help topic
        if (help_topic == "") {
        } else if (priority) {
            if (!filter_number.test(priority)) {
                var error = "Please provide a valid priority";
                error_list.push(error);
                $("#priority_error").addClass("has-error");
            }
        }
        // checking for validation of password
        if (password == "") {
            var error = "Password is a required field";
            error_list.push(error);
            $("#password_error").addClass("has-error");
        }
        // checking for validation of fetching host
        if (fetching_status == 'on') {
            if (fetching_host == "") {
                var error = "Fetching Host is a required field";
                error_list.push(error);
                $("#fetching_host_error").addClass("has-error");
            }
            // checking for validation of fetching port
            if (fetching_port == "") {
                var error = "Fetching Port is a required field";
                error_list.push(error);
                $("#fetching_port_error").addClass("has-error");
            }
            // checking for validation of mailbox protocol
            if (fetching_encryption == "") {
                var error = "Fetching Encryption is a required field";
                error_list.push(error);
                $("#fetching_encryption_error").addClass("has-error");
            }
            // checking for validation of mailbox protocol
            if (fetching_protocol == "") {
                var error = "Fetching Protocol is a required field";
                error_list.push(error);
                $("#fetching_protocol_error").addClass("has-error");
            }

        } else {
            // checking for validation of fetching port
            if (fetching_port) {
                if (!filter_number.test(fetching_port)) {
                    var error = "The Fetching Port Number must be an integer";
                    error_list.push(error);
                    $("#fetching_port_error").addClass("has-error");
                }
            }
        }
        // checking for validation of sending status
        if (sending_status == 'on') {
            // checking for validation of sending host
            if (sending_host == "") {
                var error = "Sending Host is a required field";
                error_list.push(error);
                $("#sending_host_error").addClass("has-error");
            }
            // checking for validation of sending port
            if (sending_port == "") {
                var error = "Sending Port is a required field";
                error_list.push(error);
                $("#sending_port_error").addClass("has-error");
            }
            // checking for validation of sending encryption
            if (sending_encryption == "") {
                var error = "Sending Encryption is a required field";
                error_list.push(error);
                $("#sending_encryption_error").addClass("has-error");
            }
            // checking for validation of sending protocol
            if (sending_protocol == "") {
                var error = "Transfer Protocol is a required field";
                error_list.push(error);
                $("#sending_protocol_error").addClass("has-error");
            }
        } else {
            // checking for validation of fetching port
            if (sending_port) {
                if (!filter_number.test(sending_port)) {
                    var error = "The Sending Port Number must be an integer";
                    error_list.push(error);
                    $("#sending_port_error").addClass("has-error");
                }
            }
        }
        // executing error chatch
        if (error) {
            var ssss = "";
            $.each(error_list, function (key, value) {
                ssss += "<li class='error-message-padding'>" + value + "</li>";
            });
            if (ssss) {
                var error_result = "<div class='alert alert-danger alert-dismissable'> <i class='fa fa-ban'> </i> <b> Alert!</b><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><div id='alert-message'>" + ssss + "</div></div>";
                $('#alert').empty();
                $('#alert').html(error_result);
                $('#alert').show();
                $("#spin").removeClass("fa-spin");
                return false;
            }
        }

// Ajax communicating to backend for further Checking/Saving the details
        $.ajax({
            type: "POST",
            url: "{!! route('validating.email.settings') !!}",
            dataType: "html",
            data: form_data,
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            beforeSend: function () {
                $('#alert').empty();
                $("#click").trigger("click");

            },
            success: function (response) {
                if (response == 1) {
                    $("#close").trigger("click");
                    var error_result = "<div class='alert alert-success alert-dismissable'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><div id='alert-message'>Your details saved successfully</div></div>";
                    $('#alert').html(error_result);
                    $('#alert').show();
                } else {
                    $("#close").trigger("click");
                    var error_result = "<div class='alert alert-danger alert-dismissable'> <i class='fa fa-ban'> </i> <b> Alert!</b><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><div id='alert-message'>" + response + "</div></div>";
                    $('#alert').html(error_result);
                    $('#alert').show();
                }
            },
            error: function (response) {
                $("#close").trigger("click");
                var errorsHtml = "<div class='alert alert-danger alert-dismissable'> <i class='fa fa-ban'> </i> <b> Alert!</b><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><div id='alert-message'>Unable to process the details </div></div>";
                $('#alert').empty();
                $('#alert').html(errorsHtml);
                $('#alert').show();
                return false;
            }
        });
        return false;
    });
</script>
@stop