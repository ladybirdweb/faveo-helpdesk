@extends('themes.default1.admin.layout.admin')

@section('Staffs')
class="active"
@stop

@section('staffs-bar')
active
@stop

@section('departments')
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
	<div class="row">
<div class="col-md-12">
<div class="box box-primary">
<div class="box-header">
	<h2 class="box-title">{!! Lang::get('lang.departments') !!}</h2><a href="{{route('departments.create')}}" class="btn btn-primary pull-right">{{Lang::get('lang.create_department')}}</a></div>

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
    <!-- table -->
				<table class="table table-hover" style="overflow:hidden;">
	<tr>
						<tr>
							<th>{{Lang::get('lang.name')}}</th>
							<th>{{Lang::get('lang.type')}}</th>
							<th>{{Lang::get('lang.department_manager')}}</th>
							<th>{{Lang::get('lang.action')}}</th>
						</tr>
						@foreach($departments as $department)
						<tr>
							<td><a href="{{route('departments.edit', $department->id)}}"> {{$department -> name }}</a></td>
							<td>
								@if($department->type=='1')
								<span style="color:green">{{'Public'}}</span>
								@else
								<span style="color:red">{{'Private'}}</span>
								@endif
							<td>{{$department->manager}}</td>
							<td>
							{!! Form::open(['route'=>['departments.destroy', $department->id],'method'=>'DELETE']) !!}
							<a href="{{route('departments.edit', $department->id)}}" class="btn btn-info btn-xs btn-flat"><i class="fa fa-edit" style="color:black;"> </i> Edit</a>
								<!-- To pop up a confirm Message -->
									{!! Form::button('<i class="fa fa-trash" style="color:black;"> </i> Delete',
					            		['type' => 'submit',
					            		'class'=> 'btn btn-warning btn-xs btn-flat',
					            		'onclick'=>'return confirm("Are you sure?")'])
					            	!!}
									{!! Form::close() !!}
							</td>
						</tr>
						@endforeach
</td>
</tr>
</tr>
</table>
</div>
</div>
</div>
</div>
@section('FooterInclude')

@stop
@stop
<!-- /content -->