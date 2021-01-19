@extends('themes.default1.admin.layout.admin')

@section('Settings')
class="nav-link active"
@stop

@section('settings-menu-parent')
class="nav-item menu-open"
@stop

@section('settings-menu-open')
class="nav nav-treeview menu-open"
@stop

@section('social-login')
class="nav-link active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>Social media settings</h1>
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')
<ol class="breadcrumb">

</ol>
@stop
@section('content')
{!! Form::open(['url' => 'social/media/'.$provider, 'method' => 'POST']) !!}
@if (count($errors) > 0)
<div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- check whether success or not -->
@if(Session::has('warn'))
<div class="alert alert-warning alert-dismissable">
    <i class="fas fa-check-circle"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {!!Session::get('warn')!!}
</div>
@endif
@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <i class="fas fa-check-circle"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {!!Session::get('success')!!}
</div>
@endif
<!-- failure message -->
@if(Session::has('fails'))
<div class="alert alert-danger alert-dismissable">
    <i class="fas fa-ban"></i>
    <b>{!! Lang::get('lang.alert') !!}!</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {!!Session::get('fails')!!}
</div>
@endif
<div class="card card-light">
    <div class="card-header">
        <h3 class="card-title">{{ucfirst($provider)}}</h3>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('client_id') ? 'has-error' : '' }}">
                    {!! Form::label('client_id',Lang::get('lang.client_id')) !!}<spam class="help-block"> *</spam>
                    {!! Form::text('client_id',$social->getvalueByKey($provider,'client_id'),['class' => 'form-control']) !!}
                    {!! $errors->first('client_id', '<spam class="help-block">:message</spam>') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('client_secret') ? 'has-error' : '' }}">
                    {!! Form::label('client_secret',Lang::get('lang.client_secret')) !!}<spam class="help-block"> *</spam>
                    {!! Form::text('client_secret',$social->getvalueByKey($provider,'client_secret'),['class' => 'form-control']) !!}
                     {!! $errors->first('client_secret', '<spam class="help-block">:message</spam>') !!}
                </div>
            </div>
        </div> 
        <div class="row">
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('redirect') ? 'has-error' : '' }}">
                    {!! Form::label('redirect',Lang::get('lang.redirect')) !!}
                    {!! Form::text('redirect',$social->getvalueByKey($provider,'redirect'),['class' => 'form-control']) !!}
                    {!! $errors->first('redirect', '<spam class="help-block">:message</spam>') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::label('status',Lang::get('lang.status')) !!} 
                        </div>
                        <div class="col-md-6">
                            <p>{!! Form::radio('status',1,$social->checkActive($provider))!!} Active</p>
                        </div>
                        <div class="col-md-6">
                            <p>{!! Form::radio('status',0,$social->checkInactive($provider)) !!} Inactive</p>
                        </div>
                        <div class="col-md-12">
                            <i>Activate login via {{ucfirst($provider)}}</i>
                        </div>
                         {!! $errors->first('status', '<spam class="help-block">:message</spam>') !!}
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="card-footer">
        {!! Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary'])!!}
    </div>
</div>
{!! Form::close() !!}
@stop
