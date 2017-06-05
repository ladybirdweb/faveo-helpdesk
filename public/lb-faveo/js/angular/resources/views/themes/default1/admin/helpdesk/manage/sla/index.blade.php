@extends('themes.default1.admin.layout.admin')

@section('Manage')
active
@stop

@section('manage-bar')
active
@stop

@section('sla')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{Lang::get('lang.SLA_plan')}}</h1>
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
	<div class="row">
<div class="col-md-12">
<div class="box box-primary">
<div class="box-header">
	<h2 class="box-title">{{Lang::get('lang.list_of_SLA_plan')}}</h2><a href="{{route('sla.create')}}" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-plus"></span> &nbsp;{{Lang::get('lang.create_SLA')}}</a></div>

<div class="box-body">

<!-- check whether success or not -->

@if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <i class="fa  fa-check-circle"></i>
        <b>Success!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {!! Session::get('success') !!}
    </div>
    @endif
    <!-- failure message -->
    @if(Session::has('fails'))
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <b>Fail!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {!! Session::get('fails') !!}
    </div>
    @endif


{!! Datatable::table()
        ->addColumn(Lang::get('lang.name'),
          
       Lang::get('lang.status'),
       Lang::get('lang.priority'),
      Lang::get('lang.created'),
      
        Lang::get('lang.action'))  // these are the column headings to be shown
        ->setUrl(route('sla.plan.getindex'))  // this is the route where data will be retrieved
        ->render() !!}

</div>
</div>
</div>
</div>

<script>
    function confirmDelete(id) {
        var r = confirm('Are you sure?');
        if (r == true) {
            
            window.location = '{!! url("sla_plan/delete") !!}/' + id;
            
        } else {
            return false;
        }
    }
</script>

@stop
