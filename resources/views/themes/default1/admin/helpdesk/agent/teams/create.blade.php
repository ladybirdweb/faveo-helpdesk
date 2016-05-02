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


{!! Form::open(array('action' => 'Admin\helpdesk\TeamController@store' , 'method' => 'post') )!!}


<div class="box box-primary">
    <div class="content-header">

        <h4>{!! Lang::get('lang.create') !!}	{!! Form::submit(Lang::get('lang.save'),['class'=>'form-group btn btn-primary pull-right'])!!}</h4>

    </div>

    <div class="box-body">

        <div class="row">

            <!-- name -->
            <div class="col-xs-6 form-group {{ $errors->has('name') ? 'has-error' : '' }}">

                {!! Form::label('name',Lang::get('lang.name')) !!}
                {!! $errors->first('name', '<spam class="help-block">:message</spam>') !!}
                {!! Form::text('name',null,['class' => 'form-control']) !!}

            </div>

            <!-- team lead -->
            <div class="col-xs-6 form-group {{ $errors->has('team_lead') ? 'has-error' : '' }}">

                {!! Form::label('team_lead',Lang::get('lang.team_lead')) !!}
                {!! $errors->first('team_lead', '<spam class="help-block">:message</spam>') !!}
                <?php $user = App\User::where('role', 'admin')->orWhere('role', 'agent')->get(); ?>
                {!! Form::select('team_lead',[''=>'Select a Team Leader','Members'=>$user->lists('user_name','id')->toArray()],null,['class' => 'form-control']) !!}	

            </div>

        </div>
        <!-- status -->
        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">

            {!! Form::label('status',Lang::get('lang.status')) !!}
            {!! $errors->first('status', '<spam class="help-block">:message</spam>') !!}
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

        {!!Form::close()!!}
    </div>
</div>

@stop