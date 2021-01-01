@extends('themes.default1.admin.layout.admin')

@section('Themes')
class="nav-link active"
@stop

@section('widget-menu-parent')
class="nav-item menu-open"
@stop

@section('widget-menu-open')
class="nav nav-treeview menu-open"
@stop

@section('social')
class="nav-link active"
@stop

@section('PageHeader')
<h1>{!! Lang::get('lang.widgets') !!}</h1>
@stop
@section('content')
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
    <b>{!! Lang::get('lang.alert') !!} !</b> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('fails')}}
</div>
@endif
<div class="card card-light">
    <div class="card-header">
        <h3 class="card-title">{!! Lang::get('lang.social-widget-settings') !!} </h3>
    </div>
    <div class="card-body">
        {!! Datatable::table()
        ->addColumn(Lang::get('lang.name'),
        Lang::get('lang.link'),
        Lang::get('lang.action'))  // these are the column headings to be shown
        ->setUrl('list-social-buttons')  // this is the route where data will be retrieved
        ->render() !!}
    </div>
</div>
@stop
