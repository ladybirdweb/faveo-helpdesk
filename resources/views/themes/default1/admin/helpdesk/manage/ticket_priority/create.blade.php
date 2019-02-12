@extends('admin.layout.admin')

@section('Manage')
active
@stop

@section('manage-bar')
active
@stop

@section('priority')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{!! Lang::get('lang.priority') !!}</h1>
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')
<ol class="breadcrumb">
</ol>
@stop
<!-- /breadcrumbs -->
<!-- content -->
@section('content')
<!-- open a form -->

<form action="{!!URL::route('priority.create1')!!}" method="post" role="form">
{{ csrf_field() }}
    <div class="box box-primary">
        <div class="box-header with-border">
            <h2 class="box-title">{{Lang::get('lang.create')}}</h2>
        </div>
        <div class="box-body">
            @if(Session::has('errors'))
            <?php //dd($errors); ?>
            <div class="alert alert-danger alert-dismissable">
                <i class="fa fa-ban"></i>
                <b>Alert!</b>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <br/>
                @if($errors->first('priority'))
                <li class="error-message-padding">{!! $errors->first('priority', ':message') !!}</li>
                @endif
                @if($errors->first('priority_desc'))
                <li class="error-message-padding">{!! $errors->first('priority_desc', ':message') !!}</li>
                @endif
                @if($errors->first('priority_color'))
                <li class="error-message-padding">{!! $errors->first('priority_color', ':message') !!}</li>
                @endif
                @if($errors->first('status'))
                <li class="error-message-padding">{!! $errors->first('status', ':message') !!}</li>
                @endif
            </div>
            @endif
            <!-- <table class="table table-hover" style="overflow:hidden;"> -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('priority') ? 'has-error' : '' }}">
                        {!! Form::label('priority',Lang::get('lang.priority')) !!} <span class="text-red"> *</span>
                        <input type="text" class="form-control" name="priority" value="" >
                    </div>
                </div>
                <!-- Grace Period text form Required -->
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('priority_desc') ? 'has-error' : '' }}">
                        {!! Form::label('priority_desc',Lang::get('lang.priority_desc')) !!}<span class="text-red"> *</span>
                        <input type="text" name="priority_desc" class="form-control">
                    </div>
                </div> 
            </div>
            <!-- Priority Color -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('priority_color') ? 'has-error' : '' }}">
                        {!! Form::label('priority_color',Lang::get('lang.priority_color')) !!}<span class="text-red"> *</span>
                        <input class="form-control my-colorpicker1 colorpicker-element" id="colorpicker" type="text" name="priority_color">

                    </div>
                </div>
                <!-- status radio: required: Active|Dissable -->
                <div class="col-md-3">
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                        {!! Form::label('status',Lang::get('lang.status')) !!}&nbsp;<span class="text-red"> *</span>
                        <input type="radio"  name="status" value="1" checked>{{Lang::get('lang.active')}}
                        <input type="radio"  name="status" value="0" >{{Lang::get('lang.inactive')}}
                    </div>       
                </div>

                <!-- Show radio: required: public|private -->
                <div class="col-md-3">
                    <div class="form-group {{ $errors->has('ispublic') ? 'has-error' : '' }}">
                        {!! Form::label('ispublic',Lang::get('lang.visibility')) !!}&nbsp;<span class="text-red"> *</span>
                        <input type="radio"  name="ispublic" value="1" checked>public
                        <input type="radio"  name="ispublic" value="0" >private
                    </div>       
                </div>
            </div>  
            <!-- Admin Note  : Textarea :  -->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('admin_note',Lang::get('lang.admin_notes')) !!}
                        {!! Form::textarea('admin_note',null,['class' => 'form-control','size' => '30x5']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            {!! Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary'])!!}
        </div>
    </div>
    <script>
        $(function () {

            $("#colorpicker").colorpicker();
        });
    </script>

    <!-- close form -->
    {!! Form::close() !!}
    @stop