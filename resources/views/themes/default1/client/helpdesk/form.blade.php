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
    <div class="container">
        <div class="well col-sm-8" style="display:none"></div>
        <!-- Nested node template -->

        <script type="text/ng-template" id="nodes_renderer2.html">
         <ng-form name="faveoClientForm">
          <div class="row" style="margin:15px;width:100%" ng-if="node.customerDisplay">
              <div class="col-sm-3" style="padding: 0px;line-height: 2.5">
                 <label >@{{node.label | translate}}</label><span ng-show="node.customerRequiredFormSubmit" style="color:red">*</span>
              </div>
              <div class="col-sm-8" style="padding: 0px">
                <input type="text" name="textfield@{{$index}}"  ng-if="node.type=='text'&&node.customerDisplay" class="form-control" style="border-radius: 0px;width:85%" ng-model="node.value" ng-required="@{{node.customerRequiredFormSubmit}}">
                <span style="color:red" ng-show="faveoClientForm.textfield@{{$index}}.$dirty && faveoClientForm.textfield@{{$index}}.$invalid">
                                          <span ng-show="faveoClientForm.textfield@{{$index}}.$error.required">@{{node.label | translate}} is required.</span>
                </span>
                <input type="text" name="numberfield@{{$index}}"  ng-if="node.type=='number'&&node.customerDisplay" class="form-control numberOnly" style="border-radius: 0px;width:85%" ng-model="node.value" ng-required="@{{node.customerRequiredFormSubmit}}" >
                <span style="color:red" ng-show="faveoClientForm.numberfield@{{$index}}.$dirty && faveoClientForm.numberfield@{{$index}}.$invalid">
                                          <span ng-show="faveoClientForm.numberfield@{{$index}}.$error.required">@{{node.label | translate}} is required.</span>
                </span>
                <input type="text"  name="datefield@{{$index}}" ng-if="node.type=='date'" class="form-control" style="border-radius: 0px;width:85%" ng-pattern="/^[0,1]?\d{1}\/(([0-2]?\d{1})|([3][0,1]{1}))\/(([1]{1}[9]{1}[9]{1}\d{1})|([2-9]{1}\d{3}))$/" ng-required="@{{node.customerRequiredFormSubmit}}" placeholder="MM/DD/YYYY" ng-model="node.value">
                <span style="color:red" ng-show="faveoClientForm.datefield@{{$index}}.$dirty && faveoClientForm.datefield@{{$index}}.$invalid">
                                          <span ng-show="faveoClientForm.datefield@{{$index}}.$error.required">@{{node.label | translate}} is required.</span>
                                          <span ng-show="faveoClientForm.datefield@{{$index}}.$error.pattern">Please Enter Valid Correct Format-MM/DD/YYYY</span>
                </span>
                <div class="input-group" ng-if="node.type=='email'&& node.label=='Requester'" style="width:100%">
                           <input type="text" class="form-control"  style="border-radius: 0px;width:85%"  ng-model="node.value" id="clientreq" onchange="angular.element(this).scope().clientUserName(this)"   placeholder="Requester Username" ng-required="@{{node.customerRequiredFormSubmit}}">
                                <!-- <span ng-show="loado@{{$index}}" style="width:15%"><img src="{{asset("lb-faveo/media/images/gifloader.gif")}}" style="width:20px;height:20px"></span> -->
                
                                 
                           <!--  <ul class="dropdown-menu" style="width:85%;display:block" ng-if="reqstr">
                                  <li ng-repeat="email in reqEmails"><a href="javascript:void(0)" ng-click="selectReq(email,$parent.$index)">@{{email.name}}(@{{email.first_name
}} @{{email.last_name}})</a></li>
                            </ul> -->
                </div>
                <div ng-if="newReqField && node.type=='email'&& node.label=='Requester'" style="margin-top:15px;">
                    <input type="text" name="requsName@{{$index}}" class="form-control" style="border-radius:0;margin-top:10px;width:85%" ng-model="req.name" placeholder="New Requester Name" id="requesterName" ng-required="@{{node.customer_name}}"/>
                                <span style="color:red" ng-show="faveoClientForm.requsName@{{$index}}.$dirty && faveoClientForm.requsName@{{$index}}.$invalid">
                                          <span ng-show="faveoClientForm.requsName@{{$index}}.$error.required">@{{node.label | translate}} is required.</span>
                                </span>
                    <input type="email" name="requsEmail@{{$index}}" class="form-control" style="border-radius:0;margin-top:10px;width:85%" ng-model="req.email" ng-pattern="emailFormat" placeholder="New Requester Email" id="requesterEmail" ng-required="@{{node.customer_email}}"/>
                                <span style="color:red" ng-show="faveoClientForm.requsEmail@{{$index}}.$dirty && faveoClientForm.requsEmail@{{$index}}.$invalid">
                                          <span ng-show="faveoClientForm.requsEmail@{{$index}}.$error.required">Email is required.</span>
                                          <span ng-show="faveoClientForm.requsEmail@{{$index}}.$error.pattern">Invalid email address.</span>
                                </span>
                    <div class="row" style="width:85%">
                    <div class="col-sm-3" style="margin-top:10px">
                        <input type="tel" class="form-control" id="telCode"style="visibility:hidden"/>
                    </div>
                    <div class="col-sm-9">
                     <input type="text" name="requsMobile@{{$index}}" class="form-control" style="border-radius:0;margin-top:10px" ng-model="req.mobile" placeholder="New Requester mobile" ng-pattern="/^[0-9]{1,99}$/" id="requesterMobile" ng-required="@{{node.customer_mobile}}"/> 
                                <span style="color:red" ng-show="faveoClientForm.requsMobile@{{$index}}.$dirty && faveoClientForm.requsMobile@{{$index}}.$invalid">
                                          <span ng-show="faveoClientForm.requsMobile@{{$index}}.$error.required">Mobile No is required.</span>
                                          <span ng-show="faveoClientForm.requsMobile@{{$index}}.$error.pattern">Invalid Mobile Number.</span>
                                </span> 
                    </div>
                    </div>
                </div>
                <textarea name="descript@{{$index}}"  class="form-control" ng-if="node.type=='textarea'&& node.default=='no'" style="border-radius: 0px;width:85%" ng-model="node.value" ng-required="@{{node.customerRequiredFormSubmit}}"></textarea>
                <span style="color:red" ng-show="faveoClientForm.descript@{{$index}}.$dirty && faveoClientForm.descript@{{$index}}.$invalid">
                                          <span ng-show="faveoClientForm.descript@{{$index}}.$error.required">@{{node.label | translate}} is required.</span>
                </span>
                <div style="width:85%" ng-if="node.type=='textarea'&&node.title=='Description'">
                <textarea name="description" id="description@{{$index}}" class="form-control"  style="border-radius: 0px;" ng-model="node.value" ng-required="@{{node.customerRequiredFormSubmit}}"></textarea>
                <span style="color:red" ng-show="description">
                                          <span>Description is required.</span>
                </span> 
                <div ng-if="node.title=='Description'" style="margin-top:20px">
                   <div id="fileList@{{$index}}"></div>
                        <span id="fileselector">
                            <label class="btn btn-default" for="upload-file-selector" style='border: none;'>
                                <input id="upload-file-selector" type="file" name="attachment[]"  multiple 
                       onchange="angular.element(this).scope().updateList(this)" >
                                          <i class="fa_icon icon-plus margin-correction"></i>Attach files
                            </label>
                            <p><i>Max File Upload size : {{file_upload_max_size()}}MB and Max Number of Files :{{ini_get('max_file_uploads')}}</i></p>
                        </span>
                </div>
                </div>
                <div ng-if="node.type=='select'&&node.default=='yes'&&node.customerDisplay">
                <select  ng-model="node.value" name="selected@{{$index}}" id="seletom@{{$index}}" ng-options="option.optionvalue for option in node.options" class="form-control" style="border-radius: 0px;width:85%;display:inline-block" ng-required="@{{node.customerRequiredFormSubmit}}" ng-click="getSelectOptions(node.api,$index)">
                  <option value="">Select</option>
                </select>
                <span ng-show="loado@{{$index}}" style="width:15%"><img src="{{asset("lb-faveo/media/images/gifloader.gif")}}" style="width:20px;height:20px"></span>
                <div style="color:red" ng-show="faveoClientForm.selected@{{$index}}.$dirty && faveoClientForm.selected@{{$index}}.$invalid">
                  <span ng-show="faveoClientForm.selected@{{$index}}.$error.required">@{{node.label | translate}} is required.</span>
                </div>
                </div>
                <select  ng-model="node.value" name="selected@{{$index}}" ng-if="node.type=='select'&&node.default=='no'&&node.customerDisplay" ng-options="option.optionvalue for option in node.options" class="form-control" style="border-radius: 0px;width:85%" ng-required="@{{node.customerRequiredFormSubmit}}">
                  <option value="">Select</option>
                </select>
                <span style="color:red" ng-show="faveoClientForm.selected@{{$index}}.$dirty && faveoClientForm.selected@{{$index}}.$invalid">
                  <span ng-show="faveoClientForm.selected@{{$index}}.$error.required">@{{node.label | translate}} is required.</span>
               </span>
                <ul class="list-group" ng-if="node.type=='radio'&&node.customerDisplay" style="border:none">
                      <li ng-repeat="option in node.options"  class="list-group-item" style="border:none">
                                          <input type="radio" name="selection" id="happy@{{$index}}" ng-model="node.value" value="@{{option.optionvalue}}" ng-required="!node.value"/>
                                            <label for="happy@{{$index}}">@{{option.optionvalue}}</label>
                      </li>
                </ul>
                <ul class="list-group" ng-if="node.type=='checkbox'" style="border:none">
                      <label ng-repeat="option in node.options"  class="list-group-item" style="border:none">
                                           <input type="checkbox" 
                                                name="selectedValue[]" ng-model="option.checked" value="@{{option.optionvalue}}">
                                           <span>@{{option.optionvalue}}</span>
                       
                          <ul ng-model="option.nodes" ng-class="{hidden: collapsed}"  style="list-style-type:none;margin-left: -70px" ng-if="option.checked==true && option.nodes.length>0" >
                              <li  ng-repeat="node in option.nodes" ng-include="'nodes_renderer2.html'"></li>
                       </ul>
                      </label>
                </ul>
              </div>
              <div class="col-sm-12"  ng-repeat="option in node.options" ng-if="option.nodes.length>0 && node.value && node.title=='Nested Select'">
                  <ul ng-model="option.nodes" ng-class="{hidden: collapsed}" style="list-style-type:none;margin-left: -70px" ng-if="option==node.value">
                      <li  ng-repeat="node in option.nodes" ng-include="'nodes_renderer2.html'">
                    </li>
                  </ul>

              </div>
              <div class="col-sm-12"  ng-repeat="option in node.options" ng-if="option.nodes.length>0 && node.value && node.title=='Nested Radio'">
                  <ul ng-model="option.nodes" ng-class="{hidden: collapsed}" style="list-style-type:none;margin-left: -70px" ng-if="option.optionvalue==node.value">
                      <li  ng-repeat="node in option.nodes" ng-include="'nodes_renderer2.html'">
                    </li>
                  </ul>
              </div>       
          </div>
          <ul  ng-model="node.nodes" ng-class="{hidden: collapsed}" style="list-style-type:none">
            <li ng-repeat="node in node.nodes"  ng-include="'nodes_renderer2.html'">
            </li>
          </ul>
        </ng-form>
        </script>
        <div class="col-sm-8" style="border: 1px solid gainsboro;" id="rtl">
            <form name="faveoClientFormParent">
            <div class="row">
                <div  style="border-bottom:1px solid gainsboro;background-color: white;padding:5px;" class="col-sm-12">
                    <div class="col-sm-12">
                        <h4>Create a new ticket</h4>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-right:0px">
                <div class="col-sm-12">
                    <ul  ng-model="tree3"  style="list-style-type:none">
                        <li ng-repeat="node in tree3"  ng-include="'nodes_renderer2.html'">
                            
                        </li>
                    </ul>

                </div>
                <div style="text-align:center" id="loader">
                              <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}" >
                            </div>
            </div> 
            <div class="row">
                <div class="col-sm-12" style="border-top:1px solid gainsboro;background-color: white;padding:5px;text-align: right">
                    <button type="button" class="btn btn-info" ng-disabled="faveoClientFormParent.$invalid"  ng-click="uploadPic($event,requesterName)">Submit</button>
                </div>
            </div>
            </form>
        </div>
    </div>

</div>

@stop
@push('scripts')

<script src="{{asset('vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
<script src="{{asset("lb-faveo/js/intlTelInput.js")}}"></script>
<script>
$(document).ready(function() {
    $(".numberOnly").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl/cmd+A
            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: Ctrl/cmd+C
            (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: Ctrl/cmd+X
            (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
});
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
        $scope.uploaded = 0;
        $scope.tree3 = [];
        $scope.headFormObj={};
        $scope.emailFormat = /^[a-z]+[a-z0-9._]+@[a-z]+\.[a-z.]{2,5}$/;
        $http.get("{{url('ticket/form/requester/auth')}}").success(function (data) {
           $scope.userdt=data;
        $http.get("{{url('form/ticket')}}").success(function (data) {
          var datas=data[0];
            for(var i in datas){
               if(datas[i].title=="Requester"){
                    datas[i].value=$scope.userdt.user_name;
               }
            }
            $scope.tree3 = datas;
         
            
//            console.log($scope.tree3);
           setTimeout(function(){
            for(var i in $scope.tree3){
            if($scope.tree3[i].title=='Description'){
            CKEDITOR.replace('description'+i, {
              toolbarGroups: [
                {"name": "basicstyles", "groups": ["basicstyles"]},
                {"name": "links", "groups": ["links"]},
                {"name": "paragraph", "groups": ["list", "blocks"]},
                {"name": "document", "groups": ["mode"]},
                {"name": "insert", "groups": ["insert"]},
                {"name": "styles", "groups": ["styles"]}
            ],
            removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar',
            disableNativeSpellChecker: false
            });
            $("#loader").hide();
           }
          
          }
         if('{{Lang::getLocale()}}'=='ar'){
            $('#rtl').css('direction','rtl');
            $('.input-group').find('.form-control').css('float','inherit');
              $('.col-sm-1,.col-sm-2,.col-sm-3,.col-sm-4,.col-sm-5,.col-sm-6,.col-sm-7,.col-sm-8,.col-sm-9,.col-sm-10,.col-sm-11,.col-sm-12').css('float','none');
              $('.list-group').css('padding-right','0px');
              setTimeout(function(){
                 $('.cke_ltr').attr('dir','rtl');
                 $('.cke_ltr').toggleClass('cke_rtl');
                 $('.cke_wysiwyg_frame').contents().find("html").attr('dir','rtl');
              },500);
            }

          
          },2000);
        })
        })
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
                    e.files[i]['id'] = $scope.uploaded + '-' + i;
                    $scope.uploadArray.push(e.files[i])
                }

            });
            if ($scope.uploaded == 1) {
             for(var i in $scope.tree3){
               if($scope.tree3[i].title=='Description'){
                var output = document.getElementById('fileList'+i);
                for (var i = 0; i < $scope.uploadArray.length; ++i) {
                    $compile($(output).append('<div id="hidden" style="list-style-type:none;background-color: #f5f5f5;border: 1px solid #dcdcdc;font-weight: bold;margin:8px;overflow-y: hidden;padding: 4px 4px 4px 8px;max-width: 448px;margin-left: 14px;" contenteditable="false">' + $scope.uploadArray[i].name + '(' + $scope.uploadArray[i].size + ')<div style="display:none">' + $scope.uploadArray[i].id + '</div><i class="fa fa-times" aria-hidden="true" style="float:right;cursor: pointer;" ng-click="remove($event)"></i></div>'))($scope);
                   }
                  }
                }
            }
            else {
             for(var i in $scope.tree3){
               if($scope.tree3[i].title=='Description'){
                var output = document.getElementById('fileList'+i);
                output.innerHTML = "";
                for (var i = 0; i < $scope.uploadArray.length; ++i) {
                    $compile($(output).append('<div id="hidden" style="list-style-type:none;background-color: #f5f5f5;border: 1px solid #dcdcdc;font-weight: bold;margin:8px;overflow-y: hidden;padding: 4px 4px 4px 8px;max-width: 448px;margin-left: 14px;" contenteditable="false">' + $scope.uploadArray[i].name + '(' + $scope.uploadArray[i].size + ')<div style="display:none">' + $scope.uploadArray[i].id + '</div><i class="fa fa-times" aria-hidden="true" style="float:right;cursor: pointer;" ng-click="remove($event)"></i></div>'))($scope);
                }
               }
              }
            }
        }

     $scope.uploadPic = function (x,y) {
        for(var i in $scope.tree3) {
         if($scope.tree3[i].title=='Description'&&$scope.tree3[i].customerRequiredFormSubmit==true){
          if($(".cke_wysiwyg_frame").contents().find("body").text()){
            x.currentTarget.disabled = true;
            x.currentTarget.innerHTML = 'Sending, please wait...';
            $scope.editor = $(".cke_wysiwyg_frame").contents().find("body").html();
            if ($scope.editor == '<p><br></p>') {
                $scope.editor1 = "";
            }
            else {
                $scope.editor1 = $scope.editor;
            }
            var serialize = $("#form-create").serialize();
            $scope.uploadSize = 0;
            var total_file_number = 0;
            $scope.uploadArray.forEach(function (i) {
                $scope.uploadSize += i.size;
                total_file_number++;
            })
           
             $scope.tree5=angular.copy($scope.tree3);
            $.each($scope.tree5, walker);
      
        function walker(key, value) {
                 
                  delete this.placeholder;
                  delete this.name;
                  delete this.agentRequiredFormSubmit;
                  delete this.customerDisplay;
                  delete this.customerRequiredFormSubmit;
                  delete this.api;
                  delete this.format;
                  
                  if(this.value!=undefined && this.type=='radio' && this.default=='no' && this.title!='Nested Radio'){
                       this[this.label]=this.value;
                       delete this.label; 
                       delete this.value;
                       delete this.type;
                       delete this.default;
                       delete this.title;
                          delete this.options;
                       
                  }
                  else if(this.value!=undefined && this.type=='radio' && this.default=='no' && this.title=='Nested Radio'){
                       this[this.label]=this.options;
                       delete this.label;
                       delete this.type;
                       delete this.default;
                       delete this.title;
                          for(var i in this.options){
                            if(this.value!=this.options[i].optionvalue){
                                  delete this.options[i]
                            }
                            else{ 
                                  this.options[this.value]=this.options[i].nodes;
                                  
                                  if (typeof this.options[this.value] === "object"  && this.options[i].nodes !=0) {
                                       // Recurse into children
                                        $.each(this.options[this.value], walker);
                                  }
                                  else{
                                        this.options[this.value]=1;
                                  }
                                  delete this.options[i];
                            }
                          }
                       
                       delete this.value;
                        delete this.options; 
                  }

                  else if(this.default=='no' && this.type=='select' &&  this.title=='Nested Select'){
                      this[this.label]=this.options;
                      delete this.label; 
                       delete this.type;
                       delete this.default;
                       delete this.title;
                       for(var i in this.options){
                            if(this.value.id!=this.options[i].id){
                                  delete this.options[i];
                            }
                            else{
                            
                                this.options[this.value.optionvalue]=this.options[i].nodes;
                                 
                                 if (typeof this.options[this.value.optionvalue] === "object" && this.options[i].nodes !=0) {
                                       // Recurse into children
                                        $.each(this.options[this.value.optionvalue], walker);
                                  }
                                  else{

                                        this.options[this.value.optionvalue]=1;
                                  }

                                  delete this.options[i];
                            }
                          }
                      delete this.value;
                       delete this.options;
                  }
                  else if(this.default=='no' && this.type=='select' && this.title!='Nested Select'){
                      this[this.label]=this.value.optionvalue;
                      delete this.label; 
                       delete this.value;
                       delete this.type;
                       delete this.default;
                       delete this.title;
                       delete this.options;
                  }
                  else if(this.default=='no' && this.type=='checkbox' && this.title!='Nested Checkbox'){
                        var checkboxValue=[];
                      for(var i in this.options){
                         if(this.options[i].checked==true){
                            checkboxValue.push(this.options[i].optionvalue)
                         }
                      }
                      this[this.label]=checkboxValue;
                       delete this.label; 
                       delete this.value;
                       delete this.type;
                       delete this.default;
                       delete this.title;
                       delete this.options;
                  }
                   else if(this.default=='no' && this.type=='checkbox' && this.title=='Nested Checkbox'){
                      this[this.label]=this.options;
                       delete this.label; 
                       delete this.type;
                       delete this.default;
                       delete this.title;
                       for(var i in this.options){
                          if(this.options[i].checked==false || this.options[i].checked==""){
                            delete this.options[i];
                         }
                         else{
                            this.options[this.options[i].optionvalue]=this.options[i].nodes;
                            
                            if (typeof this.options[this.options[i].optionvalue] === "object" && this.options[i].nodes.length !=0) {
                                       // Recurse into children
                                        $.each(this.options[this.options[i].optionvalue], walker);
                                  }
                              else{
                                  alert('1')
                                  this.options[this.options[i].optionvalue]=1; 
                              }
                             delete this.options[i];
                         }
                       }
                        delete this.options;
                  }
                  else if(this.default=='yes' && this.title=="Description"){
                       this[this.label]=$scope.editor1;
                       delete this.label; 
                       delete this.value;
                       delete this.type;
                       delete this.default;
                       delete this.title;
                  }
                  else if(this.default=='yes' && this.type=="select"){
                        this[this.label]=this.value.id;
                        delete this.label; 
                        delete this.value;
                        delete this.type;
                        delete this.default;
                        delete this.title;
                        delete this.options;
                  }
                  else if(this.default=='yes' && this.title=="Requester"){
                       if($scope.reqId!=null){
                        this[this.label]=$scope.reqId;
                      }
                      else if($scope.reqValue!=null){
                         this[this.label]=$scope.reqValue;
                      }
                      else{
                         this[this.label]=this.value;
                      }
                        delete this.label; 
                        delete this.value;
                        delete this.type;
                        delete this.agentCCfield;
                        delete this.agent_email;
                        delete this.agent_mobile;
                        delete this.agent_name;
                        delete this.customerCCfield;
                        delete this.customer_email;
                        delete this.customer_mobile;
                        delete this.customer_name;
                        delete this.default;
                        delete this.title;
                  }
                   else if(this.default=='yes' && this.title=="Subject"){
                        this[this.label]=this.value;
                        delete this.label; 
                        delete this.value;
                        delete this.type;
                        delete this.default;
                        delete this.title;
                        
                  }
                  else{
                       this[this.label]=this.value;
                       delete this.label; 
                       delete this.value;
                       delete this.type;
                       delete this.default;
                       delete this.title;
                  }
                  
                  }
                $.each($scope.tree5, reeduce);
                  function reeduce(key,value){
                      if('Requester' in value){
                        $scope.tree5['Requester']=value.Requester;
                          
                      }
                      else if('Subject' in value){
                        $scope.tree5['Subject']=value.Subject;
                         
                      }
                      else if('Type' in value){
                        $scope.tree5['Type']=value.Type;
                        
                      }
                      else if('Status' in value){
                        $scope.tree5['Status']=value.Status;
                        
                      }
                      else if('Priority' in value){
                        $scope.tree5['Priority']=value.Priority;
                        
                      }
                      else if ('Help Topic' in value){
                         var array=Object.values(value)
                        $scope.tree5['Help Topic']=array[0];
                        $
                      }
                      else if('Assigned' in value){
                        $scope.tree5['Assigned']=value.Assigned;
                        
                      }
                      else if('Description' in value){
                        $scope.tree5['Description']=value.Description;
                        
                      }
                  }
                  
                  console.log($scope.tree5)

            
            $scope.tree5['attachment']=$scope.uploadArray;
            var maxsize = ($scope.uploadSize / 1024) / 1024;
            var max_file_number = "{{ini_get('max_file_uploads')}}";
            var file_upload_max_size = "{{file_upload_max_size()}}";
            if($('#requesterName').val())
            {
            $scope.tree5['Requester_name']=document.getElementById('requesterName').value;
             }
             if($('#requesterMobile').val())
            {
            $scope.tree5['Requester_mobile']=document.getElementById('requesterMobile').value;
             }
             if($('#requesterEmail').val())
            {
            $scope.tree5['Requester_email']=document.getElementById('requesterEmail').value;
             }
            if($('.selected-dial-code').html())
            {
            $scope.tree5['Requester_code']=$('.selected-dial-code').html();
             }
            
             if($scope.reqValue!=null){
                   $scope.tree5['Requester']=$scope.reqValue;
               }
             else if($scope.userdt!=null){
                  $scope.tree5['Requester']=$scope.userdt.id;
             }
            if (maxsize <= file_upload_max_size && total_file_number <= max_file_number) {
               console.log($scope.headFormObj);
                $scope.uploadArray.upload = Upload.upload({
                    url: "{{url('postedform')}}",
                    data: $scope.tree5,
                }).success(function (data) {
               $('.well').css('display','block');      
               $('.well').html(data.result.success);
                $('.well').css('color','green');
                $('html, body').animate({scrollTop:0}, 500);
            x.currentTarget.innerHTML = 'Submit';
            $scope.reqValue="";
            $scope.headFormObj['Requester_name']="";
            $scope.headFormObj['Requester_email']="";
            $scope.headFormObj['Requester_name']="";
            setTimeout(function(){
                  location.reload();
            },2000);     
         })
                        .error(function (data) {
                            x.currentTarget.disabled = false;
                            x.currentTarget.innerHTML = "Submit";
                            $('.well').css('display','block');      
                            $('.well').html(data.error);
                            $('.well').css('color','red');
                            $('html, body').animate({scrollTop: 0}, 500);
                        })
                    
            } else if (maxsize > file_upload_max_size && total_file_number <= max_file_number) {
                alert('failed!! size and file number are maximum');
                x.currentTarget.disabled = false;
                x.currentTarget.innerHTML = "Create Ticket";
            }
            else if (maxsize > file_upload_max_size) {
                alert('failed!! file size is maximum');
                x.currentTarget.disabled = false;
                x.currentTarget.innerHTML= "Create Ticket";

            } else if (total_file_number <= max_file_number) {
                alert('failed!!   file number is maximum');
                x.currentTarget.disabled = false;
                x.currentTarget.innerHTML= "Create Ticket";
            }
            }
                else{
                    $scope.description=true;
                }
                }
            else if($scope.tree3[i].title=='Description'&&$scope.tree3[i].customerRequiredFormSubmit==false){
               x.currentTarget.disabled = true;
            x.currentTarget.innerHTML = 'Sending, please wait...';
            $scope.editor = $(".cke_wysiwyg_frame").contents().find("body").html();
            if ($scope.editor == '<p><br></p>') {
                $scope.editor1 = "";
            }
            else {
                $scope.editor1 = $scope.editor;
            }
            var serialize = $("#form-create").serialize();
            $scope.uploadSize = 0;
            var total_file_number = 0;
            $scope.uploadArray.forEach(function (i) {
                $scope.uploadSize += i.size;
                total_file_number++;
            })
            
           $scope.tree5=angular.copy($scope.tree3);
            $.each($scope.tree5, walker);
      
        function walker(key, value) {
                 
                  delete this.placeholder;
                  delete this.name;
                  delete this.agentRequiredFormSubmit;
                  delete this.customerDisplay;
                  delete this.customerRequiredFormSubmit;
                  delete this.api;
                  delete this.format;
                  
                  if(this.value!=undefined && this.type=='radio' && this.default=='no' && this.title!='Nested Radio'){
                       this[this.label]=this.value;
                       delete this.label; 
                       delete this.value;
                       delete this.type;
                       delete this.default;
                       delete this.title;
                          delete this.options;
                       
                  }
                  else if(this.value!=undefined && this.type=='radio' && this.default=='no' && this.title=='Nested Radio'){
                       this[this.label]=this.options;
                       delete this.label;
                       delete this.type;
                       delete this.default;
                       delete this.title;
                          for(var i in this.options){
                            if(this.value!=this.options[i].optionvalue){
                                  delete this.options[i]
                            }
                            else{ 
                                  this.options[this.value]=this.options[i].nodes;
                                  
                                  if (typeof this.options[this.value] === "object"  && this.options[i].nodes !=0) {
                                       // Recurse into children
                                        $.each(this.options[this.value], walker);
                                  }
                                  else{
                                        this.options[this.value]=1;
                                  }
                                  delete this.options[i];
                            }
                          }
                       
                       delete this.value;
                        delete this.options; 
                  }

                  else if(this.default=='no' && this.type=='select' &&  this.title=='Nested Select'){
                      this[this.label]=this.options;
                      delete this.label; 
                       delete this.type;
                       delete this.default;
                       delete this.title;
                       for(var i in this.options){
                            if(this.value.id!=this.options[i].id){
                                  delete this.options[i];
                            }
                            else{
                            
                                this.options[this.value.optionvalue]=this.options[i].nodes;
                                 
                                 if (typeof this.options[this.value.optionvalue] === "object" && this.options[i].nodes !=0) {
                                       // Recurse into children
                                        $.each(this.options[this.value.optionvalue], walker);
                                  }
                                  else{

                                        this.options[this.value.optionvalue]=1;
                                  }

                                  delete this.options[i];
                            }
                          }
                      delete this.value;
                       delete this.options;
                  }
                  else if(this.default=='no' && this.type=='select' && this.title!='Nested Select'){
                      this[this.label]=this.value.optionvalue;
                      delete this.label; 
                       delete this.value;
                       delete this.type;
                       delete this.default;
                       delete this.title;
                       delete this.options;
                  }
                  else if(this.default=='no' && this.type=='checkbox' && this.title!='Nested Checkbox'){
                        var checkboxValue=[];
                      for(var i in this.options){
                         if(this.options[i].checked==true){
                            checkboxValue.push(this.options[i].optionvalue)
                         }
                      }
                      this[this.label]=checkboxValue;
                       delete this.label; 
                       delete this.value;
                       delete this.type;
                       delete this.default;
                       delete this.title;
                       delete this.options;
                  }
                   else if(this.default=='no' && this.type=='checkbox' && this.title=='Nested Checkbox'){
                      this[this.label]=this.options;
                       delete this.label; 
                       delete this.type;
                       delete this.default;
                       delete this.title;
                       for(var i in this.options){
                          if(this.options[i].checked==false || this.options[i].checked==""){
                            delete this.options[i];
                         }
                         else{
                            this.options[this.options[i].optionvalue]=this.options[i].nodes;
                            
                            if (typeof this.options[this.options[i].optionvalue] === "object" && this.options[i].nodes.length !=0) {
                                       // Recurse into children
                                        $.each(this.options[this.options[i].optionvalue], walker);
                                  }
                              else{
                                  alert('1')
                                  this.options[this.options[i].optionvalue]=1; 
                              }
                             delete this.options[i];
                         }
                       }
                        delete this.options;
                  }
                  else if(this.default=='yes' && this.title=="Description"){
                       this[this.label]=$scope.editor1;
                       delete this.label; 
                       delete this.value;
                       delete this.type;
                       delete this.default;
                       delete this.title;
                  }
                  else if(this.default=='yes' && this.type=="select"){
                        this[this.label]=this.value.id;
                        delete this.label; 
                        delete this.value;
                        delete this.type;
                        delete this.default;
                        delete this.title;
                        delete this.options;
                  }
                  else if(this.default=='yes' && this.title=="Requester"){
                       if($scope.reqId!=null){
                        this[this.label]=$scope.reqId;
                      }
                      else if($scope.reqValue!=null){
                         this[this.label]=$scope.reqValue;
                      }
                      else{
                         this[this.label]=this.value;
                      }
                        delete this.label; 
                        delete this.value;
                        delete this.type;
                        delete this.agentCCfield;
                        delete this.agent_email;
                        delete this.agent_mobile;
                        delete this.agent_name;
                        delete this.customerCCfield;
                        delete this.customer_email;
                        delete this.customer_mobile;
                        delete this.customer_name;
                        delete this.default;
                        delete this.title;
                  }
                   else if(this.default=='yes' && this.title=="Subject"){
                        this[this.label]=this.value;
                        delete this.label; 
                        delete this.value;
                        delete this.type;
                        delete this.default;
                        delete this.title;
                        
                  }
                  else{
                       this[this.label]=this.value;
                       delete this.label; 
                       delete this.value;
                       delete this.type;
                       delete this.default;
                       delete this.title;
                  }
                  
                  }
                $.each($scope.tree5, reeduce);
                  function reeduce(key,value){
                      if('Requester' in value){
                        $scope.tree5['Requester']=value.Requester;
                          
                      }
                      else if('Subject' in value){
                        $scope.tree5['Subject']=value.Subject;
                         
                      }
                      else if('Type' in value){
                        $scope.tree5['Type']=value.Type;
                        
                      }
                      else if('Status' in value){
                        $scope.tree5['Status']=value.Status;
                        
                      }
                      else if('Priority' in value){
                        $scope.tree5['Priority']=value.Priority;
                        
                      }
                      else if ('Help Topic' in value){
                         var array=Object.values(value)
                        $scope.tree5['Help Topic']=array[0];
                        $
                      }
                      else if('Assigned' in value){
                        $scope.tree5['Assigned']=value.Assigned;
                        
                      }
                      else if('Description' in value){
                        $scope.tree5['Description']=value.Description;
                        
                      }
                  }
                  
                  console.log($scope.tree5)

            
            $scope.tree5['attachment']=$scope.uploadArray;
            var maxsize = ($scope.uploadSize / 1024) / 1024;
            var max_file_number = "{{ini_get('max_file_uploads')}}";
            var file_upload_max_size = "{{file_upload_max_size()}}";
              if($('#requesterName').val())
            {
            $scope.tree5['Requester_name']=document.getElementById('requesterName').value;
             }
             if($('#requesterMobile').val())
            {
            $scope.tree5['Requester_mobile']=document.getElementById('requesterMobile').value;
             }
             if($('#requesterEmail').val())
            {
            $scope.tree5['Requester_email']=document.getElementById('requesterEmail').value;
             }
            if($('.selected-dial-code').html())
            {
            $scope.tree5['Requester_code']=$('.selected-dial-code').html();
             }
             if($scope.reqValue!=null){
                   $scope.tree5['Requester']=$scope.reqValue;
               }
             else if($scope.userdt!=null){
                  $scope.tree5['Requester']=$scope.userdt.id;
             }
            if (maxsize <= file_upload_max_size && total_file_number <= max_file_number) {
               console.log($scope.headFormObj);
                $scope.uploadArray.upload = Upload.upload({
                    url: "{{url('postedform')}}",
                    data: $scope.tree5,
                }).success(function (data) {
               $('.well').css('display','block');      
               $('.well').html(data.result.success);
                $('.well').css('color','green');
                $('html, body').animate({scrollTop:0}, 500);
            x.currentTarget.innerHTML = 'Submit';
            $scope.reqValue="";
            $scope.headFormObj['Requester_name']="";
            $scope.headFormObj['Requester_email']="";
            $scope.headFormObj['Requester_name']="";
            setTimeout(function(){
                  location.reload();
            },2000);     
         })
                        .error(function (data) {
                            x.currentTarget.disabled = false;
                            x.currentTarget.innerHTML = "Submit";
                            $('.well').css('display','block');      
                            $('.well').html(data.error);
                            $('.well').css('color','red');
                            $('html, body').animate({scrollTop: 0}, 500);
                        })
                    
            } else if (maxsize > file_upload_max_size && total_file_number <= max_file_number) {
                alert('failed!! size and file number are maximum');
                x.currentTarget.disabled = false;
                x.currentTarget.innerHTML = "Create Ticket";
            }
            else if (maxsize > file_upload_max_size) {
                alert('failed!! file size is maximum');
                x.currentTarget.disabled = false;
                x.currentTarget.innerHTML= "Create Ticket";

            } else if (total_file_number <= max_file_number) {
                alert('failed!!   file number is maximum');
                x.currentTarget.disabled = false;
                x.currentTarget.innerHTML= "Create Ticket";
            }
            }
                }
        }

       
        $scope.checkboxValue = function (x) {
            $scope.selectedValue = x.nodes[0];
        }

       $scope.bou=0;
        $scope.getSelectOptions=function(x,y){
             $scope.bou++;
            var dependancy = x;
            if($scope.bou==1){
            $scope['loado'+y]=true;
            $http.get("{{url('ticket/form/dependancy?dependency=')}}"+dependancy).success(function (data) {
                 $('#seletom'+y).attr('ng-click',null).unbind('click');
                 $scope.tree3[y].options=data;
                 $('#seletom'+y).css('height', parseInt($('#seletom'+y+' option').length) * 33);
                 $scope['loado'+y]=false;
                 $scope.bou=0;
            });
          }
        }
        $scope.clientUserName=function(){
            var charCode = $('#clientreq').val(); 
           
            $http.get("{{url('ticket/form/requester?term=')}}"+charCode+'&type=client').success(function (data) {
                
                 if(data==""){
                    $scope.newReqField=true;
                    setTimeout(function(){
                    $("#telCode").intlTelInput({
                            // allowDropdown: false,
                            // autoHideDialCode: false,
                            // autoPlaceholder: "off",
                            // dropdownContainer: "body",
                            // excludeCountries: ["us"],
                            // formatOnDisplay: false,
                          geoIpLookup: function(callback) {
                               $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                                    var countryCode = (resp && resp.country) ? resp.country : "";
                                    callback(countryCode);
                                });
                            },
                              initialCountry: "auto",
                          // nationalMode: false,
                          // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
                          // placeholderNumberType: "MOBILE",
                          // preferredCountries: ['cn', 'jp'],
                         separateDialCode: true,
                         utilsScript: "{{asset('lb-faveo/js/utils.js')}}"
                      });
                    },100);
                 }
                 else{
                    $scope.newReqField=false;
                    $scope.reqValue=data.id;
                 }
            });
        };
       
        

    });
</script>

@endpush


