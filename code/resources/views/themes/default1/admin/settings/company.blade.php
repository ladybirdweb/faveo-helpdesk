@extends('themes.default1.layouts.blank')

@section('Settings')
class="active"
@stop

@section('settings-bar')
active
@stop

@section('company')
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

	{!! Form::model($companys,['url' => 'postcompany/'.$companys->id, 'method' => 'PATCH','files'=>true]) !!}

<!-- <div class="form-group {{ $errors->has('company_name') ? 'has-error' : '' }}"> -->
	<!-- table  -->

<div class="row">
<div class="col-md-12">
<div class="box box-primary">
	<div class="content-header">

		<div>
        	<h4>{{Lang::get('lang.company')}}{!! Form::submit(Lang::get('lang.save'),['class'=>'form-group btn btn-primary pull-right'])!!}</h4>
    	</div>

    </div>

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

		<!-- Name text form Required -->
 		<div class="box-body table-responsive"style="overflow:hidden;">
            <div class="row">
				<div class="col-md-4">
                <div class="form-group {{ $errors->has('company_name') ? 'has-error' : '' }}">

                    {!! Form::label('company_name',Lang::get('lang.name')) !!}
			        {!! $errors->first('company_name', '<spam class="help-block">:message</spam>') !!}
					{!! Form::text('company_name',$companys->company_name,['class' => 'form-control']) !!}

                </div>
                </div>


                <div class="col-md-4">
                <div class="form-group {{ $errors->has('website') ? 'has-error' : '' }}">

                    {!! Form::label('website',Lang::get('lang.website')) !!}
                    {!! $errors->first('website', '<spam class="help-block">:message</spam>') !!}
			        {!! Form::text('website',$companys->website,['class' => 'form-control']) !!}

                </div>
                </div>

                <div class="col-md-4">
                <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">

                    {!! Form::label('phone',Lang::get('lang.phone')) !!}
                    {!! $errors->first('phone', '<spam class="help-block">:message</spam>') !!}
			        {!! Form::text('phone',$companys->phone,['class' => 'form-control']) !!}

                </div>
                </div>

                	<div class="col-md-12">
                    <div class="form-group {{ $errors->has('company_address') ? 'has-error' : '' }}">

                        {!! Form::label('address',Lang::get('lang.address')) !!}
                        {!! $errors->first('company_address', '<spam class="help-block">:message</spam>') !!}
                        {!! Form::textarea('company_address',$companys->address,['class' => 'form-control','size' => '30x5']) !!}

                    </div>
                    </div>

                    <div class="col-md-4">
	                <div class="form-group">

	  		            {!! Form::label('landing_page',Lang::get('lang.landing')) !!}
			            {!!Form::select('landing_page', ['landing page'],null,['class' => 'form-control select']) !!}

		            </div>
                    </div>

                    <div class="col-md-4">
		            <div class="form-group">

				        {!! Form::label('offline_page',Lang::get('lang.offline')) !!}
			            {!!Form::select('offline_page', ['offline page'],null,['class' => 'form-control select']) !!}

			        </div>
                  	</div>

                    <div class="col-md-4">
		         	<div class="form-group">

						{!! Form::label('thank_page',Lang::get('lang.thank')) !!}
						{!!Form::select('thank_page', ['thank page'],null,['class' => 'form-control select']) !!}

					</div>
            		</div>

		       		<div class="col-md-4">
               		<div class="">

						{!! Form::label('logo',Lang::get('lang.logo')) !!}
						{!! Form::file('logo') !!}
					</div>
					</div>
		</div>

</div>
</div>
</div></div>
@stop
</div><!-- /.box -->
@section('FooterInclude')

@stop
@stop
<!-- /content -->
