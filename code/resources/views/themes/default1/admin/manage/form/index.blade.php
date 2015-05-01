@extends('themes.default1.layouts.blank')

@section('Manage')
class="active"
@stop

@section('manage-bar')
active
@stop

@section('form')
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
		<div class="col-xs-12">
			<div class="box box-primary">
               <div class="box-body">

                      <div class="form-group">
                       <div class="box-header">
                            <h2 class="box-title">{{Lang::get('lang.forms')}}</h2><a href="{{route('form.create')}}" class="btn btn-primary pull-right">{{Lang::get('lang.create_form')}}</a></div>


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
		<th width="100px">{{Lang::get('lang.Custom_form')}}</th>
		<th width="100px">{{Lang::get('lang.last_updated')}}</th>
		<th width="100px">Action</th>
	</tr>
	<!-- Foreach @var$forms as @var form -->
		@foreach($forms as $form)
	<tr>

		<!-- form Name with Link to Edit page along Id -->
		<td><a href="{{route('form.edit',$form->id)}}">{!! $form->title !!}</a></td>

		<!-- Last Updated -->
		<td> {!! $form->updated_at !!} </td>
		<!-- Deleting Fields -->
		<td>
			{!! Form::open(['route'=>['form.destroy', $form->id],'method'=>'DELETE']) !!}

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
</div>
</div>

@stop
</div><!-- /.box -->
@section('FooterInclude')

@stop
@stop
<!-- /content -->