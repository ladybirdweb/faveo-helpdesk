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
<h1>{{$teams->name}}</h1>
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


@if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <i class="fa  fa-check-circle"></i>
        <b>Success!</b>
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
<!-- <input type="text" name="show_id" value="{{$id}}"> -->
<?php
 if($team_lead_name= App\User::whereId($teams->team_lead)->first())
          {
            $team_lead = $team_lead_name->first_name . " " . $team_lead_name->last_name;
             // $assign_team_agent=App\Model\helpdesk\Agent\Assign_team_agent::all();
            // $total_members = $assign_team_agent->where('team_id',$id)->count();
        }

?>

    <div class="box box-primary">
        <div class="box-header with-border">
        @if($team_lead_name)
            <span class="lead border-right">{!! Lang::get('lang.team_lead') !!} : {!! $team_lead !!} </span>
         @endif
            <span class="lead border-left">{!! Lang::get('lang.status') !!} : <?php if($teams->status == 1) { $stat = Lang::get('lang.active'); } elseif($teams->status == 0) { $stat = Lang::get('lang.inactive'); } ?>{!! $stat !!} </span>


            <div class="pull-right">
                <a href="{{URL::route('teams.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{Lang::get('lang.go_back')}}</a>
            </div>
        </div>
        <input type="hidden" name="show_id" value={{$id}}>
        <!-- /.box-header -->
        <div class="box-body">
            {!! Datatable::table()
                    ->addColumn(
                        Lang::get('lang.user_name'),
                        Lang::get('lang.name'),
                        Lang::get('lang.status'),
                        Lang::get('lang.group'),
                        Lang::get('lang.department'),
                        Lang::get('lang.role')
                    )
                    ->setUrl(route('teams.getshow.list', $id))  // this is the route where data will be retrieved
                    ->render()
            !!}
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
        </div>
    </div>


@stop
