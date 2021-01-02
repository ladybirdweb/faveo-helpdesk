@extends('themes.default1.admin.layout.admin')

@section('Settings')
class="nav-link active"
@stop

@section('settings-menu-parent')
class="nav-item menu-open"
@stop

@section('settings-menu-open')
class="nav nav-treeview menu-open"
@stop

@section('languages')
class="nav-link active"
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
<!-- check whether success or not -->
@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <i class="fa  fa-check-circle"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('success')}} @if(Session::has('link'))<a href="{{url(Session::get('link'))}}">{{Lang::get('lang.enable_lang')}}</a> @endif
</div>
@endif
<!-- failure message -->
@if(Session::has('fails'))
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('fails')}}
</div>
@endif
<div class="card card-light">
    <div class="card-header">
        <h3 class="card-title">{{ Lang::get('lang.language-settings') }}</h3>
        <div class="card-tools">
            <a href="{{route('download')}}" title="click here to download template file" class="btn btn-default btn-tool">
                <i class="fas fa-download"></i> {{Lang::get('lang.download')}} 
            </a> 
            <a href="{{route('add-language')}}" class="btn btn-default btn-tool"><i class="fas fa-plus"></i> {{Lang::get('lang.add')}}</a>
        </div>
    </div>
    <div class="card-body">
        {!! Datatable::table()
        ->addColumn(Lang::get('lang.language'),Lang::get('lang.native-name'),Lang::get('lang.iso-code'),Lang::get('lang.system-language'),Lang::get('lang.Action'))       // these are the column headings to be shown
        ->setUrl(route('getAllLanguages'))   // this is the route where data will be retrieved
        ->render()  !!}
    </div>
</div>
@stop