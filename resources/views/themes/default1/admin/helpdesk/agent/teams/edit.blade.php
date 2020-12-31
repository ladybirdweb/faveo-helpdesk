@extends('themes.default1.admin.layout.admin')

@section('Staffs')
class="nav-link active"
@stop

@section('staff-menu-parent')
class="nav-item menu-open"
@stop

@section('staff-menu-open')
class="nav nav-treeview menu-open"
@stop

@section('teams')
class="nav-link active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{Lang::get('lang.teams')}}</h1>
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
<!-- open a form -->
{!!Form::model($teams, ['url'=>'teams/'.$teams->id , 'method'=> 'PATCH'])!!}

@if(Session::has('errors'))
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <b>Alert!</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <br/>
    @if($errors->first('name'))
    <li class="error-message-padding">{!! $errors->first('name', ':message') !!}</li>
    @endif
    @if($errors->first('team_lead'))
    <li class="error-message-padding">{!! $errors->first('team_lead', ':message') !!}</li>
    @endif
    @if($errors->first('status'))
    <li class="error-message-padding">{!! $errors->first('status', ':message') !!}</li>
    @endif
</div>
@endif

<div class="card card-light">

    <div class="card-header">
        <h3 class="card-title">{!! Lang::get('lang.edit_a_team') !!}</h3>	
    </div>
    
    <div class="card-body">
       
        <div class="row">
            <!-- name -->
            <div class="col-sm-5 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                {!! Form::label('name',Lang::get('lang.name')) !!} <span class="text-red"> *</span>
                {!! Form::text('name',null,['class' => 'form-control']) !!}
            </div>
            <!-- team lead -->
            <div class="col-sm-4 form-group {{ $errors->has('team_lead') ? 'has-error' : '' }}">
                {!! Form::label('team_lead',Lang::get('lang.team_lead')) !!}
                {!! Form::select('team_lead',[''=>Lang::get('lang.select_a_team_lead'), Lang::get('lang.members')=>$user->pluck('full_name','id')->toArray()],null,['class' => 'form-control']) !!}	
            </div>

            <div class="col-sm-3">
                <!-- status -->
                <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                    {!! Form::label('status',Lang::get('lang.status')) !!}
                    <div class="row">
                        <div class="col-sm-6">
                            {!! Form::radio('status','1',true) !!} {{Lang::get('lang.active')}}
                        </div>
                        <div class="col-sm-6">
                            {!! Form::radio('status','0',null) !!} {{Lang::get('lang.inactive')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- admin notes -->
        <div>
            {!! Form::label('admin_notes',Lang::get('lang.admin_notes')) !!}
            {!! Form::textarea('admin_notes',null,['class' => 'form-control','size' => '30x5']) !!}
        </div>
    </div>
    <div class="card-footer">
        {!! Form::submit(Lang::get('lang.update'),['class'=>'btn btn-primary'])!!}
    </div>
    {!!Form::close()!!}
</div>
@stop