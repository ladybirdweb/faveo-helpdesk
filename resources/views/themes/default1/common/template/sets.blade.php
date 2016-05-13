@extends('themes.default1.admin.layout.admin')
@section('head')

@stop
@section('header')

<h1> List of Statuses </h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
    <li class="active"> Edit Status </li>
</ol>
@stop

@section('content')
<section class="content" style='padding-top: 30px'>
    <div class="row">
        <div class="col-xs-12">
            
            <!-- -->    
            <div class="box">
                
                <div class="box-header with-border">
                    
                    <h3 class="box-title">Current Sets</h3>
                     <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-toggle="modal" data-target="#create" title="Create"><i class="fa fa-plus-circle fa-2x"></i></button>
                 <div class="modal fade" id="create">
                                       <div class="modal-dialog">
                                          <div class="modal-content">
                                  {!! Form::open(['route'=>'template-sets.store']) !!}
                    <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Create</h4>
        </div>
                     <div class="modal-body">
                        
                              <div class="form-group">

                    <label for="title">Name:</label><br>
{!! Form::text('name',null,['class'=>'form-control'])!!}
              
                        
                     </div>
                         </div>
                                                                        <div class="modal-footer">
                                                                            <div class="form-group">
                                                                                {!! Form::submit('Create Set',['class'=>'btn btn-primary'])!!}
                                                                            
                                                                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                                        </div></div>
                                                                        {!! Form::close() !!}
                                                                    </div> 
                                                                </div>
                                                            </div>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
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
                                
                                <th>Set Name</th>
                                <th>Status</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sets as $set)
                               
                            <tr>
                                <td>{!! $set->id !!}</td>
                                <td>{!! $set->name !!}</td>
                                <?php $status = DB::table('settings_email')->first(); 
                                if (strpos($status->template, '_') !== false) {
            $ratName = str_replace('_', ' ',$status->template);
            }
            else {
                $ratName = $status->template;
              
            }
                                ?>
                                
                <td><input type="radio" disabled="disabled" value="Active"<?php echo ($ratName == $set->name)?'checked':'' ?> /></td>
                                 <td>
                                     {!! link_to_route('active.template-set','Activate This Set',[$set->name],['class'=>'btn btn-success btn-sm']) !!}
                                     {!! link_to_route('show.templates','Show',[$set->id],['class'=>'btn btn-success btn-sm']) !!}
                                   <!--<button class="btn btn-info btn-sm" data-toggle="modal" data-target="#{{$set->id}}">Edit Details</button>--> 
                                   
                                  <div class="modal fade" id="{{$set->id}}">
                                       <div class="modal-dialog">
                                          <div class="modal-content">
                                  {!! Form::model($set,['route'=>['template-sets.update', $set->id],'method'=>'PATCH','files' => true]) !!}
                    <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Edit Details</h4>
        </div>
                     <div class="modal-body">
                         
                              <div class="form-group">
                
              <div class="form-control">
                    <label for="title">Name:</label><br>
{!! Form::text('name',null,['class'=>'form-control'])!!}
              </div>
            </div>
                         
                                     </div>
                                                                        <div class="modal-footer">
                                                                            <div class="form-group">
                                                                                {!! Form::submit('Update Details',['class'=>'btn btn-primary'])!!}
                                                                            
                                                                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                                        </div></div>
                                                                        {!! Form::close() !!}
                                                                    </div> 
                                                                </div>
                                                            </div>
                                   
                                    <?php 
                                  $settings =   DB::table('settings_email')->whereId(1)->first();
if($set->name == $settings->template)  {
  $dis = "disabled";  
} else {
  $dis = "";
} ?>
                                                            <button class="btn btn-danger btn-sm {!! $dis !!}" data-toggle="modal" data-target="#{{$set->id}}delete">Delete</button>
                                                            
                                                            <div class="modal fade" id="{{$set->id}}delete">
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
                                                                            {!! link_to_route('sets.delete','Delete',[$set->id],['id'=>'delete','class'=>'btn btn-danger btn-sm']) !!}
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
            <!-- -->
        </div>
    </div>

          
    </section>

@stop
@section('footer')
<script src="{{asset("lb-sample/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
<script src="{{asset("lb-sample/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>
<!-- set script -->
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