@extends('themes.default1.agent.layout.agent')

@section('Tools')
class="active"
@stop

@section('tools-bar')
active
@stop

@section('tools')
class="active"
@stop

@section('PageHeader')
<h1>{{trans('lang.canned_response')}}</h1>
@stop

<!-- content -->
@section('content')
<!-- open a form -->
{!! Form::open(['route'=>'canned.store','method' => 'patch']) !!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{!! trans('lang.create') !!} </h3>
    </div>
    <div class="box-body">
        @if(Session::has('errors'))
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! trans('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @if($errors->first('title'))
            <li class="error-message-padding">{!! $errors->first('title', ':message') !!}</li>
            @endif
            @if($errors->first('message'))
            <li class="error-message-padding">{!! $errors->first('message', ':message') !!}</li>
            @endif
        </div>
        @endif
        <div class="row">
            <!-- username -->
            <div class="col-xs-6 form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                {!! Form::label('title',trans('lang.title')) !!}    <span class="text-red"> *</span>
                {!! Form::text('title',null,['class' => 'form-control']) !!}
            </div>
            <!-- firstname -->
            <div class="col-xs-12 form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                {!! Form::label('message',trans('lang.message')) !!}<span class="text-red"> *</span>
                {!! Form::textarea('message',null,['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit(trans('lang.submit'),['class'=>'form-group btn btn-primary'])!!}
    </div>
</div>
<script>
    $(function() {
        //Add text editor
        $("textarea").wysihtml5();
    });
</script>
@stop
