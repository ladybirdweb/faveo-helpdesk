@extends('themes.default1.layouts.installer')

@section('content')
<h1>Create Admin Account</h1>
<div class="login-box-body" >
<?php
$language = Session::get('language');
$timezone = Session::get('timezone');
$date = Session::get('date');
$datetime = Session::get('datetime');
?>

{!! Form::open(['url'=>route('postaccount')]) !!}
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<!--  Hidden form fields -->
<input type="hidden" name="language" id="language" value="{{$language}}">
<input type="hidden" name="timezone" id="timezone" value="{{$timezone}}">
<input type="hidden" name="date" id="date" value="{{$date}}">
<input type="hidden" name="datetime" id="datetime" value="{{$datetime}}">

<!-- Personal Information -->
<h4>Personal Information</h4>
<b>First Name</b>
<input type="text" class="form-control" name="firstname" id="firstname">
@if($errors->has('firstname'))
<div class="text-red">{{$errors->first('firstname')}}</div>
@endif

<b>Last Name</b>
<input type="text" class="form-control" name="Lastname" id="Lastname">
@if($errors->has('Lastname'))
<div class="text-red">{{$errors->first('Lastname')}}</div>
@endif

<b>Email</b>
<input type="text" class="form-control" name="email" id="email">
@if($errors->has('email'))
<div class="text-red">{{$errors->first('email')}}</div>
@endif

<h4>Login Information</h4>
<b>User Name</b>
<input type="text" class="form-control" name="username" id="username">
@if($errors->has('username'))
<div class="text-red">{{$errors->first('username')}}</div>
@endif

<b>Password</b>
<input type="password" class="form-control" name="password" id="password">
@if($errors->has('password'))
<div class="text-red">{{$errors->first('password')}}</div>
@endif

<b>Confirm Password</b>
<input type="password" class="form-control" name="confirmpassword" id="confirmpassword">
@if($errors->has('confirmpassword'))
<div class="text-red">{{$errors->first('confirmpassword')}}</div>
@endif

<br>
 {{-- <a href="{{URL::route('configuration')}}" id="access1" style="color:black">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Prev</a> --}}
<input type="submit" value="Next" id="access">
{!! Form::token() !!}
{!! Form::close() !!}
<br><p>
</div></p>
@stop