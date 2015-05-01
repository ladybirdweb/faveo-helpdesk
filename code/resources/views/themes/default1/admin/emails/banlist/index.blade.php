@extends('themes.default1.layouts.blank')

@section('Emails')
class="active"
@stop

@section('emails-bar')
active
@stop

@section('ban')
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
				<h2 class="box-title">{{Lang::get('lang.banlists')}}</h2><a href="{{route('banlist.create')}}" class="pull-right btn btn-primary">{{Lang::get('lang.ban_email')}}</a>
				</div>
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
		<th width="100px">{{Lang::get('lang.email_address')}}</th>
		<th width="100px">{{Lang::get('lang.status')}}</th>
		<th width="100px">{{Lang::get('lang.created')}}</th>
		<th width="100px">{{Lang::get('lang.last_updated')}}</th>
		<th width="100px">{{Lang::get('lang.action')}}</th>
	</tr>
	<!-- Foreach @var bans as @var ban -->
		@foreach($bans as $ban)
	<tr>

		<!-- Email Address with Link to Edit page along Id -->
		<td><a href="{{route('banlist.edit',$ban->id)}}">{!! $ban->email_address !!}</a></td>
		<!-- Ban Status : if status==1 active -->
		<td>
			@if($ban->ban_status=='active')
				<p style="color:green">Active</p>
			@else
				<p style="color:red">Disable</p>
			@endif
		</td>
		<!-- Date Added -->
		<td>{!! $ban->created_at !!}</td>
		<!-- Last Updated -->
		<td> {!! $ban->updated_at !!} </td>
		<!-- Deleting Fields -->
		<td>
			{!! Form::open(['route'=>['banlist.destroy', $ban->id],'method'=>'DELETE']) !!}

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
		@endforeach
	</tr>

	<!-- Set a link to Create Page -->




</table>
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