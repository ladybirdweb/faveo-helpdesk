@extends('themes.default1.admin.layout.admin')

@section('Plugins')
active
@stop

@section('settings-bar')
active
@stop

@section('cron')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{ Lang::get('lang.plugin') }}</h1>
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

<div class="box box-primary">
    {!!Form::open(['id' => 'podio-auth', 'url'=>'#','method' => 'POST'])!!}
    <div class="box-header with-border">
        <h3 class="box-title">{{Lang::get('Podio::lang.podio-settings')}}</h3>
        <span class="btn btn-primary pull-right" id="help" style="color:white;" title="{!!Lang::get('lang.podio-help-title')!!}"><i class="fa fa-plus-square pull-right"> Help<!--{!!Lang::get('lang.help')!!}--></i></span>
    </div>

    <div class="box-body table-responsive"style="overflow:hidden;">
        <!-- check whether success or not -->
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!!Session::get('success')!!}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!!Session::get('fails')!!}
        </div>
        @endif
        <div id="custom-alert-body2">
                        <div class="row">
                            <!-- <div id="loader2" style="display:none">
                                <center><img src="{{asset('lb-faveo/media/images/gifloader.gif')}}"></center>
                            </div> -->
                            <div id="app-auth-success2" class="col-md-12" style="display:none">
                                <div class="alert alert-success" id="alert-success2">
                                <i class="fa  fa-check-circle"></i>
                                </div>
                            </div>
                            <div id="app-auth-fails2" class="col-md-12" style="display:none">
                                <div class="alert alert-danger" id="alert-danger2">
                                <i class="fa  fa-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group has-feedback">
                    {!!Form::label('client_id',Lang::get('Podio::lang.client-id'))!!}
                    &nbsp;<span style="color:red">*</span>
                    {!! Form::text('client_id','',['class' => 'form-control', 'required' => true]) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group has-feedback">
                    {!!Form::label('client_key',Lang::get('Podio::lang.client-secret-key'))!!}
                    &nbsp;<span style="color:red">*</span>
                    {!! Form::text('client_key','',['class' => 'form-control', 'required' => true]) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group has-feedback">
                    {!!Form::label('username',Lang::get('Podio::lang.user_name'))!!}
                    &nbsp;<span style="color:red">*</span>
                    {!! Form::text('username','',['class' => 'form-control', 'required' => true]) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group has-feedback">
                    {!!Form::label('password',Lang::get('Podio::lang.password'))!!}
                    &nbsp;<span style="color:red">*</span>
                    {!! Form::password('password',['class' => 'form-control', 'required' => true]) !!}
                    </div>
                </div>
            </div>
    </div>

    <div class="box-footer">
        {!! Form::submit(Lang::get('lang.submit'),['class'=>'form-group btn btn-primary'])!!}  
    </div>
    {!!Form::close()!!}
</div>
<!-- Modal Popup for help -->   
<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; padding-right: 15px;background-color: rgba(0, 0, 0, 0.7);">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closemodal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <img src="{{asset('lb-faveo/media/images/podio.png')}}" height="8%" width="8%">
                <span style="font-size:1.2em">{{Lang::get('Podio::lang.podio-help-title')}}</span>
            </div><!-- /.modal-header-->
            <div class ="modal-body">
                <div class="row">
                <div class="col-md-12">
                    <b>{{Lang::get('Podio::lang.step1')}}:</b>&nbsp;&nbsp;&nbsp;<h4>{{Lang::get('Podio::lang.authentication')}}</h4>
                    <ul>
                        <li>
                            {{Lang::get('Podio::lang.generate-key-msg1')}} <a href="https://podio.com/settings/api" target="_blank">{{Lang::get('Podio::lang.here')}} </a>{{Lang::get('Podio::lang.generate-key-msg2')}}
                        </li>
                        <li>
                            {{Lang::get('Podio::lang.fill-fields-msg')}}
                        </li>
                        <li>
                            {{Lang::get('Podio::lang.submit-msg')}}
                        </li>
                    </ul>
                    <b>{{Lang::get('Podio::lang.step2')}}:</b>&nbsp;&nbsp;&nbsp;<h4>{{Lang::get('Podio::lang.workspace-selection')}}</h4>
                    <ul>
                        <li>
                            {{Lang::get('Podio::lang.success-auth-msg')}}
                        </li>
                        <li>
                            {{Lang::get('Podio::lang.select-org-drop-msg')}}
                        </li>
                        <li>
                            {{Lang::get('Podio::lang.select-space-drop-msg')}}
                        </li>
                        <li>
                        {{Lang::get('Podio::lang.enter-app-item-name')}}
                        </li>
                        <li>
                        {{Lang::get('Podio::lang.workspace-last-space')}}
                        </li>
                    </ul>
                    <b>{{Lang::get('Podio::lang.step3')}}:</b>&nbsp;&nbsp;&nbsp;<h4>{{Lang::get('Podio::lang.app-authentication')}}</h4>
                    <ul>
                        <li>
                            {{Lang::get('Podio::lang.app-auth-info')}}
                        </li>
                        <li>
                            {{Lang::get('Podio::lang.app-auth-step1')}}
                        </li>
                        <li>
                            {{Lang::get('Podio::lang.app-auth-step2')}}
                        </li>
                        <li>
                            {{Lang::get('Podio::lang.app-auth-step3')}}
                        </li>
                    </ul>
                </div>
                </div>
            </div><!-- /.modal-body -->
            <div class="modal-footer">
                    <button type="button" class="btn btn-default closemodal">{{Lang::get('lang.close')}}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!--Modal popup for form submit-->
<div class="modal fade in" id="auth-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; padding-right: 15px;background-color: rgba(0, 0, 0, 0.7);">
    <div class="modal-dialog" role="document">
        <div class="col-md-2"></div>
        <div class="col-md-12" style="height:40%">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="{{asset('lb-faveo/media/images/podio.png')}}" height="8%" width="8%">
                    <span style="font-size:1.2em">{{Lang::get('Podio::lang.authenticating')}}</span> 
                    <button type="button" class="close closemodal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body" id="custom-alert-body" >
                <div class="row">
                    <div id="loader">
                    <center><img src="{{asset('lb-faveo/media/images/gifloader.gif')}}"></center>
                    </div>
                    <div id="auth-success" class="col-md-12">
                        <div class="alert alert-success" id="alert-success">
                            <i class="fa  fa-check-circle"></i>
                        </div>
                    </div>
                    <div id="auth-fails" class="col-md-12">
                        <div class="alert alert-danger" id="alert-danger">
                            <i class="fa  fa-check-circle"></i>
                        </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default closemodal pull-left">{{Lang::get('lang.close')}}</button>
                    <a href="#" data-toggle="modal" id="next" data-target="#myModal3" style="display:none"><button type="button" class="btn btn-primary">{{Lang::get('Podio::lang.next')}}</button></a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal popup for app authentication -->
<div class="modal fade in" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; padding-right: 15px;background-color: rgba(0, 0, 0, 0.7);">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="merge-close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <img src="{{asset('lb-faveo/media/images/podio.png')}}" height="8%" width="8%">
                <span style="font-size:1.2em">{{Lang::get('Podio::lang.create_podio_app')}}</span>
            </div><!-- /.modal-header-->
            <div class ="modal-body">
                <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-6" id="app_auth_loader"  style="display:none;">
                        <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}"><br/><br/><br/>
                    </div><!-- /.merge-loader -->
                </div>
                <div id="app_auth_body">
                    <div id="merge-body-alert">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="app-succ-alert" class="alert alert-success alert-dismissable" style="display:none;" >
                                    <!--<button id="dismiss-merge" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>-->
                                    <h4><i class="icon fa fa-check"></i>{!! Lang::get('lang.alert') !!}!</h4>
                                    <div id="message-app-succ"></div>
                                </div>
                                <div id="app-err-alert" class="alert alert-danger alert-dismissable" style="display:none;">
                                    <!--<button id="dismiss-merge2" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>-->
                                    <h4><i class="icon fa fa-ban"></i>{!! Lang::get('lang.alert') !!}!</h4>
                                    <div id="message-app-err"></div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.merge-alert -->
                    <div id="app-body-form">
                    {!! Form::open(['id'=>'app-form','method' => 'POST'] )!!}
                        <div class="row">
                            <div class="col-md-6">
                                <label>{!! Lang::get('Podio::lang.select-podio-organization') !!}</label>
                                <select class="form-control" id="select-app-org"  name='org_id' data-placeholder="{!! Lang::get('lang.select_tickets') !!}" style="width: 100%;"><option value=""></option></select>
                            </div>
                            <div class="col-md-6">
                                <label>{!! Lang::get('Podio::lang.select-podio-space') !!}</label>
                                <div id="space-loader" style="display:none;">
                                    <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}" height="30px" width="30px">
                                </div>
                                <div id="space-body">
                                    <select class="form-control" id="select-app-space"  name='p_id' data-placeholder="{!! Lang::get('lang.select_tickets') !!}" style="width: 100%;"><option value=""></option></select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>{!! Lang::get('Podio::lang.podio-app-name') !!}</label>
                                {!! Form::text('app_name','',['class' => 'form-control', 'required' => true, 'placeholder' => Lang::get('Podio::lang.faveo-helpdesk'), 'id' => 'app-name']) !!}
                            </div>
                            <div class="col-md-6">
                                <label>{!! Lang::get('Podio::lang.podio-item-name') !!}</label>
                                {!! Form::text('item_name','',['class' => 'form-control', 'required' => true, 'placeholder' => Lang::get('Podio::lang.ticket'), 'id' => 'item-name']) !!}
                            </div>
                        </div>
                    </div><!-- mereg-body-form -->
                </div><!-- merge-body -->
            </div><!-- /.modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis2">{!! Lang::get('lang.close') !!}</button>
                <div id="create" style="display:none"><input  type="submit" id="merge-btn" class="btn btn-primary pull-right" value="{!! Lang::get('Podio::lang.create_app') !!}"></input></div>
                <a href="#" data-toggle="modal" id="app-auth" data-target="#myModal4" style="display:none"><button type="button" class="btn btn-primary">{{Lang::get('Podio::lang.next')}}</button></a>
                {!! Form::close() !!}
            </div><!-- /.modal-footer -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- Modal for last step of setting -->
<div class="modal fade in" id="last-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; padding-right: 15px;background-color: rgba(0, 0, 0, 0.7);">
    <div class="modal-dialog" role="document">
        <div class="col-md-2"></div>
        <div class="col-md-12" style="height:40%">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="{{asset('lb-faveo/media/images/podio.png')}}" height="8%" width="8%">
                    <span style="font-size:1.2em">{{Lang::get('Podio::lang.app-authentication')}}</span> 
                    <button type="button" class="close closemodal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div id="custom-alert-body2">
                        <div class="row">
                            <div id="loader2" style="display:none">
                                <center><img src="{{asset('lb-faveo/media/images/gifloader.gif')}}"></center>
                            </div><!-- 
                            <div id="app-auth-success2" class="col-md-12" style="display:none">
                                <div class="alert alert-success" id="alert-success2">
                                <i class="fa  fa-check-circle"></i>
                                </div>
                            </div>
                            <div id="app-auth-fails2" class="col-md-12" style="display:none">
                                <div class="alert alert-danger" id="alert-danger2">
                                <i class="fa  fa-check-circle"></i>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div id="app-auth-form">
                    {!! Form::open(['id'=>'app-auth-form','method' => 'POST'] )!!}
                        <div class="row">
                            <div class="col-md-6">
                                <label>{!! Lang::get('Podio::lang.app_id') !!}</label>
                                {!! Form::text('app_id','',['class' => 'form-control', 'required' => true, 'placeholder' => Lang::get('Podio::lang.app_id'), 'id' => 'app-id']) !!}
                            </div>
                            <div class="col-md-6">
                                <label>{!! Lang::get('Podio::lang.token') !!}</label>
                                {!! Form::text('token','',['class' => 'form-control', 'required' => true, 'placeholder' => Lang::get('Podio::lang.token'), 'id' => 'app-token']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close-last" class="btn btn-default closemodal pull-left">{{Lang::get('lang.close')}}</button>
                    <div id="last-submit"><input  type="submit" id="merge-btn" class="btn btn-primary pull-right" value="{!! Lang::get('Podio::lang.create_app') !!}"></input></div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<!-- modal end -->
@stop

@section('FooterInclude')

<script>
    $(document).ready(function() {
        // function to show help popup on click
        $('#help').on('click', function(){
            $('#myModal').css('display', 'block')
            $('#custom-alert-body').css('overflow', 'auto')
        })

        // fucntion to close all modal popup by clicking on close
        $('.closemodal').on('click', function(){
            $('#myModal').css('display', 'none');
            $('#auth-modal').css('display', 'none');
            $('#myModal3').css('display', 'none');
            $('#last-modal').css('display', 'none');
        });

        //fucntion to post setting page form for step 1 using ajax
        $('#podio-auth').on('submit', function(e){
            var x = [];
            e.preventDefault();
            $("input" ).each(function(index ) {
                x[index] = $(this ).val();
            });
            $.ajax({
                type: "POST",
                url: "{{route('post-podio-setting')}}",
                dataType: "html",
                data: {input: x},
                beforeSend: function() {
                    $('#auth-modal').css('display', 'block');
                    $('#loader').css('display','block');
                    $('#next').css('display', 'none');
                    $('#auth-success').css('display','none');
                    $('#auth-fails').css('display','none');
                },
                success: function(response) {
                    if(response == 0){
                        $('#next').css('display', 'none');
                        $('#loader').css('display','none');
                        $('#auth-fails').css('display','block');
                        $('#auth-success').css('display','none');
                        $('#alert-danger').html("{{Lang::get('Podio::lang.fill_all_fields')}}");
                    } else if(response == 1){
                        $('#loader').css('display','none');
                        $('#auth-success').css('display','block');
                        $('#auth-fails').css('display','none');
                        $('#alert-success').html("{{Lang::get('Podio::lang.authenitcated-suucessfully')}}");
                        $('#next').css('display', 'block');
                    } else {
                        $('#next').css('display', 'none');
                        $('#loader').css('display','none');
                        $('#auth-fails').css('display','block');
                        $('#auth-success').css('display','none');
                        var errormessage = getErrormessage(response);
                        $('#alert-danger').html("{{Lang::get('Podio::lang.podio-says')}}: <b>"+response+"</b> {{Lang::get('Podio::lang.occured')}}<li>"+errormessage+"</li>");
                    }
                }
            });
        });

        // fucntion to show 2nd step modal pop up
        $('#next').on('click', function(){
            $('#auth-modal').css('display', 'none');
            $('#myModal3').css('display', 'block');
        });

        //function to fecth organization and space on showing modal pop up3
        $('#myModal3').on('show.bs.modal', function() {
            $.ajax({// ajax request to fetch organization
                type: "GET",
                url: "{{route('podio-settings2')}}",
                dataType: "html",
                beforeSend: function() {
                    $('#create').css('display', 'none');
                    $('#app-auth').css('display', 'none');
                    $('#app_auth_loader').css('display', 'block');
                    $('#app_auth_body').css('display', 'none');
                },
                success: function(response) {
                    if(response == 0) {
                        $('#create').css('display', 'none');
                        $('#app_auth_loader').css('display', 'none');
                        $('#app_auth_body').css('display', 'block');
                        $('#app-body-form').css('display', 'none');
                        $('#message-app-err').html("{{Lang::get('Podio::lang.no-organization1')}} <a href='https://podio.com/organization/new' target='_blank'>{{Lang::get('Podio::lang.click-here')}}</a> {{Lang::get('Podio::lang.no-organization2')}}");
                        $('#app-err-alert').css('display', 'block');
                    } else {
                        $('#select-app-org').html(response);
                        $('#app_auth_loader').css('display', 'none');
                        $('#app_auth_body').css('display', 'block');
                        $('#app-succ-alert').css('display', 'none');
                        $('#app-err-alert').css('display', 'none');
                        $('#app-body-form').css('display', 'block');
                        $('#myModal3').css('pointer-events','none');
                        $('.modal-content').css('pointer-events','auto');
                        var x = document.getElementById("select-app-org").value;
                        $.ajax({// ajax request to fetch workspace
                            type: "GET",
                            url: "{{route('podio-settings3')}}",
                            dataType: "html",
                            data: {input: x},
                            beforeSend: function() {
                                $('#space-body').css('display', 'none');
                                $('#space-loader').css('display', 'block');
                                $('select-app-space').html('<img src="{{asset("lb-faveo/media/images/    gifloader.gif")}}">')
                            },
                            success: function(response) {
                                if (response.includes("<option")) {
                                    $('#create').css('display', 'block');
                                    $('#select-app-space').html(response);
                                    $('#space-loader').css('display', 'none');
                                    $('#space-body').css('display', 'block');
                                } else {
                                    $('#create').css('display', 'none');
                                    $('#app_auth_loader').css('display', 'none');
                                    $('#app_auth_body').css('display', 'block');
                                    $('#app-body-form').css('display', 'none');
                                    $('#message-app-err').html("{{Lang::get('Podio::lang.no-organization1')}} <a href='https://podio.com/organization/new' target='_blank'>{{Lang::get('Podio::lang.click-here')}}</a> {{Lang::get('Podio::lang.no-organization2')}}");
                                    $('#app-err-alert').css('display', 'block');
                                }
                            }
                        });
                    }
                }
            });
        });

        //function to fetch workspace for selected organization
        $('#select-app-org').on('change', function(){
            var x = document.getElementById("select-app-org").value;
            $.ajax({
                type: "GET",
                url: "{{route('podio-settings3')}}",
                dataType: "html",
                data: {input: x},
                beforeSend: function() {
                    $('#space-body').css('display', 'none');
                    $('#space-loader').css('display', 'block');
                    $('select-app-space').html('<img src="{{asset("lb-faveo/media/images/gifloader.gif")}}">')
                },
                success: function(response) {
                    $('#create').css('display', 'block');
                    $('#select-app-space').html(response);
                    $('#space-loader').css('display', 'none');
                    $('#space-body').css('display', 'block');
                }
            });
        });

        //function to submit second step and creating app is podio using ajax request
        $('#app-form').on('submit', function(e){
            var x = document.getElementById("select-app-org").value;
            var y = document.getElementById("select-app-space").value;
            var w = document.getElementById("app-name").value;
            var z = document.getElementById("item-name").value;
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{route('podio-settings4')}}",
                dataType: "html",
                data: {input1: x, input2: y, input3: w, input4: z},
                beforeSend: function() {
                    $('#app_auth_body').css('display', 'none');
                    $('#app_auth_loader').css('display', 'block');
                },
                success: function(response){
                    if(response == '1'){
                        $('#create').css('display', 'none');
                        $('#app-auth').css('display', 'block');
                        $('#app_auth_loader').css('display', 'none');
                        $('#app_auth_body').css('display', 'block'); 
                        $('#app-body-form').css('display', 'none');
                        $('#message-app-succ').html('{{Lang::get("Podio::lang.app-created")}}');
                        $('#app-succ-alert').css('display', 'block');
                    } else {
                        $('#create').css('display', 'none');
                        $('#app_auth_loader').css('display', 'none');
                        $('#app_auth_body').css('display', 'block');
                        $('#app-body-form').css('display', 'none');
                        var errormessage = getErrormessage(response);
                        $('#message-app-err').html("{{Lang::get('Podio::lang.podio-says')}}: <b>"+response+"</b> {{Lang::get('Podio::lang.occured')}}<li>"+errormessage+"</li>");
                        $('#app-err-alert').css('display', 'block');
                    }
                }
            });
        });

        // fucntion to show last step modal after creating applicatioj
        $('#app-auth').on('click', function(){
            $('#myModal3').css('display', 'none');
            $('#last-modal').css('display', 'block');
        });

        //function to submit last step form for app authentication
        $('#app-auth-form').on('submit', function(e){
            e.preventDefault();
            var x = document.getElementById("app-id").value;
            var y = document.getElementById("app-token").value;
            $.ajax({
                type: "POST",
                url: "{{route('podio-settings5')}}",
                dataType: "html",
                data: {input1: x, input2: y},
                beforeSend: function() {
                    // $('#app_auth_body').css('display', 'none');
                    // $('#app_auth_loader').css('display', 'block');
                    $('#app-auth-form').css('display', 'none');
                    $('#loader2').css('display', 'block');
                },
                success: function(response) {
                    $('#loader2').css('display', 'none');
                    $('#last-submit').css('display', 'none');
                    $('#app-auth-success2').css('display', 'block');
                    $('#alert-success2').css('display','block');
                    $('#alert-success2').html('{{Lang::get("Podio::lang.successfull-setup-message")}}');
                    $('#close-last').trigger("click");
                }
            });
        });
    });
function getErrormessage(response) {
    if(response === 'PodioInvalidGrantError') {
        return "{{Lang::get('Podio::lang.InvalidGrantError')}}";

    } else if(response === 'PodioBadRequestError'){
        return "{{Lang::get('Podio::lang.BadRequestError')}}";

    } else if(response === 'PodioAuthorizationError'){
        return "{{Lang::get('Podio::lang.AuthorizationError')}}";

    } else if(response === 'PodioForbiddenError'){
        return "{{Lang::get('Podio::lang.ForbiddenError')}}";

    } else if(response === 'PodioNotFoundError'){
        return "{{Lang::get('Podio::lang.NotFoundError')}}";

    } else if(response === 'PodioConflictError'){
        return "{{Lang::get('Podio::lang.ConflictError')}}";

    } else if(response === 'PodioGoneError'){
        return "{{Lang::get('Podio::lang.GoneError')}}";

    } else if(response === 'PodioRateLimitError'){
        return "{{Lang::get('Podio::lang.RateLimitError')}}";

    } else if(response === 'PodioUnavailableError') {
        return "{{Lang::get('Podio::lang.UnavailableError')}}";

    } else if(response === 'PodioServerError') {
        return "{{Lang::get('Podio::lang.ServerError')}}";

    } else {
        return "{{Lang::get('Podio::lang.ServerError')}}";

    }
}
</script>
@stop

