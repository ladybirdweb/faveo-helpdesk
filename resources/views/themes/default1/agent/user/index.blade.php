@extends('themes.default1.layouts.agent')

@section('Users')
class="active"
@stop

@section('user-bar')
active
@stop

@section('user')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')


@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')
<ol class="breadcrumb">

</ol>
@stop
<!-- /breadcrumbs -->
<!-- content -->
@section('content')

<!-- open a form -->

<div class="box box-primary">
<div class="box-header">
	<h3 class="box-title">{{Lang::get('lang.user')}}</h3><a href="{{route('user.create')}}" class="btn btn-primary pull-right">{{Lang::get('lang.create_user')}}</a></div>

<div class="box-body table-responsive no-padding">


<!-- check whether success or not -->

@if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <i class="fa  fa-check-circle"></i>
        <b>Success!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('success')}}
    </div>
    @endif
    <!-- failure message -->
    @if(Session::has('fails'))
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <b>Alert!</b> Failed.
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('fails')}}
    </div>
    @endif

	<table class="table table-hover" style="overflow:hidden;">
	<tr>
							<th width="100px">{{Lang::get('lang.name')}}</th>
							<th width="100px">{{Lang::get('lang.status')}}</th>
							<th width="100px">{{Lang::get('lang.created')}}</th>
							<th width="100px">{{Lang::get('lang.last_updated')}}</th>
							<th width="100px">{{Lang::get('lang.action')}}</th>

						</tr>

						@foreach($users as $user)
						<tr>
							<td><a href="{{route('user.show', $user->id)}}"> {{$user -> user_name }}</a></td>
							<td><?php if($user->active == 1) { ?> <button class="btn btn-success btn-xs">Active</button> <?php } else { ?> <button class="btn btn-danger btn-xs">Inactive</button> <?php  }  ?></td>
							<td>{{$user -> created_at}}</td>
							<td>{{$user -> updated_at}}</td>
							<td>
							{!! Form::open(['route'=>['user.destroy', $user->id],'method'=>'DELETE']) !!}

							 {{-- <div class="form-group"> --}}
							<!-- To pop up a confirm Message -->
								{!! Form::button(' <i class="fa fa-trash" style="color:black;"> </i> Delete',['type' => 'submit',
				            		'class'=> 'btn btn-warning  btn-xs btn-flat',
				            		'onclick'=>'return confirm("Are you sure?")'])
				            	!!}

							{{-- </div> --}}
							{!! Form::close() !!}
							</td>
						</tr>
						@endforeach



</td>
</tr>
</table>
</div>
</div>


@section('FooterInclude')

@stop
@stop
<!-- /content -->
@stop
@section('FooterInclude')

@stop

<!-- /content -->