@extends('themes.default1.admin.layout.admin')
@section('head')

@stop
@section('header')

<h1> List of Ratings </h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
    <li class="active"> Settings </li>
</ol>
@stop

@section('content')
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            
                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissable">
                        <i class="fa fa-ban"></i>
                        <b>Alert!</b> Success.
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <p>{{Session::get('success')}}</p>                
                    </div>
                @endif

            <!-- -->    
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Current Ratings</h3>
                     <div class="box-tools pull-right">
                                              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-toggle="modal" data-target="#create" title="Create"><i class="fa fa-plus-circle fa-2x"></i></button>
                 <div class="modal fade" id="create">
                                       <div class="modal-dialog">
                                          <div class="modal-content">
                                  {!! Form::open(['route'=>'rating.create']) !!}
                    <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Create</h4>
        </div>
                     <div class="modal-body">
                         <h3 id="conn" style="display:none;">Successfully Saved</h3>
                                              <div id="show" style="display:none;">
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-9">
            <img src="{{asset("dist/img/loading.gif")}}">
        </div>
    </div>
</div>
                              <div class="form-group {{ $errors->has('rating_name') ? 'has-error' : '' }}">
        <div class="row">
                 
              <div class="col-md-6">
                    <label for="title">Name:</label><br>
{!! Form::text('rating_name',null,['class'=>'form-control'])!!}
              </div>
            
        </div></div>
         <div class="form-group {{ $errors->has('publish') ? 'has-error' : '' }}">
		<!-- gender -->
			{!! Form::label('gender','Would you like to publish this rating?') !!}
                        <blockquote>If you choose Yes then the rating will be publish in client and agent panel.</blockquote>
			<div class="row">
				<div class="col-xs-3">
					{!! Form::radio('publish','1') !!} {{Lang::get('lang.yes')}}
				</div>
				<div class="col-xs-3">
					{!! Form::radio('publish','0') !!} {{Lang::get('lang.no')}}
				</div>
			</div>
		</div>
                           <div class="form-group {{ $errors->has('modify') ? 'has-error' : '' }}">
		<!-- Email user -->
						
{!! Form::label('modify','Allow user to change the rating?') !!}
                        <blockquote>If you choose 'YES' user can modify the rating.</blockquote>
			<div class="row">
				<div class="col-xs-3">
					{!! Form::radio('modify','1') !!} {{Lang::get('lang.yes')}}
				</div>
				<div class="col-xs-3">
					{!! Form::radio('modify','0') !!} {{Lang::get('lang.no')}}
				</div>
		</div>        
                     </div>
                         </div>
                                                                        <div class="modal-footer">
                                                                            <div class="form-group">
                                                                                {!! Form::submit('Create Rating',['class'=>'btn btn-primary'])!!}
                                                                            
                                                                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                                        </div></div>
                                                                        {!! Form::close() !!}
                                                                    </div> 
                                                                </div>
                                                            </div>
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                
                                <th>Name</th>
                                
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ratings as $rating)
                               
                            <tr>
                                <td>{!! $rating->id !!}</td>
                                <td>{!! $rating->rating_name !!}</td>
                                
                                 <td>
                                     
                                   <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#{{$rating->id}}">Edit Details</button> 
                                   
                                  <div class="modal fade" id="{{$rating->id}}">
                                       <div class="modal-dialog">
                                          <div class="modal-content">
                                             
                                             
                                  {!! Form::model($rating,['route'=>['settings.rating', $rating->id],'method'=>'PATCH','files' => true]) !!} 
                                  {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
                    <div class="modal-header">
                       
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Edit Details</h4>
        </div>
                    <div class="modal-body">
                         <h3 id="conn" style="display:none;">Successfully Saved</h3>
                                              <div id="show" style="display:none;">
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-9">
            <img src="{{asset("dist/img/loading.gif")}}">
        </div>
    </div>
</div>
                         <div class="row">
                              <div class="col-md-6 form-group {{ $errors->has('rating_name') ? 'has-error' : '' }}">
                {!! Form::label('rating_name',Lang::get('lang.rating_name')) !!}
                {!! Form::text('rating_name',null,['class' => 'form-control']) !!}
            </div>
                                     </div>
                                              <div class=" form-group {{ $errors->has('publish') ? 'has-error' : '' }}">
                {!! Form::label('publish',Lang::get('lang.publish')) !!}
                   <blockquote>If you choose Yes then the rating will be publish in client and agent panel.</blockquote>
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::radio('publish','1',true) !!} {{Lang::get('lang.yes')}}
                    </div>
                    <div class="col-xs-12">
                        {!! Form::radio('publish','0') !!} {{Lang::get('lang.no')}}
                    </div>
                </div>
            </div>
                                              <div class="form-group {{ $errors->has('modify') ? 'has-error' : '' }}">
                {!! Form::label('modify',Lang::get('lang.modify')) !!}
                          <blockquote>If you choose 'YES' user can modify the rating.</blockquote>
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::radio('modify','1',true) !!} {{Lang::get('lang.yes')}}
                    </div>
                    <div class="col-xs-12">
                        {!! Form::radio('modify','0') !!} {{Lang::get('lang.no')}}
                    </div>
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
                                    
                                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#{{$rating->slug}}delete">Delete</button>
                                                            
                                                            <div class="modal fade" id="{{$rating->slug}}delete">
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
            <!-- -->
        </div>
    </div>

    </section>

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

    

@stop