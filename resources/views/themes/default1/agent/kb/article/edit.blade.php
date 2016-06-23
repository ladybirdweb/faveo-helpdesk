@extends('themes.default1.agent.layout.agent')

@extends('themes.default1.agent.layout.sidebar')    

@section('article')
active
@stop

@section('all-article')
class="active"
@stop

@section('PageHeader')
<h1>{{Lang::get('lang.article')}}</h1>
@stop

@section('content')
<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
{!! Form::model($article,['url' => 'article/'.$article->id , 'method' => 'PATCH'] )!!}
<div class="row">
    <div class="content-header">
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
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif
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
            @if($errors->first('type'))
            <li class="error-message-padding">{!! $errors->first('type', ':message') !!}</li>
            @endif
            @if($errors->first('status'))
            <li class="error-message-padding">{!! $errors->first('status', ':message') !!}</li>
            @endif
            @if($errors->first('category_id'))
            <li class="error-message-padding">{!! $errors->first('category_id', ':message') !!}</li>
            @endif
        </div>
        @endif
    </div>  
    <div class="col-md-8">
        <div class="box box-primary box-body">
            <div class="row">
                <div class="col-md-6 form-group {{ $errors->has('name') ? 'has-error' : '' }}" >
                    {!! Form::label('name',Lang::get('lang.name')) !!} <span class="text-red"> *</span>

                    {!! Form::text('name',null,['class' => 'form-control']) !!}
                </div>
                <div class="col-md-6 form-group {{ $errors->has('slug') ? 'has-error' : '' }}" >
                    {!! Form::label('slug',Lang::get('lang.slug')) !!} <span class="text-red"> *</span>

                    {!! Form::text('slug',null,['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                {!! Form::label('description',Lang::get('lang.description')) !!} <span class="text-red"> *</span>

                <div class="form-group" style="background-color:white">
                    {!! Form::textarea('description',$article->description,['class' => 'form-control','id'=>'editor','size' => '128x20','placeholder'=>Lang::get('lang.enter_the_description')]) !!}
                </div>
                <script>
CKEDITOR.replace('editor', {
    filebrowserImageBrowseUrl: '{{url("laravel-filemanager?type=Images")}}',
    filebrowserImageUploadUrl: '{{url("laravel-filemanager/upload?type=Images")}}',
    filebrowserBrowseUrl: '{{url("laravel-filemanager?type=Files")}}',
    filebrowserUploadUrl: '{{url("laravel-filemanager/upload?type=Files")}}'
});
                </script>
            </div>
        </div>
    </div>
    <ul style="list-style-type:none;">
        <li>
            <div class="col-md-4">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{Lang::get('lang.publish')}}</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                            {!! Form::label('type',Lang::get('lang.status')) !!}
                            <div class="row">
                                <div class="col-xs-1">
                                    {!! Form::radio('type','1',true) !!}
                                </div>
                                <div class="col-xs-4">
                                    {{Lang::get('lang.published')}}
                                </div>
                                <div class="col-xs-1">
                                    {!! Form::radio('type','0',null) !!}
                                </div>
                                <div class="col-xs-4">
                                    {{Lang::get('lang.draft')}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                            {!! Form::label('status',Lang::get('lang.visibility')) !!}
                            <div class="row">
                                <div class="col-xs-1">
                                    {!! Form::radio('status','1',true) !!}
                                </div>
                                <div class="col-xs-4">  
                                    {{Lang::get('lang.public')}}
                                </div>
                                <div class="row">
                                    <div class="col-xs-1">
                                        {!! Form::radio('status','0',null) !!}
                                    </div>
                                    <div class="col-xs-4"> 
                                        {{Lang::get('lang.private')}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $format = App\Model\helpdesk\Settings\System::where('id', '1')->first()->date_time_format;
                        $format = \App\Model\helpdesk\Utility\Date_time_format::where('id', $format)->first()->format;
                        $tz = App\Model\helpdesk\Settings\System::where('id', '1')->first()->time_zone;
                        $tz = App\Model\helpdesk\Utility\Timezones::where('id', $tz)->first()->name;
                        date_default_timezone_set($tz);
                        $date = date($format);
                        $dateparse = date_parse_from_format('Y-m-d H:i:s', $article->publish_time);
                        $month = $dateparse['month'];
                        $day = $dateparse['day'];
                        $year = $dateparse['year'];
                        $hour = $dateparse['hour'];
                        $minute = $dateparse['minute'];
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::label('month',Lang::get('lang.publish_immediately')) !!}
                            </div>
                            <div class="col-md-12">
                                <span>
                                    {!! Form::selectMonth('month', $month)  !!}
                                    {!! Form::selectRange('day', 1, 31, $day)  !!}
                                    {!! Form::text('year',$year,['style'=>'width: 50px;'])  !!}@
                                    <input type="text" name="hour" value="{{$hour}}" style="width: 30px;">:<input type="text" name="minute" value="{{$minute}}" style="width: 30px;" >
                                </span>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                    <div class="box-footer" style="background-color:#f5f5f5;">
                        {!! Form::submit(Lang::get('lang.publish'),['class'=>'btn btn-primary'])!!}
                    </div>
                    </li>
                    <li>
                        <div class="col-md-4">
                            <div class="box box-default">
                                <div class="box-header with-border">
                                    <h3 class="box-title">{{Lang::get('lang.category')}} <span class="text-red"> *</span></h3>
                                </div>
                                <div class="box-body" style="height:190px; overflow-y:auto;">
                                    <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                                        {{-- {!! Form::label('category_id','Category') !!} --}}
                                        @foreach($category->toArray() as $key=>$val)
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-1">
                                                    <input type="radio" name="category_id[]" value="<?php echo $val; ?>" <?php
                                                    if (in_array($val, $assign->all())) {
                                                        echo ('checked');
                                                    }
                                                    ?> ></div>
                                                <div class="col-md-10">
                                                    <?php echo $key; ?>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="box-footer" style="background-color:#f5f5f5;">
                                    <span class="btn btn-info btn-sm" data-toggle="modal" data-target="#j">{!! Lang::get('lang.addcategory') !!}</span>
                                    <div class="modal" id="j">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                {!! Form::open(['method'=>'post','action'=>'Agent\kb\CategoryController@store']) !!}
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title">{{Lang::get('lang.addcategory')}}</h4>
                                                </div>
                                                <div class="modal-body">
                                                    @include('themes.default1.agent.kb.category.form')
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="form-group">
                                                        {!! Form::submit(Lang::get('lang.add'))!!}
                                                    </div>
                                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{!! Lang::get('lang.close') !!}</button>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    </ul>
                    @stop
                    <!-- /content -->