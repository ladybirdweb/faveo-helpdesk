@extends('themes.default1.admin.layout.admin')
<link href="{{asset("lb-faveo/css/faveo-css.css")}}" rel="stylesheet" type="text/css" />

<style type="text/css">

    .container{
        margin-top:20px;
    }
    .image-preview-input {
        position: relative;
        overflow: hidden;
        margin: 0px;    
        color: #333;
        background-color: #fff;
        border-color: #ccc;    
    }
    .image-preview-input input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
    }
    .image-preview-input-title {
        margin-left:2px;
    }



    .container{
        margin-top:20px;
    }
    .image-preview-input1 {
        position: relative;
        overflow: hidden;
        margin: 0px;    
        color: #333;
        background-color: #fff;
        border-color: #ccc;    
    }
    .image-preview-input1 input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
    }
    .image-preview-input-title1 {
        margin-left:2px;
    }
</style>

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
{!! Form::model($companys,['url' => 'postcompany/'.$companys->id, 'method' => 'PATCH','files'=>true,'class'=>'upload-form']) !!}
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
            @if($errors->first('logo'))
            <li class="error-message-padding">{!! $errors->first('logo', ':message') !!}</li>
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

                    <input type="text" name="phone" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57"  value="{{$companys->phone}}"> 
                    <!-- {!! Form::text('phone',$companys->phone,['class' => 'form-control']) !!} -->
                </div>
            </div>
            <div class="col-md-12">
                <!-- comapny address -->
                <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                    {!! Form::label('address',Lang::get('lang.address')) !!}
                    {!! Form::textarea('address',$companys->address,['class' => 'form-control','size' => '30x5']) !!}
                </div>
            </div>

            <?php
                $company = App\Model\helpdesk\Settings\Company::where('id', '=', '1')->first();
                $portal = App\Model\helpdesk\Theme\Portal::where('id', '=', 1)->first();
                ?>
      
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Admin Panel</h3>
                      <!--   <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                        </div> -->

                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('admin_header_color') ? 'has-error' : '' }}">
                            {!! Form::label('admin_header_color',Lang::get('lang.header_color')) !!}<span class="text-red"> *</span></br>

                            <select name="admin_header_color" class="form-control" id="admin_header_color1">
                                <option value="" <?= $portal->admin_header_color == '0' ? ' selected="selected"' : ''; ?>>--Default--</option>
                                <option value="skin-blue" <?= $portal->admin_header_color == 'skin-blue' ? ' selected="selected"' : ''; ?>>Blue </option>
                                  <option value="skin-black"<?= $portal->admin_header_color == 'skin-black' ? ' selected="selected"' : ''; ?>>Black</option>

                             <option value="skin-green" <?= $portal->admin_header_color == 'skin-green' ? ' selected="selected"' : ''; ?>>Green</option>
                                <option value="skin-purple"<?= $portal->admin_header_color == 'skin-purple' ? ' selected="selected"' : ''; ?>>Purple</option>
                                <option value="skin-red" <?= $portal->admin_header_color == 'skin-red' ? ' selected="selected"' : ''; ?>>Red</option>
                                <option value="skin-yellow" <?= $portal->admin_header_color == 'skin-yellow' ? ' selected="selected"' : ''; ?>>Yellow</option>
                              

                            </select>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Agent Panel</h3>
                       <!--  <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                        </div> -->

                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('agent_header_color') ? 'has-error' : '' }}">
                            {!! Form::label('agent_header_color',Lang::get('lang.header_color')) !!}<span class="text-red"> *</span></br>

                            <select name="agent_header_color" class="form-control" id="agent_header_color1">
                                <option value="" <?= $portal->admin_header_color == '0' ? ' selected="selected"' : ''; ?>>--Default--</option>
                                <option value="skin-blue" <?= $portal->agent_header_color == 'skin-blue' ? ' selected="selected"' : ''; ?>>Blue </option>
                                 <option value="skin-black"<?= $portal->agent_header_color == 'skin-black' ? ' selected="selected"' : ''; ?>>Black</option>
                                
                                <option value="skin-green" <?= $portal->agent_header_color == 'skin-green' ? ' selected="selected"' : ''; ?>>Green</option>
                                <option value="skin-purple"<?= $portal->agent_header_color == 'skin-purple' ? ' selected="selected"' : ''; ?>>Purple</option>
                                <option value="skin-red" <?= $portal->agent_header_color == 'skin-red' ? ' selected="selected"' : ''; ?>>Red</option>
                                <option value="skin-yellow" <?= $portal->agent_header_color == 'skin-yellow' ? ' selected="selected"' : ''; ?>>Yellow</option>
                               

                            </select>

                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Client Panel</h3>
                <!-- <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div> -->

            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('client_header_color') ? 'has-error' : '' }}">
                            {!! Form::label('client_header_color',Lang::get('lang.header_color')) !!}<span class="text-red"> *</span></br>
                            @if($portal->client_header_color == 'null')
                            Default <input type="checkbox" name="client_header_color" id="client_header_color" value="1" checked="checked"></br>
                            <input class="form-control my-colorpicker1 colorpicker-element" id="colorpicker" type="text" name="client_header_color">
                            @else
                            Default <input type="checkbox" name="client_header_color" id="client_header_color" value="1"></br>
                            <input class="form-control my-colorpicker1 colorpicker-element" id="colorpicker" type="text" name="client_header_color" value="{{$portal->client_header_color}}">
                            @endif


                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('client_button_color') ? 'has-error' : '' }}">
                            {!! Form::label('client_button_color',Lang::get('lang.button_color')) !!}<span class="text-red"> *</span></br>
                            @if($portal->client_button_color == 'null')

                            Default <input type="checkbox" name="client_button_color" id="client_button_color" value="1"  checked="checked"></br>

                            <input class="form-control my-colorpicker1 colorpicker-element" id="colorpicker1" type="text" name="client_button_color">
                            @else

                            Default <input type="checkbox" name="client_button_color" id="client_button_color" value="1"></br>

                            <input class="form-control my-colorpicker1 colorpicker-element" id="colorpicker1" type="text" name="client_button_color" value="{{$portal->client_button_color}}">

                            @endif


                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('client_input_fild_color') ? 'has-error' : '' }}">
                            {!! Form::label('client_input_fild_color',Lang::get('lang.input_field_color')) !!}<span class="text-red"> *</span></br>
                            @if($portal->client_input_fild_color == 'null')
                            Default <input type="checkbox" name="client_input_fild_color" id="client_input_fild_color" value="1" checked="checked"></br>

                            <input class="form-control my-colorpicker1 colorpicker-element" id="colorpicker2" type="text" name="client_input_fild_color">

                            @else
                            Default <input type="checkbox" name="client_input_fild_color" id="client_input_fild_color" value="1" ></br>

                            <input class="form-control my-colorpicker1 colorpicker-element" id="colorpicker2" type="text" name="client_input_fild_color" value="{{$portal->client_input_fild_color}}">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('client_button_border_color') ? 'has-error' : '' }}">
                            {!! Form::label('client_button_border_color',Lang::get('lang.button_border_color')) !!}<span class="text-red"> *</span></br>
                            @if($portal->client_button_border_color == 'null')
                            Default <input type="checkbox" name="client_button_border_color" id="client_button_border_color" value="1" checked="checked"></br>

                            <input class="form-control my-colorpicker1 colorpicker-element" id="colorpicker3" type="text" name="client_button_border_color">
                            @else
                            Default <input type="checkbox" name="client_button_border_color" id="client_button_border_color" value="1" ></br>

                            <input class="form-control my-colorpicker1 colorpicker-element" id="colorpicker3" type="text" name="client_button_border_color" value="{{$portal->client_button_border_color}}">
                            @endif
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
                <?php
                $company = App\Model\helpdesk\Settings\Company::where('id', '=', '1')->first();
                $portal = App\Model\helpdesk\Theme\Portal::where('id', '=', 1)->first();
                ?>
                @if($companys->logo != null)
                <div class="col-md-2 image" data-content="{{Lang::get('lang.click-delete')}}">
                    <img src="{{asset('uploads/company')}}{{'/'}}{{$company->logo}}" alt="User Image" id="company-logo" width="100px" style="border:1px solid #DCD1D1" />
                </div>
                @endif
            </div>

                 </div>

            </div><!-- /.box-body -->
        </div><!-- /.box -->

        <?php
        $portal = App\Model\helpdesk\Theme\Portal::where('id', '=', 1)->first();
        ?>


        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Logo And Favicon</h3>
                <!-- <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div> -->
                <!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('logo',Lang::get('lang.logo')) !!}</br>

                            @if($portal->logo =='0')



                            Default <input type="checkbox" name="logo_admim_agent" id="logo_default" value="1" checked="checked">  &nbsp &nbsp

                            <img src="{{ asset("lb-faveo/media/images/logo.png")}}" class="img-rounded" alt="Cinque Terre" width="100" style="background-color:blue;">

                            </br></br>

                            <div id="logo_not_default">

                                <div class="container">
                                    <div class="row">    
                                        <div class="col-xs-5">  
                                            <!-- image-preview-filename input [CUT FROM HERE]-->
                                            <div class="input-group image-preview">
                                                <input type="text" class="form-control image-preview-filename" disabled="disabled"> 
                                                <!-- don't give a name === doesn't send on POST/GET -->
                                                <span class="input-group-btn">
                                                    <!-- image-preview-clear button -->
                                                    <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                                                        <span class="glyphicon glyphicon-remove"></span> Clear
                                                    </button>
                                                    <!-- image-preview-input -->
                                                    <div class="btn btn-default image-preview-input">
                                                        <span class="glyphicon glyphicon-folder-open"></span>
                                                        <span class="image-preview-input-title">Browse</span>
                                                        <input type="file" accept="image/png, image/jpeg, image/gif" name="logo_admim_agent"/> <!-- rename it -->
                                                    </div>
                                                </span>
                                            </div><!-- /input-group image-preview [TO HERE]--> 
                                        </div>
                                    </div>
                                </div>




                    <!-- <input class="upload-file" name="logo_admim_agent"  data-max-size="22,810" type="file" > -->
                                </br>


<!--   <input type="file" name="logo" id="logo" accept="image/*" style="height:28px; width:175px;" onchange="return ValidateFileUpload()"> -->
                            </div>

                            @else

                            Default <input type="checkbox" name="logo_admim_agent" id="logo_default" value="1">  &nbsp &nbsp



                            </br></br>

                            <div id="logo_not_default">


                                <div class="row">    
                                    <div class="col-xs-9">  
                                        <!-- image-preview-filename input [CUT FROM HERE]-->
                                        <div class="input-group image-preview">
                                            <input type="text" class="form-control image-preview-filename" disabled="disabled"> 
                                            <!-- don't give a name === doesn't send on POST/GET -->
                                            <span class="input-group-btn">
                                                <!-- image-preview-clear button -->
                                                <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                                                    <span class="glyphicon glyphicon-remove"></span> Clear
                                                </button>
                                                <!-- image-preview-input -->
                                                <div class="btn btn-default image-preview-input">
                                                    <span class="glyphicon glyphicon-folder-open"></span>
                                                    <span class="image-preview-input-title">Browse</span>
                                                    <input type="file" accept="image/png, image/jpeg, image/gif" name="logo_admim_agent"/> <!-- rename it -->
                                                </div>
                                            </span>
                                        </div><!-- /input-group image-preview [TO HERE]--> 
                                    </div>
                                </div>






                                </br>


                                <img src='{{ asset("uploads/logo/$portal->logo")}}' class="img-rounded" alt="Cinque Terre" width="100">



                            </div>

                            @endif






                        </div>
                    </div>




                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('icon',Lang::get('lang.icon')) !!}



                            </br>



                            @if($portal->icon =='0')
                            Default <input type="checkbox" name="icon" id="icon_default" value="1" checked="checked"> &nbsp &nbsp &nbsp &nbsp
                            <img src="{{asset("lb-faveo/media/images/favicon.ico")}}" rel="shortcut icon" width="40"> 


                            </br></br></br></br>

                            <div id="icon_not_default">


                                <div class="row">    
                                    <div class="col-xs-9">  
                                        <!-- image-preview-filename input [CUT FROM HERE]-->
                                        <div class="input-group image-preview1">
                                            <input type="text" class="form-control image-preview-filename1" disabled="disabled"> 
                                            <!-- don't give a name === doesn't send on POST/GET -->
                                            <span class="input-group-btn">
                                                <!-- image-preview-clear button -->
                                                <button type="button" class="btn btn-default image-preview-clear1" style="display:none;">
                                                    <span class="glyphicon glyphicon-remove"></span> Clear
                                                </button>
                                                <!-- image-preview-input -->
                                                <div class="btn btn-default image-preview-input1">
                                                    <span class="glyphicon glyphicon-folder-open"></span>
                                                    <span class="image-preview-input-title1">Browse</span>
                                                    <input type="file" accept="image/png, image/jpeg, image/gif" name="icon"/> <!-- rename it -->
                                                </div>
                                            </span>
                                        </div><!-- /input-group image-preview [TO HERE]--> 
                                    </div>
                                </div>
                                </br>

                            </div>
                            @else
                            Default <input type="checkbox" name="icon" id="icon_default" value="1"> &nbsp &nbsp &nbsp &nbsp


                            </br></br>


                            <div id="icon_not_default">

                                <div class="row">    
                                    <div class="col-xs-9">  
                                        <!-- image-preview-filename input [CUT FROM HERE]-->
                                        <div class="input-group image-preview1">
                                            <input type="text" class="form-control image-preview-filename1" disabled="disabled"> 
                                            <!-- don't give a name === doesn't send on POST/GET -->
                                            <span class="input-group-btn">
                                                <!-- image-preview-clear button -->
                                                <button type="button" class="btn btn-default image-preview-clear1" style="display:none;">
                                                    <span class="glyphicon glyphicon-remove"></span> Clear
                                                </button>
                                                <!-- image-preview-input -->
                                                <div class="btn btn-default image-preview-input1">
                                                    <span class="glyphicon glyphicon-folder-open"></span>
                                                    <span class="image-preview-input-title1">Browse</span>
                                                    <input type="file" accept="image/png, image/jpeg, image/gif" name="icon"/> <!-- rename it -->
                                                </div>
                                            </span>
                                        </div><!-- /input-group image-preview [TO HERE]--> 
                                    </div>
                                </div>


                            <!-- <input class="upload-file1" name="icon"  data-max-size="8,000" type="file" > -->
                                </br>

                                @if($portal->icon!='0')
                                <img src='{{ asset("uploads/icon/$portal->icon")}}' class="img-rounded" alt="Cinque Terre" width="40" style="background-color:#e0baba;">

                                @endif
                                <!-- <input type="file" name="icon" accept="image/*"> -->
                            </div>
                            @endif



                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->


        <script type="text/javascript">

            $(document).on('click', '#close-preview', function() {
                $('.image-preview').popover('hide');
                // Hover befor close the preview
                $('.image-preview').hover(
                        function() {
                            $('.image-preview').popover('show');
                        },
                        function() {
                            $('.image-preview').popover('hide');
                        }
                );
            });

            $(function() {
                // Create the close button
                var closebtn = $('<button/>', {
                    type: "button",
                    text: 'x',
                    id: 'close-preview',
                    style: 'font-size: initial;',
                });
                closebtn.attr("class", "close pull-right");
                // Set the popover default content
                $('.image-preview').popover({
                    trigger: 'manual',
                    html: true,
                    title: "<strong>Preview</strong>" + $(closebtn)[0].outerHTML,
                    content: "There's no image",
                    placement: 'bottom'
                });
                // Clear event
                $('.image-preview-clear').click(function() {
                    $('.image-preview').attr("data-content", "").popover('hide');
                    $('.image-preview-filename').val("");
                    $('.image-preview-clear').hide();
                    $('.image-preview-input input:file').val("");
                    $(".image-preview-input-title").text("Browse");
                });
                // Create the preview image
                $(".image-preview-input input:file").change(function() {
                    var img = $('<img/>', {
                        id: 'dynamic',
                        width: 150,
                        height: 100
                    });
                    var file = this.files[0];
                    var reader = new FileReader();
                    // Set preview image into the popover data-content
                    reader.onload = function(e) {
                        $(".image-preview-input-title").text("Change");
                        $(".image-preview-clear").show();
                        $(".image-preview-filename").val(file.name);
                        img.attr('src', e.target.result);
                        $(".image-preview").attr("data-content", $(img)[0].outerHTML).popover("show");
                    }
                    reader.readAsDataURL(file);
                });
            });



        </script>
        <script type="text/javascript">

            $(document).on('click', '#close-preview1', function() {
                $('.image-preview1').popover('hide');
                // Hover befor close the preview
                $('.image-preview1').hover(
                        function() {
                            $('.image-preview1').popover('show');
                        },
                        function() {
                            $('.image-preview1').popover('hide');
                        }
                );
            });

            $(function() {
                // Create the close button
                var closebtn = $('<button/>', {
                    type: "button",
                    text: 'x',
                    id: 'close-preview1',
                    style: 'font-size: initial;',
                });
                closebtn.attr("class", "close pull-right1");
                // Set the popover default content
                $('.image-preview1').popover({
                    trigger: 'manual',
                    html: true,
                    title: "<strong>Preview</strong>" + $(closebtn)[0].outerHTML,
                    content: "There's no image",
                    placement: 'bottom'
                });
                // Clear event
                $('.image-preview-clear1').click(function() {
                    $('.image-preview1').attr("data-content", "").popover('hide');
                    $('.image-preview-filename1').val("");
                    $('.image-preview-clear1').hide();
                    $('.image-preview-input1 input:file').val("");
                    $(".image-preview-input-title1").text("Browse");
                });
                // Create the preview image
                $(".image-preview-input1 input:file").change(function() {
                    var img = $('<img/>', {
                        id: 'dynamic1',
                        width: 150,
                        height: 100
                    });
                    var file = this.files[0];
                    var reader = new FileReader();
                    // Set preview image into the popover data-content
                    reader.onload = function(e) {
                        $(".image-preview-input-title1").text("Change");
                        $(".image-preview-clear1").show();
                        $(".image-preview-filename1").val(file.name);
                        img.attr('src', e.target.result);
                        $(".image-preview1").attr("data-content", $(img)[0].outerHTML).popover("show");
                    }
                    reader.readAsDataURL(file);
                });
            });



        </script>





        <script type="text/javascript">

            $(document).ready(function() {

                $("#admin_header_color").click(function() {
                    // alert('ok');
                    $("#admin_header_color1").toggle();
                });
                $("#agent_header_color").click(function() {
                    // alert('ok');
                    $("#agent_header_color1").toggle();
                });

                // client header color
                if ($("#client_header_color").attr("checked")) {
                    $('#colorpicker').val('');

                    $('#colorpicker').hide();

                    $("#client_header_color").click(function() {
                         $('#colorpicker').val('');

                        $("#colorpicker").toggle();
                    });
                } else {
                    $('#colorpicker').show();

                    $("#client_header_color").click(function() {

                        $("#colorpicker").val('');
                        $("#colorpicker").toggle();
                    });

                    

                }

                // client button color
                if ($("#client_button_color").attr("checked")) {

                    // alert('opoo');
                     $('#colorpicker1').val('');
                    $('#colorpicker1').hide();

                    $("#client_button_color").click(function() {
                        $('#colorpicker1').val('');
                        $("#colorpicker1").toggle();
                    });
                } else {
                    $('#colorpicker1').show();

                    $("#client_button_color").click(function() {
                        // alert('ok');
                         $("#colorpicker1").val('');
                        $("#colorpicker1").toggle();
                    });

                }

                // client input field color

                if ($("#client_input_fild_color").attr("checked")) {
                     $('#colorpicker2').val('');
                    $('#colorpicker2').hide();

                    $("#client_input_fild_color").click(function() {
                       $('#colorpicker2').val('');
                        $("#colorpicker2").toggle();
                    });
                } else {
                    $('#colorpicker2').show();

                    $("#client_input_fild_color").click(function() {
                       $("#colorpicker2").val('');
                        $("#colorpicker2").toggle();
                    });

                }


                // client button border color
                if ($("#client_button_border_color").attr("checked")) {
                     $('#colorpicker3').val('');
                    $('#colorpicker3').hide();

                    $("#client_button_border_color").click(function() {
                      $('#colorpicker3').val('');
                        $("#colorpicker3").toggle();
                    });
                } else {
                    $('#colorpicker3').show();

                    $("#client_button_border_color").click(function() {
                        $("#colorpicker3").val('');
                        $("#colorpicker3").toggle();
                    });

                }





                // logo

                if ($("#logo_default").attr("checked")) {
                    $('#logo_not_default').hide();

                    $("#logo_default").click(function() {
                        // alert('ok');

                        $("#logo_not_default").toggle();
                    });
                } else {
                    $('#logo_not_default').show();

                    $("#logo_default").click(function() {
                        // alert('ok');

                        $("#logo_not_default").toggle();
                    });

                }


                // favicon

                if ($("#icon_default").attr("checked")) {
                    $('#icon_not_default').hide();

                    $("#icon_default").click(function() {
                        // alert('ok');
                        $("#icon_not_default").toggle();
                    });

                } else {
                    $('#icon_not_default').show();

                    $("#icon_default").click(function() {
                        // alert('ok');
                        $("#icon_not_default").toggle();
                    });


                }





                // $("#logo_default").click(function() {
                //     // alert('ok');

                //     $("#logo_not_default").toggle();
                // });
                // $("#icon_default").click(function() {
                //     // alert('ok');
                //     $("#icon_not_default").toggle();
                // });




            });
        </script>


  <!-- <script>
$(function(){
    var fileInput = $('.upload-file');
    var maxSize = fileInput.data('max-size');
    // alert(maxSize);
    // $('.upload-form').submit(function(e){
        if(fileInput.get(0).files.length){
            var fileSize = fileInput.get(0).files[0].size; // in bytes
            if(fileSize>maxSize){
                alert('file size is more then' + maxSize + ' bytes');
                return false;
            }else{
                alert('file size is correct- '+fileSize+' bytes');
            }
        }else{
            alert('choose logo image, please');
            return false;
        }

    // });
});
    </script> -->

   <!--    <script>
$(function(){
    var fileInput = $('.upload-file1');
    var maxSize = fileInput.data('max-size');
    // alert(maxSize);
    // $('.upload-form').submit(function(e){
        if(fileInput){
        if(fileInput.get(0).files.length){
            var fileSize = fileInput.get(0).files[0].size; // in bytes
            if(fileSize>maxSize){
                alert('file size is more then' + maxSize + ' bytes');
                return false;
            }else{
                alert('file size is correct- '+fileSize+' bytes');
            }
        }else{
            alert('choose icon image, please');
            return false;
        }

    }

    // });
});
    </script>
        -->

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
<script>
    $(function() {

        $("#colorpicker").colorpicker();
        $("#colorpicker1").colorpicker();
        $("#colorpicker2").colorpicker();
        $("#colorpicker3").colorpicker();

    });
</script>
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
                    if (data) {
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


<script>

    function ValidateFileUpload() {
        alert('ok');
        var fuData = document.getElementById('logo');
        var FileUploadPath = fuData.value;
        alert(FileUploadPath);
        if (FileUploadPath == '') {
            alert("Please upload an image");
        } else {
            var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
            if (Extension == "gif" || Extension == "png" || Extension == "bmp"
                    || Extension == "jpeg" || Extension == "jpg") {
                if (fuData.files && fuData.files[0]) {
                    var size = fuData.files[0].size;
                    if (size > MAX_SIZE){
                        alert("Maximum file size exceeds");
                        return;
                    } else {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('#blah').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(fuData.files[0]);
                    }
                }
            }
        }
    }
</script>
@stop