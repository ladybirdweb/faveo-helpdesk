@extends('themes.default1.admin.layout.admin')
@section('PageHeader')
<h1>{!! Lang::get('lang.edit_template') !!}</h1>
@stop
@section('content')
<div class="box box-primary">

    <div class="content-header">
        {!! Form::model($template,['url'=>'templates/'.$template->id,'method'=>'patch']) !!}
        <h4>{{Lang::get('lang.template')}}	{!! Form::submit(Lang::get('lang.save'),['class'=>'form-group btn btn-primary pull-right'])!!}</h4>

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

                    <div class="col-md-4 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <!-- first name -->
                        {!! Form::label('name',Lang::get('lang.name'),['class'=>'required']) !!}<span style="color:red;">*</span>
                        <!--{!! $errors->first('name', '<spam class="help-block">:message</spam>') !!}-->
                        {!! Form::text('name',null,['class' => 'form-control']) !!}

                    </div>

                    <div class="col-md-4 form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                        <!-- last name -->
                        {!! Form::label('type',Lang::get('lang.template-types'),['class'=>'required']) !!}<span style="color:red;">*</span>
                            <!--{!! $errors->first('type', '<spam class="help-block">:message</spam>') !!}-->
                        {!! Form::select('type',[''=>'Select','Type'=>$type],null,['class' => 'form-control']) !!}

                    </div>

                </div>
         <div class="row">
                    <div class="col-md-12 form-group {{ $errors->has('subject') ? 'has-error' : '' }}">
         
                        {!! Form::label('subject',Lang::get('lang.subject')) !!}<span style="color:red;">*</span>
                            <!--{!! $errors->first('subject', '<spam class="help-block">:message</spam>') !!}-->
                        {!! Form::text('subject',null,['class' => 'form-control']) !!}

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                        
                        {!! Form::label('message',Lang::get('lang.content'),['class'=>'required']) !!}<span style="color:red;">*</span>
                            <!--{!! $errors->first('message', '<spam class="help-block">:message</spam>') !!}-->
                        {!! Form::textarea('message',null,['class'=>'form-control','id'=>'textarea']) !!}
                       
                    </div>


                </div>

            </div>

        </div>

    </div>

</div>


{!! Form::close() !!}
@stop