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
 <!-- <a href="{{route('ticket.type.edit1', $tk_type->id)}}"><button type="button"  href=" -->
<form action="{{route('ticket.type.edit1', $tk_type->id)}}" method="post" role="form" id="Form">
{{ csrf_field() }}
    <input type="hidden" name="tk_type_id" value="{{$tk_type->id}}">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h2 class="box-title">{{Lang::get('lang.edit_ticket_type')}}</h2>
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
               @if($errors->first('status'))
                <li class="error-message-padding">{!! $errors->first('status', ':message') !!}</li>
                @endif

            </div>
            @endif
            <!-- Name text form Required -->
            <div class="box-body table-responsive no-padding"style="overflow:hidden;">
            <!-- <table class="table table-hover" style="overflow:hidden;"> -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('name',Lang::get('lang.name')) !!}<span class="text-red"> *</span>
                            <input type="text" class="form-control" name="name" value="{{ ($tk_type->name) }}" >
                        </div>
                    </div>
                    <!-- Grace Period text form Required -->
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('type_desc') ? 'has-error' : '' }}">
                            {!! Form::label('type_desc',Lang::get('lang.type_desc')) !!} <span class="text-red"> *</span>
                            <input type="text" class="form-control" name="type_desc" value="{{ ($tk_type->type_desc) }}">
                        </div>
                    </div></div>
                <!-- Priority Color -->
                <div class="row">
                 
                    <!-- status radio: required: Active|Dissable -->

                      @if($tk_type->is_default == $tk_type->id)
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                            {!! Form::label('status',Lang::get('lang.status')) !!}<span class="text-red"> *</span>&nbsp;&nbsp;
                            <input type="radio"  name="status" value="1" {{$tk_type->status == '1' ? 'checked' : ''}}>&nbsp;&nbsp;{{Lang::get('lang.active')}}&nbsp;&nbsp;
                            <!-- <input type="radio"  name="status"  value="0" {{$tk_type->status == '0' ? 'checked' : ''}}>&nbsp;&nbsp;{{Lang::get('lang.inactive')}} -->
                        </div>
                    </div>
                    @else
                     <div class="col-md-3">
                        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                            {!! Form::label('status',Lang::get('lang.status')) !!}<span class="text-red"> *</span>&nbsp;&nbsp;
                            <input type="radio"  name="status" value="1" {{$tk_type->status == '1' ? 'checked' : ''}}>&nbsp;&nbsp;{{Lang::get('lang.active')}}&nbsp;&nbsp;
                            <input type="radio"  name="status"  value="0" {{$tk_type->status == '0' ? 'checked' : ''}}>&nbsp;&nbsp;{{Lang::get('lang.inactive')}}
                        </div>
                    </div>
                    @endif
                    <!-- Show radio: required: public|private -->
                    <div class="col-md-3">
                    @if($tk_type->is_default == $tk_type->id)
                    <div class="form-group {{ $errors->has('ispublic') ? 'has-error' : '' }}">
                            {!! Form::label('visibility',Lang::get('lang.visibility')) !!}&nbsp;<span class="text-red"> *</span>&nbsp;&nbsp;&nbsp;
                            <input type="radio"  name="ispublic" value="1" {{$tk_type->ispublic == '1' ? 'checked' : ''}} >&nbsp;&nbsp;{{Lang::get('lang.public')}}&nbsp;&nbsp;
                            
                        </div>     
                     @else
                     <div class="form-group {{ $errors->has('ispublic') ? 'has-error' : '' }}">
                            {!! Form::label('visibility',Lang::get('lang.visibility')) !!}&nbsp;<span class="text-red"> *</span>&nbsp;&nbsp;&nbsp;
                            <input type="radio"  name="ispublic" value="1" {{$tk_type->ispublic == '1' ? 'checked' : ''}} >&nbsp;&nbsp;{{Lang::get('lang.public')}}&nbsp;&nbsp;
                            <input type="radio"  name="ispublic"  value="0" {{$tk_type->ispublic == '0' ? 'checked' : ''}}>&nbsp;&nbsp;{{Lang::get('lang.private')}}
                        </div>     
                      @endif

                          
                    </div>
                </div>  
                <!-- Admin Note : Textarea : -->
                <div class="row hide">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('admin_note',Lang::get('lang.admin_notes')) !!}
                            {!! Form::textarea('admin_note',null,['class' => 'form-control','size' => '30x5','id'=>'ckeditor']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="form-group">
                <input type="checkbox" name="default_ticket_type" @if($tk_type->is_default == $tk_type->id) checked disabled @endif> {{ Lang::get('lang.make-default-type')}}
            </div>
            <div class="form-group">
            </div>
<!--            {!! Form::submit(Lang::get('lang.update'),['class'=>'btn btn-primary'])!!}-->
<!--            {!!Form::button('<i class="fa fa-refresh" aria-hidden="true">&nbsp;&nbsp;</i>'.Lang::get('lang.update'),['type' => 'submit', 'class' =>'btn btn-primary'])!!}-->
                <button type="submit" id="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-refresh fa-spin fa-1x fa-fw'>&nbsp;</i> updating..."><i class="fa fa-refresh">&nbsp;&nbsp;</i>{!!Lang::get('lang.update')!!}</button>    
        </div>
    </div>
    <!-- close form -->
    {!! Form::close() !!}
   

    @stop
