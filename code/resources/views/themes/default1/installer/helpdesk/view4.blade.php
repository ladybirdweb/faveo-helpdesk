@extends('themes.default1.installer.layout.installer')
@section('content')
<h1>Configuration</h1>
<div class="login-box-body">
<h3>Database Connection</h3>
{!! Form::open(['url'=> '/step4post']) !!}
<!-- <b>database</b><br> -->
<select class="form-control" name="default" id="default">
	<option value="mysql">mysql</option>
	<option value="pgsql">pgsql</option>
	<option value="sqlsrv">sqlsrv</option>
</select><br>
<!-- <b>Host</b><br> -->
<input type="text" class="form-control"  name="host" id="host" placeholder="Host" required><br>
<!-- <b>Database Name</b><br> -->
<input type="text" class="form-control" name="databasename" id="databasename" placeholder="Databsae Name" required><br>
<!-- <b>User Name</b><br> -->
<input type="text" class="form-control" name="username" id="username" placeholder="Username" required><br>
<!-- <b>User Password</b><br> -->
<input type="text" class="form-control" name="password" id="password" placeholder="Password" ><br>

<!-- <input type="submit" value="prev" id="access1"> -->
<a href="{{URL::route('localization')}}" style="text-color:black" id="access1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Prev</a>
<input type="submit"  value="next" id="access">
</form>
<br>
</div>
</p>
@stop


