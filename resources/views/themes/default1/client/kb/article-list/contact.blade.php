@extends('themes.default1.client.layout.client')

@section('contact')
    class = "active"
@stop

@section('check')
<!-- Start of Page Container -->
<div style="padding-top: 60px;">

    @if($settings->address)
    <h2>Our Address</h2>
    {!! $settings->address !!}
    @endif
</div>
@stop
@section('content')
<div id="content" class="site-content col-md-9">
    <article class="type-page hentry clearfix">
        <h1 class="post-title">
            <a href="#">Contact us</a>
        </h1>
        <hr>
        <p></p>
    </article>
    {!! Form::open(['method'=>'post','action'=>'Client\kb\UserController@postContact']) !!}
    @if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <i class="fa  fa-check-circle"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('success')}}
    </div>
    @endif
    <!-- failure message -->
    @if(Session::has('fails'))
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('fails')}}
    </div>
    @endif

    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">

        {!! Form::label('name','Name') !!}
        {!! $errors->first('name', '<spam class="help-block">:message</spam>') !!}
        {!! Form::text('name',null,['class' => 'form-control']) !!}

    </div>

    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">

        {!! Form::label('email','Email') !!}
        {!! $errors->first('email', '<spam class="help-block">:message</spam>') !!}
        {!! Form::text('email',null,['class' => 'form-control']) !!}

    </div>

    <div class="form-group {{ $errors->has('subject') ? 'has-error' : '' }}">

        {!! Form::label('subject','Subject') !!}
        {!! $errors->first('subject', '<spam class="help-block">:message</spam>') !!}
        {!! Form::text('subject',null,['class' => 'form-control']) !!}

    </div>

    <div class="form-group {{ $errors->has('message') ? 'has-	error' : '' }}">
        {!! Form::label('message','Messege', ['style' => 'display: block']) !!}
        {!! $errors->first('message', '<spam class="help-block">:message</spam>') !!}
        {!! Form::textarea('message',null,['class' => 'form-control','size' => '30x7','id'=>'message']) !!}

    </div>
    <div>

        {!! Form::submit('Send Message',['class'=>'form-group btn btn-primary'])!!}

    </div>

    {!! Form::close() !!}


</div>

@stop