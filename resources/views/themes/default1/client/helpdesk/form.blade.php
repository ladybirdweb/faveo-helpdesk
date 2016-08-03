@extends('themes.default1.client.layout.client')

@section('title')
{!! Lang::get('lang.submit_a_ticket') !!} -
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
<div class="banner-wrapper  clearfix">
    <h3 class="banner-title text-center text-info h4">{!! Lang::get('lang.have_a_ticket') !!}?</h3>
    @if(Session::has('check'))
    @if (count($errors) > 0)
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <b>{!! Lang::get('lang.alert') !!} !</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </div>
    @endif
    @endif
    <div class="banner-content text-center">
        {!! Form::open(['url' => 'checkmyticket' , 'method' => 'POST'] )!!}
        {!! Form::label('email',Lang::get('lang.email')) !!}<span class="text-red"> *</span>
        {!! Form::text('email_address',null,['class' => 'form-control']) !!}
        {!! Form::label('ticket_number',Lang::get('lang.ticket_number')) !!}<span class="text-red">*</span>
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
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {!! Session::get('message') !!}
    </div>
    @endif
    @if (count($errors) > 0)
    @if(Session::has('check'))
    <?php goto a; ?>
    @endif
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <b>{!! Lang::get('lang.alert') !!} !</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    <?php a: ?>
    @endif
    <!-- open a form -->
    {{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script> --}}
    <script src="{{asset("lb-faveo/js/jquery2.0.2.min.js")}}" type="text/javascript"></script>
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
    {!! Form::open(['action'=>'Client\helpdesk\FormController@postedForm','method'=>'post', 'enctype'=>'multipart/form-data']) !!}
    <div>
        <div class="content-header">
            <h4>{!! Lang::get('lang.ticket') !!} </h4>
        </div>
        <div class="row col-md-12">
            <div class="col-md-12 form-group {{ $errors->has('help_topic') ? 'has-error' : '' }}">
                {!! Form::label('help_topic', Lang::get('lang.choose_a_help_topic')) !!} 
                {!! $errors->first('help_topic', '<spam class="help-block">:message</spam>') !!}
                <?php
                $forms = App\Model\helpdesk\Form\Forms::get();
                $helptopic = App\Model\helpdesk\Manage\Help_topic::where('status', '=', 1)->get();
                ?>                  
                <select name="helptopic" class="form-control" id="selectid">
                    <?php
                    $system_default_department = App\Model\helpdesk\Settings\System::where('id', '=', 1)->first();
                    if (isset($system_default_department->department)) {
                        $department_relation_helptopic = App\Model\helpdesk\Manage\Help_topic::where('department', '=', $system_default_department->department)->first();
                        $default_helptopic = $department_relation_helptopic->id;
                    } else {
                        $default_helptopic = 0;
                    }
                    ?>
                    @foreach($helptopic as $topic)
                    <option value="{!! $topic->id !!}">{!! $topic->topic !!}</option>
                    @endforeach
                </select>
            </div>
            
                @if(Auth::user())
                    
                        {!! Form::hidden('Name',Auth::user()->user_name,['class' => 'form-control']) !!}
                    
                @else
                    <div class="col-md-12 form-group {{ $errors->has('Name') ? 'has-error' : '' }}">
                        {!! Form::label('Name',Lang::get('lang.name')) !!}<span class="text-red"> *</span>
                        {!! Form::text('Name',null,['class' => 'form-control']) !!}
                    </div>
                @endif
            
            

                @if(Auth::user())
                    
                        {!! Form::hidden('Email',Auth::user()->email,['class' => 'form-control']) !!}
                    
                @else
                    <div class="col-md-12 form-group {{ $errors->has('Email') ? 'has-error' : '' }}">
                        {!! Form::label('Email',Lang::get('lang.email')) !!}<span class="text-red"> *</span>
                        {!! Form::text('Email',null,['class' => 'form-control']) !!}
                    </div>
                @endif



                
            
                @if(!Auth::user())
                    
            <div class="col-md-2 form-group {{ Session::has('country_code_error') ? 'has-error' : '' }}">
                {!! Form::label('Code',Lang::get('lang.country-code')) !!}
                {!! Form::text('Code',null,['class' => 'form-control', 'placeholder' => $phonecode, 'title' => Lang::get('lang.enter-country-phone-code')]) !!}
            </div>
            <div class="col-md-5 form-group {{ $errors->has('Phone') ? 'has-error' : '' }}">
                {!! Form::label('Mobile',Lang::get('lang.mobile_number')) !!}
                {!! Form::text('Mobile',null,['class' => 'form-control']) !!}
            </div>
            <div class="col-md-5 form-group {{ $errors->has('Phone') ? 'has-error' : '' }}">
                {!! Form::label('Phone',Lang::get('lang.phone')) !!}
                {!! Form::text('Phone',null,['class' => 'form-control']) !!}
            </div>
              @endif
            <div class="col-md-12 form-group {{ $errors->has('Subject') ? 'has-error' : '' }}">
                {!! Form::label('Subject',Lang::get('lang.subject')) !!}<span class="text-red"> *</span>
                {!! Form::text('Subject',null,['class' => 'form-control']) !!}
            </div>
            <div class="col-md-12 form-group {{ $errors->has('Details') ? 'has-error' : '' }}">
                {!! Form::label('Details',Lang::get('lang.message')) !!}<span class="text-red"> *</span>
                {!! Form::textarea('Details',null,['class' => 'form-control']) !!}
            </div>
            <div class="col-md-12 form-group">
                <div class="btn btn-default btn-file"><i class="fa fa-paperclip"> </i> {!! Lang::get('lang.attachment') !!}<input type="file" name="attachment[]" multiple/></div><br/>
                {!! Lang::get('lang.max') !!}. 10MB
            </div>
            {{-- Event fire --}}
            <?php Event::fire(new App\Events\ClientTicketForm()); ?>
            <div class="col-md-12" id="response"> </div>
            <div id="ss" class="xs-md-6 form-group {{ $errors->has('') ? 'has-error' : '' }}"> </div>
            <div class="col-md-12 form-group">{!! Form::submit(Lang::get('lang.Send'),['class'=>'form-group btn btn-info pull-left', 'onclick' => 'this.disabled=true;this.value="Sending, please wait...";this.form.submit();'])!!}</div>
        </div>
        <div class="col-md-12" id="response"> </div>
        <div id="ss" class="xs-md-6 form-group {{ $errors->has('') ? 'has-error' : '' }}"> </div>
    </div>
    {!! Form::close() !!}
</div>
<!--
|====================================================
| SELECTED FORM STORED IN SCRIPT
|====================================================
-->
<script type="text/javascript">
$('#selectid').on('change', function() {
    var value = $('#selectid').val();
    $.ajax({
        url: "postform/" + value,
        type: "post",
        data: value,
        success: function(data) {
            $('#response').html(data);
            var wysihtml5Editor = $('#unique-textarea').wysihtml5().data("wysihtml5").editor;
        }
    });
});

$(function() {
//Add text editor
    $("textarea").wysihtml5();
});
</script>
@stop