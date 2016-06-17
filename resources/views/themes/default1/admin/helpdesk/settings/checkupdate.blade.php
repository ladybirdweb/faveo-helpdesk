@extends('themes.default1.admin.layout.admin')
@section('update')
class="active"
@stop
@section('PageHeader')
<h1>{{ Lang::get('lang.update-version')}}</h1>
@stop
@section('content')

<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title">Check for Update</h3>
	</div>
	 
	<div class="box-body">
	@if(Session::has('info'))
        <div class="alert alert-info alert-dismissable">
            <i class="fa  fa-info-circle"></i>
            <b>Info!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!!Session::get('info')!!}
        </div>
        @endif
		Click to check Update
                <a href="{!! URL::route('version-check') !!}" class="btn btn-primary">Check</a>
	</div>
	<div class="box-footer">
		
	</div>
</div>

@stop