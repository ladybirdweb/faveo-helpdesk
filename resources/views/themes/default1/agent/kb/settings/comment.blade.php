@extends('themes.default1.agent.layout.agent')

@extends('themes.default1.agent.layout.sidebar')    
@section('PageHeader')
<h1>{!! Lang::get('lang.comments') !!}</h1>
@stop
@section('comment')
class="nav-link active"
@stop

@section('Tools')
class="nav-link active"
@stop

@section('tool')
class="active"
@stop

@section('kb')
class="nav-link active"
@stop

@section('content')

@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <i class="fas fa-check-circle"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('success')}}
</div>
@endif
<!-- failure message -->
@if(Session::has('fails'))
<div class="alert alert-danger alert-dismissable">
    <i class="fas fa-ban"></i>
    <b>{!! Lang::get('lang.alert') !!} !</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('fails')}}
</div>
@endif

<div class="card card-light">
    <div class="card-header">
        <h3 class="card-title">{{Lang::get('lang.comments-list')}}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                {!! Datatable::table()
                ->addColumn(Lang::get('lang.details'), 
                Lang::get('lang.comment'),
                Lang::get('lang.status'),
                Lang::get('lang.action'))       // these are the column headings to be shown
                ->setUrl(route('api.comment'))   // this is the route where data will be retrieved
                ->render() !!}
            </div>
        </div>
    </div>
</div>

@stop