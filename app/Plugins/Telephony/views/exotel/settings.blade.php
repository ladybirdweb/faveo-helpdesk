@extends('themes.default1.admin.layout.admin')
@section('content')

<section class="content-heading-anchor">
    <h1>
        {{Lang::get('telephone::lang.telephone-integration')}}  


    </h1>

</section>


<!-- Main content -->

<div class="box box-primary">
    <div class="box-header with-border">
        <h4>  {{ucfirst($name)}}   </h4>
        <!-- /.box-header -->
        <!-- form start -->
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
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Your exotel information Pass Through url : <pre>{{url('telephone/exotel/pass') }}</pre>
        </div>
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        @endif
        <!-- fail message -->
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif
        {!! Form::open(['url'=>'telephone/'.$short,'method'=>'post']) !!}
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group{{ $errors->has('sid') ? 'has-error' : '' }}">
                    <label for="sid" class="control-label">SID</label>
                    {!! Form::text('sid',$details->getValue($short,'sid'),['class'=>'form-control']) !!}
                </div>
                <div class="form-group{{ $errors->has('token') ? 'has-error' : '' }}">
                    <label for="token" class="control-label">Token</label>
                    {!! Form::text('token',$details->getValue($short,'token'),['class'=>'form-control']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit(Lang::get('telephone::lang.save'),['class'=>'btn btn-success']) !!}
        {!! Form::close() !!}
    </div>
</div>

@stop
