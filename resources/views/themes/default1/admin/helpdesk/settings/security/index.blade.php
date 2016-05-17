@extends('themes.default1.admin.layout.admin')
@section('PageHeader')
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

            @if(Session::has('success'))
            <div class="alert alert-success alert-dismissable">
                <i class="fa fa-ban"></i>
                <b>Alert!</b> Success.
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
            <!-- -->    
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Security Settings</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    {!! Form::model($security,['route'=>['securitys.update', $security->id],'method'=>'PATCH','files' => true]) !!}
                    <div class="form-group {{ $errors->has('lockout_message') ? 'has-error' : '' }}">
                        <div class="row">

                            <div class="col-md-3">
                                <label for="title">Lockout Message:</label>
                            </div>
                            <div  class="col-md-9">
                                <blockquote><em>The message to display when a user (host) has been locked out.</em></blockquote>
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
<blockquote><em>The number of login attempts a user has before their host/user or computer is locked out of the system. Set to 0 to record bad login attempts without locking out the host/user..</em></blockquote>
                      {!! $errors->first('backlist_threshold', '<spam class="help-block">:message</spam>') !!}
<span>{!! Form::text('backlist_threshold',null,['class'=>'form-control'])!!} Lockouts</span>
                            </div>     
                        </div>
                    </div>

<!--                    <div class="form-group {{ $errors->has('backlist_offender') ? 'has-error' : '' }}">
                         gender 
                        <div class="row">

                            <div class="col-md-3">
                        {!! Form::label('backlist_offender','Backlist Offender?') !!}
                            </div>
                        <div class="col-md-9">
                            <blockquote><em>If you choose Yes then the IP address of the offending computer will be added to "Ban Users" blacklist after the user reaches the number of lockouts listed above.</em></blockquote>
                               {!! $errors->first('backlist_offender', '<spam class="help-block">:message</spam>') !!}
                            <div class="col-xs-3">
                                {!! Form::radio('backlist_offender','1',true) !!} {{Lang::get('lang.yes')}}
                            </div>
                            <div class="col-xs-3">
                                {!! Form::radio('backlist_offender','0') !!} {{Lang::get('lang.no')}}
                            </div>
                        </div>
                        </div>
                    </div>-->
                    <div class="form-group {{ $errors->has('lockout_period') ? 'has-error' : '' }}"> 
                        <div class="row">

                            <div class="col-md-3">
                                <label for="title">Lockout Period:</label>
                            </div>
                        <div class="col-md-6">
                           <blockquote><em>The length of minutes a host or user will be banned from this site after hitting the limit of bad logins.</em></blockquote>
                             {!! $errors->first('lockout_period', '<spam class="help-block">:message</spam>') !!}
                          <span> {!! Form::text('lockout_period',null,['class'=>'form-control'])!!} Minutes</span>
                        </div>
                    </div>
                    </div>
<!--                    <div class="form-group {{ $errors->has('days_to_keep_logs') ? 'has-error' : '' }}">
                        <div class="row">

                            <div class="col-md-3"><label for="title">No of days to keep logs:</label></div>
                        <div class="col-md-6">
                            <blockquote><em>No of days database logs should be kept.</em></blockquote>
                          {!! $errors->first('days_to_keep_logs', '<spam class="help-block">:message</spam>') !!}
                            <span>{!! Form::text('days_to_keep_logs',null,['class'=>'form-control'])!!} Days</span>
                        </div>
                        </div>
                    </div>-->
                    <div class="form-group">
                        
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                    {!! Form::close() !!}
                </div><!-- /.box-body -->
            </div>

@stop
@section('footer')
<script src="{{asset("lb-sample/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
<script src="{{asset("lb-sample/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>
<!-- security script -->
<script type="text/javascript">
$(function () {
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