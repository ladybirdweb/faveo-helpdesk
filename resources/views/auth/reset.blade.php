@extends('themes.default1.layouts.login')

@section('body')
@if(Session::has('status'))
<div class="alert alert-success alert-dismissable">
    <i class="fa fa-check-circle"> </i> <b> {!! trans('lang.success') !!} </b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('status')}}
</div>
@endif
<!-- failure message -->
@if (count($errors) > 0)
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <b>{!! trans('lang.alert') !!} !</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    @foreach ($errors->all() as $error)
    <li class="error-message-padding">{{ $error }}</li>
    @endforeach
</div>
@endif
<p class="login-box-msg">{!! trans('lang.reset_password') !!}</p>
<div class="panel-body">
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="token" value="{{ $token }}">
        <!-- Email -->
        <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
            <input type="email" class="form-control" name="email" placeholder="{!! trans('lang.e-mail') !!}" value="{{ old('email') }}">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <!-- password -->
        <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
            <input type="password" class="form-control" name="password" placeholder="{!! trans('lang.password') !!}">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <!-- confirm password -->
        <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
            <input type="password" class="form-control" name="password_confirmation" placeholder="{!! trans('lang.confirm_password') !!}">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
        </div>
        <!-- Confirm password -->
        <div class="form-group">
            <div class="col-md-3"></div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-flat">
                    {!! trans('lang.reset_password') !!}
                </button>
            </div>
        </div>
    </form>
</div>
@stop