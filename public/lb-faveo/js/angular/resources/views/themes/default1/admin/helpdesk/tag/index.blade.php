@extends('themes.default1.admin.layout.admin')

@section('Tickets')
active
@stop

@section('manage-bar')
active
@stop

@section('tags')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{trans('lang.tags')}}</h1>
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

@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <i class="fa fa-check-circle"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('success')}}
</div>
@endif
@if(Session::has('fails'))
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('fails')}}
</div>
@endif
@if(Session::has('warn'))
<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('warn')}}
</div>
@endif
<div class="box">
    <div class="box-header">
        <div class="box-title">
            {{trans('lang.tags')}}
        </div>
        <a href="{{url('tag/create')}}" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-plus"></span> &nbsp;{{trans('lang.new-tag')}}</a>

    </div>
    <div class="box-body">
        {!! 
        Datatable::table()
        ->addColumn(trans('lang.title'),trans('lang.description'),trans('lang.tickets-count'),trans('lang.action'))
        ->setUrl(url('tag-ajax'))   
        ->render()
        !!}
    </div>
</div>
@stop