@extends('themes.default1.admin.layout.admin')

@section('Manage')
class="active"
@stop

@section('manage-bar')
active
@stop

@section('help')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')

@stop
<!-- /breadcrumbs -->
<!-- content -->
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{!! Lang::get('lang.ticket_workflow') !!}</h3>
                <a href="{!! URL::route('workflow.create') !!}" class="btn btn-primary pull-right">{!! Lang::get('lang.create') !!}</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <!-- check whether success or not -->
                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissable">
                    <i class="fa  fa-check-circle"></i>
                    <b>Success</b>
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
                Lang::get('lang.order'),
                Lang::get('lang.rules'),
                Lang::get('lang.target_channel'),
                Lang::get('lang.created'),
                Lang::get('lang.updated'),
                Lang::get('lang.action')) // these are the column headings to be shown
                ->setUrl(route('workflow.list'))   // this is the route where data will be retrieved
                ->render() !!}
            </div>
            <!-- /.box-body -->
            <!-- <div class="box box-footer"> -->

            <!-- </div> -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>

<script>
    $(function() {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>
@stop
