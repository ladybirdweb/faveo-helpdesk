@extends('themes.default1.layouts.blank')

@section('Staffs')
class="active"
@stop

@section('staffs-bar')
active
@stop

@section('staffs')
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
	<h2 class="box-title">{{Lang::get('lang.agents')}}</h2><a href="{{route('agents.create')}}" class="btn btn-primary pull-right">{{Lang::get('lang.create_agent')}}</a></div>

<div class="box-body table-responsive no-padding">

<!-- check whether success or not -->

@if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <i class="fa  fa-check-circle"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('success')}}
    </div>
    @endif
    <!-- failure message -->
    @if(Session::has('fails'))
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('fails')}}
    </div>
    @endif


				<table class="table table-hover" style="overflow:hidden;">
	<tr>
							<th width="100px">{{Lang::get('lang.name')}}</th>
							<th width="100px">{{Lang::get('lang.user_name')}}</th>
							<th width="100px">{{Lang::get('lang.status')}}</th>
							<th width="100px">{{Lang::get('lang.group')}}</th>
							<th width="100px">{{Lang::get('lang.department')}}</th>
							<th width="100px">{{Lang::get('lang.created')}}</th>
							<th width="100px">{{Lang::get('lang.lastlogin')}}</th>
							<th width="100px">{{Lang::get('lang.action')}}</th>

						</tr>
						@foreach($user as $use)
						<tr>
							<td><a href="{{route('agents.edit', $use->id)}}"> {{$use -> user_name }}</a></td>
							<td> {{$use -> user_name }}</a></td>
							<td>
								@if($use->account_type=='1')
								<p style="color:green">{{'Active'}}</p>
								@else
								<p style="color:red">{{'Inactive'}}</p>
								@endif


							<td>{{$use -> assign_group }}</td>
							<td>{{$use -> primary_dpt }}</td>
							<td>{{$use -> created_at}}</td>
							<td>{{$use -> Lastlogin_at}}</td>
							<td>
							{!! Form::open(['route'=>['agents.destroy', $use->id],'method'=>'DELETE']) !!}

							 <div class="form-group">
								<!-- To pop up a confirm Message -->
									{!! Form::button('<i class="fa fa-star"></i> Delete',
					            		['type' => 'submit',
					            		'class'=> 'actions-line icon-trash',
					            		'onclick'=>'return confirm("Are you sure?")'])
					            	!!}

								</div>

							{!! Form::close() !!}
							</td>
						</tr>
						@endforeach

</td>
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