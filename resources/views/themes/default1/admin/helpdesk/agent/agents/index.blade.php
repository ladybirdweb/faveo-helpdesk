@extends('themes.default1.admin.layout.admin')

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

	
<div class="box box-primary">
<div class="box-header">
	<h2 class="box-title">{!! Lang::get('lang.staffs') !!} </h2><a href="{{route('agents.create')}}" class="btn btn-primary pull-right">{{Lang::get('lang.create_agent')}}</a></div>

<div class="box-body table-responsive">
<?php 
 $user = App\User::where('role','!=','user')->orderBy('id', 'ASC')->paginate(20);
?>
<!-- check whether success or not -->

@if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <i class="fa  fa-check-circle"></i>
        <b>{!! Lang::get('lang.success') !!}</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('success')}} 
    </div>
    @endif
    <!-- failure message -->
    @if(Session::has('fails'))
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <b>{!! Lang::get('lang.fails') !!}!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('fails')}}
    </div>
    @endif
    		<!-- Agent table -->
				<table class="table table-bordered dataTable" style="overflow:hidden;">
					<tr>
							<th width="100px">{{Lang::get('lang.name')}}</th>
							<th width="100px">{{Lang::get('lang.user_name')}}</th>
							<th width="100px">{{Lang::get('lang.role')}}</th>
							<th width="100px">{{Lang::get('lang.status')}}</th>
							<th width="100px">{{Lang::get('lang.group')}}</th>
							<th width="100px">{{Lang::get('lang.department')}}</th>
							<th width="100px">{{Lang::get('lang.created')}}</th>
							{{-- <th width="100px">{{Lang::get('lang.lastlogin')}}</th> --}}
							<th width="100px">{{Lang::get('lang.action')}}</th>
						</tr>
						@foreach($user as $use)
						@if($use->role == 'admin' || $use->role == 'agent')
						<tr>
							<td><a href="{{route('agents.edit', $use->id)}}"> {!! $use->first_name !!} {!! " ". $use->last_name !!}</a></td>
							<td><a href="{{route('agents.edit', $use->id)}}"> {!! $use->user_name !!}</td>
							<?php 
							if($use->role == 'admin')
							{
							echo '<td><button class="btn btn-success btn-xs">Admin</button></td>';	
							}
							elseif ($use->role == 'agent') {
							echo '<td><button class="btn btn-primary btn-xs">Agent</button></td>';		
							}
							?>
							<td>
								@if($use->active=='1')
								<span style="color:green">{{'Active'}}</span>
								@else
								<span style="color:red">{{'Inactive'}}</span>
								@endif

								<?php    
								$group = App\Model\helpdesk\Agent\Groups::whereId($use->assign_group)->first();
								$department = App\Model\helpdesk\Agent\Department::whereId($use->primary_dpt)->first();
								?>

							<td>{{ $group->name }}</td>
							<td>{{ $department->name }}</td>
							<td>{{ UTC::usertimezone($use->created_at) }}</td>
							{{-- <td>{{$use->Lastlogin_at}}</td> --}}
							<td>
							{!! Form::open(['route'=>['agents.destroy', $use->id],'method'=>'DELETE']) !!}
							<a href="{{route('agents.edit', $use->id)}}" class="btn btn-info btn-xs btn-flat"><i class="fa fa-edit" style="color:black;"> </i> {!! Lang::get('lang.edit') !!} </a>
								<!-- To pop up a confirm Message -->
									{{-- {!! Form::button(' <i class="fa fa-trash" style="color:black;"> </i> '  . Lang::get('lang.delete') ,['type' => 'submit', 'class'=> 'btn btn-warning btn-xs btn-flat','onclick'=>'return confirm("Are you sure?")']) !!} --}}
							{!! Form::close() !!}
							</td>
						</tr>
						@endif
						@endforeach
				</table>
		</div>
		
</div>
@stop