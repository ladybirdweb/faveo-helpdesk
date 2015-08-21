@extends('themes.default1.layouts.installer')
@section('content')
<script type="text/javascript">
// function toUnicode(elmnt,content)
// {
//     if (content.length==elmnt.maxLength)
//     {
//         next=elmnt.tabIndex
//         if (next<document.forms[0].elements.length)
//         {
//             document.forms[0].elements[next].focus()
//         }
//     }
// }
</script>

<h1>Enter Serial Key</h1>
    <div class="login-box-body">
                    @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissable">
                        <i class="fa fa-ban"></i>
                        <b>Alert!</b> Success.
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{Session::get('success')}}
                    </div>
                    @endif
                    <!-- fail message -->
                    @if(Session::has('fails'))
                    <div class="alert alert-danger alert-dismissable">
                        <i class="fa fa-ban"></i>
                        <b>Alert!</b> Failed.
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{Session::get('fails')}}
                    </div>
                    @endif
 <!-- form -->
<form action="http://www.faveohelpdesk.com/bill/serial" method="post">
<input type="hidden" name="domain" value="http://{{ $_SERVER['HTTP_HOST'] }}">
<input type="hidden" name="url" value="http://{{$_SERVER['HTTP_HOST']}}{{$_SERVER['REQUEST_URI']}}">
<input type="hidden" name="_token" value="{{csrf_token()}}">
   
<div class="form-group {{ $errors->has('order_no') ? 'has-error' : '' }}">
  <!-- first name -->
   {!! Form::label('order_no','Order Number') !!}
   {!! $errors->first('order_no', '<spam class="help-block">:message</spam>') !!}
   {!! Form::text('order_no',null,['class' => 'form-control']) !!}
</div>

    <div class="form-group {{ $errors->has('serial') ? 'has-error' : '' }}">
    <!-- last name -->
    {!! Form::label('serial','Serial Key') !!}
    {!! $errors->first('serial', '<spam class="help-block">:message</spam>') !!}
        <div class="row">
            <div class="col-md-3">
                <input size="4" tabindex="3" name="first" maxlength="4" class="form-control" onkeyup="toUnicode(this,this.value)" >
            </div>
            <div class="col-md-3">
                <input size="4" tabindex="3" name="second" maxlength="4" class="form-control" onkeyup="toUnicode(this,this.value)"> 
            </div>
            <div class="col-md-3">
                <input size="4" tabindex="3" name="third" maxlength="4" class="form-control" onkeyup="toUnicode(this,this.value)"> 
            </div>
            <div class="col-md-3">
                <input size="4" tabindex="3" name="forth" maxlength="4"  class="form-control" onkeyup="toUnicode(this,this.value)">
            </div>
        </div>
    </div>
    <div class="form-group ">
        {!! Form::submit("Submit",['class'=>'form-group btn btn-primary'])!!}
    </div>
</form>
</div>

@stop