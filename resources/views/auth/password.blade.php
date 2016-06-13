@extends('themes.default1.layouts.login')

@section('body')
@if(Session::has('status'))
<div class="alert alert-success alert-dismissable">
    <i class="fa  fa-check-circle"> </i> <b> {!! Lang::get('lang.success') !!} </b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('status')}}
</div>
@endif
@if (count($errors) > 0)
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <b>{!! Lang::get('lang.alert') !!} !</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</div>
@endif
<p class="login-box-msg">{!! Lang::get('lang.enter_email_to_reset_password') !!}</p>
<!-- form open -->
<form role="form" method="POST" action="{{ url('/password/email') }}">
    <!-- Email -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <!-- Email -->
    <!-- <div class="input-group margin"> -->
    <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
        <input type="email" class="form-control" name="email" placeholder="{!! Lang::get('lang.email') !!}" value="{{ old('email') }}">
         <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    

    <div class="row">
    <div class="col-xs-8">

    <a href="{{url('auth/login')}}" class="text-center">{!! Lang::get('lang.i_know_my_password') !!}</a>    
    </div>
    <div class="col-xs-4">
        <span class="input-group-btn"><button type="submit" class="btn btn-primary btn-block btn-flat">{!! Lang::get('lang.send') !!}</button></span>
        <br/>
    </div>
    </div>        
    <!-- </div> -->
</form>


<!-- /.login-page -->
@stop