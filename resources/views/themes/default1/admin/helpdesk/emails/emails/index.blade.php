@extends('themes.default1.admin.layout.admin')

@section('Emails')
class="active"
@stop

@section('emails-bar')
active
@stop

@section('emails')
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
	<h2 class="box-title">{!! Lang::get('lang.incoming_emails') !!}</h2><a href="{{route('emails.create')}}" class="btn btn-primary pull-right">{{Lang::get('lang.create_email')}}</a></div>

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
        <b>Fail!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('fails')}}
    </div>
    @endif
    		<!-- table -->
				<table class="table table-hover" style="overflow:hidden;">
	<tr>
							<th width="100px">{{Lang::get('lang.email')}}</th>
							<th width="100px">{{Lang::get('lang.priority')}}</th>
							<th width="100px">{{Lang::get('lang.department')}}</th>
							<th width="100px">{{Lang::get('lang.created')}}</th>
							<th width="100px">{{Lang::get('lang.last_updated')}}</th>
							<th width="100px">{{Lang::get('lang.action')}}</th>
						</tr>
						@foreach($emails as $email)
						<tr>
							<td><a href="{{route('emails.edit', $email->id)}}"> {{$email -> email_address }}</a></td>
							<?php $priority = App\Model\helpdesk\Ticket\Ticket_Priority::where('priority_id','=',$email->priority)->first(); ?>
							<td>{{  ucfirst($priority->priority_desc) }}</td>
							<?php  $department = App\Model\helpdesk\Agent\Department::where('id','=',$email->department)->first();  ?>
							<td>{{ $department->name }}</td>
							<td>{{ UTC::usertimezone($email->created_at) }}</td>
							<td>{{ UTC::usertimezone($email->updated_at) }}</td>
							<td>
							{!! Form::open(['route'=>['emails.destroy', $email->id],'method'=>'DELETE']) !!}
							<a href="{{route('emails.edit', $email->id)}}" class="btn btn-info btn-xs btn-flat"><i class="fa fa-edit" style="color:black;"> </i> Edit</a>
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