@extends('themes.default1.admin.layout.admin')

@section('Settings')
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
<h1>{{ Lang::get('lang.settings') }}</h1>
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
<div class="row">
    <div class="col-md-12">
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li id="tab1" class="active"><a href="#tab_1" data-toggle="tab">CLI</a></li>
                <li id="tab2"><a href="#tab_2" data-toggle="tab" id="tab2">URL</a></li>


            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                   @include('themes.default1.admin.helpdesk.settings.cron.cron-new')
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    @include('themes.default1.admin.helpdesk.settings.cron.cron-url')
                </div>
                <!-- /.tab-pane -->
                
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
    </div>
    <!-- /.col -->
</div>
@stop
