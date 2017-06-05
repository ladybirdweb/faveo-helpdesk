@extends('themes.default1.admin.layout.admin')

@section('Manage')
active
@stop

@section('manage-bar')
active
@stop

@section('ticket-types')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{!! Lang::get('lang.ticket_type') !!}</h1>
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')
<ol class="breadcrumb">
</ol>
@stop

<!-- content -->
@section('content')

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
<div class="box box-primary">
    <div class="box-header with-border">
        <span class="lead border-right">
        {!! Lang::get('lang.ticket_type') !!}</span>
        <div class="pull-right">
             <a href="{{route('ticket.type.create')}}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;{{Lang::get('lang.create_ticket_type')}}</a>
        </div>
    </div>
    <div class="box-body">
        {!! Datatable::table()
        ->addColumn(
        Lang::get('lang.ticket_type_name'),
        Lang::get('lang.type_desc'),
        
        Lang::get('lang.status'),
        Lang::get('lang.action'))
        ->setUrl(route('ticket.type.index1')) // this is the route where data will be retrieved
        ->render() !!}
    </div>
    <div class="box-footer">
    </div>
</div>

<script>
    function confirmDelete(id) {
        var r = confirm('Are you sure?');
        if (r == true) {
            // alert('{!! url("ticket_priority") !!}/' + id + '/destroy');
            window.location = '{!! url("ticket-types") !!}/' + id + '/destroy';
            //    $url('ticket_priority/' . $model->priority_id . '/destroy')
        } else {
            return false;
        }
    }
</script>

@stop