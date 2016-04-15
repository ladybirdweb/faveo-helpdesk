@extends('themes.default1.admin.layout.admin')

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
     <div class="box">
       {!! Form::model($forms,['url' => 'forms/'.$forms->id,'method' => 'PATCH']) !!}

    <div class="form-group">
                <div class="box-header">
                    <h3 class="box-title">{!! Lang::get('lang.adding_fields') !!}</h3>
                </div>
                        <div class="callout callout-default col-md-4"> {!! Lang::get('lang.click_add_fields_button_to_add_fields') !!} </div>
                        <div class="col-md-4"> 
                            <button type="button" class="btn btn-primary addField" value="Show Div" onclick="showDiv()" ><i class="fa fa-plus"></i>&nbsp; {!! Lang::get('lang.add_fields') !!}</button>
                        </div>
    <div class="row">
     
        
    
    </div>
    
    <hr>
    <div class="box-body" id="welcomeDiv" >
       <table id="example2" class="table table-bordered table-striped">
                        <thead>
                        <th>{!! Lang::get('lang.label') !!} </th>
                        <th>{!! Lang::get('lang.name') !!} </th>
                        <th>{!! Lang::get('lang.type') !!} </th>
                        <th>{!! Lang::get('lang.values(selected_fields)') !!} </th>
                        <th>{!! Lang::get('lang.required') !!} </th>
                        <th>{!! Lang::get('lang.Action') !!} </th>
                        </thead>
                        <tbody class="inputField" id="inputField">
                        <p></p>
                            <tr></tr>  
                        </tbody>
       </table>
       
    </div>  
    <div class="box-footer">
        <input type="submit" class="btn btn-primary" value="{!! Lang::get('lang.save_form') !!}">
    </div>
    </div>
     </div>
<!--<script>
var string = '<h1>Paste your html sada</h1>';
var text = "";
var i;
var j=2;
for (i = 0; i < j; i++) {
    text += string ;
}
document.getElementById("sada").innerHTML = text;
</script>-->
<script>
    
    function showDiv() {
   document.getElementById('welcomeDiv').style.display = "block";
}

$(document).ready(function() {
    var max_fields      = 10;
    var wrapper         = $(".inputField"); 
    var add_button      = $(".addField"); 
    
   var j=5; 
    
     
        for (x = 1; x < j; x++) {
           
            $(wrapper).append('<tr><td><input type="text" name="label[]"></td><td><input type="text" name="name[]"></td><td><select name="type[]"><option>text</option><option>email</option><option>password</option><option>textarea</option><option>select</option><option>radio</option><option>checkbox</option><option>submit</option></select></td><td><textarea name="value[]"></textarea></td><td>{!! Lang::get("lang.yes") !!}&nbsp;&nbsp;<input type=radio name="required['+x+'][]" value=1 checked>&nbsp;&nbsp;{!! Lang::get("lang.no") !!}&nbsp;&nbsp;<input type=radio name="required['+x+'][]" value=0></td><td><button type="button" class="remove_field btn btn-danger"><i class="fa fa-trash-o"></i>&nbsp {!! Lang::get("lang.remove") !!}</button></td></tr>'); 
        }
  
    
    $(wrapper).on("click",".remove_field", function(e)
 {
        e.preventDefault(); $(this).closest('tr').remove(); x--;
    });
});
</script>

@stop
