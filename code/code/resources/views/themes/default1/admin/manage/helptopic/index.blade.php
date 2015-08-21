@extends('themes.default1.layouts.admin')

@section('Manage')
class="active"
@stop

@section('manage-bar')
active
@stop

@section('help')
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
                      <div class="form-group">
                       <div class="box-header">
                            <h2 class="box-title">{{Lang::get('lang.help_topic')}}</h2><a href="{{route('helptopic.create')}}" class="btn btn-primary pull-right">{{Lang::get('lang.create_help_topic')}}</a></div>
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
		<th width="100px">{{Lang::get('lang.topic')}}</th>
		<th width="100px">{{Lang::get('lang.status')}}</th>
		<th width="100px">{{Lang::get('lang.type')}}</th>
		<th width="100px">{{Lang::get('lang.priority')}}</th>
		<th width="100px">{{Lang::get('lang.department')}}</th>
		<th width="100px">{{Lang::get('lang.last_updated')}}</th>
		<th width="100px">{{Lang::get('lang.action')}}</th>
	</tr>
	<!-- Foreach @var$topics as @var topic -->
		@foreach($topics as $topic)
	<tr style="padding-bottom:-30px">

		<!-- topic Name with Link to Edit page along Id -->
		<td><a href="{{route('helptopic.edit',$topic->id)}}">{!! $topic->topic !!}</a></td>

		<!-- topic Status : if status==1 active -->
		<td>
			@if($topic->ticket_status=='1')
				<span style="color:green">Active</span>
			@else
				<span style="color:red">Disable</span>
			@endif
		</td>

		<!-- Type -->

		<td>
			@if($topic->type=='1')
				<span style="color:green">Public</span>
			@else
				<span style="color:red">Private</span>
			@endif
		</td>
		<!-- Priority -->
		<td>{!! $topic->priority !!}</td>
		<!-- Department -->
		<td>{!! $topic->department !!}</td>
		<!-- Last Updated -->
		<td> {!! $topic->updated_at !!} </td>
		<!-- Deleting Fields -->
		<td>
			{!! Form::open(['route'=>['helptopic.destroy', $topic->id],'method'=>'DELETE']) !!}
			<a href="{{route('helptopic.edit',$topic->id)}}" class="btn btn-info btn-xs btn-flat"><i class="fa fa-trash" style="color:black;"> </i> Edit</a>
				<!-- To pop up a confirm Message -->
				{!! Form::button('<i class="fa fa-trash" style="color:black;"> </i> Delete',
					['type' => 'submit',
					'class'=> 'btn btn-warning btn-xs btn-flat',
					'onclick'=>'return confirm("Are you sure?")'])
				!!}

			</div>

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
</div>
</div>
</div>

@stop
</div><!-- /.box -->
@section('FooterInclude')

@stop
@stop
<!-- /content -->