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
                <h2 class="box-title">{{Lang::get('lang.teams')}}</h2><a href="{{route('teams.create')}}" class="btn btn-primary pull-right">{{Lang::get('lang.create_team')}}</a></div>

            <div class="box-body table-responsive">

                <!-- check whether success or not -->

                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissable">
                    <i class="fa  fa-check-circle"></i>
                    <b>Success!</b>
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
                        <th>{{Lang::get('lang.name')}}</th>
                        <th>{{Lang::get('lang.status')}}</th>
                        <th>{{Lang::get('lang.team_members')}}</th>
                        <th>{{Lang::get('lang.team_lead')}}</th>
                        <th>{{Lang::get('lang.action')}}</th>
                    </tr>
                    @foreach($teams as $team)
                    <tr>
                        <td><a href="{{route('teams.edit', $team->id)}}"> {{$team -> name }}</a></td>
                        <td>
                            @if($team->status=='1')
                            <span style="color:green">{{'Active'}}</span>
                            @else
                            <span style="color:red">{{'Inactive'}}</span>
                            @endif

                            <?php
                            if ($team->team_lead == 0) {
                                $team_lead = "";
                            } else {
                                $users = App\User::whereId($team->team_lead)->first();
                                $team_lead = $users->first_name . " " . $users->last_name;
                            }
                            ?>
                        <td>{{count($assign_team_agent->where('team_id',$team->id))}}</td>
                        <td>{{ $team_lead }}</td>
                        <td>
                            {!! Form::open(['route'=>['teams.destroy', $team->id],'method'=>'DELETE']) !!}
                            <!-- To pop up a confirm Message -->
                            <a href="{{route('teams.edit', $team->id)}}" class="btn btn-info btn-xs btn-flat"><i class="fa fa-edit" style="color:black;"> </i> Edit</a>
                            {!! Form::button('<i class="fa fa-trash" style="color:black;"> </i> Delete',
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