@extends('themes.default1.agent.layout.agent')

@extends('themes.default1.agent.layout.sidebar')    

@section('pages')
active
@stop

@section('add-pages')
class="active"
@stop

@section('PageHeader')
<h1>{{Lang::get('lang.pages')}}</h1>
@stop

@section('content')
{!! Form::open(array('action' => 'Agent\kb\PageController@store' , 'method' => 'post') )!!}
<div class="box-body">
    <div class="row">
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
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">  
                    <h3 class="box-title">{!! Lang::get('lang.addpages') !!}</h3>
                </div>
                <div class="box-body"> 
                    <div class="row">
                        <div class="col-md-6 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('name',Lang::get('lang.name')) !!}<span class="text-red"> *</span>

                            {!! Form::text('name',null,['class' => 'form-control']) !!}
                        </div>
                        
                    </div>
                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                        {!! Form::label('description',Lang::get('lang.description')) !!}

                        <div class="form-group" style="background-color:white">
                            {!! Form::textarea('description',null,['class' => 'form-control color','size' => '110x15','id'=>'myNicEditor','placeholder'=>Lang::get('lang.enter_the_description')]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">{{Lang::get('lang.publish')}}</h3>
                </div>
                <div class="box-body">
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                        {!! Form::label('status',Lang::get('lang.status')) !!}

                        <div class="row">
                            <div class="col-xs-5">
                                {!! Form::radio('status','1',true) !!} {{ Lang::get('lang.published') }}
                            </div>
                            <div class="col-xs-5">
                                {!! Form::radio('status','0',null) !!} {{ Lang::get('lang.draft') }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('visibility') ? 'has-error' : '' }}">
                        {!! Form::label('visibility',Lang::get('lang.visibility')) !!}

                        <div class="row">
                            <div class="col-xs-5">
                                {!! Form::radio('visibility','1',true) !!} {{Lang::get('lang.public')}}
                            </div>
                            <div class="row">
                                <div class="col-xs-5">
                                    {!! Form::radio('visibility','0',null) !!} {{Lang::get('lang.private')}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer" style="background-color:#F7F7F7;">
                    <!--<div style="margin-left:140px;">-->
                    {!! Form::submit(Lang::get('lang.publish'),['class'=>'btn btn-primary'])!!}
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
</script>

<script>
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