@extends('themes.default1.layouts.agent')

@section('content')

{!! Form::open(['route'=>'test1234','method'=>'patch']) !!}
    
<input type="text" name="abc" value="aaa@aaa.com bbb@bbb.com ccc@ccc.com" class="form-control">

<input type="submit" class="btn btn-warning">

</form>

@stop