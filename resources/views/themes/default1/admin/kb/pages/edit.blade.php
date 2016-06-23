@extends('themes.default1.admin.layout.kb')

@section('pages')
    active
@stop
@section('all-pages')
    class="active"
@stop
<script type="text/javascript" src="{{asset('dist/js/EditnicEdit.js')}}"></script>
<script type="text/javascript">
    bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>

@section('content')

	{!! Form::model($page,['url' => 'page/'.$page->slug, 'method' => 'PATCH','files'=>true]) !!}

<!-- <div class="form-group {{ $errors->has('company_name') ? 'has-error' : '' }}"> -->
	<!-- table  -->

<div class="box-body">

    <div class="row">

    <div class="col-md-9">

    <div class="row">
        <div class="col-md-6 form-group {{ $errors->has('name') ? 'has-error' : '' }}">

            {!! Form::label('name',Lang::get('lang.name')) !!}
            {!! $errors->first('name', '<spam class="help-block">:message</spam>') !!}
            {!! Form::text('name',null,['class' => 'form-control']) !!}

        </div>

        <div class="col-md-6 form-group {{ $errors->has('slug') ? 'has-error' : '' }}">

            {!! Form::label('slug',Lang::get('lang.slug')) !!}
            {!! $errors->first('slug', '<spam class="help-block">:message</spam>') !!}
            {!! Form::text('slug',null,['class' => 'form-control']) !!}

        </div>
    </div>
                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                    {!! Form::label('description',Lang::get('lang.description')) !!}
                    {!! $errors->first('description', '<spam class="help-block">:message</spam>') !!}

                    <div class="form-group" style="background-color:white">
                    {!! Form::textarea('description',null,['class' => 'form-control color','size' => '110x15','id'=>'myNicEditor','placeholder'=>'Enter the description']) !!}
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
                        {!! $errors->first('status', '<spam class="help-block">:message</spam>') !!}
                        <div class="row">
                            <div class="col-xs-4">
                                {!! Form::radio('status',1,true) !!}{{Lang::get('lang.published')}}
                            </div>
                            <div class="col-xs-3">
                                {!! Form::radio('status',0,null) !!}{{Lang::get('lang.draft')}}
                            </div>
                        </div>
                    </div>


                    <div class="form-group {{ $errors->has('visibility') ? 'has-error' : '' }}">

                        {!! Form::label('visibility',Lang::get('lang.visibility')) !!}
                        {!! $errors->first('visibility', '<spam class="help-block">:message</spam>') !!}
                        <div class="row">
                            <div class="col-xs-3">
                                {!! Form::radio('visibility','1',true) !!}{{Lang::get('lang.public')}}
                                </div>
                                <div class="row">
                            <div class="col-xs-3">
                                {!! Form::radio('visibility','0',null) !!}{{Lang::get('lang.private')}}
                                </div>
                    </div>

                </div>

            </div>
       </div>

        <div class="box-footer" style="background-color:#f5f5f5;">
        <div style="margin-left:140px;">

                {!! Form::submit(Lang::get('lang.publish'),['class'=>'btn btn-primary'])!!}
        </div>

        </div>

    </div>
</div>
</div>
</div>
@stop
@section('FooterInclude')

@stop

<!-- /content -->
