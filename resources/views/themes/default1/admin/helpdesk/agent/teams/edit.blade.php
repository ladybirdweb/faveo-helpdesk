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
<!-- open a form -->
{!!Form::model($teams, ['url'=>'teams/'.$teams->id , 'method'=> 'PATCH'])!!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.edit_a_team') !!}</h3>	
    </div>
    <div class="box-body">
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
        <div class="row">
            <!-- name -->
            <div class="col-xs-6 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                {!! Form::label('name',Lang::get('lang.name')) !!}
                {!! Form::text('name',null,['class' => 'form-control']) !!}
            </div>
            <!-- team lead -->
            <div class="col-xs-6 form-group {{ $errors->has('team_lead') ? 'has-error' : '' }}">
                {!! Form::label('team_lead',Lang::get('lang.team_lead')) !!}
                <?php $user = App\User::where('role', 'admin')->orWhere('role', 'agent')->get(); ?>
                {!! Form::select('team_lead',[''=>Lang::get('lang.select_a_team_lead'), Lang::get('lang.members')=>$user->lists('user_name','id')->toArray()],null,['class' => 'form-control']) !!}	
            </div>
        </div>
        <!-- status -->
        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
            {!! Form::label('status',Lang::get('lang.status')) !!}
            <div class="row">
                <div class="col-xs-1">
                    {!! Form::radio('status','1',true) !!} {{Lang::get('lang.active')}}
                </div>
                <div class="col-xs-2">
                    {!! Form::radio('status','0',null) !!} {{Lang::get('lang.inactive')}}
                </div>
            </div>
        </div>
        <!-- admin notes -->
        <div class="form-group">
            {!! Form::label('admin_notes',Lang::get('lang.admin_notes')) !!}
            {!! Form::textarea('admin_notes',null,['class' => 'form-control','size' => '30x5']) !!}
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit(Lang::get('lang.update'),['class'=>'form-group btn btn-primary'])!!}
    </div>
    {!!Form::close()!!}
</div>
@stop