@extends('themes.default1.admin.layout.admin')
@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{!! Lang::get('lang.admin_panel') !!}</h1>
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')
@stop
<!-- /breadcrumbs -->
<!-- content -->
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.staffs') !!}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{ url('agents') }}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-user fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.agents') !!}</p>
                    </div>
                </div>
                <!--/.col-md-2-->
                <!--col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{ url('departments') }}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-sitemap fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.departments') !!}</p>
                    </div>
                </div>
                <!--/.col-md-2-->
                <!--col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{ url('teams') }}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-users fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.teams') !!}</p>
                    </div>
                </div>
                <!--/.col-md-2-->
                <!--col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{ url('groups') }}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-group fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.groups') !!}</p>
                    </div>
                </div>
                <!--/.col-md-2-->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- ./box-body -->
</div>
<!-- /.box -->

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.email') !!}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <!--col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{ url('emails') }}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-envelope-o fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.emails') !!}</p>
                    </div>
                </div>
                <!--/.col-md-2-->
                <!--col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{ url('banlist') }}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-ban fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.ban_lists') !!}</p>
                    </div>
                </div>
                <!--/.col-md-2-->
                <!--col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{ url('template-sets') }}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-mail-forward fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.templates') !!}</p>
                    </div>
                </div>
                <!--/.col-md-2-->
                <!--col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{ url('getdiagno') }}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-plus fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.diagnostics') !!}</p>
                    </div>
                </div>
                <!--/.col-md-2-->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- ./box-body -->
</div>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.manage') !!}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{url('helptopic')}}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-file-text-o fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.help_topics') !!}</p>
                    </div>
                </div>
                <!--/.col-md-2-->
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{url('sla')}}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-clock-o fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.sla_plans') !!}</p>
                    </div>
                </div>
                <!--/.col-md-2-->

                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{url('forms')}}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-file-text fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.forms') !!}</p>
                    </div>
                </div>
                <!--/.col-md-2-->
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{url('workflow')}}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-sitemap fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.workflow') !!}</p>
                    </div>
                </div>
                <!--/.col-md-2-->

            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- ./box-body -->
</div>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.settings') !!}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{!! url('getcompany') !!}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-building-o fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.company') !!}</p>
                    </div>
                </div>
                <!--/.col-md-2-->
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{url('getsystem')}}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-laptop fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.system') !!}</p>
                    </div>
                </div>
                <!--/.col-md-2-->

                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{url('getemail')}}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-at fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.email') !!}</p>
                    </div>
                </div>
                <!--/.col-md-2-->

                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{url('getticket')}}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-file-text-o fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.ticket') !!}</p>
                    </div>
                </div>
                <!--/.col-md-2-->

                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{url('getresponder')}}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-reply-all fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.auto_response') !!}</p>
                    </div>
                </div>
                <!--/.col-md-2-->

                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{url('getalert')}}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-bell-o fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.alert_notices') !!}</p>
                    </div>
                </div>
                <!--/.col-md-2-->

                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{url('languages')}}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-language fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title">{!! Lang::get('lang.language') !!}</p>
                    </div>
                </div>
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{url('job-scheduler')}}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa  fa-hourglass-o fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.cron') !!}</p>
                    </div>
                </div>
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{url('security')}}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa  fa-lock fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.security') !!}</p>
                    </div>
                </div>
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{url('setting-status')}}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-hourglass-o"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >Statuses</p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{url('settings-notification')}}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-bell"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.notification') !!}</p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{url('getratings')}}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-star"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.ratings') !!}</p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{url('close-workflow')}}">
                                <span class="fa-stack fa-2x">    
                                    <i class="fa fa-sitemap"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.close_ticket_workflow') !!}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- ./box-body -->
</div>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.widgets') !!}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{ url('widgets') }}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-list-alt fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.widgets') !!}</p>
                    </div>
                </div>
                <!--/.col-md-2-->                                        
                <!--col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{ url('social-buttons') }}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-cubes fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.social') !!}</p>
                    </div>
                </div>
                <!--/.col-md-2-->                                        
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- ./box-body -->
</div>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.plugin') !!}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{ url('plugins') }}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-plug fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.plugin') !!}</p>
                    </div>
                </div>
                <!--/.col-md-2-->

            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- ./box-body -->
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.api') !!}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="{{ url('api') }}">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-archive"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >{!! Lang::get('lang.api') !!}</p>
                    </div>
                </div>
                <!--/.col-md-2-->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- ./box-body -->
</div>
<?php \Event::fire('service.desk.admin.settings', array()); ?>


@stop
