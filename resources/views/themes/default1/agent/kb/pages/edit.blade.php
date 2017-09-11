@extends('themes.default1.agent.layout.agent')
@extends('themes.default1.agent.layout.sidebar')    

@section('pages')
active
@stop
@section('all-pages')
class="active"
@stop

@section('PageHeader')
<h1>{{trans('lang.pages')}}</h1>
@stop

@section('content')
{!! Form::model($page,['url' => 'page/'.$page->slug, 'method' => 'PATCH','files'=>true]) !!}
<div class="box-body">
    <div class="row">
        @if(Session::has('errors'))
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! trans('lang.alert') !!}!</b>
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
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">  
                    <h3 class="box-title">{!! trans('lang.addpages') !!}</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('name',trans('lang.name')) !!}<span class="text-red"> *</span>

                            {!! Form::text('name',null,['class' => 'form-control']) !!}
                        </div>
                        
                    </div>
                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                        {!! Form::label('description',trans('lang.description')) !!}

                        <div class="form-group" style="background-color:white">
                            {!! Form::textarea('description',null,['class' => 'form-control color','size' => '110x15','id'=>'myNicEditor','placeholder'=>'Enter the description']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">{{trans('lang.publish')}}</h3>
                </div>
                <div class="box-body">
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                        {!! Form::label('status',trans('lang.status')) !!}

                        <div class="row">
                            <div class="col-xs-5">
                                {!! Form::radio('status',1,true) !!} {{trans('lang.published')}}
                            </div>
                            <div class="col-xs-5">
                                {!! Form::radio('status',0,null) !!} {{trans('lang.draft')}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('visibility') ? 'has-error' : '' }}">
                        {!! Form::label('visibility',trans('lang.visibility')) !!}

                        <div class="row">
                            <div class="col-xs-5">
                                {!! Form::radio('visibility','1',true) !!} {{trans('lang.public')}}
                            </div>
                            <div class="row">
                                <div class="col-xs-5">
                                    {!! Form::radio('visibility','0',null) !!} {{trans('lang.private')}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer" style="background-color:#f7f7f7;">
                    <!--<div style="margin-left:140px;">-->
                    {!! Form::submit(trans('lang.publish'),['class'=>'btn btn-primary'])!!}
                    <!--</div>-->
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $("textarea").wysihtml5();
    });
    
    $(function() {
        
        $('input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-blue'
        });
        $('input[type="radio"]').iCheck({
            radioClass: 'iradio_flat-blue'
        });
    
    }); 
</script>
@stop
