@extends('themes.default1.agent.layout.agent')

@section('Dashboard')
class="nav-link active"
@stop

@section('dashboard-bar')
active
@stop

@section('profile')
class="nav-link active"
@stop

@section('PageHeader')
<h1>{{Lang::get('lang.edit-profile')}}</h1>
@stop

@section('content')

@if(Session::has('success1'))
<div class="alert alert-success alert-dismissable">
    <i class="fas fa-check-circle"></i>
    <b>Success</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('success1')}}
</div>
@endif
<!-- fail message -->
@if(Session::has('fails1'))
<div class="alert alert-danger alert-dismissable">
    <i class="fas fa-ban"></i>
    <b>Fail!</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('fails1')}}
</div>
@endif
@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <i class="fas fa-check-circle"></i>
    <b>Success</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('success')}}
</div>
@endif
<!-- fail message -->
@if(Session::has('fails'))
<div class="alert alert-danger alert-dismissable">
    <i class="fas fa-ban"></i>
    <b>Fail!</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('fails')}}
</div>
@endif
@if(Session::has('errors'))
<?php //dd($errors); ?>

<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <b>{!! Lang::get('lang.alert') !!}!</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <br/>
    @if($errors->first('first_name'))
    <li class="error-message-padding">{!! $errors->first('first_name', ':message') !!}</li>
    @endif
    @if($errors->first('mobile'))
    <li class="error-message-padding">{!! $errors->first('mobile', ':message') !!}</li>
    @endif
</div>
@endif
<div class="row">
    <div class="col-md-6">
        {!! Form::model($user,['url'=>'agent-profile', 'id' => 'agent-profile', 'method' => 'PATCH','files'=>true]) !!}
        <div class="card card-light">
            <div class="card-header">
                <h3 class="card-title">
                    {!! Lang::get('lang.profile') !!}
                </h3>
            </div>
            <div class="card-body">
                <!-- first name -->
                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                    {!! Form::label('first_name',Lang::get('lang.first_name')) !!} <span class="text-red"> *</span>
                    {!! Form::text('first_name',null,['class' => 'form-control']) !!}
                </div>
                <!-- last name -->
                <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                    {!! Form::label('last_name',Lang::get('lang.last_name')) !!}
                    {!! Form::text('last_name',null,['class' => 'form-control']) !!}
                </div>
                <!-- gender -->
                <div class="form-group">
                    {!! Form::label('gender',Lang::get('lang.gender')) !!}
                    <div class="row">
                        <div class="col-sm-3">
                            {!! Form::radio('gender','1',true) !!} {{Lang::get('lang.male')}}
                        </div>
                        <div class="col-sm-3">
                            {!! Form::radio('gender','0') !!} {{Lang::get('lang.female')}}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <!-- email address -->
                    {!! Form::label('email',Lang::get('lang.email_address')) !!}
                    <div>
                        {{$user->email}}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('company') ? 'has-error' : '' }}">
                    <!-- company -->
                    {!! Form::label('company',Lang::get('lang.company')) !!}
                    {!! Form::text('company',null,['class' => 'form-control']) !!}
                </div>
                <div class="row">
                    <!-- phone extension -->
                    <div class="col-sm-2 form-group {{ Session::has('country_code_error') ? 'has-error' : '' }}">
                        {!! Form::label('country_code',Lang::get('lang.country-code')) !!}
                        {!! Form::text('country_code',null,['class' => 'form-control', 'placeholder' => $phonecode, 'title' => Lang::get('lang.enter-country-phone-code'), 'id' => 'code']) !!}
                    </div>
                    <!-- phone number -->
                    <div class="col-sm-8 form-group {{ $errors->has('phone_number') ? 'has-error' : '' }}">
                        {!! Form::label('phone_number',Lang::get('lang.phone')) !!}
                        {!! Form::text('phone_number',null,['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-2 form-group {{ $errors->has('ext') ? 'has-error' : '' }}">
                        {!! Form::label('ext',Lang::get('lang.ext')) !!}
                        {!! Form::text('ext',null,['class' => 'form-control']) !!}
                    </div>
                </div>
                <!-- mobile -->
                <div class="form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
                    {!! Form::label('mobile',Lang::get('lang.mobile_number')) !!}
                    {!! Form::input('number', 'mobile',null,['class' => 'form-control', 'id' => 'mobile']) !!}
                </div>
                <div class="form-group {{ $errors->has('agent_sign') ? 'has-error' : '' }}">
                    {!! Form::label('agent_sign',Lang::get('lang.agent_sign')) !!}
                    {!! Form::textarea('agent_sign',null,['class' => 'form-control']) !!}
                </div>
                <div class="form-group {{ $errors->has('profile_pic') ? 'has-error' : '' }}">
                    <!-- profile pic -->
                    <div type="file" class="btn btn-default btn-file" style="color:orange">
                        <i class="fa fa-user"> </i>
                        {!! Form::label('profile_pic',Lang::get('lang.profile_pic'),['style'=>'font-weight:400;margin-bottom:0px;']) !!}
                        {!! Form::file('profile_pic',['class' => 'form-file']) !!}
                    </div>
                </div>
                {!! Form::token() !!}
                {!! Form::close() !!}
            </div>
            <div class="card-footer">
                {!! Form::submit(Lang::get('lang.update'),['class'=>'btn btn-primary'])!!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        {!! Form::model($user,['url'=>'agent-profile-password/'.$user->id , 'method' => 'PATCH']) !!}
        <div class="card card-light">
            <div class="card-header">
                <h3 class="card-title">{!! Lang::get('lang.change_password') !!}</h3> 
            </div>
            <div class="card-body pb-0">
                <!-- old password -->
                <div class="form-group has-feedback {{ $errors->has('old_password') ? 'has-error' : '' }}">
                    {!! Form::label('old_password',Lang::get('lang.old_password')) !!} <span class="text-red"> *</span>
                    {!! Form::password('old_password',['class' => 'form-control']) !!}
                    {!! $errors->first('old_password', '<spam class="help-block">:message</spam>') !!}
                    <span class="glyphicon glyphicon-lock form-control-feedback" style="float: right;top: -46px;left: -10px;"></span>
                </div>
                <!-- new password -->
                <div class="form-group has-feedback {{ $errors->has('new_password') ? 'has-error' : '' }}">
                    {!! Form::label('new_password',Lang::get('lang.new_password')) !!} <span class="text-red"> *</span>
                    {!! Form::password('new_password',['class' => 'form-control']) !!}
                    {!! $errors->first('new_password', '<spam class="help-block">:message</spam>') !!}
                    <span class="glyphicon glyphicon-lock form-control-feedback" style="float: right;top: -46px;left: -10px;"></span>
                </div>
                <!-- confirm password -->
                <div class="form-group has-feedback {{ $errors->has('confirm_password') ? 'has-error' : '' }}">
                    {!! Form::label('confirm_password',Lang::get('lang.confirm_password')) !!} <span class="text-red"> *</span>
                    {!! Form::password('confirm_password',['class' => 'form-control']) !!}
                    {!! $errors->first('confirm_password', '<spam class="help-block">:message</spam>') !!}
                    <span class="glyphicon glyphicon-lock form-control-feedback" style="float: right;top: -46px;left: -10px;"></span>
                </div>
            </div>
            <div class="card-footer">
                {!! Form::submit(Lang::get('lang.update'),['class'=>'btn btn-primary'])!!}
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
<!-- Modal for last step of setting -->
<div class="modal fade" id="last-modal">
    <div class="modal-dialog" role="document">
        <div class="col-md-2"></div>
        <div class="col-md-12" style="height:40%">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{Lang::get('lang.verify-number')}}</h4> 
                    <button type="button" class="close closemodal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div id="custom-alert-body2">
                        <div class="row">
                            <div class="col-md-12">
                            <div id="loader2" style="display:none">
                                <center><img src="{{asset('lb-faveo/media/images/gifloader.gif')}}"></center>
                            </div>
                            <div id="verify-success" style="display:none" class="alert alert-success alert-dismissable">
                                <i class="fa  fa-check-circle"> </i>
                                <span id = "success_message"></span>
                            </div>
                            <div id="verify-fail" style="display:none" class="alert alert-danger alert-dismissable">
                                <i class="fa fa-ban"> </i> <b> {!! Lang::get('lang.alert') !!}! </b>
                                <span id = "error_message"></span>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div id="verify-number-form">
                    {!! Form::open(['id'=>'verify-otp','method' => 'POST'] )!!}
                        <div class="row">
                            <div class="col-md-8">
                                {{ Lang::get('lang.get-verify-message') }}
                            </div>
                            <div class="col-md-4">
                                {!! Form::text('token','',['class' => 'form-control', 'required' => true, 'placeholder' => Lang::get('lang.enter-otp'), 'id' => 'otp']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" id="close-last" class="btn btn-default closemodal">{{Lang::get('lang.close')}}</button>
                    <div id="last-submit"><input  type="submit" id="merge-btn" class="btn btn-primary" value="{!! Lang::get('lang.verify') !!}"></input></div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<!-- modal end -->
<script>
    $(function() {
        $("textarea").wysihtml5();
    });
</script>
@if($verify == 1 || $verify == '1')
<script type="text/javascript">
$('#agent-profile').on('submit', function(e){
    var old_mobile = "<?php echo $user->mobile;?>";
    var email = "<?php echo $user->email;?>";
    var full_name = "<?php echo $user->first_name; ?>";
    var mobile = document.getElementById('mobile').value;
    var code = document.getElementById('code').value;
    if (code == '' || code == null) {
            //do nothingalert
    } else {
        var id = "<?php echo $user->id; ?>";
        if (mobile !== old_mobile) {
            e.preventDefault();
            $('#last-modal').css('display', 'block');
            $.ajax({                    
                url: '{{URL::route("agent-verify-number")}}',     
                type: 'post', // performing a POST request
                data : {
                    mobile : mobile,
                    full_name: full_name,
                    email: email,
                    code: code // will be accessible in $_POST['data1']
                },
                dataType: 'json', 
                beforeSend: function() {
                    $('#loader2').css('display', 'block');
                    $('#verify-number-form').css('display', 'none');
                    $('#verify-fail').css('display', 'none');
                    $('verify-success').css('display', 'none');
                },
                success: function(response) {
                    $('#loader2').css('display', 'none');
                    $('#verify-number-form').css('display', 'block');
                    $('#verify-otp').on('submit', function(e){
                        e.preventDefault();
                        var otp = document.getElementById('otp').value;
                        $.ajax({
                            url: '{{URL::route("post-agent-verify-number")}}',
                            type: 'POST',
                            data: {
                                otp: otp,
                                u_id: id,
                            },
                            dataType: 'html',
                            beforeSend: function(){
                                $('#loader2').css('display', 'block');
                                $('#verify-number-form').css('display', 'none');
                                $('#verify-fail').css('display', 'none');
                                $('verify-success').css('display', 'none');
                            },
                            success: function(response){
                                if( response == 1) {
                                    $('#loader2').css('display', 'none');
                                    var message = "{{Lang::get('lang.number-verification-sussessfull')}}";
                                    $('#success_message').html(message);
                                    $('#verify-success').css('display', 'block');
                                    $('#agent-profile').unbind('submit').submit();
                                } else {
                                    $('#loader2').css('display', 'none');
                                    $("#error_message").html(response);
                                    $('#verify-fail').css('display', 'block');
                                    $('#verify-number-form').css('display', 'block');
                                }
                            }
                        });
                    });
                },
                complete: function( jqXHR, textStatus) {
                    if (textStatus === "parsererror" || textStatus === "timeout" || textStatus === "abort" || textStatus === "error") {
                        var message = "{{Lang::get('lang.otp-not-sent')}}";
                        $('#loader2').css('display', 'none');
                        $("#error_message").html(message);
                        $("#merge-btn").css('display', 'none');
                        $('#verify-fail').css('display', 'block');
                    }
                }
            });
        }
          
    }
});
$('.closemodal').on('click', function(){
    $('#last-modal').css('display', 'none');
});
</script>
@endif
@stop