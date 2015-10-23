@extends('themes.default1.installer.layout.installer')
@section('content')
<style type="text/css">
	h1
	{
		color:#008A00;
	}
	h3
	{
		color: 19D119;
	}

</style>

<h1>You're All Set</h1>
<p>

<h3>Thank You</h3>
<p>

<br>
<a href="{{url('auth/login')}}" id="access1">&nbsp;&nbsp;&nbsp;&nbsp; Submit</a>
<br><br><br>
<p>

@stop
