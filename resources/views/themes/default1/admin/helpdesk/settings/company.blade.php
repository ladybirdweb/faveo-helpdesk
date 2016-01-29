@extends('themes.default1.admin.layout.admin')

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

<div class="box box-primary">
	<div class="box-header">
        <h4 class="box-title">{{Lang::get('lang.company')}}</h4>{!! Form::submit(Lang::get('lang.save'),['class'=>'form-group btn btn-primary pull-right'])!!}
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
            <b>Fail!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
    @endif

		<!-- Name text form Required -->
 		<div class="box-body">
            <div class="row">

            {{-- <div class="row"> --}}
				<div class="col-md-4">
                <!-- comapny name -->
                <div class="form-group {{ $errors->has('company_name') ? 'has-error' : '' }}">

                    {!! Form::label('company_name',Lang::get('lang.name')) !!}
			        {!! $errors->first('company_name', '<spam class="help-block">:message</spam>') !!}
					{!! Form::text('company_name',$companys->company_name,['class' => 'form-control']) !!}

                </div>
                </div>


                <div class="col-md-4">
                <!-- website -->
                <div class="form-group {{ $errors->has('website') ? 'has-error' : '' }}">

                    {!! Form::label('website',Lang::get('lang.website')) !!}
                    {!! $errors->first('website', '<spam class="help-block">:message</spam>') !!}
			        {!! Form::url('website',$companys->website,['class' => 'form-control']) !!}

                </div>
                </div>

                <div class="col-md-4">
                <!-- phone -->
                <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">

                    {!! Form::label('phone',Lang::get('lang.phone')) !!}
                    {!! $errors->first('phone', '<spam class="help-block">:message</spam>') !!}
			        {!! Form::text('phone',$companys->phone,['class' => 'form-control']) !!}

                </div>
                </div>

                	<div class="col-md-12">
                    <!-- comapny address -->
                    <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">

                        {!! Form::label('address',Lang::get('lang.address')) !!}
                        {!! $errors->first('address', '<spam class="help-block">:message</spam>') !!}
                        {!! Form::textarea('address',$companys->address,['class' => 'form-control','size' => '30x5']) !!}

                    </div>
                    </div>

                    {{-- <div class="col-md-4"> --}}
                    <!-- landing page -->
	                {{-- <div class="form-group"> --}}

	  		            {{-- {!! Form::label('landing_page',Lang::get('lang.landing')) !!} --}}
			            {{-- {!!Form::select('landing_page', ['landing page'],null,['class' => 'form-control select']) !!} --}}

		            {{-- </div> --}}
                    {{-- </div> --}}

                    {{-- <div class="col-md-4"> --}}
                    <!-- offline page -->
		            {{-- <div class="form-group"> --}}

				        {{-- {!! Form::label('offline_page',Lang::get('lang.offline')) !!} --}}
			            {{-- {!!FooterIncluderm::select('offline_page', ['offline page'],null,['class' => 'form-control select']) !!} --}}

			        {{-- </div> --}}
                  	{{-- </div> --}}

                    {{-- <div class="col-md-4"> --}}
                    <!-- thank page -->
		         	{{-- <div class="form-group"> --}}

						{{-- {!! Form::label('thank_page',Lang::get('lang.thank')) !!} --}}
						{{-- {!! Form::select('thank_page', ['thank page'],null,['class' => 'form-control select']) !!} --}}

					{{-- </div> --}}
            		{{-- </div> --}}

		       		<div class="col-md-2">
                    <!-- logo -->
               		
						{!! Form::label('logo',Lang::get('lang.logo')) !!}
                        <div class="btn bg-olive btn-file" style="color:blue"> Upload file
						{!! Form::file('logo') !!}
                        </div>
				
					</div>
                    @if($companys->logo != null)
                        <div class="col-md-2">
                            {!! Form::checkbox('use_logo') !!} <label> Use Logo</label>
                        </div>
                    @endif

                    <?php  $company = App\Model\helpdesk\Settings\Company::where('id', '=', '1')->first(); ?>

                    @if($companys->logo != null)
                        <div class="col-md-2">
                            <img src="{{asset('lb-faveo/media/company')}}{{'/'}}{{$company->logo}}" alt="User Image" width="100px" style="border:1px solid #DCD1D1" />
                        </div>
                    @endif
		    </div>
        </div>
    </div>

@stop