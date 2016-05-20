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
<!-- -->    
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Close ticket workflow Settings</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
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

        {!! Form::model($security,['route'=>['close-workflow.update', $security->id],'method'=>'PATCH','files' => true]) !!}
        <div class="form-group {{ $errors->has('days') ? 'has-error' : '' }}">
            <div class="row">

                <div class="col-md-3">
                    <label for="title">{!! Lang::get('lang.no_of_days') !!}:</label>
                </div>
                <div  class="col-md-9">
                    <div class="callout callout-default" style="font-style: oblique;">{!! Lang::get('lang.close-msg1') !!}</div>
                    {!! $errors->first('days', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('days',null,['class'=>'form-control'])!!}
                </div>
            </div>
        </div>
        <div class="form-group {{ $errors->has('backlist_threshold') ? 'has-error' : '' }}">
            <div class="row">

                <div class="col-md-3">
                    <label for="title">{!! Lang::get('lang.enable_workflow') !!}:</label>
                </div>
                <div class="col-md-9">
                    <div class="callout callout-default" style="font-style: oblique;">{!! Lang::get('lang.close-msg2') !!}</div>
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
        <div class="form-group {{ $errors->has('send_email') ? 'has-error' : '' }}"> 
            <div class="row">

                <div class="col-md-3">
                    <label for="title">{!! Lang::get('lang.send_email_to_user') !!}:</label>
                </div>
                <div class="col-md-6">
                    <div class="callout callout-default" style="font-style: oblique;">{!! Lang::get('lang.close-msg4') !!}</div>
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
                    <label for="title">{!! Lang::get('lang.ticket_status') !!}:</label>
                </div>
                <div class="col-md-6">
                    <div class="callout callout-default" style="font-style: oblique;">{!! Lang::get('lang.close-msg3') !!}</div>
                    {!! $errors->first('status', '<spam class="help-block">:message</spam>') !!}
                    <?php $user = \App\Model\helpdesk\Ticket\Ticket_Status::where('state', '=', 'closed')->get(); ?>
                    {!! Form::select('status',[ Lang::get('lang.status')=>$user->lists('name','id')->toArray()],null,['class' => 'form-control']) !!}	
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