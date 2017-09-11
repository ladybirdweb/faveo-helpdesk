@extends('themes.default1.admin.layout.admin')

@section('Manage')
active
@stop

@section('manage-bar')
active
@stop

@section('sla')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{trans('lang.manage')}}</h1>
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
	<h2 class="box-title">{{trans('lang.SLA_plan')}}</h2><a href="{{route('sla.create')}}" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-plus"></span> &nbsp;{{trans('lang.create_SLA')}}</a></div>

<div class="box-body table-responsive">

<!-- check whether success or not -->

@if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <i class="fa  fa-check-circle"></i>
        <b>Success!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {!! Session::get('success') !!}
    </div>
    @endif
    <!-- failure message -->
    @if(Session::has('fails'))
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <b>Fail!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {!! Session::get('fails') !!}
    </div>
    @endif

<table class="table table-bordered dataTable" style="overflow:hidden;">

	<tr>
		<th width="100px">{{trans('lang.name')}}</th>
		<th width="100px">{{trans('lang.status')}}</th>
		<th width="100px">{{trans('lang.grace_period')}}</th>
		<th width="100px">{{trans('lang.created')}}</th>
		<th width="100px">{{trans('lang.last_updated')}}</th>
		<th width="100px">{{trans('lang.action')}}</th>
	</tr>

<?php
$default_sla = App\Model\helpdesk\Settings\Ticket::where('id','=','1')->first();
$default_sla = $default_sla->sla;
?>

	<!-- Foreach @var$slas as @var sla -->
		@foreach($slas as $sla)
	<tr>
		<!-- sla Name with Link to Edit page along Id -->
		<td><a href="{{route('sla.edit',$sla->id)}}">{!! $sla->name !!}
		@if($sla->id == $default_sla)
			( Default )
		<?php  
			$disable = 'disabled';
		?>
		@else
		<?php  
			$disable = '';
		?>
		@endif
		</a> </td>
		<!-- sla Status : if status==1 active -->
		<td>
			@if($sla->status=='1')
				<span style="color:green">Active</span>
			@else
				<span style="color:red">Disable</span>
			@endif
		</td>
		<!-- To show the sla's Time Period -->
		<td>{!! $sla->grace_period !!}</td>
		<!-- Created Date -->
		<td>{!! UTC::usertimezone($sla->created_at) !!}</td>
		<!-- Last Updated -->
		<td> {!! UTC::usertimezone($sla->updated_at) !!} </td>
		<!-- Deleting Fields -->
		<td>
			{!! Form::open(['route'=>['sla.destroy', $sla->id],'method'=>'DELETE']) !!}
			<a href="{{route('sla.edit',$sla->id)}}" class="btn btn-info btn-xs btn-flat"><i class="fa fa-edit" style="color:black;"> </i> Edit</a>
			<!-- To pop up a confirm Message -->
				{!! Form::button('<i class="fa fa-trash" style="color:black;"> </i> Delete',
            		['type' => 'submit',
            		'class'=> 'btn btn-warning btn-xs btn-flat '.$disable,
            		'onclick'=>'return confirm("Are you sure?")'])
            	!!}
			{!! Form::close() !!}
		</td>
		@endforeach
	</tr>
	<!-- Set a link to Create Page -->

</table>

</div>
</div>
</div>
</div>
@stop
