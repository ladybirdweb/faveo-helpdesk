@extends('themes.default1.admin.layout.admin')
@section('PageHeader')
<h1>Ratings</h1>
@stop
@section('header')

<h1> List of Ratings </h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
    <li class="active"> Settings </li>
</ol>
@stop

@section('content')


            <!-- -->    
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Current Ratings</h3>
                     <div class="box-tools pull-right">
                                              <div class="box-tools pull-right">
                                                  <a class="btn btn-box-tool" href="{{ route('rating.create') }}" title="Create"><i class="fa fa-plus-circle fa-2x"></i></a>

<!--                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>-->
              </div>
                </div><!-- /.box-header -->
                </div>
                
                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <p>{{Session::get('success')}}</p>                
                    </div>
                @endif
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                
                                <th>Name</th>
                                <th>Display Order</th>
                                <th>Rating Area</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ratings as $rating)
                               
                            <tr>
                                <td>{!! $rating->id !!}</td>
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
                                 <h4 class="modal-title">Delete</h4>
                                      </div>
                                         <div class="modal-body">
                                             <p>Are you sure you want to Delete ?</p>
                                                </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                                            {!! link_to_route('ratings.delete','Delete',[$rating->id],['id'=>'delete','class'=>'btn btn-danger btn-sm']) !!}
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