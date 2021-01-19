@extends('themes.default1.admin.layout.admin')

@section('Settings')
class="nav-link active"
@stop

@section('settings-menu-parent')
class="nav-item menu-open"
@stop

@section('settings-menu-open')
class="nav nav-treeview menu-open"
@stop

@section('storage')
class="nav-link active"
@stop

@section('PageHeader')
<h1>{{ Lang::get('storage::lang.storage')}}</h1>
@stop

@section('HeadInclude')
@stop
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
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('success')}}
</div>
@endif
<!-- fail message -->
@if(Session::has('fails'))
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <b>{{Lang::get('message.alert')}}!</b> {{Lang::get('message.failed')}}.
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('fails')}}
</div>
@endif

<div class="card card-light">

    <div class="card-header">
        <h3 class="card-title"> {{Lang::get('storage::lang.storage')}} </h3>
       
        {!! Form::open(['url'=>'storage','method'=>'post']) !!}
    </div><!-- /.box-header -->
    <!-- /.box-header -->
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-8 {{ $errors->has('default') ? 'has-error' : '' }}">
                {!! Form::label('default',Lang::get('storage::lang.default')) !!}
                {!! Form::select('default',['database'=>'Database','local'=>'Local'],$default,['class'=>'form-control']) !!}             
            </div>
            
            <div class="form-group col-md-6 {{ $errors->has('root') ? 'has-error' : '' }}" id="root" style="display: none;">
                {!! Form::label('root',Lang::get('storage::lang.root')) !!}
                {!! Form::select('root',$directories,$root,['class'=>'form-control']) !!}             
            </div>
            <div id="common" style="display: none;">
                <div class="form-group col-md-6 {{ $errors->has('key') ? 'has-error' : '' }}">
                    {!! Form::label('key',Lang::get('storage::lang.key')) !!}
                    {!! Form::text('key',null,['class'=>'form-control']) !!}             
                </div>
                <div class="form-group col-md-6 {{ $errors->has('region') ? 'has-error' : '' }}">
                    {!! Form::label('region',Lang::get('storage::lang.region')) !!}
                    {!! Form::text('region',null,['class'=>'form-control']) !!}             
                </div>
            </div>
            <div id="s3" style="display: none;">
                <div class="form-group col-md-6 {{ $errors->has('secret') ? 'has-error' : '' }}">
                    {!! Form::label('secret',Lang::get('storage::lang.secret')) !!}
                    {!! Form::text('secret',null,['class'=>'form-control']) !!}             
                </div>
                <div class="form-group col-md-6 {{ $errors->has('bucket') ? 'has-error' : '' }}">
                    {!! Form::label('bucket',Lang::get('storage::lang.bucket')) !!}
                    {!! Form::text('bucket',null,['class'=>'form-control']) !!}             
                </div>
            </div>
            <div id="rackspace" style="display: none;">
                <div class="form-group col-md-6 {{ $errors->has('username') ? 'has-error' : '' }}">
                    {!! Form::label('username',Lang::get('storage::lang.username')) !!}
                    {!! Form::text('username',null,['class'=>'form-control']) !!}             
                </div>
                <div class="form-group col-md-6 {{ $errors->has('container') ? 'has-error' : '' }}">
                    {!! Form::label('container',Lang::get('storage::lang.container')) !!}
                    {!! Form::text('container',null,['class'=>'form-control']) !!}             
                </div>
                <div class="form-group col-md-6 {{ $errors->has('endpoint') ? 'has-error' : '' }}">
                    {!! Form::label('endpoint',Lang::get('storage::lang.endpoint')) !!}
                    {!! Form::text('endpoint',null,['class'=>'form-control']) !!}             
                </div>
                <div class="form-group col-md-6 {{ $errors->has('url_type') ? 'has-error' : '' }}">
                    {!! Form::label('url_type',Lang::get('storage::lang.url_type')) !!}
                    {!! Form::text('url_type',null,['class'=>'form-control']) !!}             
                </div>
            </div>


        </div>
        <!-- /.box-body -->
    </div>
    <div class="card-footer">
        {!! Form::submit('Save',['class'=>'btn btn-success']) !!}
        {!! Form::close() !!}
    </div>
    <!-- /.box -->
</div>
@stop
@section('FooterInclude')
<script>
    $(document).ready(function () {
        var defaults = $("#default").val();
        switches(defaults);
        $("#default").on("change", function () {
            defaults = $("#default").val();
            switches(defaults);
        });
        function switches(defaults) {
            if(defaults=="local"){
                $("#common").hide();
                $("#s3").hide();
                $("#rackspace").hide();
                $("#root").show();
            }
            if(defaults=="s3"){
               $("#root").hide();
               $("#rackspace").hide();
               $("#common").show();
               $("#s3").show();
            }
            if(defaults=="rackspace"){
               $("#root").hide();
                $("#s3").hide();
               $("#common").show();
               $("#rackspace").show();
            }
            if(defaults=="database"){
               $("#root").hide();
                $("#s3").hide();
               $("#common").hide();
               $("#rackspace").hide();
            }
            
        }
    });
</script>
@stop