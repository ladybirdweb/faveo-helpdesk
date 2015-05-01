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
<select>
<option data-id="form" value="form">form</option>
<option data-id="forma" value="forma">forma</option>
</select>
<br/>
<!-- <label>data</label> -->
<!-- <input name="stack" id="stack"/> -->



<!--
|====================================================
| SELECTED FORM STORED IN SCRIPT
|====================================================
 -->
<script type="text/javascript">

jQuery(document).ready(function($) {
    $('select').on('change', function (e) {
 //alert('hello2');
 var $_token = $('#token').val();
  var data1 = $(this).children('option:selected').data('id');
//alert('data1');
        $.ajax({
            type        :   "POST",
            cache		: 	false,
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
		for (var j = 0 ; j<splited.length; j++)
		{

			//var splited1 = splited[j].split('-');
			//alert(splited1);
			
			var sli = splited[j].split('-');

	        	document.write(sli[1]+"<div class="+'form-group'+">"+"<input type="+sli[0]+" id="+sli[1]+" class="+'form-control'+" name="+sli[1]+"/>"+"</div>");
	    	

		}
		

   
    return false;
});




                     
            }
        })
        return false;
    });
});

</script>





@stop
@section('FooterInclude')

@stop

<!-- /content -->