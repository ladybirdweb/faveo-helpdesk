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

@section('HeadInclude')
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
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">{!! trans('lang.edit') !!}</h3>
    </div>
    <div class="box-header with-border">
        <h3 class="box-title">{!! trans('lang.instructions') !!}</h3>
        <div class="callout callout-default" style="font-style: oblique;">{!! trans('lang.instructions_on_creating_form') !!}.</div>
    </div>
    <div class="box-body with-border">
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        @endif
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif
        @if(Session::has('warn'))
        <div class="alert alert-warning alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('warn')}}
        </div>
        @endif
        <h3 class="box-title">{!! trans('lang.form_properties') !!}</h3>
        {!! Form::model($form,['route'=>['forms.update',$form->id],'method'=>'PATCH']) !!}
        <div class="form-group">
            <div class="row">
                <div class="col-md-4">    
                </div>  
            </div>
        </div>
        <div class="form-group">
            <div class="row" style="margin-top: 10px;">
                <div class="col-md-4">
                    <h4 style="text-align: center">{!! trans('lang.form_name') !!}: <span class="text-red"> *</span></h4>
                </div>
                <div class="col-md-4">
                    {!! Form::text('formname',null,['class'=>'form-control']) !!}
                    <!--<input type="text" name="formname" class="form-control">-->
                </div>
            </div>
        </div>
        <h3 class="box-title">{!! trans('lang.adding_fields') !!}</h3>
        <div class="callout callout-default col-md-4"> {!! trans('lang.click_add_fields_button_to_add_fields') !!} </div>
        <div class="col-md-4"> 
            <button type="button" class="btn btn-primary addField" value="Show Div" onclick="showDiv()" ><i class="fa fa-plus"></i>&nbsp; {!! trans('lang.add_fields') !!}</button>
        </div>
        <div class="row">
        </div>
        <div class="box-body" id="welcomeDiv">
            <table id="example2" class="table table-bordered table-striped">
                <thead>
                <th>{!! trans('lang.label') !!} </th>
                <th>{!! trans('lang.name') !!} </th>
                <th>{!! trans('lang.type') !!} </th>
                <th>{!! trans('lang.values(selected_fields)') !!} </th>
                <th>{!! trans('lang.required') !!} </th>
                <th>{!! trans('lang.action') !!} </th>
                </thead>
                <tbody class="inputField">

                    @forelse($fields as $key=>$field)

                    <tr>
                        <td><input type="text" name="label[]" value="{{$field->label}}" class="form-control"></td>
                        <td><input type="text" name="name[]" value="{{$field->name}}" class="form-control"></td>
                        
                        <td>{!! Form::select('type[]',['text'=>'text','email'=>'email','password'=>'password','textarea'=>'textarea','select'=>'select','radio'=>'radio','checkbox'=>'checkbox','hidden'=>'hidden'],$field->type,['class'=>'form-control']) !!}</td>
                        <td><input type="text" name="value[]" value="{{$field->valuesAsString()}}" class="form-control"></td>
                        
                        <td>{!! trans("lang.yes") !!}&nbsp;&nbsp;{!! Form::radio('required['.$key.']',1,true) !!}&nbsp;&nbsp;{!! trans("lang.no") !!}&nbsp;&nbsp;{!! Form::radio('required['.$key.']',0,$field->nonRequiredFieldForCheck()) !!}</td>
                        <td><button type="button" class="remove_field btn btn-danger"><i class="fa fa-trash-o"></i>&nbsp {!! trans("lang.remove") !!}</button></td>
                    </tr> 
                    @empty 

                    @endforelse

                </tbody>
            </table>
        </div>  
    </div>
    <div class="box-footer">
        <input type="submit" class="btn btn-primary" value="{!! trans('lang.save_form') !!}">
    </div>
</div>
{!! Form::close() !!}
<script>
    function showDiv() {
        document.getElementById('welcomeDiv').style.display = "block";
    }
    $(document).ready(function () {
        var max_fields = 10;
        var wrapper = $(".inputField");
        var add_button = $(".addField");
        var x = 1;
        $(add_button).click(function (e)
        {
            e.preventDefault();
            if (x < max_fields) {
                x++;
                $(wrapper).append('<tr>\n\
    <td><input type="text" class="form-control" name="label[]"></td>\n\
    <td><input type="text" class="form-control" name="name[]"></td>\n\
    <td><select name="type[]" class="form-control"><option>text</option><option>email</option><option>password</option><option>textarea</option><option>select</option><option>radio</option><option>checkbox</option><option>hidden</option></select>\n\
    </td><td><input type="text" name="value[]" class="form-control"></td>\n\
    <td>{!! trans("lang.yes") !!}&nbsp;&nbsp;<input type=radio name="required[]" value=1 checked>&nbsp;&nbsp;{!! trans("lang.no") !!}&nbsp;&nbsp;<input type=radio name="required[]" value=0></td>\n\
    <td><button type="button" class="remove_field btn btn-danger"><i class="fa fa-trash-o"></i>&nbsp {!! trans("lang.remove") !!}</button></td></tr>');
            }
        });
        $(wrapper).on("click", ".remove_field", function (e)
        {
            e.preventDefault();
            $(this).closest('tr').remove();
            x--;
        });
    });
</script>
@stop

