@extends('themes.default1.admin.layout.admin')
<link href="{{asset("lb-faveo/css/faveo-css.css")}}" rel="stylesheet" type="text/css" />
@section('Settings')
active
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
<h1>{{ Lang::get('lang.settings') }}</h1>
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
    <div class="box-header with-border">
        <h3 class="box-title">{{Lang::get('lang.company_settings')}}</h3>
    </div>
    <!-- Name text form Required -->
    <div class="box-body">
        <!-- check whether success or not -->
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!!Session::get('success')!!}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!!Session::get('fails')!!}
        </div>
        @endif

        @if(Session::has('errors'))
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @if($errors->first('company_name'))
            <li class="error-message-padding">{!! $errors->first('company_name', ':message') !!}</li>
            @endif
            @if($errors->first('website'))
            <li class="error-message-padding">{!! $errors->first('website', ':message') !!}</li>
            @endif
            @if($errors->first('phone'))
            <li class="error-message-padding">{!! $errors->first('phone', ':message') !!}</li>
            @endif
        </div>
        @endif
        <div class="row">
            <div class="col-md-4">
                <!-- comapny name -->
                <div class="form-group {{ $errors->has('company_name') ? 'has-error' : '' }}">
                    {!! Form::label('company_name',Lang::get('lang.name')) !!} <span class="text-red"> *</span>
                    {!! Form::text('company_name',$companys->company_name,['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <!-- website -->
                <div class="form-group {{ $errors->has('website') ? 'has-error' : '' }}">
                    {!! Form::label('website',Lang::get('lang.website')) !!}
                    {!! Form::url('website',$companys->website,['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <!-- phone -->
                <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                    {!! Form::label('phone',Lang::get('lang.phone')) !!}
                    {!! Form::text('phone',$companys->phone,['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-md-12">
                <!-- comapny address -->
                <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                    {!! Form::label('address',Lang::get('lang.address')) !!}
                    {!! Form::textarea('address',$companys->address,['class' => 'form-control','size' => '30x5']) !!}
                </div>
            </div>
            <div class="col-md-2">
                <!-- logo -->
                {!! Form::label('logo',Lang::get('lang.logo')) !!}
                <div class="btn bg-olive btn-file" style="color:blue"> Upload file
                    {!! Form::file('logo') !!}
                </div>
            </div>
            <div id="logo-display" style="display: block;">
                @if($companys->logo != null)
                <div class="col-md-2">
                    {!! Form::checkbox('use_logo') !!} <label> {!! Lang::get('lang.use_logo') !!}</label>
                </div>
                @endif
                <?php $company = App\Model\helpdesk\Settings\Company::where('id', '=', '1')->first(); ?>
                @if($companys->logo != null)
                <div class="col-md-2 image" data-content="{{Lang::get('lang.click-delete')}}">
                    <img src="{{asset('uploads/company')}}{{'/'}}{{$company->logo}}" alt="User Image" id="company-logo" width="100px" style="border:1px solid #DCD1D1" />
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit(Lang::get('lang.submit'),['class'=>'form-group btn btn-primary'])!!}
    </div>
    <!-- Modal -->   
    <div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; padding-right: 15px;background-color: rgba(0, 0, 0, 0.7);">
        <div class="modal-dialog" role="document">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close closemodal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                    </div>
                    <div class="modal-body" id="custom-alert-body" >
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary pull-left yes" data-dismiss="modal"></button>
                        <button type="button" class="btn btn-default no"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".image").on("click", function() {
            $("#myModal").css("display", "block");
            $("#myModalLabel").html("{!! Lang::get('lang.delete-logo') !!}");
            $(".yes").html("{!! Lang::get('lang.yes') !!}");
            $(".no").html("{{Lang::get('lang.cancel')}}");
            $("#custom-alert-body").html("{{Lang::get('lang.confirm')}}");
        });
        $('.no,.closemodal').on("click", function() {
            $("#myModal").css("display", "none");
        });
        $('.yes').on('click', function() {
            var src = $('#company-logo').attr('src').split('/');
            var file = src[src.length - 1];

            var path = "uploads/company/" + file;
            // alert(path); 
            $.ajax({
                type: "GET",
                url: "{{route('delete.logo')}}",
                dataType: "html",
                data: {data1: path},
                success: function(data) {
                    if (data == "true") {
                        var msg = "Logo deleted succesfully."
                        $("#logo-display").css("display", "none");
                        $("#myModal").css("display", "none");
                    } else {
                        $("#myModal").css("display", "none");
                    }
                }
            });
        });
    });
</script>
@stop