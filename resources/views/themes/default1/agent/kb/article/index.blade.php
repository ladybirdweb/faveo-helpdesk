@extends('themes.default1.agent.layout.agent')

@extends('themes.default1.agent.layout.sidebar')    

@section('Tools')
class="nav-link active"
@stop

@section('tool')
class="active"
@stop

@section('kb')
class="nav-link active"
@stop

@section('all-article')
class="nav-link active"
@stop

@section('article')
class="nav-link active"
@stop

@section('article-menu-open')
class="nav nav-treeview menu-open"
@stop

@section('article-menu-parent')
class="nav-item menu-open"
@stop

@section('PageHeader')
<h1>{{Lang::get('lang.article')}}</h1>
@stop

@section('content')
<!-- check whether success or not -->
@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <i class="fa  fa-check-circle"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('success')}}
</div>
@endif
<!-- failure message -->
@if(Session::has('fails'))
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <b>{!! Lang::get('lang.alert') !!}!</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('fails')}}
</div>
@endif
<div class="card card-light">
    <div class="card-header">
        <h3 class="card-title">{{Lang::get('lang.allarticle')}}</h3>
    </div>
    <div class="card-body">
        {!! Datatable::table()
        ->addColumn(Lang::get('lang.name'),
        Lang::get('lang.publish_time'),
        Lang::get('lang.action'))       // these are the column headings to be shown
        ->setOrder(array(1=>'desc')) 
        ->setUrl(route('api.article'))   // this is the route where data will be retrieved
        ->render() !!}
    </div>
</div>
@stop