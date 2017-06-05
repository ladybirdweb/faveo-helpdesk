@extends('themes.default1.agent.layout.agent')

@section('Tickets')
class="active"
@stop

@section('ticket-bar')
active
@stop

@section('newticket')
class="active"
@stop

@section('PageHeader')
<h1 id="header">{{Lang::get('lang.tickets')}}</h1>
@stop

@section('content')
<!-- Main content -->
{!! Form::open(['id'=>'form']) !!}
<div class="box box-primary" ng-controller="CreateTicketAgent">
    <div class="box-header with-border" id='box-header1'>
        <h3 class="box-title">{!! Lang::get('lang.create_ticket') !!}</h3>
        @if(Session::has('success'))
        <br><br>        
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('fails'))
        <br><br>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif
        <div id="response"></div>
        @if(Session::has('errors'))
        <br><br>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @if($errors->first('email'))
            <li class="error-message-padding">{!! $errors->first('email', ':message') !!}</li>
            @endif
            @if($errors->first('first_name'))
            <li class="error-message-padding">{!! $errors->first('first_name', ':message') !!}</li>
            @endif
            @if($errors->first('phone'))
            <li class="error-message-padding">{!! $errors->first('phone', ':message') !!}</li>
            @endif
            @if($errors->first('subject'))
            <li class="error-message-padding">{!! $errors->first('subject', ':message') !!}</li>
            @endif
            @if($errors->first('body'))
            <li class="error-message-padding">{!! $errors->first('body', ':message') !!}</li>
            @endif
            @if($errors->first('code'))
            <li class="error-message-padding">{!! $errors->first('code', ':message') !!}</li>
            @endif
            @if($errors->first('mobile'))
            <li class="error-message-padding">{!! $errors->first('mobile', ':message') !!}</li>
            @endif
             @if($errors->first('helptopic'))
            <li class="error-message-padding">{!! $errors->first('helptopic', ':message') !!}</li>
            @endif
             
           
        </div>
        @endif
    </div><!-- /.box-header -->
    <div class="box-header with-border">
        <h4 class="box-title">{!! Lang::get('lang.user_details') !!}:</h4>
    </div>
    <div class="box-body">

        <div class="form-group">
            <div class="row">
                <div class="col-md-4">
                    <!-- email -->
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        {!! Form::label('email',Lang::get('lang.email')) !!}
                        @if ($email_mandatory->status == 1)
                        <span class="text-red"> *</span>
                        @endif

                        {!! Form::text('email',null,['class' => 'form-control', 'id' => 'email']) !!}
                    </div>
                </div>
                
                <div class="col-md-4">
                    <!-- email -->
                    <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                        {!! Form::label('email',Lang::get('lang.first_name')) !!} <span class="text-red"> *</span>
                        {!! Form::text('first_name',null,['class' => 'form-control', 'id' => 'first_name']) !!}
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- full name -->
                    <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                        {!! Form::label('fullname',Lang::get('lang.last_name')) !!} <span class="text-red"></span>
                        <input type="text" name="last_name" id="last_name" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1 form-group {{ Session::has('country_code_error') ? 'has-error' : '' }}">
                    <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                    {!! Form::label('code',Lang::get('lang.country-code')) !!}
                    @if ($email_mandatory->status == 0 || $settings->status == 1)
                         <span class="text-red"> *</span>
                    @endif

                    {!! Form::text('code',null,['class' => 'form-control', 'id' => 'country_code', 'placeholder' => $phonecode, 'title' => Lang::get('lang.enter-country-phone-code')]) !!}
                    </div>
                </div>
                <div class="col-md-5">
                    <!-- phone -->
                    <div class="form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
                        <label>{!! Lang::get('lang.mobile_number') !!}:</label>
                        @if ($email_mandatory->status == 0 || $settings->status == 1)
                         <span class="text-red"> *</span>
                        @endif

                        <input type="text" name="mobile" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57" >
                        <!-- {!! Form::input('number','mobile',null,['class' => 'form-control', 'id' => 'mobile']) !!} -->
                    </div>
                </div>
                <div class="col-md-5">
                    <!-- phone -->
                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                        <label>{!! Lang::get('lang.phone') !!}:</label>
                        <input type="text" name="phone" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57" >
                        <!-- {!! Form::input('number','phone',null,['class' => 'form-control', 'id' => 'phone_number']) !!} -->
                        {!! $errors->first('phone', '<spam class="help-block text-red">:message</spam>') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-header with-border">
        <h4 class="box-title">{!! Lang::get('lang.ticket_option') !!}:</h4>
    </div>
    <div class="box-body">
        <!-- ticket options -->
        <div class="form-group">
            <div class="row">
                <div class="col-md-4">
                     <div class="form-group {{ $errors->has('helptopic') ? 'has-error' : '' }}">
                        <label>{!! Lang::get('lang.help_topic') !!}:</label>
                        <span class="text-red"> *</span>
                        <!-- helptopic -->
                        <?php $helptopic = App\Model\helpdesk\Manage\Help_topic::where('status', '=', 1)->get(); ?>
                        {!! Form::select('helptopic', ['' => Lang::get('lang.select_helptopic'), Lang::get('lang.help_topics')=>$helptopic->pluck('topic', 'id')->toArray()], null, ["class" => "form-control select", "id" => "selectid"]) !!}
                    </div>
                </div>
                
                <div class="col-md-4">
                    <!-- due date -->
                    <div class="form-group" id="duedate">
                        <label>{!! Lang::get('lang.due_date') !!}:</label>
                        {!! Form::text('duedate',null,['class' => 'form-control','id'=>'datemask']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- assign to -->
                    <div class="form-group">
                        <label>{!! Lang::get('lang.assign_to') !!}:</label>
                       <select  name="assignto" class="form-control select" id="agent_id">
                <option value="">Select Agent</option>
              </select>
                    </div>
                </div>
                <div id="response" class="col-md-6 form-group"></div>
            </div>
        </div>
    </div>
    <div class="box-header with-border">
        <h4 class="box-title">{!! Lang::get('lang.ticket_detail') !!}:</h4>
    </div>
    <div class="box-body">
        <!-- ticket details -->
        <div class="form-group">
            <!-- subject -->
            <div class="form-group {{ $errors->has('subject') ? 'has-error' : '' }}">
                <div class="row">
                    <div class="col-md-2">
                        <label>{!! Lang::get('lang.subject') !!}:<span class="text-red"> *</span></label>
                    </div>
                    <div class="col-md-4">
                        {!! Form::text('subject',null,['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
                <!-- details -->
                <div class="row">
                    <div class="col-md-2">
                        <label>{!! Lang::get('lang.detail') !!}:<span class="text-red"> *</span></label>
                    </div>
                    
                    <div class="col-md-9">
                        @include('themes.default1.inapp-notification.wyswyg-editor')
                        {!! Form::textarea('body',null,['class' => 'form-control','id' => 'body', 'style'=>"width:100%; height:150px;"]) !!}

                    </div>
                    <script src="{{asset('vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script> 
                                        <script>
  CKEDITOR.replace( 'body', {
      toolbarGroups: [
				{"name":"basicstyles","groups":["basicstyles"]},
				{"name":"links","groups":["links"]},
				{"name":"paragraph","groups":["list","blocks"]},
				{"name":"document","groups":["mode"]},
				{"name":"insert","groups":["insert"]},
				{"name":"styles","groups":["styles"]},
				{"name":"about","groups":["about"]}
			],
    removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar',
    disableNativeSpellChecker: false
  });
</script>
                
                </div>
                
            </div>
            <div class="form-group">
                            <div class="row">
                                <div class="col-md-2"></div>
                                    <div class="col-md-10">
                                        <div id="t5">
                                            <div id="file_details"></div>
                                        </div>
                                    </div>
                            </div>
                        </div>
            <div class="form-group">
                <!-- priority -->
                <div class="row">
                    <div class="col-md-1">
                        <label>{!! Lang::get('lang.priority') !!}:</label>
                    </div>
                    <div class="col-md-3">
                        <?php $Priority = App\Model\helpdesk\Ticket\Ticket_Priority::where('status','=',1)->get(); ?>
                        {!! Form::select('priority', [''=>$Priority->pluck('priority_desc','priority_id')->toArray()],null,['class' => 'form-control select']) !!}
                    </div>
                    <div class="col-md-1">
                        <label>{!! Lang::get('lang.type') !!}:</label>
                    </div>
                    <div class="col-md-3">
                        <?php $types = App\Model\helpdesk\Manage\Tickettype::where('status','=',1)->select('id','name')->get(); ?>
                          {!! Form::select('type', [''=>$types->pluck('name','id')->toArray()],null,['class' => 'form-control select']) !!}
                       
                    </div>
                    
                </div>
            </div>
             
        </div>
    </div>
    <div class="box-footer">
        <div class="row">
            <div class="col-md-1">
            </div>
            <div class="col-md-3">
                <input type="button" value="{!! Lang::get('lang.create_ticket') !!}" class="btn btn-primary" ng-click="getEditor($event)">
            </div>
        </div>
    </div>
</div><!-- /. box -->
{!! Form::close() !!}

<!-- //auto change agent depends on helptopic -->
<script type="text/javascript">
    $(document).ready(function () {
     
        $("#selectid").on("change", function () {
             helpTopic = $("#selectid").val();
                $.ajax({
               
                url: '{{route("newticket1")}}',
                data: {'helptopic': helpTopic},
                type: "GET",
                dataType: "html",
                success: function (data) {
                   
                    $("#agent_id").empty();
                    $(data).appendTo('#agent_id'); 
                     
                },
                
            });
            
        });
        });
        </script>



<script type="text/javascript">
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
    
    $(document).ready(function () {
        $('#form').submit(function () {
            var duedate = document.getElementById('datemask').value;
            if (duedate) {
                var pattern = /^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/;
                if (pattern.test(duedate) === true) {
                    $('#duedate').removeClass("has-error");
                    $('#clear-up').remove();
                } else {
                    $('#duedate').addClass("has-error");
                    $('#clear-up').remove();
                    $('#box-header1').append("<div id='clear-up'><br><br><div class='alert alert-danger alert-dismissable'><i class='fa fa-ban'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Invalid Due date</div></div>");
                    return false;
                }
            }
        });
    });
                $(document).ready(function(){                   
                    $("#email").autocomplete({
                        source:"{!!URL::route('post.newticket.autofill')!!}",
                        minLength:1,
                        select:function(evt, ui) {
                            // this.form.phone_number.value = ui.item.phone_number;
                            // this.form.user_name.value = ui.item.user_name;
                            if(ui.item.first_name) {
                                this.form.first_name.value = ui.item.first_name;
                            }
                            if(ui.item.last_name) {
                                this.form.last_name.value = ui.item.last_name;
                            }
                            if(ui.item.country_code) {
                                this.form.country_code.value = ui.item.country_code;
                            }
                            if(ui.item.phone_number) {
                                this.form.phone_number.value = ui.item.phone_number;
                            }
                            if(ui.item.mobile) {
                                this.form.mobile.value = ui.item.mobile;
                            }
                        }
                    });
                });

    $(function () {
        $('#datemask').datepicker({
            changeMonth: true, 
            changeYear: true,
            minDate: 0,
        }).mask('99/99/9999');
    });
</script>

@stop
@push('scripts')


<script>

app.controller('CreateTicketAgent', function($scope,$http, $sce,$window,$compile){
    $scope.disable=true;
      $scope.inlineImage=true;
      $scope.arrayImage=[];
      $scope.attachmentImage=[];
      $scope.inlinImage=[];
   $scope.getImageApi=function(){
       
      $http.get("{{url('media/files')}}").success(function(data){
          $scope.arrayImage=data;
          $scope.apiCalled=true;
          console.log($scope.arrayImage);
      })
  }
      $scope.insert=function(x,i,pathname,name){
          
           $scope.disable=false;
          
           $scope.preview=true;
           $scope.viewImage=$scope.arrayImage[i]
           if(x=="image"){
               $scope.inlineImage=false;
               $scope.viewImage=i;
               $scope.pathName=pathname;
               $scope.fileName=name;
           }
           else if(x=="text"){
               $scope.inlineImage=true;
               $scope.viewImage="{{asset('lb-faveo/media/images/txt.png')}}";
               $scope.pathName=pathname;
               $scope.fileName=name;
           }
           else{
               $scope.inlineImage=true;
               $scope.viewImage="{{asset('lb-faveo/media/images/common.png')}}";
               $scope.pathName=pathname;
               $scope.fileName=name;
           }
      }
      $scope.noInsert=function(){
           $scope.disable=true;
           $scope.inlineImage=true;
      }
      
       $scope.pushToEditor=function(){
          var radios = document.getElementsByName('selection');
           for (var i = 0, length = radios.length; i < length; i++) {
             if (radios[i].checked) {
                 var attaremove=$scope.arrayImage.data[i].filename;
                 console.log(attaremove);
                   $scope.attachmentImage.push($scope.arrayImage.data[i]);
                   $compile($("#file_details").append("<div type='hidden' id='hidden' style='background-color: #f5f5f5;border: 1px solid #dcdcdc;font-weight: bold;margin-top:9px;overflow-y: hidden;padding: 4px 4px 4px 8px;max-width: 448px;' contenteditable='false'>"+$scope.arrayImage.data[i].filename+"("+$scope.arrayImage.data[i].size+"bytes)<i class='fa fa-times' aria-hidden='true' style='float:right;cursor: pointer;' ng-click='remove($event)'></i></div>"))($scope);
                }
          }
      }
      $scope.pushImage=function(){
           var radios = document.getElementsByName('selection');
           for (var i = 0, length = radios.length; i < length; i++) {
             if (radios[i].checked) {
                 
                $(".cke_wysiwyg_frame").contents().find("body").append("<img  src="+$scope.arrayImage.data[i].base_64+" alt='"+$scope.arrayImage.data[i].filename+"' width='150px' height='150px' />");
             }
          }
      }
      $scope.remove=function(x){
           var id=x.currentTarget.parentNode;
           id.remove();
          var value=x.currentTarget.parentNode.innerHTML;
          var b=value.split('(');
           $scope.attachmentImage=$.grep($scope.attachmentImage, function(e){
                 return e.filename != b[0];
                 
             })
           
      }
      $scope.getEditor=function(x){
          x.currentTarget.disabled=true;
          x.currentTarget.value='Sending, please wait...';
         
          $scope.editor=$(".cke_wysiwyg_frame").contents().find("body").html();
          $scope.imagesAlt=[];     
          $("<div>" + $scope.editor + "</div>").find('img').each(function(i) {
              
              $scope.imagesAlt.push(this.alt);
              })
         
          for(var i in $scope.imagesAlt){
            var x=$.grep($scope.arrayImage.data, function(e){
                 return e.filename == $scope.imagesAlt[i];
               })
             $scope.inlinImage.push(x[0]);
         }
         $("<div>" + $scope.editor + "</div>").find('img').each(function(i) {
            
              var old=this.src;
              
              $scope.editor1=$scope.editor.replace(old,$scope.imagesAlt[i]);
              $scope.editor=$scope.editor1;
                   
             
             });
             if($("<div>" + $scope.editor + "</div>").find('img').length==0){
                 if($scope.editor=='<p><br></p>'){
                     $scope.editor1="";
                   }
                else{
                    $scope.editor1=$scope.editor;
                }
            }
             $scope.inlinImage.forEach(function(v){ delete v.base_64 });
             $scope.attachmentImage.forEach(function(v){ delete v.base_64 });

              var serialize=$("#form").serialize();
              console.log(serialize);
          $scope.editorValues={};
          $scope.editorValues['body']=$scope.editor1;
          $scope.editorValues['inline']=$scope.inlinImage;
          $scope.editorValues['attachment']=$scope.attachmentImage;
          console.log($scope.editorValues);
          var config={
                 headers : {
                      'Content-Type' : 'application/json'
                  }
          }
          var url = "{{route('post.newticket')}}?"+serialize;
          
          $http.post(url,$scope.editorValues,config)
                  .success(function(data){
              if(data.result.success!=null){
                $("#response").html("<div class='alert alert-success'>"+data.result.success+"</div>");
                $('html, body').animate({scrollTop: $("#header").offset().top}, 650);
              }
          })
          .error(function(data){
                x.currentTarget.disabled=false;
                x.currentTarget.value="Create Ticket";
                var res="";
                $.each(data, function (idx, topic) {
                   res += "<li>" + topic + "</li>";
                });
                $("#response").html("<div class='alert alert-danger'><strong>Whoops!</strong> There were some problems with your input.<br><br><ul>" +res+ "</ul></div>");
                $('html, body').animate({scrollTop: $("#header").offset().top}, 650);
           })
        
      }
     $scope.callApi=function(){
         
         $scope.api2Called=true;
         if($scope.arrayImage.next_page_url==null){
                 $scope.api2Called=false;   
        }
         $http.get($scope.arrayImage.next_page_url).success(function(data){
          	  console.log(data);
                  $scope.api2Called=false;
              [].push.apply($scope.arrayImage.data, data.data);
              console.log($scope.arrayImage.data)
                 $scope.arrayImage.next_page_url=data.next_page_url;
         
     })
     
 }
 $scope.filterApi=function(x){
         console.log(x.year,x.month,x.day,x.type);
         var filter={};
         if(x.year==undefined || x.year==""){
              filter['year']="";
             }
         else{
             filter['year']=x.year;
         }
         if(x.month==undefined || x.month==""){
              filter['month']="";
             }
         else{
             filter['month']=x.month;
             
         }
         if(x.day==undefined || x.day==""){
              filter['day']="";
             }
         else{
             filter['day']=x.day;
         }
         if(x.type==undefined || x.type==""){
              filter['type']="";
             }
         else{
             filter['type']=x.type;
         }
        
        if(filter.type==""&&filter.year==""&&filter.month==""&&filter.day!=""){
             alert('Please Select a Particular Month and Year')
        }
        else if(filter.type==""&&filter.year==""&&filter.month!=""&&filter.day!=""){
             alert('Please Select a Particular Year')
        }
        else if(filter.type==""&&filter.year==""&&filter.month!=""&&filter.day==""){
             alert('Please Select a Particular Year')
        }
        else{
            var config={
              params:filter
            }
            console.log(config);
            $http.get("{{url('media/files')}}",config).success(function(data){
                $scope.arrayImage=data;
            })
        }
         
    }  

});
</script>
@endpush


