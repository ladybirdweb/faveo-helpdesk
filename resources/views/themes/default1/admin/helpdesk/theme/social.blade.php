@extends('themes.default1.admin.layout.admin')

@section('Themes')
active
@stop

@section('theme-bar')
active
@stop

@section('socail')
class="active"
@stop
@section('PageHeader')
<h1>{!! trans('lang.widgets') !!}</h1>
@stop
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h4 class="box-title">{!! trans('lang.social-widget-settings') !!} </h4>
    </div>
    <div class="box-body">
        <!-- check whether success or not -->
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! trans('lang.alert') !!} !</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif
        {!! Datatable::table()
        ->addColumn(trans('lang.name'),
        trans('lang.link'),
        trans('lang.action'))  // these are the column headings to be shown
        ->setUrl('list-social-buttons')  // this is the route where data will be retrieved
        ->render() !!}
    </div>
</div>
@stop
