
@extends('themes.default1.agent.layout.agent')

@section('Tools')
class="nav-link active"
@stop

@section('tools-bar')
active
@stop

@section('tool')
class="active"
@stop

@section('tools')
class="nav-link active"
@stop

@section('PageHeader')
<h1>{{Lang::get('lang.canned_response')}}</h1>
@stop
<!-- content -->
@section('content')
<!-- open a form -->
{!! Form::model($canned, ['url' => 'canned/update/'.$canned->id,'method' => 'PATCH'] )!!}
@if(Session::has('errors'))
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fas fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
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
<!-- <section class="content"> -->
<div class="card card-light">
    <div class="card-header">
        <h3 class="card-title">{!! Lang::get('lang.edit') !!}</h3>
    </div>
    <div class="card-body">
        
        <div class="row">
            <!-- username -->
            <div class="col-sm-6 form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                {!! Form::label('title',Lang::get('lang.title')) !!}         <span class="text-red"> *</span>       
                {!! Form::text('title',null,['class' => 'form-control']) !!}
            </div>
            <!-- firstname -->
            <div class="col-sm-12 form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                {!! Form::label('message',Lang::get('lang.message')) !!}         <span class="text-red"> *</span>      
                {!! Form::textarea('message',null,['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="card-footer">
        {!! Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary'])!!}
    </div>
</div>
<script>
    $(function() {
        //Add text editor
        $("textarea").summernote({
            height: 300,
            tabsize: 2,
            toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
          ]
          });
    });
</script>
@stop
