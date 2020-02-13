@extends('themes.default1.agent.layout.agent')
@section('comment')
    class="active"
@stop
@section('content')
<body>
<div class="box box-primary">
<div class="box-header">
    <h2 class="box-title">{{Lang::get('lang.comments')}}</h2></div>
<div class="box-body table-responsive no-padding">
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
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('fails')}}
    </div>
    @endif
    <section class="content">
<div class="row">
<div class="col-xs-12">
<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table table-hover" style="overflow:hidden;">
<div class="row">
<div class="col-sm-12">
    <table id="example2"  class="table table-bordered table-striped dataTable" >
        <thead>
        <tr>
            <th>{{Lang::get('lang.name')}}</th>
			<th>{{Lang::get('lang.email')}}</th>
			<th>{{Lang::get('lang.website')}}</th>
			<th>{{Lang::get('lang.comment')}}</th>
			<th>{{Lang::get('lang.status')}}</th>
			<th>{{Lang::get('lang.created')}}</th>
			<th>{{Lang::get('lang.action')}}</th>
        </tr>
        </thead>
        <tbody>
         {!! Datatable::table()
    ->addColumn('id','name')       // these are the column headings to be shown
    ->setUrl(route('api.category'))   // this is the route where data will be retrieved
    ->render() !!}
        </tbody>
    </table>
    </div>
    </div>
    </div>
    </div>
    </div>
    </section>
    </div>
    </div>
    </body>
    <script>
  $(function () {
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