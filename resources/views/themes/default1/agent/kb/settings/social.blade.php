@extends('themes.default1.agent.layout.agent')
@extends('themes.default1.agent.layout.sidebar')    

@section('widget')
    active
@stop
@section('social')
    class="active"
@stop
@section('content')
<!-- open a form -->

	{!! Form::model($social,['url' => 'postsocial', 'method' => 'PATCH','files'=>true]) !!}

<!-- <div class="form-group {{ $errors->has('company_name') ? 'has-error' : '' }}"> -->
	<!-- table  -->

<div class="row">
<div class="col-md-12">
<div class="box box-primary">
	<div class="box-header">
        <h3 class="box-title">{{Lang::get('lang.social')}}</h3>  {!! Form::submit(Lang::get('lang.save'),['class'=>'form-group btn btn-primary pull-right'])!!}
    </div>

    <!-- check whether success or not -->

    @if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <i class="fa  fa-check-circle"></i>
        <b>Success</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('success')}}
    </div>
    @endif
    <!-- failure message -->
    @if(Session::has('fails'))
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <b>Fail!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('fails')}}
    </div>
    @endif

		<!-- Name text form Required -->
 		<div class="box-body table-responsive"style="overflow:hidden;">

            <div class="row">

                <div class=" col-xs-4 form-group {{ $errors->has('google') ? 'has-error' : '' }}">

                    {!! Form::label('google','google') !!}
                    {!! $errors->first('google', '<spam class="help-block">:message</spam>') !!}
			        {!! Form::text('google',null,['class' => 'form-control']) !!}

                </div>

                <div class=" col-xs-4 form-group {{ $errors->has('twitter') ? 'has-error' : '' }}">

                    {!! Form::label('twitter','twitter') !!}
                    {!! $errors->first('twitter', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('twitter',null,['class' => 'form-control']) !!}

                </div>

                <div class=" col-xs-4 form-group {{ $errors->has('facebook') ? 'has-error' : '' }}">

                    {!! Form::label('facebook','facebook') !!}
                    {!! $errors->first('facebook', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('facebook',null,['class' => 'form-control']) !!}

                </div>

        </div>

        <div class="row">

                <div class=" col-xs-4 form-group {{ $errors->has('linkedin') ? 'has-error' : '' }}">

                    {!! Form::label('linkedin','linkedin') !!}
                    {!! $errors->first('linkedin', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('linkedin',null,['class' => 'form-control']) !!}

                </div>

                <div class=" col-xs-4 form-group {{ $errors->has('stumble') ? 'has-error' : '' }}">

                    {!! Form::label('stumble','stumble') !!}
                    {!! $errors->first('stumble', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('stumble',null,['class' => 'form-control']) !!}

                </div>

                <div class=" col-xs-4 form-group {{ $errors->has('deviantart') ? 'has-error' : '' }}">

                    {!! Form::label('deviantart','deviantart') !!}
                    {!! $errors->first('deviantart', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('deviantart',null,['class' => 'form-control']) !!}

                </div>

        </div>

        <div class="row">

                <div class=" col-xs-4 form-group {{ $errors->has('flickr') ? 'has-error' : '' }}">

                    {!! Form::label('flickr','flickr') !!}
                    {!! $errors->first('flickr', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('flickr',null,['class' => 'form-control']) !!}

                </div>

                <div class=" col-xs-4 form-group {{ $errors->has('skype') ? 'has-error' : '' }}">

                    {!! Form::label('skype','skype') !!}
                    {!! $errors->first('skype', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('skype',null,['class' => 'form-control']) !!}

                </div>

                <div class=" col-xs-4 form-group {{ $errors->has('rss') ? 'has-error' : '' }}">

                    {!! Form::label('rss','rss') !!}
                    {!! $errors->first('rss', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('rss',null,['class' => 'form-control']) !!}

                </div>

        </div>

         <div class="row">

                <div class=" col-xs-4 form-group {{ $errors->has('youtube') ? 'has-error' : '' }}">

                    {!! Form::label('youtube','youtube') !!}
                    {!! $errors->first('youtube', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('youtube',null,['class' => 'form-control']) !!}

                </div>

                <div class=" col-xs-4 form-group {{ $errors->has('vimeo') ? 'has-error' : '' }}">

                    {!! Form::label('vimeo','vimeo') !!}
                    {!! $errors->first('vimeo', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('vimeo',null,['class' => 'form-control']) !!}

                </div>

                <div class=" col-xs-4 form-group {{ $errors->has('pinterest') ? 'has-error' : '' }}">

                    {!! Form::label('pinterest','pinterest') !!}
                    {!! $errors->first('pinterest', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('pinterest',null,['class' => 'form-control']) !!}

                </div>

        </div>

        <div class="row">

                <div class=" col-xs-6 form-group {{ $errors->has('dribbble') ? 'has-error' : '' }}">

                    {!! Form::label('dribbble','dribbble') !!}
                    {!! $errors->first('dribbble', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('dribbble',null,['class' => 'form-control']) !!}

                </div>

                <div class=" col-xs-6 form-group {{ $errors->has('instagram') ? 'has-error' : '' }}">

                    {!! Form::label('instagram','instagram') !!}
                    {!! $errors->first('instagram', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('instagram',null,['class' => 'form-control']) !!}

                </div>


        </div>

</div>
</div>
</div></div>
@stop
