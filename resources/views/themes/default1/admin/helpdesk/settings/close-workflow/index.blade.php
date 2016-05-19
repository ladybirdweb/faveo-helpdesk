@extends('themes.default1.admin.layout.admin')
@section('PageHeader')
<h1>Auto-close Workflow</h1>
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
                    <h3 class="box-title">Close ticket workflow Settings</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    {!! Form::model($security,['route'=>['close-workflow.update', $security->id],'method'=>'PATCH','files' => true]) !!}
                    <div class="form-group {{ $errors->has('days') ? 'has-error' : '' }}">
                        <div class="row">

                            <div class="col-md-3">
                                <label for="title">No of days:</label>
                            </div>
                            <div  class="col-md-9">
                                <blockquote><em>The number of days to after which the tickets will be auto-closed.</em></blockquote>
                 {!! $errors->first('days', '<spam class="help-block">:message</spam>') !!}
                                {!! Form::text('days',null,['class'=>'form-control'])!!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('backlist_threshold') ? 'has-error' : '' }}">
                        <div class="row">

                            <div class="col-md-3">
                                <label for="title">Enable Workflow:</label>
                            </div>
                            <div class="col-md-9">
<blockquote><em>Enable auto-close workflow?</em></blockquote>
                      {!! $errors->first('condition', '<spam class="help-block">:message</spam>') !!}
<div class="row">
				<div class="col-xs-3">
					{!! Form::radio('condition','1') !!} {{Lang::get('lang.yes')}}
				</div>
				<div class="col-xs-3">
					{!! Form::radio('condition','0') !!} {{Lang::get('lang.no')}}
				</div>
		</div>       
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
                    <div class="form-group {{ $errors->has('send_email') ? 'has-error' : '' }}"> 
                        <div class="row">

                            <div class="col-md-3">
                                <label for="title">Send email to user:</label>
                            </div>
                        <div class="col-md-6">
                           <blockquote><em>Send email to user on auto-closing the ticket?.</em></blockquote>
                             {!! $errors->first('send_email', '<spam class="help-block">:message</spam>') !!}
                          <div class="row">
				<div class="col-xs-3">
					{!! Form::radio('send_email','1') !!} {{Lang::get('lang.yes')}}
				</div>
				<div class="col-xs-3">
					{!! Form::radio('send_email','0') !!} {{Lang::get('lang.no')}}
				</div>
		</div>       
                        </div>
                    </div>
                    </div>

                    <div class="form-group {{ $errors->has('send_email') ? 'has-error' : '' }}"> 
                        <div class="row">

                            <div class="col-md-3">
                                <label for="title">Ticket status:</label>
                            </div>
                        <div class="col-md-6">
                           <blockquote><em>Select a status to choose on closing the ticket.</em></blockquote>
                             {!! $errors->first('status', '<spam class="help-block">:message</spam>') !!}
                                <?php $user = \App\Model\helpdesk\Ticket\Ticket_Status::where('state','=','closed')->get(); ?>
                {!! Form::select('status',[ Lang::get('lang.status')=>$user->lists('name','id')->toArray()],null,['class' => 'form-control']) !!}	
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