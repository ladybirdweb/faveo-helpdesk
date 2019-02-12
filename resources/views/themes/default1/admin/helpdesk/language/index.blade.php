@extends('admin.layout.admin')

@section('Settings')
active
@stop

@section('settings-bar')
active
@stop

@section('languages')
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
<div class="box box-primary">
    <div class="box-header">
        <h2 class="box-title">{{ Lang::get('lang.language-settings') }}</h2><span class="pull-right"><a href="{{route('download')}}" title="click here to download template file" class="btn btn-primary"><i class="fa fa-download"></i> {{Lang::get('lang.download')}} </a> <a href="{{route('add-language')}}" class="btn btn-primary "><i class="fa fa-plus"></i> {{Lang::get('lang.add')}}</a></span>
    </div>
    <div class="box-body">
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
        {!! Datatable::table()
        ->addColumn(Lang::get('lang.language'),Lang::get('lang.native-name'),Lang::get('lang.iso-code'),Lang::get('lang.system-language'),Lang::get('lang.Action'))       // these are the column headings to be shown
        ->setUrl(route('getAllLanguages'))   // this is the route where data will be retrieved
        ->render()  !!}
    </div>
</div>
@stop