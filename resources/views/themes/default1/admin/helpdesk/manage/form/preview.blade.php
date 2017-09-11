@extends('themes.default1.admin.layout.admin')

@section('Manage')
active
@stop

@section('manage-bar')
active
@stop

@section('forms')
class="active"
@stop

<!-- header -->
@section('PageHeader')
<h1>{!! trans('lang.forms') !!}</h1>
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
@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <i class="fa fa-check-circle"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('success')}}
</div>
@endif
@if(Session::has('fails'))
<div class="alert alert-success alert-dismissable">
    <i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <b>{!! trans('lang.alert') !!} !</b> <br>
    <li class="error-message-padding">{{Session::get('fails')}}</li>
</div>
@endif
<!-- -->    
<div class="box">
    <div class="box-header">
        <h3 class="box-title">{!! trans('lang.form_name') !!} : {!! $form->formname !!}</h3>
    </div>
    <div class="box-body">
        @foreach($fields as $field)
        <?php
        $form = App\Http\Controllers\Admin\helpdesk\FormController::getForm($field);
        ?>

        {!! $form !!}
          
<!--        <script>
            $("[name='{{$field->name}}']").on('change', function () {
                var valueid = $("[name='{{$field->name}}']").val();
                alert(valueid);
                send(valueid);
            });
            function send(valueid) {
                $.ajax({
                    url: "{{url('forms/render/child/'.$field->id)}}",
                    dataType: "html",
                    data: {'valueid': valueid},
                    success: function (response) {
                        $("#{{$field->name}}").html(response);
                    },
                    error: function (response) {
                        $("#{{$field->name}}").html(response);
                    }
                });
            }
        </script>-->
        @endforeach         
    </div>
</div>
@stop
@section('FooterInclude')

@stop
