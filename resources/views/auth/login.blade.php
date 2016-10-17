@extends('themes.default1.layouts.login')

@section('body')
<h4 class="login-box-msg">
    @if (Session::has('login_require'))
        {!! Session::get('login_require') !!}
    @else
        {!! Lang::get('lang.Login_to_start_your_session') !!}
    @endif
</h4>
@if(Session::has('status'))
<div class="alert alert-success alert-dismissable">
    <i class="fa  fa-check-circle"> </i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('status')}}
</div>
@endif
<!-- failure message -->
@if(Session::has('errors'))
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"> </i> <b> {!! Lang::get('lang.alert') !!}! </b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    @if(Session::has('error'))    
    <li>{!! Session::get('error') !!}</li>
    @else
    <li>{!! Lang::get('lang.please_fill_all_required_feilds') !!}</li>
    @endif
</div>
@endif
<!-- failure message -->
@if(Session::has('fails'))
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"> </i> <b> {!! Lang::get('lang.alert') !!}! </b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <li>{!! Session::get('fails') !!}</li>
</div>
@endif

<!-- form open -->
{!!  Form::open(['action'=>'Auth\AuthController@postLogin', 'method'=>'post']) !!}
<!-- Email -->
<div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
    {!! Form::text('email',null,['placeholder'=> Lang::get("lang.email") ,'class' => 'form-control']) !!}
    <!-- {!! $errors->first('email', '<spam class="help-block">:message</spam>') !!} -->
    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
</div>

<!-- Password -->
<div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
    {!! Form::password('password',['placeholder'=>Lang::get("lang.password"),'class' => 'form-control']) !!}
    <!-- {!! $errors->first('password', '<spam class="help-block">:message</spam>') !!} -->
    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
</div>
@if (Session::has('referer'))
    <input type='hidden' name="referer" value="{!! Session::get('referer') !!}">
@elseif(Session::has('errors'))
    <input type='hidden' name="referer" value="form">
@endif
<div class="row">
    <div class="col-xs-8">
        <div class="checkbox icheck">
            <label>
                <input type="checkbox" name="remember"> {!! Lang::get("lang.remember") !!}
            </label>
        </div>
    </div><!-- /.col -->
    <div class="col-xs-4">
        <button type="submit" class="btn btn-primary btn-block btn-flat">{!! Lang::get("lang.login") !!}</button>
    </div><!-- /.col -->
</div>
</form>

<a href="{{url('password/email')}}">{!! Lang::get("lang.iforgot") !!}</a><br>
<a href="{{url('auth/register')}}" class="text-center">{!! Lang::get("lang.register") !!}</a>
<!-- /.login-page -->

@include('themes.default1.client.layout.social-login')
@stop
