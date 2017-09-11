@extends('themes.default1.agent.layout.agent')

@extends('themes.default1.agent.layout.sidebar')    

@section('category')
active
@stop

@section('PageHeader')
<h1>{{trans('lang.category')}}</h1>
@stop

@section('all-category')
class="active"
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{trans('lang.allcategory')}}</h3>
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
            <b>{!! trans('lang.alert') !!} !</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif
        <div class="row">
            <div class="col-sm-12">
                {!! Datatable::table()
                ->addColumn(trans('lang.name'),
                trans('lang.create'),
                trans('lang.action'))       // these are the column headings to be shown
                ->setUrl(route('api.category'))   // this is the route where data will be retrieved
                ->render() !!}
            </div>
        </div>
    </div>
</div>
@stop