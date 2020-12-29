@extends('themes.default1.agent.layout.agent')

@section('Users')
class="nav-link active"
@stop

@section('user-bar')
active
@stop

@section('user')
class="active"
@stop

@section('organizations')
class="nav-link active"
@stop

@section('PageHeader')
<h1>{!! Lang::get('lang.organizations') !!}</h1>
@stop
<!-- content -->
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
    
        <h3 class="card-title">{{Lang::get('lang.organization_list')}}</h3>
    
        <div class="card-tools">
    
            <a href="{{route('organizations.create')}}" class="btn btn-default btn-tool"><i class="fas fa-plus"> </i> {{Lang::get('lang.create_organization')}}</a>        
        </div>

    </div>
    
    <div class="card-body">
    
        {!! Datatable::table()
        ->addColumn(Lang::get('lang.name'),
        Lang::get('lang.website'),
        Lang::get('lang.phone'),
        Lang::get('lang.action'))  // these are the column headings to be shown
        ->setUrl(route('org.list'))  // this is the route where data will be retrieved
        ->render() !!}
    </div>
</div>
@stop