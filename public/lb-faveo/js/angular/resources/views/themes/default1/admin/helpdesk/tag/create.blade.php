@extends('themes.default1.admin.layout.admin')

@section('Tickets')
active
@stop

@section('manage-bar')
active
@stop

@section('tags')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{trans('lang.tags')}}</h1>
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
@if(Session::has('warn'))
<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('warn')}}
</div>
@endif
@if (count($errors) > 0)
<div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="box">
    <div class="box-header">
        <div class="box-title">
            {{trans('lang.tags')}}
        </div>
        {!! Form::open(['url'=>'tag','method'=>'post', 'id' => 'label-form']) !!}
    </div>
    <div class="box-body">
        <table class="table table-borderless">

            <tr>
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <td>{!! Form::label('name',trans('lang.name')) !!}<span class="text-red"> *</span></td>
                <td>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::text('name',null,['class'=>'form-control']) !!}
                    </div>
                </td>
            </div>
            </tr>
            <tr>
                <td>{!! Form::label('description',trans('lang.description')) !!}</td>
                <td>
                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                        {!! Form::textarea('description', null,['class'=>'form-control']) !!}
                    </div>
                </td>
            </tr>
            {{--
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
    <td><input type="checkbox" value="1" name="status" id="status" checked="true">&nbsp;&nbsp;{{Lang::get('lang.enable')}}</td>
</tr>
--}}
</table>
</div>
<div class="box-footer">
    {!! Form::submit(trans('lang.save'),['class'=>'btn btn-success']) !!}
    {!! Form::close() !!}
</div>
</div>
@stop