@extends('themes.default1.admin.layout.admin')

@section('Emails')
class="nav-link active"
@stop

@section('email-menu-parent')
class="nav-item menu-open"
@stop

@section('email-menu-open')
class="nav nav-treeview menu-open"
@stop

@section('template')
class="nav-link active"
@stop

@section('PageHeader')
<h1>{!! Lang::get('lang.templates') !!}</h1>
@stop

@section('content')
{!! Form::model($template,['url'=>'templates/'.$template->id,'method'=>'patch']) !!}
@if (count($errors) > 0)
<div class="alert alert-danger">
    <i class="fa fa-ban"></i>  
    <strong>{!! Lang::get('lang.alert') !!} !</strong>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <i class="fa fa-check-circle"></i>  
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('success')}}
</div>
@endif
<!-- fail lang -->
@if(Session::has('fails'))
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <b>{{Lang::get('lang.alert')}}!</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('fails')}}
</div>
@endif
<div class="card card-light">
    <div class="card-header">

        <h3 class="card-title">{{Lang::get('lang.edit_template')}}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <!-- first name -->
                <p class="lead mb-0">{!! $template->name !!}</p>
            </div>
            <div class="col-md-4 form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                <!-- last name -->
                {!! Form::label('type',Lang::get('lang.template-types'),['class'=>'required']) !!}<span style="color:red;">*</span>
                {!! Form::select('type',[''=>'Select','Type'=>$type],null,['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 form-group {{ $errors->has('subject') ? 'has-error' : '' }}">
                {!! Form::label('subject',Lang::get('lang.subject')) !!}
                {!! Form::text('subject',null,['class' => 'form-control', 'id' =>'subject']) !!}
            </div>
            <div class="col-md-3 form-group" id = "use-subject" style="margin-top: 15px;">
                <br/>
                {!! Form::hidden('variable','0') !!}
                {!! Form::checkbox('variable','1') !!}
                {!! Form::label('subject',Lang::get('lang.use_subject')) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                {!! Form::label('message',Lang::get('lang.content'),['class'=>'required']) !!}<span style="color:red;">*</span>
                {!! Form::textarea('message',null,['class'=>'form-control','id'=>'textarea']) !!}
            </div>
        </div>
    </div>
    <div class="card-footer">
        {!! Form::submit(Lang::get('lang.update'),['class'=>'btn btn-primary'])!!}
    </div>
</div>
{!! Form::close() !!}

<script>
    $(document).ready(function() {
        $("#subject").keyup(function() {
            var subject = document.getElementById('subject').value;
            if (subject) {
                $("#use-subject").show();
            } else {
                $("#use-subject").hide();
            }
        });
    });
</script>
@stop