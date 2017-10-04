@extends('themes.default1.admin.layout.admin')

@section('Manage')
active
@stop

@section('manage-bar')
active
@stop

@section('ticket-types')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{!! Lang::get('lang.ticket_type') !!}</h1>
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

<form action="{!!URL::route('ticket.type.create1')!!}" method="post" role="form" id="Form">
{{ csrf_field() }}
    <div class="box box-primary">
        <div class="box-header with-border">
            <h2 class="box-title">{{Lang::get('lang.create_new_ticket_type')}}</h2>
        </div>
        <div class="box-body">
            @if(Session::has('errors'))
           
            <div class="alert alert-danger alert-dismissable">
                <i class="fa fa-ban"></i>
                <b>Alert!</b>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <br/>
                @if($errors->first('name'))
                <li class="error-message-padding">{!! $errors->first('name', ':message') !!}</li>
                @endif
                @if($errors->first('type_desc'))
                <li class="error-message-padding">{!! $errors->first('type_desc', ':message') !!}</li>
                @endif
              

            </div>
            @endif
            <!-- <table class="table table-hover" style="overflow:hidden;"> -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('name',Lang::get('lang.name')) !!} <span class="text-red"> *</span>
                        {!! Form::text('name',null,['class' => 'form-control']) !!}
<!--                    <input type="text" class="form-control" name="name" value="" >-->
                    
                    </div>
                </div>
                <!-- Grace Period text form Required -->
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('type_desc') ? 'has-error' : '' }}">
                        {!! Form::label('type_desc',Lang::get('lang.type_desc')) !!}<span class="text-red"> *</span>
                        {!! Form::text('type_desc',null,['class' => 'form-control']) !!}
<!--                    <input type="text" name="type_desc" class="form-control">-->
                    </div>
                </div> 
            </div>
            <!-- Priority Color -->
            <div class="row">
                
                <!-- status radio: required: Active|Dissable -->
                <div class="col-md-3">
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                        {!! Form::label('status',Lang::get('lang.status')) !!}&nbsp;<span class="text-red"> *</span>&nbsp;&nbsp;&nbsp;
<!--                        <input type="radio"  name="status" value="1" checked> &nbsp;&nbsp;{{Lang::get('lang.active')}}&nbsp;&nbsp;
                            <input type="radio"  name="status" value="0" >&nbsp;&nbsp;{{Lang::get('lang.inactive')}}   -->
                            {!! Form::radio('status','1',true) !!}&nbsp;&nbsp;{{Lang::get('lang.active')}}&nbsp;&nbsp;
                            {!! Form::radio('status','0') !!}&nbsp;&nbsp;{{Lang::get('lang.inactive')}}
                    </div>       
                </div>

                <!-- Show radio: required: public|private -->
                <div class="col-md-3">
                    <div class="form-group {{ $errors->has('ispublic') ? 'has-error' : '' }}">
                        {!! Form::label('ispublic',Lang::get('lang.visibility')) !!}&nbsp;<span class="text-red"> *</span>
<!--                        <input type="radio"  name="ispublic" value="1" checked>&nbsp;&nbsp;{{Lang::get('lang.public')}}&nbsp;&nbsp;
                            <input type="radio"  name="ispublic" value="0" >&nbsp;&nbsp;{{Lang::get('lang.private')}} -->
                            {!! Form::radio('ispublic','1',true) !!}&nbsp;&nbsp; {{Lang::get('lang.public')}}&nbsp;&nbsp;
                            {!! Form::radio('ispublic','0') !!}&nbsp;&nbsp; {{Lang::get('lang.private')}}
                      
                    </div>       
                </div>
            </div>  
            <!-- Admin Note  : Textarea :  -->
            <div class="row hide">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('admin_note',Lang::get('lang.admin_notes')) !!}
                        {!! Form::textarea('admin_note',null,['class' => 'form-control','size' => '30x5','id'=>'ckeditor']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
<!--            {!! Form::submit(Lang::get('lang.create'),['class'=>'btn btn-primary'])!!}-->
<!--            {!!Form::button('<i class="fa fa-floppy-o" aria-hidden="true">&nbsp;&nbsp;</i>'.Lang::get('lang.save'),['type' => 'submit', 'class' =>'btn btn-primary'])!!}-->
                 <button type="submit" id="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'>&nbsp;</i> Saving..."><i class="fa fa-floppy-o">&nbsp;&nbsp;</i>{!!Lang::get('lang.save')!!}</button>
        </div>
    </div>
    

    <!-- close form -->
    {!! Form::close() !!}
    @stop