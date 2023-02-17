@extends('themes.default1.agent.layout.agent')

@extends('themes.default1.agent.layout.sidebar')    

@section('Tools')
class="nav-link active"
@stop

@section('tool')
class="active"
@stop

@section('kb')
class="nav-link active"
@stop

@section('add-pages')
class="nav-link active"
@stop

@section('pages')
class="nav-link active"
@stop

@section('page-menu-open')
class="nav nav-treeview menu-open"
@stop

@section('page-menu-parent')
class="nav-item menu-open"
@stop

@section('PageHeader')
<h1>{{Lang::get('lang.pages')}}</h1>
@stop

@section('content')

{!! Form::open(array('route' => 'page.store' , 'method' => 'post') )!!}

@if(Session::has('errors'))
<?php //dd($errors); ?>
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <b>{!! Lang::get('lang.alert') !!}!</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <br/>
    @if($errors->first('name'))
    <li class="error-message-padding">{!! $errors->first('name', ':message') !!}</li>
    @endif
    @if($errors->first('slug'))
    <li class="error-message-padding">{!! $errors->first('slug', ':message') !!}</li>
    @endif
    @if($errors->first('description'))
    <li class="error-message-padding">{!! $errors->first('description', ':message') !!}</li>
    @endif
    @if($errors->first('status'))
    <li class="error-message-padding">{!! $errors->first('status', ':message') !!}</li>
    @endif
    @if($errors->first('visibility'))
    <li class="error-message-padding">{!! $errors->first('visibility', ':message') !!}</li>
    @endif
</div>
@endif

<div class="row">
    
    <div class="col-sm-9">
        
        <div class="card card-light">

            <div class="card-header">  
                <h3 class="card-title">{!! Lang::get('lang.addpages') !!}</h3>
            </div>

            <div class="card-body"> 
                <div class="row">
                    <div class="col-md-6 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('name',Lang::get('lang.name')) !!}<span class="text-red"> *</span>

                        {!! Form::text('name',null,['class' => 'form-control']) !!}
                    </div>
                    
                    <div class="form-group col-sm-12 {{ $errors->has('description') ? 'has-error' : '' }}">
                        {!! Form::label('description',Lang::get('lang.description')) !!}

                        <div class="form-group" style="background-color:white">
                            {!! Form::textarea('description',null,['class' => 'form-control color','size' => '110x15','id'=>'myNicEditor','placeholder'=>Lang::get('lang.enter_the_description')]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  

    <div class="col-sm-3">
        
        <div class="card card-light">
            
            <div class="card-header">
                <h3 class="card-title">{{Lang::get('lang.publish')}}</h3>
            </div>
            
            <div class="card-body">
                <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                    {!! Form::label('status',Lang::get('lang.status')) !!}
                    <div class="row">
                        <div class="col-sm-5">
                            {!! Form::radio('status','1',true) !!} {{ Lang::get('lang.published') }}
                        </div>
                        <div class="col-sm-5">
                            {!! Form::radio('status','0',null) !!} {{ Lang::get('lang.draft') }}
                        </div>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('visibility') ? 'has-error' : '' }}">
                    {!! Form::label('visibility',Lang::get('lang.visibility')) !!}
                    <div class="row">
                        <div class="col-sm-5">
                            {!! Form::radio('visibility','1',true) !!} {{Lang::get('lang.public')}}
                        </div>
                        <div class="col-sm-5">
                            {!! Form::radio('visibility','0',null) !!} {{Lang::get('lang.private')}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                {!! Form::submit(Lang::get('lang.publish'),['class'=>'btn btn-primary'])!!}
            </div>
        </div>
    </div>    
</div>
<script type="text/javascript">
    $(function() {
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