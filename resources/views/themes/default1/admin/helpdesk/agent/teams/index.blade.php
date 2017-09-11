@extends('themes.default1.admin.layout.admin')

@section('Staffs')
active
@stop

@section('staffs-bar')
active
@stop

@section('teams')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{trans('lang.teams')}}</h1>
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
                <h2 class="box-title">{{trans('lang.list_of_teams')}}</h2><a href="{{route('teams.create')}}" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-plus"></span> &nbsp;{{trans('lang.create_team')}}</a></div>
            <div class="box-body table-responsive">
                <!-- check whether success or not -->
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
                    <b>Fail!</b>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{Session::get('fails')}}
                </div>
                @endif
                <table class="table table-bordered dataTable" style="overflow:hidden;">
                    <tr>
                        <th>{{trans('lang.name')}}</th>
                        <th>{{trans('lang.status')}}</th>
                        <th>{{trans('lang.team_members')}}</th>
                        <th>{{trans('lang.team_lead')}}</th>
                        <th>{{trans('lang.action')}}</th>
                    </tr>
                    @foreach($teams as $team)
                    <tr>
                        <td><a href="{{route('teams.show', $team->id)}}"> {{$team->name }}</a></td>
                        <td>
                            @if($team->status=='1')
                            <span style="color:green">{{trans('lang.active')}}</span>
                            @else
                            <span style="color:red">{{trans('lang.inactive')}}</span>
                            @endif
                            <?php
                            if ($team->team_lead == 0) {
                                $team_lead = "";
                            } else {
                                $users = App\User::whereId($team->team_lead)->first();
                                $team_lead = $users->full_name;
                            }
                            ?>
                        <td>{{count($assign_team_agent->where('team_id',$team->id))}}</td>
                        <td>{{ $team_lead }}</td>
                        <td>
                            {!! Form::open(['route'=>['teams.destroy', $team->id],'method'=>'DELETE']) !!}

                            <!-- To pop up a confirm Message -->
                           @if ($team->status == 0) 
                            <a href="{{route('teams.show', $team->id)}}" class="btn btn-success btn-xs btn-flat" disabled='disabled'><i class="fa fa-edit" style="color:black;"> </i> {!! trans('lang.show') !!}</a>
                            
                            @endif
                             @if ($team->status == 1) 
                            <a href="{{route('teams.show', $team->id)}}" class="btn btn-success btn-xs btn-flat" ><i class="fa fa-edit" style="color:black;"> </i> {!! trans('lang.show') !!}</a>
                            
                            @endif

                            <a href="{{route('teams.edit', $team->id)}}" class="btn btn-info btn-xs btn-flat"><i class="fa fa-edit" style="color:black;"> </i> {!! trans('lang.edit') !!}</a>
                            
                            {!! Form::button('<i class="fa fa-trash" style="color:black;"> </i> '.trans('lang.delete'),
                            ['type' => 'submit',
                            'class'=> 'btn btn-warning btn-xs btn-flat',
                            'onclick'=>'return confirm("Are you sure?")'])
                            !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                    @endforeach
                    </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@stop