@extends('themes.default1.admin.layout.admin')

@section('Plugins')
active
@stop

@section('settings-bar')
active
@stop

@section('plugin')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{!! Lang::get('lang.plugins') !!}</h1>
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
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.plugins-list') !!}</h3>
        <button type="button" class="btn btn-primary pull-right" id="Edit_Ticket" data-toggle="modal" data-target="#Edit"><b>{!! Lang::get('lang.add_plugin') !!}</b></button>        
        <div class="modal fade" id="Edit">
            <div class="modal-dialog">
                <div class="modal-content">  
                    <div class="modal-header">
                        <h4 class="modal-title">{!! Lang::get('lang.add_plugin') !!}</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['url'=>'post-plugin','files'=>true]) !!}
                        <label>{!! Lang::get('lang.plugin') !!} :</label> 
                        <div class="btn bg-olive btn-file" style="color:blue">
                            {!! Lang::get('lang.upload_file') !!}<input type="file" name="plugin">
                        </div>
                    </div><!-- /.modal-content -->   
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis">{!! Lang::get('lang.close') !!}</button>
                        <input type="submit" class="btn btn-primary pull-right" value="{!! Lang::get('lang.upload') !!}">
                    </div>
                    {!! Form::close() !!}
                </div>
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
    <div class="box-body">
        @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b><br/>
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
            {!!Session::get('success')!!}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!!Session::get('fails')!!}
        </div>
        @endif
        @if($info == 1)
        <div class="alert alert-info alert-dismissable">
            <i class="fa fa-info-circle"></i>
            <b></b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Lang::get('lang.plugin-info')}}
            <ul><li><a href="http://www.faveohelpdesk.com/plugins/" target="_blank">{{Lang::get('lang.click-here')}}</a>{{Lang::get('lang.plugin-info-pro')}}</li></ul>
        </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <script src="{{asset('lb-faveo/plugins/jQuery/jQuery-2.1.4.min.js')}}" type="text/javascript"></script>
                <script type="text/javascript" src="{{asset('lb-faveo/plugins/datatables/jquery.dataTables.js')}}"></script>
                <script type="text/javascript" src="{{asset('lb-faveo/plugins/datatables/dataTables.bootstrap.js')}}"></script>

                {!! Datatable::table()
                ->addColumn('Name','Description','Author','Website','Version')       // these are the column headings to be shown
                ->setUrl('getplugin')   // this is the route where data will be retrieved
                ->render() !!}
            </div>
        </div>
    </div>
</div>
@stop
