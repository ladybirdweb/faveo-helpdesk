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
<h1>{{Lang::get('lang.groups')}}</h1>
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
                <h2 class="box-title">{!! Lang::get('lang.list_of_groups') !!}</h2><a href="{{route('groups.create')}}" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-plus"></span> &nbsp;{{Lang::get('lang.create_group')}}</a></div>
            <div class="box-body">
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
                    <thead>
                    <tr>
                        <th>{{Lang::get('lang.group_name')}}</th>
                        <th>{{Lang::get('lang.status')}}</th>
                        <th>{{Lang::get('lang.action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($groups as $group)
                    <tr>
                        <td><a href="{{route('groups.edit', $group->id)}}"> {{$group -> name }}</a></td>
                        <td>
                            @if($group->group_status=='1')
                            <p class="btn btn-xs btn-success">{{Lang::get('lang.active')}}</p>
                            @else
                            <p class="btn btn-xs btn-danger">{{Lang::get('lang.inactive')}}</p>
                            @endif
                        <td>
                            {!! Form::open(['route'=>['groups.destroy', $group->id],'method'=>'DELETE']) !!}
                            <a href="{{route('groups.edit', $group->id)}}" class="btn btn-primary btn-xs "><i class="fa fa-edit" style="color:white;"> </i>&nbsp; Edit</a>&nbsp;
                            <!-- To pop up a confirm Message -->
                            {!! Form::button('<i class="fa fa-trash" style="color:white;"> </i> &nbsp;Delete',
                            ['type' => 'submit',
                            'class'=> 'btn btn-primary btn-xs ',
                            'onclick'=>'return confirm("Are you sure?")'])
                            !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
@section('FooterInclude')
<script type="text/javascript">
    $('.dataTable').DataTable({
        "columnDefs": [
            { "searchable": false, "targets": [2] },
        ]
    });
</script>
@stop