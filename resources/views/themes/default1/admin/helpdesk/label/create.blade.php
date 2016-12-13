@extends('themes.default1.admin.layout.admin')

@section('Tickets')
active
@stop

@section('manage-bar')
active
@stop

@section('labels')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>Labels</h1>
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

@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <i class="fa fa-check-circle"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('success')}}
</div>
@endif
@if(Session::has('fails'))
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('fails')}}
</div>
@endif
 @if(Session::has('errors'))
        <br><br>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @if($errors->first('title'))
            <li class="error-message-padding">{!! $errors->first('title', ':message') !!}</li>
            @endif
            @if($errors->first('color'))
            <li class="error-message-padding">{!! $errors->first('color', ':message') !!}</li>
            @endif
            @if($errors->first('order'))
            <li class="error-message-padding">{!! $errors->first('order', ':message') !!}</li>
            @endif
        </div>
        @endif
@if(Session::has('warn'))
<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('warn')}}
</div>
@endif
<div class="box">
      <link rel="stylesheet" href="{{asset('lb-faveo/plugins/colorpicker/bootstrap-colorpicker.min.css')}}">
    <div class="box-header">
        <div class="box-title">
            New Label
        </div>
        {!! Form::open(['url'=>'labels','method'=>'post', 'id' => 'label-form']) !!}
    </div>
    <div class="box-body">
        <table class="table table-borderless">
            
            <tr>
                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                <td>{!! Form::label('title','Title') !!}<span class="text-red"> *</span></td>
                <td>
                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        {!! Form::text('title',null,['class'=>'form-control']) !!}
                    </div>
                </td>
                </div>
            </tr>
             <tr>
                <td>{!! Form::label('color','Color') !!}<span class="text-red"> *</span></td>
                <td>
                    <div class="form-group {{ $errors->has('color') ? 'has-error' : '' }}">
                    {!! Form::text('color', null,['class'=>'form-control my-colorpicker1 colorpicker-element']) !!}
                    </div>
                </td>
            </tr>
            
             <tr>
                <td>{!! Form::label('order','Order') !!}<span class="text-red"> *</span></td>
                <td>
                    <div class="form-group {{ $errors->has('order') ? 'has-error' : '' }}">
                    {!! Form::input('number', 'order', null, array('class' => 'form-control')) !!}
                    </div>
                </td>
            </tr>
            
             <tr>
                <td>{!! Form::label('status','Status') !!}</td>
                <td><input type="checkbox" name="status" id="status" checked="true">&nbsp;&nbsp;{{Lang::get('lang.enable')}}</td>
            </tr>
            
        </table>
    </div>
    <div class="box-footer">
        {!! Form::submit('Save',['class'=>'btn btn-success']) !!}
        {!! Form::close() !!}
    </div>
</div>
@stop
@section('FooterInclude')
<script src="{{asset('lb-faveo/plugins/colorpicker/bootstrap-colorpicker.min.js')}}"></script>
<script>
//Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();
</script>
<script type="text/javascript">
    $("#label-form").on('submit', function(e){
        if(document.getElementById('status').checked) {
            checked = 1;
        } else {
            checked = 0;
        }
        $('<input />')
          .attr('type', 'hidden')
          .attr('name', "status")
          .attr('value', checked)
          .appendTo('#label-form');
    })
</script>
@stop