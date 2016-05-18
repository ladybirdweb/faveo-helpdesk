@extends('themes.default1.admin.layout.admin')
@section('PageHeader')

@section('Settings')
active
@stop

@section('security')
class="active"
@stop

<h1>Security</h1>
@stop

@section('header')
<h1> List of Security </h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
    <li class="active"> Security Settings </li>
</ol>
@stop

@section('content')
<!-- -->    
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Security Settings</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p>{!! Session::get('success') !!}</p>
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
        {!! Form::model($security,['route'=>['securitys.update', $security->id],'method'=>'PATCH','files' => true]) !!}
        <div class="form-group {{ $errors->has('lockout_message') ? 'has-error' : '' }}">
            <div class="row">
                <div class="col-md-3">
                    <label for="title">Lockout Message:</label>
                </div>
                <div  class="col-md-9">
                    <div class="callout callout-default" style="font-style: oblique;">The message to display when a user (host) has been locked out.</div>
                    {!! $errors->first('lockout_message', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::textarea('lockout_message',null,['class'=>'form-control'])!!}
                </div>
            </div>
        </div>
        <div class="form-group {{ $errors->has('backlist_threshold') ? 'has-error' : '' }}">
            <div class="row">
                <div class="col-md-3">
                    <label for="title">Max Login Attempts Per Host/User:</label>
                </div>
                <div class="col-md-9">
                    <div class="callout callout-default" style="font-style: oblique;">The number of login attempts a user has before their host/user or computer is locked out of the system. Set to 0 to record bad login attempts without locking out the host/user..</div>
                    {!! $errors->first('backlist_threshold', '<spam class="help-block">:message</spam>') !!}
                    <span>{!! Form::text('backlist_threshold',null,['class'=>'form-control'])!!} Lockouts</span>
                </div>     
            </div>
        </div>
        <div class="form-group {{ $errors->has('lockout_period') ? 'has-error' : '' }}"> 
            <div class="row">
                <div class="col-md-3">
                    <label for="title">Lockout Period:</label>
                </div>
                <div class="col-md-8">
                    <div class="callout callout-default" style="font-style: oblique;">The length of minutes a host or user will be banned from this site after hitting the limit of bad logins.</div>
                    {!! $errors->first('lockout_period', '<spam class="help-block">:message</spam>') !!}
                    <span> {!! Form::text('lockout_period',null,['class'=>'form-control'])!!} Minutes</span>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
    <div class="box-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    {!! Form::close() !!}
</div>
@stop
@section('footer')
<script src="{{asset("lb-sample/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
<script src="{{asset("lb-sample/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>
<!-- security script -->
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