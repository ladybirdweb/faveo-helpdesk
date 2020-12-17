@extends('themes.default1.client.layout.client')

@section('title')
{!! Lang::get('lang.submit_a_ticket') !!} -
@stop

@section('submit')
class = "nav-item active"
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
    
    <div id="sidebar" class="site-sidebar col-md-3">

        <div id="form-border" class="comment-respond form-border" style="background : #fff">

            <section id="section-categories" class="section">
        
                <h2 class="section-title h4 clearfix">

                    <i class="line"></i>{!! Lang::get('lang.have_a_ticket') !!}?
                </h2>

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

                <div>
                     {!! Form::open(['url' => 'checkmyticket' , 'method' => 'POST'] )!!}
                    {!! Form::label('email',Lang::get('lang.email')) !!}<span class="text-red"> *</span>
                    {!! Form::text('email_address',null,['class' => 'form-control']) !!}
                    {!! Form::label('ticket_number',Lang::get('lang.ticket_number')) !!}<span class="text-red"> *</span>
                    {!! Form::text('ticket_number',null,['class' => 'form-control']) !!}
                    <br/><input type="submit" value="{!! Lang::get('lang.check_ticket_status') !!}" class="btn btn-info">
                    {!! Form::close() !!}
                </div>
            </section>
        </div>
    </div><!-- #sidebar -->
@stop
<!-- content -->
@section('content')

    <div id="content" class="site-content col-md-9">

        @if(Session::has('message'))
        <div class="alert alert-success alert-dismissable">
            <i class="fas  fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! Session::get('message') !!}
        </div>
        @endif
        @if (count($errors) > 0)
        @if(Session::has('check'))
        <?php goto a; ?>
        @endif
        @if(!Session::has('error'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fas fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!} !</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <?php a: ?>
        @endif

        <?php
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        ?>
        <input id="token" type="hidden" value="{{$encrypted_token}}">
        {!! Form::open(['action'=>'Client\helpdesk\FormController@postedForm','method'=>'post', 'enctype'=>'multipart/form-data']) !!}

        <article class="hentry">

            <div id="form-border" class="comment-respond form-border" style="background : #fff">
                
                <section id="section-categories">
            
                    <h2 class="section-title h4 clearfix mb-0">

                        <i class="line"></i>{!! Lang::get('lang.submit_a_ticket') !!}
                    </h2>

                    <div class="row mt-4">
                      
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
                            {!! Form::label('Email',Lang::get('lang.email')) !!}
                            @if($email_mandatory->status == 1 || $email_mandatory->status == '1')
                                <span class="text-red"> *</span>
                            @endif
                            {!! Form::email('Email',null,['class' => 'form-control']) !!}
                        </div>
                        @endif

                        @if(!Auth::user())
                    
                        <div class="col-md-2 form-group {{ Session::has('country_code_error') ? 'has-error' : '' }}">
                            {!! Form::label('Code',Lang::get('lang.country-code')) !!}
                             @if($email_mandatory->status == 0 || $email_mandatory->status == '0')
                                    <span class="text-red"> *</span>
                                    @endif

                            {!! Form::text('Code',null,['class' => 'form-control', 'placeholder' => $phonecode, 'title' => Lang::get('lang.enter-country-phone-code')]) !!}
                        </div>
                        <div class="col-md-5 form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
                            {!! Form::label('mobile',Lang::get('lang.mobile_number')) !!}
                             @if($email_mandatory->status == 0 || $email_mandatory->status == '0')
                                    <span class="text-red"> *</span>
                                    @endif
                            {!! Form::text('mobile',null,['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-5 form-group {{ $errors->has('Phone') ? 'has-error' : '' }}">
                            {!! Form::label('Phone',Lang::get('lang.phone')) !!}
                            {!! Form::text('Phone',null,['class' => 'form-control']) !!}
                        </div>
                        @else 
                            {!! Form::hidden('mobile',Auth::user()->mobile,['class' => 'form-control']) !!}
                            {!! Form::hidden('Code',Auth::user()->country_code,['class' => 'form-control']) !!}
                            {!! Form::hidden('Phone',Auth::user()->phone_number,['class' => 'form-control']) !!}
             
                       @endif
                        <div class="col-md-12 form-group {{ $errors->has('help_topic') ? 'has-error' : '' }}">
                            {!! Form::label('help_topic', Lang::get('lang.choose_a_help_topic')) !!} 
                            {!! $errors->first('help_topic', '<spam class="help-block">:message</spam>') !!}
                            <?php
                            $forms = App\Model\helpdesk\Form\Forms::get();
                            $helptopic = App\Model\helpdesk\Manage\Help_topic::where('status', '=', 1)->get();
                            ?>                  
                            <select name="helptopic" class="form-control" id="selectid">
                                
                                @foreach($helptopic as $topic)
                                <option value="{!! $topic->id !!}">{!! $topic->topic !!}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- priority -->
                         <?php 
                         $Priority = App\Model\helpdesk\Settings\CommonSettings::select('status')->where('option_name','=', 'user_priority')->first(); 
                         $user_Priority=$Priority->status;
                        ?>
                         
                         @if(Auth::user())

                         @if(Auth::user()->active == 1)
                        @if($user_Priority == 1)
             
                        <div class="col-md-12 form-group">
                            <div class="row">
                                <div class="col-md-1">
                                    <label>{!! Lang::get('lang.priority') !!}:</label>
                                </div>
                                <div class="col-md-12">
                                    <?php $Priority = App\Model\helpdesk\Ticket\Ticket_Priority::where('status','=',1)->get(); ?>
                                    {!! Form::select('priority', ['Priority'=>$Priority->pluck('priority_desc','priority_id')->toArray()],null,['class' => 'form-control select']) !!}
                                </div>
                             </div>
                        </div>
                        @endif
                        @endif
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
                            <label>{!! Lang::get('lang.attachment') !!}</label>
                            <input type="file" name="attachment[]" multiple/><br/>
                            {!! Lang::get('lang.max') !!}. 10MB
                        </div>
                        {{-- Event fire --}}
                        <?php Event::fire(new App\Events\ClientTicketForm()); ?>
                        <div class="col-md-12" id="response"> </div>
                        <div id="ss" class="xs-md-6 form-group {{ $errors->has('') ? 'has-error' : '' }}"> </div>
                        <div class="col-md-12 form-group">
                            {!! Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-info float-right', 'onclick' => 'this.disabled=true;this.value="Sending, please wait...";this.form.submit();'])!!}
                        </div>
       
                        <div class="col-md-12" id="response"> </div>
                        <div id="ss" class="xs-md-6 form-group {{ $errors->has('') ? 'has-error' : '' }}"> </div>
                  
                    {!! Form::close() !!}  
                    </div>
                </section>    
            </div>
        </article>
    </div>
<!--
|====================================================
| SELECTED FORM STORED IN SCRIPT
|====================================================
-->
<script type="text/javascript">
$(document).ready(function(){
   var helpTopic = $("#selectid").val();
   send(helpTopic);
   $("#selectid").on("change",function(){
       helpTopic = $("#selectid").val();
       send(helpTopic);
   });
   function send(helpTopic){
       $.ajax({
           url:"{{url('/get-helptopic-form')}}",
           data:{'helptopic':helpTopic},
           type:"GET",
           dataType:"html",
           success:function(response){
               $("#response").html(response);
           },
           error:function(response){
              $("#response").html(response); 
           }
       });
   }
});

$(function() {
//Add text editor
    $("textarea").summernote({
        height: 300,
        tabsize: 2,
        toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']]
      ]
      });
});
</script>
@stop