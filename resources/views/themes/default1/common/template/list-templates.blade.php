@extends('themes.default1.admin.layout.admin')
@section('PageHeader')
<h1>Templates</h1>
@stop
@section('header')

@section('content')

<!-- -->    
<div class="box box-primary">

    <div class="box-header with-border">

        <h3 class="box-title">{!! Lang::get('lang.edit_templates') !!}</h3>


<!--<button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>-->

    </div><!-- /.box-header -->
    <div class="box-body">

        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-ban"></i>

            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p>{{Session::get('success')}}</p>                
        </div>
        @endif
        @if(Session::has('failed'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>Alert!</b> Failed.
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p>{{Session::get('failed')}}</p>                
        </div>
        @endif
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>

                    <th>Template Name</th>
                    <th>Subject</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach($templates as $template)

                <tr>
                    <td>{!! $template->id !!}</td>
                    <td>{!! $template->name !!}</td>
                    <td>{!! $template->subject !!}</td>

                    <td>
                        {!! link_to_route('templates.edit', Lang::get('lang.edit_templates'),[$template->id],['class'=>'btn btn-success btn-sm']) !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div><!-- /.box-body -->
</div>


@stop
@section('footer')
<script src="{{asset("lb-sample/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
<script src="{{asset("lb-sample/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>
<!-- status script -->
<script type="text/javascript">
$(function() {
    $("#example1").dataTable();
    $('#example2').dataTable({
        "bPaginate": true,
        "bLengthChange": false,
        "bFilter": false,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false
    });
});
</script>



@stop