@extends('themes.default1.client.layout.client')

@section('title')
{!! Lang::get('lang.submit_a_ticket') !!} -
@stop
<style>
    @import url("http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css");
    #fileselector {
        margin: 10px; 
    }
    #upload-file-selector {
        display:none;   
    }
    .margin-correction {
        margin-right: 10px;   
    }
</style>
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

<?php
$portal = App\Model\helpdesk\Theme\Portal::where('id', '=', 1)->first();
?>

@if($portal)

<div class="banner-wrapper  clearfix"    style = "border-color : <?php echo $portal->client_header_color; ?>">
    <h3 class="banner-title text-center text-info h4">{!! Lang::get('lang.have_a_ticket') !!}?</h3>
    @if(Session::has('check'))
    @if (count($errors) > 0)
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <b>{!! Lang::get('lang.alert') !!} !</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        @foreach ($errors->all() as $error)
        <li>{{ $error}}</li>
        @endforeach
    </div>
    @endif
    @endif
    <div class="banner-content text-center">
        {!! Form::open(['url' => 'checkmyticket' , 'method' => 'POST'] )!!}
        {!! Form::label('email',Lang::get('lang.email')) !!}<span class="text-red">*</span>
        {!! Form::text('email_address',null,['class' => 'form-control']) !!}
        {!! Form::label('ticket_number',Lang::get('lang.ticket_number')) !!}<span class="text-red"> *</span>
        {!! Form::text('ticket_number',null,['class' => 'form-control']) !!}
        <br/><input type="submit" value="{!! Lang::get('lang.check_ticket_status') !!}" class="btn btn-custom btn-info" style = "background-color : <?php echo $portal->client_header_color; ?>;border-color : <?php echo $portal->client_header_color; ?>" >
        {!! Form::close() !!}
    </div>
</div> 

@else
<div class="banner-wrapper  clearfix" >
    <h3 class="banner-title text-center text-info h4">{!! Lang::get('lang.have_a_ticket') !!}?</h3>
    @if(Session::has('check'))
    @if (count($errors) > 0)
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <b>{!! Lang::get('lang.alert') !!} !</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        @foreach ($errors->all() as $error)
        <li>{{ $error}}</li>
        @endforeach
    </div>
    @endif
    @endif
    <div class="banner-content text-center">
        {!! Form::open(['url' => 'checkmyticket' , 'method' => 'POST'] )!!}
        {!! Form::label('email',Lang::get('lang.email')) !!}<span class="text-red"> *</span>
        {!! Form::text('email_address',null,['class' => 'form-control']) !!}
        {!! Form::label('ticket_number',Lang::get('lang.ticket_number')) !!}<span class="text-red"> *</span>
        {!! Form::text('ticket_number',null,['class' => 'form-control']) !!}
        <br/><input type="submit" value="{!! Lang::get('lang.check_ticket_status') !!}" class="btn btn-custom btn-info">
        {!! Form::close() !!}
    </div>
</div> 

@endif 
@stop
<!-- content -->
@section('content')
<div id="content" class="site-content col-md-9" ng-controller="clientFormCtrl">
    <div id="response-create"></div>
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
    @if(!Session::has('error'))
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <b>{!! Lang::get('lang.alert') !!} !</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error}}</li>
            @endforeach
        </ul>
    </div>
    @endif
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
    <form id="form-create">
        <div>
            <div class="content-header">
                <h4>{!! Lang::get('lang.ticket') !!} </h4>
            </div>
            <div class="row col-md-12">

                @if(Auth::user())

                {!! Form::hidden('Name',Auth::user()->user_name,['class' => 'form-control']) !!}

                @else
                <div class="col-md-12 form-group {{ $errors -> has('Name') ? 'has-error' : ''}}">
                    {!! Form::label('Name',Lang::get('lang.name')) !!}<span class="text-red"> *</span>
                    {!! Form::text('Name',null,['class' => 'form-control']) !!}
                </div>
                @endif



                @if(Auth::user())

                {!! Form::hidden('Email',Auth::user()->email,['class' => 'form-control']) !!}

                @else
                <div class="col-md-12 form-group {{ $errors -> has('Email') ? 'has-error' : ''}}">
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


                    <input type="text" name="Code" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="{{$phonecode}}" id='code'>

                    <!-- {!! Form::text('Code',null,['class' => 'form-control', 'placeholder' => $phonecode, 'title' => Lang::get('lang.enter-country-phone-code')]) !!} -->
                </div>
                <div class="col-md-5 form-group {{ $errors -> has('mobile') ? 'has-error' : ''}}">
                    {!! Form::label('mobile',Lang::get('lang.mobile_number')) !!}
                    @if($email_mandatory->status == 0 || $email_mandatory->status == '0')
                    <span class="text-red"> *</span>
                    @endif

                     <!-- {!! Form::label('mobile',Lang::get('lang.mobile_number')) !!} -->
                        <input type="text" name="mobile" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    <!-- {!! Form::text('mobile',null,['class' => 'form-control']) !!} -->
                </div>
                <div class="col-md-5 form-group {{ $errors -> has('Phone') ? 'has-error' : ''}}">
                    {!! Form::label('Phone',Lang::get('lang.phone')) !!}
                    {!! Form::label('phone_number',Lang::get('lang.phone')) !!}
                            <input type="text" name="Phone" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    <!-- {!! Form::text('Phone',null,['class' => 'form-control']) !!} -->
                </div>
                @else 
                {!! Form::hidden('mobile',Auth::user()->mobile,['class' => 'form-control']) !!}
                {!! Form::hidden('Code',Auth::user()->country_code,['class' => 'form-control']) !!}
                {!! Form::hidden('Phone',Auth::user()->phone_number,['class' => 'form-control']) !!}

                @endif
                <div class="col-md-12 form-group {{ $errors -> has('help_topic') ? 'has-error' : ''}}">
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
                @if(Auth::user())
                @if(Auth::user()->role != 'user')
                <div class="col-md-12 form-group">
                    {!! Form::label('type', Lang::get('lang.type')) !!} 

<?php
$types = App\Model\helpdesk\Manage\Tickettype::where('status', '=', 1)->select('id', 'name')->get();
?>              
                    {!! Form::select('type', ['Tickettype'=>$types->pluck('name','id')->toArray()],null,['class' => 'form-control select']) !!}
                </div>
                @endif
                @endif
                <!-- priority -->
<?php
$Priority = App\Model\helpdesk\Settings\CommonSettings::select('status')->where('option_name', '=', 'user_priority')->first();
$user_Priority = $Priority->status;
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
<?php $Priority = App\Model\helpdesk\Ticket\Ticket_Priority::where('status', '=', 1)->get(); ?>
                            {!! Form::select('priority', ['Priority'=>$Priority->pluck('priority_desc','priority_id')->toArray()],null,['class' => 'form-control select']) !!}
                        </div>
                    </div>
                </div>
                @endif
                @endif
                @endif
                <div class="col-md-12 form-group {{ $errors -> has('Subject') ? 'has-error' : ''}}">
                    {!! Form::label('Subject',Lang::get('lang.subject')) !!}<span class="text-red"> *</span>
                    {!! Form::text('Subject',null,['class' => 'form-control']) !!}
                </div>
                <div class="col-md-12 form-group {{ $errors -> has('Details') ? 'has-error' : ''}}">
                    {!! Form::label('Details',Lang::get('lang.message')) !!}<span class="text-red"> *</span>
                    {!! Form::textarea('Details',null,['class' => 'form-control','id'=>'details']) !!}
                </div>
                <script src="{{asset('vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script> 
                <script>
                        CKEDITOR.replace('Details', {
                            toolbarGroups: [
                                {"name": "basicstyles", "groups": ["basicstyles"]},
                                {"name": "links", "groups": ["links"]},
                                {"name": "paragraph", "groups": ["list", "blocks"]},
                                {"name": "document", "groups": ["mode"]},
                                {"name": "insert", "groups": ["insert"]},
                                {"name": "styles", "groups": ["styles"]},
                                {"name": "about", "groups": ["about"]}
                            ],
                            removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar',
                            disableNativeSpellChecker: false
                        });
                </script>
                
                            <div id="fileList"></div>
                                <span id="fileselector">
                                    <label class="btn btn-default" for="upload-file-selector" style='border: none;margin-left: 4px;'>
                                        <input id="upload-file-selector" type="file" name="attachment[]"  multiple 
                       onchange="angular.element(this).scope().updateList(this)" >
                                          <i class="fa_icon icon-plus margin-correction"></i>Attach files
                                    </label>
                                    <i>Max File Upload size : {{file_upload_max_size()}}MB and Max Number of Files :{{ini_get('max_file_uploads')}}</i>
                                </span>
                {{-- Event fire --}}
<?php Event::fire(new App\Events\ClientTicketForm()); ?>
                <div class="col-md-12" id="response"> </div>
                <div id="ss" class="xs-md-6 form-group {{ $errors -> has('') ? 'has-error' : ''}}"> </div>
                <div class="col-md-12 form-group">{!! Form::submit(Lang::get('lang.Send'),['class'=>'form-group btn btn-info pull-left', 'ng-click'=>'uploadPic($event)'])!!}</div>
            </div>
            <div class="col-md-12" id="response"> </div>
            <div id="ss" class="xs-md-6 form-group {{ $errors -> has('') ? 'has-error' : ''}}"> </div>
        </div>
</form>
</div>
<!--
|====================================================
| SELECTED FORM STORED IN SCRIPT
|====================================================
-->
<script type="text/javascript">
            var uploadArray = [];
    updateList = function () {
        var input = document.getElementById('upload-file-selector');
        var output = document.getElementById('fileList');

        uploadArray.push(input.files[0]);
        console.log(uploadArray);
        output.innerHTML = '<ul>'
        for (var i = 0; i < uploadArray.length; ++i) {
            output.innerHTML += '<li id="hidden" style="list-style-type:none;background-color: #f5f5f5;border: 1px solid #dcdcdc;font-weight: bold;margin:8px;overflow-y: hidden;padding: 4px 4px 4px 8px;max-width: 448px;" contenteditable="false">' + uploadArray[i].name + '(' + uploadArray[i].size + ')<i class="fa fa-times" aria-hidden="true" style="float:right;cursor: pointer;" ng-click="remove($event)"></i></li>';
        }
        output.innerHTML += '</ul>';
    }

    $(document).ready(function () {
        var helpTopic = $("#selectid").val();
        send(helpTopic);
        $("#selectid").on("change", function () {
            helpTopic = $("#selectid").val();
            send(helpTopic);
        });
        function send(helpTopic) {
            $.ajax({
                url: "{{url('/get-helptopic-form')}}",
                data: {'helptopic': helpTopic},
                type: "GET",
                dataType: "html",
                success: function (response) {
                    $("#response").html(response);
                },
                error: function (response) {
                    $("#response").html(response);
                }
            });
        }
    });

</script>
@stop
@push('scripts')

<script>
    app.directive("fileread", [
        function () {
            return {
                scope: {
                    fileread: "="
                },
                link: function (scope, element, attributes) {
                    element.bind("change", function (changeEvent) {
                        var reader = new FileReader();
                        reader.onload = function (loadEvent) {
                            scope.$apply(function () {
                                scope.fileread = loadEvent.target.result;
                            });
                        }
                        reader.readAsDataURL(changeEvent.target.files[0]);
                    });
                }
            }
        }
    ]);
    app.controller('clientFormCtrl', function ($scope, $http, $sce, $window, $compile, Upload, $timeout) {
        $scope.disable = true;
        $scope.inlineImage = true;
        $scope.arrayImage = [];
        $scope.attachmentImage = [];
        $scope.inlinImage = [];
        $scope.uploaded=0;
        
        $scope.remove = function (x) {
            var id = x.currentTarget.parentNode;
            id.remove();
            var value = id.firstElementChild.innerHTML;
            $scope.uploadArray = $.grep($scope.uploadArray, function (e) {
                return e.id != value;

            })
            console.log($scope.uploadArray);

        }
        $scope.uploadArray = [];
        $scope.updateList = function (e) {
            $scope.$apply(function () {
                 $scope.uploaded++;
            
                for (var i = 0; i < e.files.length; i++) {
                    e.files[i]['id']=$scope.uploaded+'-'+i;
                    $scope.uploadArray.push(e.files[i])
                }
               
            });
            if($scope.uploaded==1){
            var output = document.getElementById('fileList');
            
            for (var i = 0; i < $scope.uploadArray.length; ++i) {
               $compile($(output).append('<div id="hidden" style="list-style-type:none;background-color: #f5f5f5;border: 1px solid #dcdcdc;font-weight: bold;margin:8px;overflow-y: hidden;padding: 4px 4px 4px 8px;max-width: 448px;margin-left: 14px;" contenteditable="false">' + $scope.uploadArray[i].name + '(' + $scope.uploadArray[i].size + ')<div style="display:none">' + $scope.uploadArray[i].id + '</div><i class="fa fa-times" aria-hidden="true" style="float:right;cursor: pointer;" ng-click="remove($event)"></i></div>'))($scope);
            }
            } 
            else{
                var output = document.getElementById('fileList');
                output.innerHTML="";
                for (var i = 0; i < $scope.uploadArray.length; ++i) {
               $compile($(output).append('<div id="hidden" style="list-style-type:none;background-color: #f5f5f5;border: 1px solid #dcdcdc;font-weight: bold;margin:8px;overflow-y: hidden;padding: 4px 4px 4px 8px;max-width: 448px;margin-left: 14px;" contenteditable="false">' + $scope.uploadArray[i].name + '(' + $scope.uploadArray[i].size + ')<div style="display:none">' + $scope.uploadArray[i].id + '</div><i class="fa fa-times" aria-hidden="true" style="float:right;cursor: pointer;" ng-click="remove($event)"></i></div>'))($scope);
            }
            }
        }
        
        $scope.uploadPic = function (x) {
             x.currentTarget.disabled=true;
          x.currentTarget.value='Sending, please wait...';
          $scope.editor=$(".cke_wysiwyg_frame").contents().find("body").html();
          if($scope.editor=='<p><br></p>'){
                     $scope.editor1="";
                   }
                else{
                    $scope.editor1=$scope.editor;
                }
            var serialize=$("#form-create").serialize();
              $scope.uploadSize=0;
              var total_file_number =0;
             $scope.uploadArray.forEach(function(i){
                 $scope.uploadSize+=i.size;
                 total_file_number++;
             })
             var maxsize=($scope.uploadSize/1024)/1024;
             var max_file_number = "{{ini_get('max_file_uploads')}}";
             var file_upload_max_size= "{{file_upload_max_size()}}"; 
              
             console.log(total_file_number);
       if(maxsize<=file_upload_max_size && total_file_number<=max_file_number){
                 $scope.uploadArray.upload = Upload.upload({
                url: "{{url('postedform')}}?"+serialize,
                data: {attachment: $scope.uploadArray,Details:$scope.editor1},
              }).success(function(data){
                  x.currentTarget.disabled=false;
                x.currentTarget.value="Create Ticket";
              if(data.result.success!=null){
                $("#form-create")[0].reset();
                $(".cke_wysiwyg_frame").contents().find("body").html('');
                document.getElementById('fileList').innerHTML="";
                $scope.uploadArray=[];
                $("#response-create").html("<div class='alert alert-success'>"+data.result.success+"</div>");
                $('html, body').animate({scrollTop: $("#content").offset().top}, 650);
              }
             })
             .error(function(data){
                x.currentTarget.disabled=false;
                x.currentTarget.value="Create Ticket";
                var res="";
                $.each(data, function (idx, topic) {
                   res += "<li>" + topic + "</li>";
                });
                $("#response-create").html("<div class='alert alert-danger'><strong>Whoops!</strong> There were some problems with your input.<br><br><ul>" +res+ "</ul></div>");
                $('html, body').animate({scrollTop: $("#content").offset().top}, 650);
             })

        }else if(maxsize>file_upload_max_size&& total_file_number<=max_file_number){
                 alert('failed!! size and file number are maximum');
                 x.currentTarget.disabled=false;
                x.currentTarget.value="Create Ticket";
             }
           else if(maxsize>file_upload_max_size){
                 alert('failed!! file size is maximum');
                 x.currentTarget.disabled=false;
                x.currentTarget.value="Create Ticket";
             
             }else if(total_file_number<=max_file_number){
                 alert('failed!!   file number is maximum');
                 x.currentTarget.disabled=false;
                x.currentTarget.value="Create Ticket";
             }
            

            
        }



    });
</script>
@endpush


