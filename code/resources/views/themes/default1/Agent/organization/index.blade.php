@extends('themes.default1.layouts.agentblank')

@section('Users')
class="active"
@stop

@section('user-bar')
active
@stop

@section('organizations')
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

<section class="content">
	<div class="row">
<div class="col-md-12">
<div class="box box-primary">
<div class="box-header">
	<h2 class="box-title">{{Lang::get('lang.organization')}}</h2><a href="{{route('organizations.create')}}" class="btn btn-primary pull-right">{{Lang::get('lang.create_user')}}</a></div>

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
							<th width="100px">{{Lang::get('lang.user')}}</th>
							<th width="100px">{{Lang::get('lang.created')}}</th>
							<th width="100px">{{Lang::get('lang.last_updated')}}</th>
							<th width="100px">{{Lang::get('lang.action')}}</th>

						</tr>


					@foreach($orgs as $org)
						<tr>
							<td><a href="{{route('organizations.show', $org->id)}}"> {{$org -> name }}</a></td>
							<td></td>
							<td>{{$org -> created_at}}</td>
							<td>{{$org -> updated_at}}</td>
							<td>
							{!! Form::open(['route'=>['organizations.destroy', $org->id],'method'=>'DELETE']) !!}

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
</section>


@section('FooterInclude')

@stop
@stop
<!-- /content -->
@stop
@section('FooterInclude')

@stop

<!-- /content -->