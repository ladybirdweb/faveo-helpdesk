@extends('themes.default1.admin.layout.admin')

@section('Emails')
active
@stop

@section('emails-bar')
active
@stop

@section('queue')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{$queue->name}}</h1>
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')
<ol class="breadcrumb">
</ol>
@stop
<!-- /breadcrumbs -->
<!-- content -->
@section('content')
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
    <i class="fa fa-check-circle"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('success')}}
</div>
@endif
@if(Session::has('fails'))
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('fails')}}
</div>
@endif
@if(Session::has('warn'))
<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('warn')}}
</div>
@endif
<div class="box">
    <div class="box-header">
        <div class="box-title">
            {!! Lang::get('lang.queues') !!}
        </div>

    </div>
    <div class="box-body">
        {!! Form::open(['url'=>'queue/'.$queue->id,'method'=>'post','id'=>'form']) !!}
        <div id="response">

        </div>
        {!! Form::submit('save',['class'=>'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>

</div>
<script>

    $(document).ready(function () {
        var queueid = '{{$queue->id}}';
        $.ajax({
            url: "{{url('form/queue')}}",
            dataType: "html",
            data: {'queueid': queueid},
            success: function (response) {
                $("#response").html(response);
            },
            error: function (response) {
                $("#response").html(response);
            }
        });
    });
</script>
@stop