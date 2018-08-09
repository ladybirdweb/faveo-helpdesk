@extends('themes.default1.admin.layout.admin')

@section('Staffs')
active
@stop

@section('staffs-bar')
active
@stop

@section('agents')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{ Lang::get('lang.agents')}} </h1>
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
    <div class="box-header">
        <div class="row">
        <div class="col-md-5">
            <h2 class="box-title">{!! Lang::get('lang.list_of_agents') !!} </h2>
        </div>
        <div class="col-md-4">
            <div class="has-feedback">
                            <input type="text" class="form-control input-sm" id="search-text" name="search" placeholder="{{Lang::get('lang.search')}}">
                            <span class="fa fa-search form-control-feedback" style="pointer-events: initial; cursor: pointer; color: #74777a" onclick="searchUSer()"></span>
                        </div>
        </div>
        <div class="col-md-3" style="width:22%">
                    <div class="pull-right">
                    <div id="labels-div" class="btn-group">
                        <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" id="labels-button" title="{{Lang::get('lang.view-option')}}"><i class="fa fa-eye" style="color:teal;">&nbsp;</i>&nbsp;<span class="caret"></span>
                        </button>
                        <ul  class="dropdown-menu role="menu" id="profile-type-filter">
                            <li><a href="#" class="all">{{Lang::get('lang.all-users')}}</a></li>
                            <li><a href="#" class="agents">{{Lang::get('lang.only-agents')}}</a></li>
                            <li><a href="#" class="admins">{{Lang::get('lang.only-admins')}}</a></li>
                            <li class="active"><a href="#" class="active-users">{{Lang::get('lang.active-users')}}</a></li>
                            <li><a href="#" class="banned">{{Lang::get('lang.banned-users')}}</a></li>
                            <li><a href="#" class="deleted">{{Lang::get('lang.deactive-users')}}</a></li>
                             <li><a href="#" class="inactive">{{Lang::get('lang.inactive-users')}}</a></li>
                           
                        </ul>
                    </div>
                    <div id="labels-div" class="btn-group">
                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" id="labels-button" title="{{Lang::get('lang.filter-agents-by-department')}}"><i class="fa fa-filter">&nbsp;</i>&nbsp;<span class="caret"></span>
                        </button>
                        <ul  class="dropdown-menu role="menu" id="department-filter">
                            <li class="active"><a href="#" class="all"]>{{Lang::get('lang.all-departments')}}</a></li>
                            @foreach($departments as $department)
                            <li><a href="#" class="{{$department->id}}"> {{$department->name}} </a></li>@endforeach
                        </ul>
                    </div>
                    <a href="{{route('agents.create')}}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;{{Lang::get('lang.create_agent')}}</a>
                    </div>
                </div>
                </div>
    </div>
    <div class="box-body">
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
            <b>{!! Lang::get('lang.fails') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif
        <!-- Warning Message -->
        @if(Session::has('warning'))
        <div class="alert alert-warning alert-dismissable">
            <i class="fa fa-warning"></i>
            <b>{!! Lang::get('lang.warning') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('warning')}}
        </div>
        @endif
        <!-- Agent table -->
        {!!$table->render('vendor.Chumper.template')!!}
    </div>
</div>
{!! $table->script('vendor.Chumper.user-table-javascript') !!}
<script type="text/javascript">
    $('.form-control-feedback').hover(
        function() {
            $( this ).css('color', '#36383a');
        }, function() {
            $( this ).css('color', '#74777a');
        }
    );
    $(document).ready(function(){
        $('[data-toggle="dropdown"]').tooltip();
    });
</script>
@stop