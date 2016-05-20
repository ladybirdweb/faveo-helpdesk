@extends('themes.default1.admin.layout.admin')

@section('Settings')
active
@stop

@section('status')
class="active"
@stop

@section('PageHeader')
<h1>Status Settings</h1>
@stop
@section('header')

<h1> List of Statuses </h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
    <li class="active"> {!! Lang::get('lang.edit_status') !!} </li><ol class="breadcrumb">

</ol>
@stop

@section('content')

<!-- -->    
<div class="box box-primary with border">

    <div class="box-header with-border">

        <h3 class="box-title">{!! Lang::get('lang.current_status') !!}</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-toggle="modal" data-target="#create" title="Create"><i class="fa fa-plus-circle fa-2x"></i></button>
            <div class="modal fade" id="create">
                <div class="modal-dialog">
                    <div class="modal-content">
                        {!! Form::open(['route'=>'statuss.create']) !!}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Create</h4>
                        </div>
                        <div class="modal-body">

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                        <label for="title">Name:</label><br>
                                        {!! Form::text('name',null,['class'=>'form-control'])!!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('sort') ? 'has-error' : '' }}">
                                        <label for="title">Display Order:</label><br>
                                        {!! Form::text('sort',null,['class'=>'form-control'])!!}
                                    </div>  
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('icon_class') ? 'has-error' : '' }}">
                                        <label for="title">Icon Class:</label><br>
                                        {!! Form::text('icon_class',null,['class'=>'form-control'])!!}
                                    </div> 
                                </div>
                            </div>
                            <div class="form-group">
                                <!-- gender -->
                                {!! Form::label('gender','Is this a resolved ticket status?') !!}
                                <blockquote>If tickets set to this status are resolved or closed (i.e. fixed, resolved, finished), enable this option. It will hide them from open ticket lists.</blockquote>
                                <div class="row">
                                    <div class="col-xs-3">
                                        {!! Form::radio('state','closed') !!} {{Lang::get('lang.yes')}}
                                    </div>
                                    <div class="col-xs-3">
                                        {!! Form::radio('state','open') !!} {{Lang::get('lang.no')}}
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <!-- Email user -->

                                {!! Form::label('gender','Is this a deleted ticket status?') !!}
                                <blockquote>If you choose 'YES' then the ticket status will be set as deleted.</blockquote>
                                <div class="row">
                                    <div class="col-xs-3">
                                        {!! Form::radio('delete','yes') !!} {{Lang::get('lang.yes')}}
                                    </div>
                                    <div class="col-xs-3">
                                        {!! Form::radio('delete','no') !!} {{Lang::get('lang.no')}}
                                    </div>
                                </div>        
                            </div>
                            <div class="form-group">
                                <!-- Email user -->

                                {!! Form::label('gender','Notify user on this status?') !!}
                                <blockquote>If you choose 'YES' an email notification will be sent to the user.</blockquote>
                                <div class="row">
                                    <div class="col-xs-3">
                                        {!! Form::radio('email_user','yes') !!} {{Lang::get('lang.yes')}}
                                    </div>
                                    <div class="col-xs-3">
                                        {!! Form::radio('email_user','no') !!} {{Lang::get('lang.no')}}
                                    </div>
                                </div>        
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="form-group">
                                {!! Form::submit('Create Status',['class'=>'btn btn-primary'])!!}

                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div> 
                </div>
            </div>
<!--<button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>-->
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        @if(Session::has('errors'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @foreach ($errors->all() as $error)
            <li class="error-message-padding">{{ $error }}</li>
            @endforeach 
        </div>
        @endif
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
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
                    <th>Status Name</th>
                    <th>Display Order</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach($statuss as $status)
                <?php if ($status->name == 'Deleted') continue; ?>
                <tr>
                    <td>{!! $status->id !!}</td>
                    <td>{!! $status->name !!}</td>
                    <td>{!! $status->sort !!}</td>

                    <td>
                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#stat{{$status->id}}">Edit Details</button> 

                        <div class="modal fade" id="stat{{$status->id}}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    {!! Form::model($status,['route'=>['statuss.update', $status->id],'method'=>'PATCH','files' => true]) !!}
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

                                            <div class="col-md-6">
                                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                                    <label for="title">{!! Lang::get('lang.name') !!}:</label><br>
                                                    {!! Form::text('name',null,['class'=>'form-control'])!!}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group {{ $errors->has('sort') ? 'has-error' : '' }}">
                                                    <label for="title">Display Order:</label><br>
                                                    {!! Form::text('sort',null,['class'=>'form-control'])!!}
                                                </div>  
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group {{ $errors->has('icon_class') ? 'has-error' : '' }}">
                                                    <label for="title">Icon Class:</label><br>
                                                    {!! Form::text('icon_class',null,['class'=>'form-control'])!!}
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <!-- gender -->
                                            {!! Form::label('gender',Lang::get('resolved_status')) !!}
                                            <blockquote>{!! Lang::get('lang.status_msg1') !!}</blockquote>
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    {!! Form::radio('state','closed',true) !!} {{Lang::get('lang.yes')}}
                                                </div>
                                                <div class="col-xs-3">
                                                    {!! Form::radio('state','open') !!} {{Lang::get('lang.no')}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <!-- Email user -->

                                            {!! Form::label('gender',Lang::get('deleted_status')) !!}
                                            <blockquote>{!! Lang::get('lang.status_msg2') !!}</blockquote>
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    {!! Form::radio('delete','yes') !!} {{Lang::get('lang.yes')}}
                                                </div>
                                                <div class="col-xs-3">
                                                    {!! Form::radio('delete','no') !!} {{Lang::get('lang.no')}}
                                                </div>
                                            </div>        
                                        </div>
                                        <div class="form-group">
                                            <!-- gender -->

                                            {!! Form::label('gender',Lang::get('lang.notify_user')) !!}
                                            <blockquote>{!! Lang::get('lang.status_msg1') !!}</blockquote>
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    {!! Form::radio('email_user','yes') !!} {{Lang::get('lang.yes')}}
                                                </div>
                                                <div class="col-xs-3">
                                                    {!! Form::radio('email_user','no') !!} {{Lang::get('lang.no')}}
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

                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#{{$status->id}}delete">Delete</button>

                        <div class="modal fade" id="{{$status->id}}delete">
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
                                        {!! link_to_route('statuss.delete','Delete',[$status->id],['id'=>'delete','class'=>'btn btn-danger btn-sm']) !!}
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