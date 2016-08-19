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
            <div class="col-md-12 form-group {{ $errors->has('Subject') ? 'has-error' : '' }}">
                {!! Form::label('Subject',Lang::get('lang.subject')) !!}<span class="text-red"> *</span>
                {!! Form::text('Subject',null,['class' => 'form-control']) !!}
            </div>
            <div class="col-md-12 form-group {{ $errors->has('Details') ? 'has-error' : '' }}">
                {!! Form::label('Details',Lang::get('lang.message')) !!}<span class="text-red"> *</span>
                {!! Form::textarea('Details',null,['class' => 'form-control']) !!}
            </div>
            <div class="col-md-12 form-group">
                <div class="btn btn-default btn-file"><i class="fa fa-paperclip"> </i> {!! Lang::get('lang.attachment') !!}<input type="file" name="attachment[]" id="attachment" multiple/></div><br/>
                <div id='file_details'></div><div id='total-size'></div>
                {!! Lang::get('lang.max') !!}. {!! $max_size_in_actual !!}
                <div>
                    <a id='clear-file' onClick='clearAll()' style='display:none; cursor:pointer;'><i class='fa fa-close'></i>Clear all</a>
                </div>
            </div>
            {{-- Event fire --}}
            <?php Event::fire(new App\Events\ClientTicketForm()); ?>
            <div class="col-md-12" id="response"> </div>
            <div id="ss" class="xs-md-6 form-group {{ $errors->has('') ? 'has-error' : '' }}"> </div>
            <div class="col-md-12 form-group">{!! Form::submit(Lang::get('lang.Send'),['id' => 'submitbtn' ,'class'=>'form-group btn btn-info pull-left', 'onclick' => 'this.disabled=true;this.value="Sending, please wait...";this.form.submit();'])!!}</div>
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
    function clearAll() {
        $("#file_details").html("");
        $("#total-size").html("");
        $("#attachment").val('');
        $("#clear-file").hide();
        $("#submitbtn").removeClass('disabled');
    }


    $(document).ready(function() {
        var helpTopic = $("#selectid").val();
        send(helpTopic);
        $("#selectid").on("change", function() {
            helpTopic = $("#selectid").val();
            send(helpTopic);
        });
        function send(helpTopic) {
            $.ajax({
                url: "{{url('/get-helptopic-form')}}",
                data: {'helptopic': helpTopic},
                type: "GET",
                dataType: "html",
                success: function(response) {
                    $("#response").html(response);
                },
                error: function(response) {
                    $("#response").html(response);
                }
            });
        }
    });

    $(function() {
//Add text editor
        $("textarea").wysihtml5();
    });


    // Ticket attachment
    $('#attachment').change(function() {
        input = document.getElementById('attachment');
        if (!input) {
            alert("Um, couldn't find the fileinput element.");
        } else if (!input.files) {
            alert("This browser doesn't seem to support the `files` property of file inputs.");
        } else if (!input.files[0]) {
        } else {
            $("#file_details").html("");
            var total_size = 0;
            for (i = 0; i < input.files.length; i++) {
                file = input.files[i];
                var supported_size = "{!! $max_size_in_bytes !!}";
                var supported_actual_size = "{!! $max_size_in_actual !!}";
                if (file.size < supported_size) {
                    $("#file_details").append("<tr> <td> " + file.name + " </td><td> " + formatBytes(file.size) + "</td> </tr>");
                } else {
                    $("#file_details").append("<tr style='color:red;'> <td> " + file.name + " </td><td> " + formatBytes(file.size) + "</td> </tr>");
                }
                total_size += parseInt(file.size);
            }
            if (total_size > supported_size) {
                $("#total-size").append("<span style='color:red'>Your total file upload size is greater than " + supported_actual_size + "</span>");
                $("#submitbtn").addClass('disabled');
                $("#clear-file").show();
            } else {
                $("#total-size").html("");
                $("#submitbtn").removeClass('disabled');
                $("#clear-file").show();
            }
        }
    });

    function formatBytes(bytes, decimals) {
        if (bytes == 0)
            return '0 Byte';
        var k = 1000;
        var dm = decimals + 1 || 3;
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        var i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }

</script>
@stop