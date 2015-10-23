@extends('themes.default1.admin.layout.admin')

@section('Manage')
class="active"
@stop

@section('manage-bar')
active
@stop

@section('forms')
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
            
                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissable">
                        <i class="fa fa-ban"></i>
                        <b>Alert!</b> Success.
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{Session::get('success')}}       
                    </div>
                @endif
                @if(Session::has('fails'))
                    <div class="alert alert-danger alert-dismissable">
                        <i class="fa fa-ban"></i>
                        <b>Alert!</b>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{Session::get('fails')}}
                    </div>
                @endif

            <!-- -->    
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Instructions</h3>
                    <div class="callout callout-default" style="font-style: oblique;">Select field type you want to add to the form below and click on 'Type' dropdown. Don't forget to set field options if type is select,checkbox or radio..Separate each option by a coma. After you finish creating the form, you can save the form by clicking Save Form button.</div>
                </div>
                

                <hr style="margin-top:0px;margin-bottom:0px;">
                <div class="box-header">
                    <h3 class="box-title">Form Properties</h3>
                </div>
    {!! Form::open(['route'=>'forms.store']) !!}
    <div class="form-group">
    <div class="row">
    <div class="col-md-4">    
    </div></div></div>
    <div class="form-group">
    <div class="row" style="margin-top: 10px;">
  <div class="col-md-4">
        <h4 style="text-align: center">Form Name:</h4>
  </div>
        <div class="col-md-4">
    <input type="text" name="formname" class="form-control">
    </div>
        </div></div>
    <hr style="margin-top:0px;margin-bottom:0px;">
    <div class="form-group">
                <div class="box-header">
                    <h3 class="box-title">Adding Fields</h3>
                </div>
                        <div class="callout callout-default col-md-4"> Click <b>'Add Fields'</b> button to add Fields</div>
                        <div class="col-md-4"> 
                            <button type="button" class="btn btn-primary addField" value="Show Div" onclick="showDiv()" ><i class="fa fa-plus"></i>&nbsp; Add Fields</button>
                        </div>
    <div class="row">
     
        
    
    </div>
    
    <hr>
    <div class="box-body" id="welcomeDiv"  style="display:none;">
       <table id="example2" class="table table-bordered table-striped">
                        <thead>
                        <th>Label</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Values(Selected Fields)</th>
                        <th>Required</th>
                        <th>Action</th>
                        </thead>
                        <tbody class="inputField">
                            
                            <tr></tr>  
                        </tbody>
       </table>
    </div>  
    <div class="box-footer">
        <input type="submit" class="btn btn-primary" value="Save Form">
    </div>
       
       {!! Form::close() !!}


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
    function showDiv() {
   document.getElementById('welcomeDiv').style.display = "block";
}

$(document).ready(function() {
    var max_fields      = 10;
    var wrapper         = $(".inputField"); 
    var add_button      = $(".addField"); 
    
    var x = 1; 
    $(add_button).click(function(e)
    { 
        e.preventDefault();
        if(x < max_fields){ 
            x++;
            $(wrapper).append('<tr><td><input type="text" name="label[]"></td><td><input type="text" name="name[]"></td><td><select name="type[]"><option>text</option><option>email</option><option>password</option><option>textarea</option><option>select</option><option>radio</option><option>checkbox</option><option>submit</option></select></td><td><textarea name="value[]"></textarea></td><td>Yes&nbsp;&nbsp;<input type=radio name="required['+x+'][]" value=1 checked>&nbsp;&nbsp;No&nbsp;&nbsp;<input type=radio name="required['+x+'][]" value=0></td><td><button type="button" class="remove_field btn btn-danger"><i class="fa fa-trash-o"></i>&nbsp Remove</button></td></tr>'); 
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e)
 {
        e.preventDefault(); $(this).closest('tr').remove(); x--;
    });
});
</script>

@stop

@stop
<!-- /content -->