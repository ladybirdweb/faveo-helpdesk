@extends('themes.default1.layouts.installer')

@section('content')
<style type="text/css">
  select {
    width:150px;
    border:1px solid red;
    -webkit-border-top-right-radius: 15px;
    -webkit-border-bottom-right-radius: 15px;
    -moz-border-radius-topright: 15px;
    -moz-border-radius-bottomright: 15px;
    border-top-right-radius: 15px;
    border-bottom-right-radius: 15px;
    padding:2px;
}

</style>

<h1>Localisation</h1>
<div class="login-box-body" >

<form action="{{URL::route('postlocalization')}}" method="post">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<select class="form-control" name="language" >
    	<option value="English(India)">English(India)</option>
    	<option value="English(U.k)">English(U.K)</option>
	</select>
    <br>

	<select class="form-control" name="timezone" >
    	<option value="Asia/Kolkata">Asia/Kolkata</option>
	</select>
    <br>

    <select class="form-control" name="date" >
    	<option value="d/m/Y">DD/MM/YYYY</option>
    	<option value="m/d/Y">MM/DD/YYYY</option>
    	<option value="Y/m/d">YYYY/MM/DD</option>
	</select>
    <br>

    <select class="form-control" name="datetime" >
    	<option value="d/m/Y H:i">DD/MM/YYYY H:i</option>
    	<option value="m/d/Y H:i">MM/DD/YYYY H:i</option>
    	<option value="Y/m/d H:i">YYYY/MM/DD H:i</option>
	</select>

    <br>
    <a href="{{URL::route('prerequisites')}}" style="text-color:black" id="access1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Prev</a>
    <input type="submit" value="Next" id="access">
</form>
<br>
</div>
</p>
@stop