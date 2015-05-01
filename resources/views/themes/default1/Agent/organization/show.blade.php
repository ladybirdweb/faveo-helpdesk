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


<div class="box box-primary">
<div class="box-header">

	<h2 class="box-title">{{$orgs->name}}</h2></div>


<div class="row">

	<div class="col-md-6">

		<div class="col-xs-4 form-group">

			<strong>{{Lang::get('lang.name')}}</strong>

		</div>

		<div class="col-xs-4">

			<a href="{{route('organizations.edit', $orgs->id)}}"> {{$orgs -> name }}</a>

		</div>

	</div>

	<div class="col-md-6">

		<div class="col-xs-4 form-group">

			<strong>{{Lang::get('lang.account_manager')}}</strong>

		</div>

		<div class="col-xs-4">



		</div>

	</div>

</div>

<div class="row">

	<div class="col-md-6">

		<div class="col-xs-4 form-group">

			<strong>{{Lang::get('lang.created')}}</strong>

		</div>

		<div class="col-xs-4">

			{{$orgs -> created_at}}

		</div>

	</div>

	<div class="col-md-6">

		<div class="col-xs-4 form-group">

			<strong>{{Lang::get('lang.last_updated')}}</strong>

		</div>

		<div class="col-xs-4">

			{{$orgs -> updated_at}}

		</div>

	</div>

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