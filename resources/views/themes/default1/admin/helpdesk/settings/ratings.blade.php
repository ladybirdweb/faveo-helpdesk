@extends('themes.default1.admin.layout.admin')

@section('Settings')
active
@stop

@section('ratings')
class="active"
@stop

@section('PageHeader')
<h1>{!! Lang::get('lang.settings') !!}</h1>
@stop

@section('header')
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.current_ratings') !!}</h3>
        <div class="box-tools pull-right">
            <div class="box-tools pull-right">
                <a class="btn btn-box-tool" href="{{ route('rating.create') }}" title="{!! Lang::get('lang.create') !!}"><i class="fa fa-plus-circle fa-2x"></i></a>
            </div>
        </div><!-- /.box-header -->
    </div>
    <div class="box-body">
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p>{{Session::get('success')}}</p>                
        </div>
        @endif
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{!! Lang::get('lang.name') !!}</th>
                    <th>{!! Lang::get('lang.display_order') !!}</th>
                    <th>{!! Lang::get('lang.rating_area') !!}</th>
                    <th>{!! Lang::get('lang.action') !!}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ratings as $rating)
                <tr>
                    <td>{!! $rating->name !!}</td>
                    <td>{!! $rating->display_order !!}</td>
                    <td>{!! $rating->rating_area !!}</td>
                    <td>
                        {!! link_to_route('rating.edit','Edit Ratings',[$rating->id],['class'=>'btn btn-info btn-sm']) !!}
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#{{$rating->id}}delete">Delete</button>
                        <div class="modal fade" id="{{$rating->id}}delete">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">{!! Lang::get('lang.delete') !!}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>{!! Lang::get('lang.are_you_sure_you_want_to_delete') !!} ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{!! Lang::get('lang.close') !!}</button>
                                        {!! link_to_route('ratings.delete',Lang::get('lang.delete'),[$rating->id],['id'=>'delete','class'=>'btn btn-danger btn-sm']) !!}
                                    </div>
                                </div> 
                            </div>
                        </div> 
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

<!-- page script -->
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

<script type="text/javascript">
<?php if (count($errors) > 0) { ?>
        $('#create').modal('show');
<?php } ?>
</script>  

@stop