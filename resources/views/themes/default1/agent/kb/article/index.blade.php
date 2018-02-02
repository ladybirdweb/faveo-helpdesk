@extends('themes.default1.agent.layout.agent')

@extends('themes.default1.agent.layout.sidebar')    

@section('article')
active
@stop

@section('all-article')
class="active"
@stop

@section('PageHeader')
<h1>{{trans('lang.article')}}</h1>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{trans('lang.allarticle')}}</h3>
    </div>
    <div class="box-body">
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
            <b>{!! trans('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif
        {!! Datatable::table()
        ->addColumn(trans('lang.name'),
        trans('lang.publish_time'),
        trans('lang.action'))       // these are the column headings to be shown
        ->setOrder(array(1=>'desc')) 
        ->setUrl(route('api.article'))   // this is the route where data will be retrieved
        ->render() !!}
    </div>
</div>
@stop