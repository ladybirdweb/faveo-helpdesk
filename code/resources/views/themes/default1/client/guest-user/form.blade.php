@extends('themes.default1.layouts.blank')
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


<!DOCTYPE html>
<html>
<head>
 <title></title>
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
</head>
<body>

<!--
|====================================================
| SELECT FROM
|====================================================
 -->
<?php
    $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
 ?>
<input id="token" type="hidden" value="{{$encrypted_token}}">
{!! Form::open(['action'=>'Guest\FormController@postedForm','method'=>'post']) !!}
<div class="box box-primary">
<div class="content-header">

        <h4>Ticket {!! Form::submit(Lang::get('lang.send'),['class'=>'form-group btn btn-primary pull-right'])!!}</h4>
    
    </div>
<div class="box-body">

		
		<div class="form-group {{ $errors->has('help_topic') ? 'has-error' : '' }}">

			{!! Form::label('help_topic',Lang::get('lang.help_topic')) !!}
			{!! $errors->first('help_topic', '<spam class="help-block">:message</spam>') !!}
			{!!Form::select('help_topic', [''=>'Select a Topic','Topics'=>'default Topic'],null,['id'=>'selectid','class' => 'form-control']) !!}
			
		</div>

<!-- <label>data</label> -->
<!-- <input name="stack" id="stack"/> -->


    <div id="ss" class="xs-md-6 form-group {{ $errors->has('') ? 'has-error' : '' }}">
        
    </div>
</div>
</div>



<!--
|====================================================
| SELECTED FORM STORED IN SCRIPT
|====================================================
 -->
<script type="text/javascript">

jQuery(document).ready(function($) {


    $('select').on('change', function (e) {
        var value = $('#selectid').val();
        var select = $('#selectid');


 //alert(select);
 var $_token = $('#token').val();
  var data1 = $(this).children('option:selected').data('id');
//alert('data1');
        $.ajax({
            type        :   "POST",
            headers		: 	{ 'X-XSRF-TOKEN' : $_token },
            url         :   "http://localhost/faveo/public/postform",
            dataType    :   'html',
            data        :   ({data2:data1}) ,
            

            success : function(response) {
                 
               //alert(response);
               //alert(response);
                    // $('#successMessage').text(response);
                     var data  = response;
                    var splited = data.split(',').slice(1);
                    //alert(splited);
                     // var splited1 = splited.split('-').slice(1);
                     // alert(splited1);
    

        $.each(splited, function (index, value)
        {

        	var splited = data.split(',').slice(1);
        	//alert(splited);
            $("#ss").html("");
        		for (var j = 0 ; j<splited.length; j++)
        		{
                    var sli = splited[j].split('-');
                   if(sli[0]=='textarea')
                   {
                    $("#ss").append(sli[1]+"<div class="+'"form-group"'+">"
                        +"<textarea id="+sli[1]+" class="+
                        'form-control'+" name="+sli[1]+"/></textarea>"+"</div>");
                   }
                    //var splited1 = splited[j].split('-');
                    //alert(value);
                    else
                    {      			
                    $("#ss").append(sli[1]+"<div class="+'"form-group"'+">"
                        +"<input type="+sli[0]+" id="+sli[1]+" class="+
                        'form-control'+" name="+sli[1]+">"+"</div>");
        	         }   
                }

        		return false;

        });
   

    

} 

})
        return false;

    });


});
s

</script>





@stop

