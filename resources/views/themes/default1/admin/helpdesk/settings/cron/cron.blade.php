@extends('admin.layout.admin')

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
<!-- open a form -->

@if($warn!=="")
@include('admin.helpdesk.settings.cron.cron-new')
@else 
@include('admin.helpdesk.settings.cron.cron-new')
@endif
@stop
