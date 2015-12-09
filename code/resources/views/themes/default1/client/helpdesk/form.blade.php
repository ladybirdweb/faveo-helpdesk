@extends('themes.default1.client.layout.client')

@section('title')
    Submit A Ticket -
@stop

@section('submit')
    class = "active"
@stop
<!-- breadcrumbs -->
@section('breadcrumb')
    <div class="site-hero clearfix">
        <ol class="breadcrumb breadcrumb-custom">
            <li class="text">{!! Lang::get('lang.you_are_here') !!}: </li>
            <li><a href="{!! URL::route('form') !!}">{!! Lang::get('lang.submit_a_ticket') !!}</a></li>
        </ol>
    </div>
@stop
<!-- /breadcrumbs -->
@section('check')
    <div class="banner-wrapper text-center clearfix">
        <h3 class="banner-title text-info h4">{!! Lang::get('lang.have_a_ticket') !!}?</h3>
        <div class="banner-content">
        {!! Form::open(['url' => 'checkmyticket' , 'method' => 'POST'] )!!}
    
            {!! Form::label('email',Lang::get('lang.email')) !!}
            {!! $errors->first('email', '<spam class="help-block">:message</spam>') !!}
            {!! Form::text('email',null,['class' => 'form-control']) !!}
                
            {!! Form::label('ticket_number',Lang::get('lang.ticket_number'),['style' => 'display: block']) !!}
            {!! $errors->first('ticket_number', '<spam class="help-block">:message</spam>') !!}
            {!! Form::text('ticket_number',null,['class' => 'form-control']) !!}
            <br/><input type="submit" value="{!! Lang::get('lang.check_ticket_status') !!}" class="btn btn-info">
                        
        {!! Form::close() !!}
        </div>
    </div>  
@stop
<!-- content -->
@section('content')
<div id="content" class="site-content col-md-9">
    @if(Session::has('message'))
    <div class="alert alert-success alert-dismissable">
        <i class="fa  fa-check-circle"></i>
        <b>Success!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('message')}}
    </div>
    @endif
    

<!-- open a form -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
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
{!! Form::open(['action'=>'Client\helpdesk\FormController@postedForm','method'=>'post']) !!}
<div>
    <div class="content-header">
        <h4>{!! Lang::get('lang.ticket') !!} {!! Form::submit(Lang::get('lang.send'),['class'=>'form-group btn btn-info pull-right'])!!}</h4>
    </div>
    <div class="row col-md-12">
        <div class="col-md-12 form-group {{ $errors->has('help_topic') ? 'has-error' : '' }}">
            {!! Form::label('help_topic', Lang::get('lang.choose_a_help_topic')) !!} 
            {!! $errors->first('help_topic', '<spam class="help-block">:message</spam>') !!}
<?php 
$forms = App\Model\helpdesk\Form\Forms::get(); 
$helptopic = App\Model\helpdesk\Manage\Help_topic::get();
?>                  
            <select name="helptopic" class="form-control" id="selectid">
            <?php  
            $system_default_department = App\Model\helpdesk\Settings\System::where('id','=',1)->first();
            if($system_default_department->department) {
                $department_relation_helptopic = App\Model\helpdesk\Manage\Help_topic::where('department','=',$system_default_department->department)->first();
                $default_helptopic = $department_relation_helptopic->id;
            } else {
                $default_helptopic = 0;
            }

             ?>  
                <option value="{!! $default_helptopic !!}">Default</option>
                @foreach($helptopic as $topic)
                    <option value="{!! $topic->id !!}">{!! $topic->topic !!}</option>
                @endforeach
                {{-- @foreach($forms as $key=>$value) --}}
                    {{-- <option value="{!! $value->id !!}">{!! ucfirst($value->formname) !!}</option> --}}
                {{-- @endforeach --}}
            </select>
        </div>
        <div class="col-md-12 form-group {{ $errors->has('Name') ? 'has-error' : '' }}">

            {!! Form::label('Name',Lang::get('lang.name')) !!}
            {!! $errors->first('Name', '<spam class="help-block">:message</spam>') !!}
            {!! Form::text('Name',null,['class' => 'form-control']) !!}

        </div>
        
        <div class="col-md-6 form-group {{ $errors->has('Email') ? 'has-error' : '' }}">

            {!! Form::label('Email',Lang::get('lang.email')) !!}
            {!! $errors->first('Email', '<spam class="help-block">:message</spam>') !!}
            {!! Form::text('Email',null,['class' => 'form-control']) !!}

        </div>
        <div class="col-md-6 form-group {{ $errors->has('Phone') ? 'has-error' : '' }}">

            {!! Form::label('Phone',Lang::get('lang.phone')) !!}
            {!! $errors->first('Phone', '<spam class="help-block">:message</spam>') !!}
            {!! Form::text('Phone',null,['class' => 'form-control']) !!}

        </div>
        <div class="col-md-12 form-group {{ $errors->has('Subject') ? 'has-error' : '' }}">

            {!! Form::label('Subject',Lang::get('lang.subject')) !!}
            {!! $errors->first('Subject', '<spam class="help-block">:message</spam>') !!}
            {!! Form::text('Subject',null,['class' => 'form-control']) !!}

        </div>
        <div class="col-md-12 form-group {{ $errors->has('Details') ? 'has-error' : '' }}">

            {!! Form::label('Details',Lang::get('lang.message')) !!}
            {!! $errors->first('Details', '<spam class="help-block">:message</spam>') !!}
            {!! Form::textarea('Details',null,['class' => 'form-control']) !!}

        </div>
        {{-- Event fire --}}
        <?php Event::fire(new App\Events\ClientTicketForm()); ?>
        
        <div class="col-md-12" id="response"> </div>
        <div id="ss" class="xs-md-6 form-group {{ $errors->has('') ? 'has-error' : '' }}"> </div>
    </div>
</div>
{!! Form::close() !!}
</div>
<!--
|====================================================
| SELECTED FORM STORED IN SCRIPT
|====================================================
 -->
<script type="text/javascript">

$('#selectid').on('change',function() {
    var value = $('#selectid').val();
    $.ajax({
        url:  "postform/"+ value,
        type: "post",
        data: value,
        success: function(data) {
        $('#response').html(data);
        //location.reload();
        }
    });
});

$(function () {
    //Add text editor
    $("textarea").wysihtml5();
});

</script>

@stop