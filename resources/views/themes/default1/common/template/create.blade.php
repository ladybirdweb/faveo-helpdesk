@extends('themes.default1.admin.layout.admin')
@section('content')
<div class="box box-primary">

    <div class="content-header">
        {!! Form::open(['route'=>'templates.store','method'=>'post']) !!}
        <h4>{{Lang::get('lang.templates')}}	{!! Form::submit(Lang::get('lang.save'),['class'=>'form-group btn btn-primary pull-right'])!!}</h4>

    </div>

    <div class="box-body">

        <div class="row">

            <div class="col-md-12">

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

                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <b>{{Lang::get('lang.alert')}}!</b> {{Lang::get('lang.success')}}.
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{Session::get('success')}}
                </div>
                @endif
                <!-- fail lang -->
                @if(Session::has('fails'))
                <div class="alert alert-danger alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <b>{{Lang::get('lang.alert')}}!</b> {{Lang::get('lang.failed')}}.
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{Session::get('fails')}}
                </div>
                @endif

                <div class="row">

                    <div class="col-md-6 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <!-- first name -->
                        {!! Form::label('name',Lang::get('lang.name'),['class'=>'required']) !!}
                        {!! Form::text('name',null,['class' => 'form-control']) !!}

                    </div>

                    <div class="col-md-6 form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                        <!-- last name -->
                        {!! Form::label('type',Lang::get('lang.template-types'),['class'=>'required']) !!}
                        {!! Form::select('type',[''=>'Select','Type'=>$type],null,['class' => 'form-control']) !!}

                    </div>
                                        

                </div>
<!--                <div class="row">
                    <div class="col-md-12 form-group {{ $errors->has('subject') ? 'has-error' : '' }}">
         
                        {!! Form::label('subject',Lang::get('lang.subject')) !!}
                        {!! Form::text('subject',null,['class' => 'form-control']) !!}

                    </div>
                </div>-->

                <div class="row">
                    <div class="col-md-12 form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                       
                        
                        {!! Form::label('message',Lang::get('lang.content'),['class'=>'required']) !!}
                        {!! Form::textarea('message',null,['class'=>'form-control','id'=>'textarea']) !!}
                       
                    </div>


                </div>

            </div>

        </div>

    </div>

</div>


{!! Form::close() !!}
@stop