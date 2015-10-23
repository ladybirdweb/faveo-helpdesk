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
                    <div class="alert alert-success alert-dismissable">
                        <i class="fa fa-ban"></i>
                        <b>Alert!</b> Fail.
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{Session::get('fails')}}
                    </div>
                @endif
            <!-- -->    
<div class="box">
    <div class="box-header">
   <?php $id = App\Model\helpdesk\Form\Forms::where('id',$id)->first(); ?>
    <h3 class="box-title">Form Name : {!! $id->formname !!}</h3>
 
    </div>
        <div class="box-body">
<?php
    $i=$id->id;
    $values = App\Model\helpdesk\Form\Fields::where('forms_id', '=', $i)->get();    
        foreach($values as $value) {
        if($value->type == "select") {
        
            $data = $value->value;
            $value = explode(',', $data);
            echo '<select class="form-control">';
            foreach($value as $option) {
                echo '<option>'.$option.'</option>';
            }
            echo '</select></br></br>';
        } elseif ($value->type == "radio" ) {
         
            $type2 = $value->value;
            $val = explode(',', $type2);
             
            echo '<label class="radio-inline">'.$value->label.'</label>&nbsp&nbsp&nbsp<input type="'.$value->type.'" name="'.$value->name.'">&nbsp;&nbsp;'.$val[0].'
            &nbsp&nbsp&nbsp<input type="'.$value->type.'" name="'.$value->name.'">&nbsp;&nbsp;'.$val[1].'</br></br>';
        
        } elseif($value->type == "textarea" ) {
            $type3 = $value->value;
            $v = explode(',', $type3); 
            echo '<label>'.$value->label.'</label></br><textarea rows="'.$v[0].'" cols="'.$v[1].'"></textarea></br></br>';
         
            
        } elseif($value->type == "checkbox" ) {
         
            $type4 = $value->value;
            $check = explode(',', $type4);
            echo '<label class="radio-inline">'.$value->label.'&nbsp&nbsp&nbsp<input type="'.$value->type.'" name="'.$value->name.'">&nbsp&nbsp'.$check[0].'</label>
            <label class="radio-inline"><input type="'.$value->type.'" name="'.$value->name.'">&nbsp&nbsp'.$check[1].'</label></br></br>'; 
         
        } else {
         
        echo '<label>'.$value->label.'</label><input type="'.$value->type.'" class="form-control"   name="'.$value->name.'" /></br></br>';
         }
    }
    ?>             
    </div>
    </div>
@stop
