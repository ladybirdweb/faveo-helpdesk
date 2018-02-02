@extends('themes.default1.admin.layout.admin')

@section('Staffs')
active
@stop

@section('staffs-bar')
active
@stop

@section('groups')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{trans('lang.staffs')}}</h1>
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
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h2 class="box-title">{!! trans('lang.groups') !!}</h2><a href="{{route('groups.create')}}" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-plus"></span> &nbsp;{{trans('lang.create_group')}}</a></div>
            <div class="box-body table-responsive">
                <!-- check whether success or not -->
                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissable">
                    <i class="fa  fa-check-circle"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {!! Session::get('success') !!}
                </div>
                @endif
                <!-- failure message -->
                @if(Session::has('fails'))
                <div class="alert alert-danger alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <b>Fail!</b>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {!! Session::get('fails') !!}
                </div>
                @endif
                <!-- Table -->
                <table class="table table-bordered dataTable" style="overflow:hidden;">
                    <tr>
                        <th>{{trans('lang.group_name')}}</th>
                        <th>{{trans('lang.status')}}</th>
                        <th>{{trans('lang.action')}}</th>
                    </tr>
                    @foreach($groups as $group)
                    <tr>
                        <td><a href="{{route('groups.edit', $group->id)}}"> {{$group -> name }}</a></td>
                        <td>
                            @if($group->group_status=='1')
                            <span style="color:green">{{'Active'}}</span>
                            @else
                            <span style="color:red">{{'Inactive'}}</span>
                            @endif
                        <td>
                            {!! Form::open(['route'=>['groups.destroy', $group->id],'method'=>'DELETE']) !!}
                            <a href="{{route('groups.edit', $group->id)}}" class="btn btn-info btn-xs btn-flat"><i class="fa fa-edit" style="color:black;"> </i> Edit</a>
                            <!-- To pop up a confirm Message -->
                            {!! Form::button('<i class="fa fa-trash" style="color:black;"> </i> Delete',
                            ['type' => 'submit',
                            'class'=> 'btn btn-warning btn-xs btn-flat',
                            'onclick'=>'return confirm("Are you sure?")'])
                            !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@stop