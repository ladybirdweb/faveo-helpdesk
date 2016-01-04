@extends('themes.default1.agent.layout.agent')
@extends('themes.default1.agent.layout.sidebar')    
@section('article')
    active
@stop
@section('all-article')
    class="active"
@stop
@section('content')
<div class="box box-primary">
    <div class="box-header">
        <h2 class="box-title">{{Lang::get('lang.articles')}}</h2>
    </div>
    <div class="box-body">
        <!-- check whether success or not -->
        @if(Session::has('success'))
            <div class="alert alert-success alert-dismissable">
                <i class="fa  fa-check-circle"></i>
                <b>Success</b>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{Session::get('success')}}
            </div>
            @endif
            <!-- failure message -->
            @if(Session::has('fails'))
            <div class="alert alert-danger alert-dismissable">
                <i class="fa fa-ban"></i>
                <b>Fail!</b>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{Session::get('fails')}}
            </div>
            @endif
                {!! Datatable::table()
                    ->addColumn(Lang::get('lang.name'),
                                Lang::get('lang.create'),
                                Lang::get('lang.action'))       // these are the column headings to be shown
                    ->setUrl(route('api.article'))   // this is the route where data will be retrieved
                    ->render() !!}
    </div>
</div>
@stop