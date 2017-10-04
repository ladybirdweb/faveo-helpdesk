@extends('themes.default1.client.layout.client')

@section('title')
{!! Lang::get('lang.submit_a_ticket') !!} -
@stop
<style>
   .btn-bs-file{
    position:relative;
}
.btn-bs-file input[type="file"]{
    position: absolute;
    top: -9999999;
    filter: alpha(opacity=0);
    opacity: 0;
    width:0;
    height:0;
    outline: none;
    cursor: inherit;
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
        <br/><input type="submit" value="{!! Lang::get('lang.check_ticket_status') !!}" class="btn btn-custom btn-info" style = "white-space: normal;background-color : <?php echo $portal->client_header_color; ?>;border-color : <?php echo $portal->client_header_color; ?>" >
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
              <div class="col-sm-3" style="padding: 0px;">
                 <label  ng-bind-html="$sce.trustAsHtml(node.clientlabel)"></label><span ng-show="node.customerRequiredFormSubmit && node.clientlabel!=''" style="color:red">*</span>
              </div>
              <div class="col-sm-8" style="padding: 0px">
                <input type="text" name="textfield@{{$index}}"  ng-if="node.type=='text'&&node.customerDisplay" class="form-control" style="border-radius: 0px;width:85%" ng-model="node.value" ng-required="@{{node.customerRequiredFormSubmit}}" ng-pattern="node.pattern" ng-disabled="node.disable">
                <span style="color:red" ng-show="faveoClientForm.textfield@{{$index}}.$dirty && faveoClientForm.textfield@{{$index}}.$invalid">
                                          <span ng-show="faveoClientForm.textfield@{{$index}}.$error.required">@{{node.clientlabel}} is required.</span>
                                          <span ng-show="faveoClientForm.textfield@{{$index}}.$error.pattern">@{{node.errmsg}}</span>
                </span>
                <input type="number" name="numberfield@{{$index}}"  ng-if="node.type=='number'&&node.customerDisplay" class="form-control" style="border-radius: 0px;width:85%" ng-model="node.value" ng-required="@{{node.customerRequiredFormSubmit}}" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" ng-disabled="node.disable">
                <span style="color:red" ng-show="faveoClientForm.numberfield@{{$index}}.$dirty && faveoClientForm.numberfield@{{$index}}.$invalid">
                                          <span ng-show="faveoClientForm.numberfield@{{$index}}.$error.required">@{{node.clientlabel}} is required.</span>
                </span>
                <input type="text"  name="datefield@{{$index}}" ng-if="node.type=='date'" class="form-control" style="border-radius: 0px;width:85%" ng-pattern="/^[0,1]?\d{1}\/(([0-2]?\d{1})|([3][0,1]{1}))\/(([1]{1}[9]{1}[9]{1}\d{1})|([2-9]{1}\d{3}))$/" ng-required="@{{node.customerRequiredFormSubmit}}" placeholder="MM/DD/YYYY" ng-model="node.value">
                <span style="color:red" ng-show="faveoClientForm.datefield@{{$index}}.$dirty && faveoClientForm.datefield@{{$index}}.$invalid">
                                          <span ng-show="faveoClientForm.datefield@{{$index}}.$error.required">@{{node.clientlabel}} is required.</span>
                                          <span ng-show="faveoClientForm.datefield@{{$index}}.$error.pattern">Please Enter Valid Correct Format-MM/DD/YYYY</span>
                </span>
                <div class="input-group" ng-if="node.type=='email'&& node.title=='Requester'" style="width:100%">
                           <input type="text" class="form-control"  style="border-radius: 0px;width:85%"  ng-model="node.value" id="clientreq" onchange="angular.element(this).scope().clientUserName(this,angular.element(this).scope().faveoClientForm)" placeholder="Requester Username" ng-required="@{{node.customerRequiredFormSubmit}}" name="reqMail" ng-disabled="node.disable">
                                <!-- <span ng-show="loado@{{$index}}" style="width:15%"><img src="{{asset("lb-faveo/media/images/gifloader.gif")}}" style="width:20px;height:20px"></span> -->
                
                                 
                           <!--  <ul class="dropdown-menu" style="width:85%;display:block" ng-if="reqstr">
                                  <li ng-repeat="email in reqEmails"><a href="javascript:void(0)" ng-click="selectReq(email,$parent.$index)">@{{email.name}}(@{{email.first_name
}} @{{email.last_name}})</a></li>
                            </ul> -->
                </div>
                <div ng-if="newReqField && node.type=='email'&& node.title=='Requester'" style="margin-top:15px;">
                    <input type="text" name="requsName@{{$index}}" class="form-control" style="border-radius:0;margin-top:10px;width:85%" ng-model="req.name" placeholder="New Requester Name" id="requesterName"/>
                                
                    <input type="email" name="requsEmail@{{$index}}" class="form-control" style="border-radius:0;margin-top:10px;width:85%" ng-model="req.email" ng-pattern="emailFormat" placeholder="New Requester Email" id="requesterEmail" required="required"/>
                       <span style="font-style: italic;">(Email is Required)</span>
                                <span style="color:red" ng-show="faveoClientForm.requsEmail@{{$index}}.$dirty && faveoClientForm.requsEmail@{{$index}}.$invalid">
                                          <span ng-show="faveoClientForm.requsEmail@{{$index}}.$error.required">Email is required.</span>
                                          <span ng-show="faveoClientForm.requsEmail@{{$index}}.$error.pattern">Invalid email address.</span>
                                </span>
                    <div class="row" style="width:85%">
                    <div class="col-sm-4" style="margin-top:10px">
                        <input type="tel" class="form-control" id="telCode"style="visibility:hidden"/>
                    </div>
                    <div class="col-sm-8">
                     <input type="text" name="requsMobile@{{$index}}" class="form-control" style="border-radius:0;margin-top:10px" ng-model="req.mobile" placeholder="New Requester mobile" ng-pattern="/^[0-9]{1,99}$/" id="requesterMobile" ng-required="@{{node.customer_mobile}}"/> 
                                <span style="color:red" ng-show="faveoClientForm.requsMobile@{{$index}}.$dirty && faveoClientForm.requsMobile@{{$index}}.$invalid">
                                          <span ng-show="faveoClientForm.requsMobile@{{$index}}.$error.pattern">Invalid Mobile Number.</span>
                                </span> 
                    </div>
                    </div>
                </div>
                <textarea name="descript@{{$index}}"  class="form-control" ng-if="node.type=='textarea'&& node.default=='no'" style="border-radius: 0px;width:85%" ng-model="node.value" ng-required="@{{node.customerRequiredFormSubmit}}" ng-pattern="node.pattern" ng-disabled="node.disable"></textarea>
                <span style="color:red" ng-show="faveoClientForm.descript@{{$index}}.$dirty && faveoClientForm.descript@{{$index}}.$invalid">
                                          <span ng-show="faveoClientForm.descript@{{$index}}.$error.required">@{{node.clientlabel}} is required.</span>
                                          <span ng-show="faveoClientForm.descript@{{$index}}.$error.pattern">@{{node.errmsg}}</span>
                </span>
                <div style="width:85%" ng-if="node.type=='textarea'&&node.title=='Description'">
                <textarea name="description" id="@{{node.unique}}" class="form-control"  style="border-radius: 0px;" ng-model="node.value"></textarea>
                <span style="color:red" ng-show="description">
                                          <span>Description is required.</span>
                </span>
                </div>
                <div ng-if="node.title=='Attachment'" style="margin-top:20px">
                   <div id="@{{node.unique}}" ></div>
                        <label class="btn-bs-file btn btn-sm btn-default @{{node.unique}}">
                              <i class="fa fa-plus"></i>&nbspAttach files
                         <input type="file" multiple ng-model="filename" valid-file onchange="angular.element(this).scope().updateList(this,angular.element(this).scope().node.unique)" ng-required="@{{node.customerRequiredFormSubmit}}"/>
                        </label>
                        <p><i>Max File Upload size : {{file_upload_max_size()}}MB and Max Number of Files :{{ini_get('max_file_uploads')}}</i></p>
                        <span style="color:red;display:none;" class="@{{node.unique}}1">
                                          <span>@{{node.clientlabel}} is required.</span>
                        </span>
                </div>
                <div ng-if="node.type=='select'&&node.default=='yes'&&node.customerDisplay">
                <select  ng-model="node.value" name="selected@{{$index}}" id="seletom@{{$index}}" ng-options="option.optionvalue for option in node.options" class="form-control" style="border-radius: 0px;width:85%;display:inline-block" ng-required="@{{node.customerRequiredFormSubmit}}" ng-click="getSelectOptions(node.api,$index)" ng-disabled="node.disable">
                  <option value="">Select</option>
                </select>
                <span ng-show="loado@{{$index}}" style="width:15%"><img src="{{asset("lb-faveo/media/images/25.gif")}}" style="width:20px;height:20px"></span>
                <div style="color:red" ng-show="faveoClientForm.selected@{{$index}}.$dirty && faveoClientForm.selected@{{$index}}.$invalid">
                  <span ng-show="faveoClientForm.selected@{{$index}}.$error.required">@{{node.clientlabel}} is required.</span>
                </div>
                </div>
                <div vc-recaptcha key="servicKey" ng-if="node.title=='Captcha'&&node.customerDisplay"></div>
               <div ng-if="node.title=='Help Topic'&&node.default=='yes'">
                <select  ng-model="node.value" name="selected@{{$index}}"  ng-options="option.optionvalue for option in node.options" class="form-control" style="border-radius: 0px;width:85%" ng-required="@{{node.customerRequiredFormSubmit}}" ng-change="nestSelectRTL(node.value)" ng-disabled="node.disable">
                  <option value="">Select</option>
                </select>
                <span style="color:red" ng-show="faveoClientForm.selected@{{$index}}.$dirty && faveoClientForm.selected@{{$index}}.$invalid">
                  <span ng-show="faveoClientForm.selected@{{$index}}.$error.required">@{{node.clientlabel}} is required.</span>
               </span>
              </div>
              <div ng-show="node.title=='Department'&&linkDept">
                <select  ng-model="node.value" name="selected@{{$index}}"  ng-options="option.optionvalue for option in node.options" class="form-control" style="border-radius: 0px;width:85%" ng-required="@{{node.customerRequiredFormSubmit}}" ng-change="nestSelectRTL()" ng-disabled="node.disable">
                  <option value="">Select</option>
                </select>
                <span style="color:red" ng-show="faveoClientForm.selected@{{$index}}.$dirty && faveoClientForm.selected@{{$index}}.$invalid">
                  <span ng-show="faveoClientForm.selected@{{$index}}.$error.required">@{{node.clientlabel}} is required.</span>
               </span>
              </div>
                <div ng-if="node.type=='select'&&node.default=='no'&&node.customerDisplay">
                <select  ng-model="node.value" name="selected@{{$index}}"  ng-options="option.optionvalue for option in node.options" class="form-control" style="border-radius: 0px;width:85%" ng-required="@{{node.customerRequiredFormSubmit}}" ng-change="nestSelectRTL()" ng-disabled="node.disable">
                  <option value="">Select</option>
                </select>
                <span style="color:red" ng-show="faveoClientForm.selected@{{$index}}.$dirty && faveoClientForm.selected@{{$index}}.$invalid">
                  <span ng-show="faveoClientForm.selected@{{$index}}.$error.required">@{{node.clientlabel}} is required.</span>
               </span>
               </div>
                <ul class="list-group" ng-if="node.type=='radio'&&node.customerDisplay" style="border:none">
                      <li ng-repeat="option in node.options"  class="list-group-item" style="border:none">
                                          <input type="radio" name="selection@{{node.unique}}" id="happy@{{$index}}" ng-model="node.value" value="@{{option.optionvalue}}" ng-required="!node.value" ng-click="nestedRadioRTL()" ng-disabled="node.disable"/>
                                            <label for="happy@{{$index}}">@{{option.optionvalue}}</label>
                      </li>
                      <div ng-if="node.clientlabel=='' && node.customerRequiredFormSubmit==true" style="color:red">(*Fields are Required)</div>
                </ul>
                <ul class="list-group" ng-if="node.type=='checkbox'" style="border:none">
                      <label ng-repeat="option in node.options"  class="list-group-item" style="border:none">
                                           <input type="checkbox" 
                                                name="selectedValue[]" ng-model="option.checked" value="@{{option.optionvalue}}" ng-click="updateSelection($parent.$index,option.optionvalue)" ng-required="checkBoxArray@{{$parent.$index}}.length==0" ng-disabled="node.disable">
                                           <span ng-bind-html="$sce.trustAsHtml(option.optionvalue)"></span>
                                           <div ng-if="node.clientlabel=='' && node.customerRequiredFormSubmit==true">(*Fields are Required)</div>
                          <ul ng-model="option.nodes" ng-class="{hidden: collapsed}"  style="list-style-type:none;margin-left: -70px" ng-if="option.checked==true && option.nodes.length>0" class='rtlCheck'>
                              <li  ng-repeat="node in option.nodes" ng-include="'nodes_renderer2.html'" ng-click="prevent($event)"></li>
                       </ul>
                      </label>
                      <div ng-if="node.clientlabel=='' && node.customerRequiredFormSubmit==true" style="color:red">(*Fields are Required)</div>
                </ul>
              </div>
              <div class="col-sm-12"  ng-repeat="option in node.options" ng-if="option.nodes.length>0 && node.value && (node.title=='Nested Select'||node.type=='multiselect')">
                  <ul ng-model="option.nodes" ng-class="{hidden: collapsed}" style="list-style-type:none;margin-left: -70px" ng-if="option==node.value" class="rtlSelect">
                      <li  ng-repeat="node in option.nodes" ng-include="'nodes_renderer2.html'">
                    </li>
                  </ul>

              </div>
              <div class="col-sm-12"  ng-repeat="option in node.options" ng-if="option.nodes.length>0 && node.value && node.title=='Nested Radio'">
                  <ul ng-model="option.nodes" ng-class="{hidden: collapsed}" style="list-style-type:none;margin-left: -70px" ng-if="option.optionvalue==node.value" class="rtlRadio">
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
                        <h4>{!!Lang::get('lang.create_new_ticket')!!}</h4>
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
    app.directive('validFile',function(){
  return {
    require:'ngModel',
    link:function(scope,el,attrs,ngModel){
      //change event is fired when file is selected
      el.bind('change',function(){
        scope.$apply(function(){
          ngModel.$setViewValue(el.val());
          ngModel.$render();
        });
      });
    }
  }
});
app.directive('input', [function() {
    return {
        restrict: 'E',
        require: '?ngModel',
        link: function(scope, element, attrs, ngModel) {
            if (
                   'undefined' !== typeof attrs.type
                && 'number' === attrs.type
                && ngModel
            ) {
                ngModel.$formatters.push(function(modelValue) {
                    return Number(modelValue);
                });

                ngModel.$parsers.push(function(viewValue) {
                    return Number(viewValue);
                });
            }
        }
    }
}]);
    app.controller('clientFormCtrl', function ($scope, $http, $sce, $window, $compile, Upload, $timeout,vcRecaptchaService) {
        $scope.servicKey="{{commonSettings('google', 'service_key')}}";
        $scope.$sce=$sce;
        $scope.disable = true;
        $scope.inlineImage = true;
        $scope.arrayImage = [];
        $scope.attachmentImage = [];
        $scope.inlinImage = [];
        $scope.uploaded = 0;
        $scope.tree3 = [];
        $scope.multiAttach=[];
        $scope.UserInfo=[];
        $scope.headFormObj={};
        $scope.UserInfo=[];
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
            $http.get("{{url('ticket/form/dependancy?dependency=helptopic')}}").success(function (data1) {
           for(var i in datas){

              if(datas[i].api=="helptopic"){

                  datas[i].options=data1;  
                  $http.get("{{url('ticket/form/dependancy?dependency=department')}}").success( function (data2) {
                        for(var i in datas){
                           if(data[0][i].api=="department"&& !data[0][i].linkHelpTopic){
                                 data[0][i].options=data2;
                                 $scope.linkDept=true;  
                              }
                            if(data[0][i].api=="department"&& data[0][i].linkHelpTopic){
                                 //alert('0')
                                  $scope.linkDept=false;
                                  $scope.departmentAgentLabel=data[0][i].agentlabel;
                                 data[0][i].clientlabel='';  
                            }
                          }
            $scope.tree3 = datas;
            console.log($scope.tree3);
             // Get URLparams 
             var search = location.search.substring(1);

             if(search.length!==0){
                $scope.userDetails=JSON.parse('{"' + decodeURI(search).replace(/"/g, '\\"').replace(/&/g, '","').replace(/=/g,'":"') + '"}')
                console.log($scope.userDetails);
            }
            $.each($scope.tree3, maker);

        function maker(key, value) {
                 var lang='{{Lang::getLocale()}}';
            if(typeof value==='object'){
                 if(value.type==='checkbox'){
                      $scope['checkBoxArray'+key]=[];
                  }
                  if(value.title=='Attachment'){
                     $scope.UserInfo[value.unique]=[]; 
                  }
                  if(value.title=='Captcha'&&value.customerDisplay){
                        $scope.clientCaptcha=true;
                  }
                  else{
                        vcRecaptchaService.getResponse=function(){
                            return null;
                        };
                  }
                };
                if(typeof value==='object'){
                if((value.type==='radio'||value.type==='checkbox'||value.type==='select' && value.default==='no')||(value.type==='multiselect' && value.default==='yes')){
                    
                    for(var i in value.options){
                      for(var j in value.options[i].optionvalue){
                          if(value.options[i].optionvalue[j].language===lang){
                              value.options[i].optionvalue=value.options[i].optionvalue[j].option;
                              break;
                          }
                      }
                    }
                }
            }
            if(typeof value==='object'){
                if((value.type==='radio'||value.type==='checkbox'||value.type==='select' && value.default==='no')||(value.type==='multiselect' && value.default==='yes')){
                    
                    for(var i in value.options){
                      if(typeof value.options[i].optionvalue ==='object'){
                        for(var j in value.options[i].optionvalue){
                          if(value.options[i].optionvalue[j].language!==lang){
                            if(j==0){
                              value.options[i].optionvalue=value.options[i].optionvalue[j].option;
                            }
                          }
                      }
                     }
                    }
                }
            }
            if(typeof value==='object'){
               if(value.clientlabel!=""){
                for(var a in value.clientlabel){
                  if(value.clientlabel[a].language=='{{Lang::getLocale()}}'){
                     value.clientlabel=value.clientlabel[a].label;
                     break;
                  }
                }
              }
            }
            if(typeof value==='object'){
              if(value.agentlabel!=""){
                for(var a in value.clientlabel){
                  if(typeof value.clientlabel ==='object'){
                    if(value.clientlabel[a].language !=='{{Lang::getLocale()}}'){
                       if(a==0){
                        value.clientlabel=value.clientlabel[a].label;
                      }
                    }
                  }
                }
              }
            }
            if(typeof value==='object'){
                for(var a in value.errmsg){
                  if(value.errmsg[a].language=='{{Lang::getLocale()}}'){
                     value.errmsg=value.errmsg[a].label;
                     break;
                  }
                }
            }
            if(typeof value==='object'){
                for(var a in value.errmsg){
                  if(typeof value.errmsg ==='object'){
                    if(value.errmsg[a].language !=='{{Lang::getLocale()}}'){
                       if(a==0){
                        value.errmsg=value.clientlabel[a].label;
                      }
                    }
                  }
                }
            }
            if (value !== null && typeof value === "object") {

                    $.each(value, maker);
                }
            }
         //  URLparams binding
          if(search.length!==0){
            for(var i in $scope.userDetails){
              
                $.each($scope.tree3, waker);

                 function waker(key, value) {
                       if (value !== null && typeof value === "object" && value.type!='checkbox' && value.type!='select'&& value.type!='multiselect') {
                              
                              if(i==value.unique){
                                  
                                  value.value=$scope.userDetails[i];
                              }
                              else if(i==value.unique+'_writable'){
                                 if($scope.userDetails[i]==1){
                                    this['disable']=true;
                                 }
                              }
                          $.each(value, waker);
                     }
                     else if (value !== null && typeof value === "object" && value.type=='checkbox') {
                          
                             if(typeof $scope.userDetails[i]=='object' && $scope.userDetails[i]!=null){
                                      //console.log($scope.userDetails[i])
                                  $.each($scope.userDetails[i], function(key,el){
                                         if(typeof el=='object'){
                                                $.each(el, function(key,el){
                                                       if(key==value.unique){
                                                             for(var j in value.options){
                                                                if(value.options[j].optionvalue==el){
                                                                      value.options[j].checked=true;
                                                                 }
                                                             }
                                                       } 
                                                   })
                                             }
                                    }) 
                               }
                               else{
                                   if(value.unique==i){
                                     for(var j in value.options){
                                        if(value.options[j].optionvalue===$scope.userDetails[i]){
                                            value.options[j].checked=true;
                                        }
                                      }
                                  }
                                  else if(i==value.unique+'_writable'){
                                    if($scope.userDetails[i]==1){
                                          this['disable']=true;
                                        }
                                    }
                               }
                          $.each(value, waker);
                     }
                    else if (value !== null && typeof value === "object" && (value.type=='select'||value.type=='multiselect')) {
                             if(typeof $scope.userDetails[i]=='object' && $scope.userDetails[i]!=null){
                                      //console.log($scope.userDetails[i])
                                  $.each($scope.userDetails[i], function(key,el){
                                         if(typeof el=='object'){
                                                $.each(el, function(key,el){
                                                       if(key==value.unique){
                                                             for(var j in value.options){
                                                                if(value.options[j].optionvalue==el){
                                                                      value.value=value.options[j];
                                                                 }
                                                             }
                                                       } 
                                                   })
                                             }
                                    }) 
                               }
                               else{
                                   if(value.unique==i){
                                     for(var j in value.options){
                                        if(value.options[j].optionvalue===$scope.userDetails[i]){
                                             value.value=value.options[j];
                                        }
                                      }
                                  }
                                  else if(i==value.unique+'_writable'){
                                    if($scope.userDetails[i]==1){
                                          this['disable']=true;
                                        }
                                    }
                               }
                          $.each(value, waker);
                    }
                 }
               }
            }
            
            //console.log($scope.multiAttach);
            
           setTimeout(function(){
            for(var i in $scope.tree3){
            if($scope.tree3[i].title=='Description'){
            CKEDITOR.replace($scope.tree3[i].unique, {
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
            CKEDITOR.config.scayt_autoStartup = true;
            CKEDITOR.config.extraPlugins = 'autolink';
            $("#loader").hide();
            var captchaApi = document.createElement('script');
              captchaApi.src = 'https://www.google.com/recaptcha/api.js?onload=vcRecaptchaApiLoaded&render=explicit';
              captchaApi.async="";
              captchaApi.defer="";
            document.head.appendChild(captchaApi);
           }
          
          }
         if('{{Lang::getLocale()}}'=='ar'){
            $('#rtl').css('direction','rtl');
            $('.input-group').find('.form-control').css('float','inherit');
              $('.col-sm-1,.col-sm-2,.col-sm-3,.col-sm-4,.col-sm-5,.col-sm-6,.col-sm-7,.col-sm-8,.col-sm-9,.col-sm-10,.col-sm-11,.col-sm-12').css('float','right');
              $('.list-group').css('padding-right','0px');
              setTimeout(function(){
                 $('.cke_ltr').attr('dir','rtl');
                 $('.cke_ltr').toggleClass('cke_rtl');
                 $('.cke_wysiwyg_frame').contents().find("html").attr('dir','rtl');
              },500);
            }

          
          },2000);
         })  
        }
      }
    })
  })
})
         
        $scope.remove = function (x,y) {
            var id = x.currentTarget.parentNode;
            console.log(id);
            $(id).remove();
            var value = id.firstElementChild.innerHTML;
            //console.log(value);
            $scope.UserInfo[y] = $.grep($scope.UserInfo[y], function (e) {
                return e.id != value;

            })
            if($scope.UserInfo[y].length==0){
                if($('.'+y).find('input').prop('required')){
                   $('.'+y+'1').css('display','block');
                }

            }
        }
        $scope.checkUnique=function(x){
               console.log(x);
        }
        $scope.uploadArray = [];
        $scope.updateList = function (e,x) {
            if($('.'+x+'1').css('display')=='block'){
                $('.'+x+'1').css('display','none');
            }
            $scope.$apply(function () {
                $scope.uploaded++;

                for (var i = 0; i < e.files.length; i++) {
                    e.files[i]['id'] = $scope.uploaded + '-' + i;
                    $scope.UserInfo[x].push(e.files[i])
                }

            });
            if ($scope.uploaded == 1) {
                var output = document.getElementById(x);
                for (var i = 0; i < $scope.UserInfo[x].length; ++i) {
                    $compile($(output).append('<div id="hidden" style="list-style-type:none;background-color: #f5f5f5;border: 1px solid #dcdcdc;font-weight: bold;margin:8px;overflow-y: hidden;padding: 4px 4px 4px 8px;max-width: 448px;margin-left: 0px;" contenteditable="false">' + $scope.UserInfo[x][i].name + '(' + $scope.UserInfo[x][i].size + ')<div style="display:none">' + $scope.UserInfo[x][i].id + '</div><i class="fa fa-times" aria-hidden="true" style="float:right;cursor: pointer;" ng-click="remove($event,\''+x+'\')"></i></div>'))($scope);
                   }
            }
            else {
                var output = document.getElementById(x);
                output.innerHTML = "";
                for (var i = 0; i < $scope.UserInfo[x].length; ++i) {
                    $compile($(output).append('<div id="hidden" style="list-style-type:none;background-color: #f5f5f5;border: 1px solid #dcdcdc;font-weight: bold;margin:8px;overflow-y: hidden;padding: 4px 4px 4px 8px;max-width: 448px;margin-left: 0px;" contenteditable="false">' + $scope.UserInfo[x][i].name + '(' + $scope.UserInfo[x][i].size + ')<div style="display:none">' + $scope.UserInfo[x][i].id + '</div><i class="fa fa-times" aria-hidden="true" style="float:right;cursor: pointer;" ng-click="remove($event,\''+x+'\')"></i></div>'))($scope);
                }
            }
            console.log($scope.UserInfo);
        }
       $scope.nestSelectRTL=function(x){
            if('{{Lang::getLocale()}}'=='ar'){
              setTimeout(function(){
                 $('.col-sm-1,.col-sm-2,.col-sm-3,.col-sm-4,.col-sm-5,.col-sm-6,.col-sm-7,.col-sm-8,.col-sm-9,.col-sm-10,.col-sm-11,.col-sm-12').css('float','right');
                 $(".rtlSelect").css({"margin-left":"0px","margin-right":"-70"})
                },100);
            }
        if(typeof x=="object"&&x!=undefined){  
           $http.get("{{url('ticket/form/dependancy?dependency=department')}}&linkedtopic="+x.id).success( function (data) {
            for(var i in data){
                                 for(var j in data[i].optionvalue){
                                      if(data[i].optionvalue[j].language==='{{Lang::getLocale()}}'){
                                          data[i].optionvalue=data[i].optionvalue[j].option;
                                          break;
                                        }
                                 }
                    }
            for(var i in data){
                if(typeof data[i].optionvalue=="object"){
                                 for(var j in data[i].optionvalue){
                                    if(data[i].optionvalue[j].language !=='{{Lang::getLocale()}}'){
                                           if(j==0){
                                              data[i].optionvalue=data[i].optionvalue[j].option;
                                              break;
                                            }
                                    }
                            }
                    }
            }
    for(var g in data){
      if(data[g].nodes!=undefined||data[g].nodes.length!=0){
        $.each(data[g].nodes, worker);
        function worker(key, value) {
                 var lang='{{Lang::getLocale()}}';
            if(typeof value==='object'){
                 if(value.type==='checkbox'){
                      $scope['checkBoxArray'+key]=[];
                  }
                  if(value.title=='Attachment'){
                     $scope.UserInfo[value.unique]=[]; 
                  }
                  
                };
                if(typeof value==='object'){
                if((value.type==='radio'||value.type==='checkbox'||value.type==='select' && value.default==='no')||(value.type==='multiselect' && value.default==='yes')){
                    
                    for(var i in value.options){
                      for(var j in value.options[i].optionvalue){
                          if(value.options[i].optionvalue[j].language===lang){
                              value.options[i].optionvalue=value.options[i].optionvalue[j].option;
                              break;
                          }
                      }
                    }
                }
            }
            if(typeof value==='object'){
                if((value.type==='radio'||value.type==='checkbox'||value.type==='select' && value.default==='no')||(value.type==='multiselect' && value.default==='yes')){
                    
                    for(var i in value.options){
                      if(typeof value.options[i].optionvalue ==='object'){
                        for(var j in value.options[i].optionvalue){
                          if(value.options[i].optionvalue[j].language!==lang){
                            if(j==0){
                              value.options[i].optionvalue=value.options[i].optionvalue[j].option;
                            }
                          }
                      }
                     }
                    }
                }
            }
            if(typeof value==='object'){
               if(value.clientlabel!=""){
                for(var a in value.clientlabel){
                  if(value.clientlabel[a].language=='{{Lang::getLocale()}}'){
                     value.clientlabel=value.clientlabel[a].label;
                     break;
                  }
                }
              }
            }
            if(typeof value==='object'){
              if(value.agentlabel!=""){
                for(var a in value.clientlabel){
                  if(typeof value.clientlabel ==='object'){
                    if(value.clientlabel[a].language !=='{{Lang::getLocale()}}'){
                       if(a==0){
                        value.clientlabel=value.clientlabel[a].label;
                      }
                    }
                  }
                }
              }
            }
            if(typeof value==='object'){
                for(var a in value.errmsg){
                  if(value.errmsg[a].language=='{{Lang::getLocale()}}'){
                     value.errmsg=value.errmsg[a].label;
                     break;
                  }
                }
            }
            if(typeof value==='object'){
                for(var a in value.errmsg){
                  if(typeof value.errmsg ==='object'){
                    if(value.errmsg[a].language !=='{{Lang::getLocale()}}'){
                       if(a==0){
                        value.errmsg=value.clientlabel[a].label;
                      }
                    }
                  }
                }
            }
            if (value !== null && typeof value === "object") {

                    $.each(value, worker);
                }
            }
      }
    }
            for(var i in $scope.tree3){
              if($scope.tree3[i].linkHelpTopic){
                      for(var a in $scope.departmentAgentLabel){
                                if($scope.departmentAgentLabel[a].language==='{{Lang::getLocale()}}'){
                                         $scope.tree3[i].clientlabel=$scope.departmentAgentLabel[a].label;
                                           break;
                                }
                                else if($scope.departmentAgentLabel[a].language !=='{{Lang::getLocale()}}'){
                                    if(a==0){
                                        $scope.tree3[i].clientlabel=$scope.departmentAgentLabel[a].label;
                                    }
                                }
                            }
                           $scope.tree3[i].options=data;
                           $scope.linkDept=true;
                        }
                    }
            });
        }
         if(typeof x!="object"&&x!=undefined){
                           $scope.linkDept=false;
                  }
     }
     $scope.nestedRadioRTL=function(){
          if('{{Lang::getLocale()}}'=='ar'){
                $('.col-sm-1,.col-sm-2,.col-sm-3,.col-sm-4,.col-sm-5,.col-sm-6,.col-sm-7,.col-sm-8,.col-sm-9,.col-sm-10,.col-sm-11,.col-sm-12').css('float','right');
                $(".rtlRadio").css({"margin-left":"0px","margin-right":"-70px"})
          }
     }
     
      $scope.updateSelection=function(position, value){
           if ($scope['checkBoxArray'+position].indexOf(value) == -1){
                    $scope['checkBoxArray'+position].push(value);
                    
                }
                else {
                    $scope['checkBoxArray'+position].splice($scope['checkBoxArray'+position].indexOf(value), 1);
                }
           if('{{Lang::getLocale()}}'=='ar'){
             $('.col-sm-1,.col-sm-2,.col-sm-3,.col-sm-4,.col-sm-5,.col-sm-6,.col-sm-7,.col-sm-8,.col-sm-9,.col-sm-10,.col-sm-11,.col-sm-12').css('float','right');
             $(".rtlCheck").css({"margin-left":"0px","margin-right":"-54px"})
        }
      }

      $scope.disableReq=function(x){
            $scope.usermail=x;
            $scope.usermail.reqMail.$setValidity("server", false);
      }
      $scope.prevent=function($event){
             if ($event.stopPropagation) $event.stopPropagation();
        if ($event.preventDefault) $event.preventDefault();
        $event.cancelBubble = true;
        $event.returnValue = false;
        }
     $scope.uploadPic = function (x,y) {
        console.log(vcRecaptchaService)
        if(vcRecaptchaService.getResponse() == ""&&$scope.clientCaptcha){ 
                alert("Please resolve the captcha and submit!")
            }
       else { 
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
            $scope.UserInfo.forEach(function (key,element) {
              if(typeof element==='object'){
               element.forEach( function(j) {
                   $scope.uploadSize += j.size;
                   total_file_number++;
                });
              }
            })
           
            $scope.tree5=angular.copy($scope.tree3);
            $.each($scope.tree5, walker);
      
                     function walker(key, value) {
                 
                  delete this.placeholder;
                  delete this.clientlabel;
                  delete this.name;
                  delete this.agentRequiredFormSubmit;
                  delete this.customerDisplay;
                  delete this.customerRequiredFormSubmit;
                  delete this.api;
                  delete this.format;
                  delete this.agentlabel;
                  delete this.errmsg;
                  delete this.pattern;
                  delete this.linkHelpTopic;

                  if(this.value!=undefined && this.type=='radio' && this.default=='no' && this.title!='Nested Radio'){
                        this[this.unique]=this.value;
                       delete this.unique; 
                       delete this.value;
                       delete this.type;
                       delete this.default;
                       delete this.title;
                       delete this.options;
                       
                  }
                  else if(this.value!=undefined && this.type=='radio' && this.default=='no' && this.title=='Nested Radio'){
                       // this[this.unique]=this.value;
                       
                       delete this.type;
                       delete this.default;
                       delete this.title;
                          for(var i in this.options){
                            if(typeof this.value=="object"){
                            if(this.value!=this.options[i].optionvalue){
                                  delete this.options[i]
                            }
                            else{ 
                                  //console.log(this.options[i].optionvalue);
                                  this[this.unique]=this.options[i].optionvalue;
                                  this.options[this.value]=this.options[i].nodes;
                                 

                                  if (typeof this.options[this.value] === "object"  && this.options[i].nodes !=0) {
                                       // Recurse into children
                                        $.each(this.options[this.value], walker);
                                  }
                                  
                                  delete this.options[i];
                            }
                           }
                          }
                       
                       delete this.value;
                        //delete this.options; 
                        delete this.unique;
                  }

                  else if(this.default=='no' && this.type=='select' &&  this.title=='Nested Select'){
                       //this[this.unique]=this.options;
                      //delete this.unique; 
                       delete this.type;
                       delete this.default;
                       delete this.title;
                       for(var i in this.options){
                          if(typeof this.value=="object"){
                            if(this.value.id!=this.options[i].id){
                                  delete this.options[i];
                            }
                            else{
                                //console.log(this.options[i].optionvalue);
                                this[this.unique]=this.options[i].optionvalue;
                                this.options[this.value.optionvalue]=this.options[i].nodes;
                                 
                                 if (typeof this.options[this.value.optionvalue] === "object" && this.options[i].nodes !=0) {
                                       // Recurse into children
                                        $.each(this.options[this.value.optionvalue], walker);
                                  }
                                  
                                  delete this.options[i];
                            }
                        }
                          }
                      delete this.value;
                      // delete this.options;
                       delete this.unique;
                  }
                    else if(this.default=='yes' && this.type=='multiselect'){
                       //this[this.unique]=this.options;
                      //delete this.unique; 
                       delete this.type;
                       delete this.default;
                       delete this.title;
                       for(var i in this.options){
                            if(this.value.id!=this.options[i].id){
                                  delete this.options[i];
                            }
                            else{
                                //console.log(this.options[i].optionvalue);
                                this[this.unique]=this.options[i].id;
                                this.options[this.value.optionvalue]=this.options[i].nodes;
                                 
                                 if (typeof this.options[this.value.optionvalue] === "object" && this.options[i].nodes !=0) {
                                       // Recurse into children
                                        $.each(this.options[this.value.optionvalue], walker);
                                  }
                                  
                                  delete this.options[i];
                            }
                          }
                      delete this.value;
                      // delete this.options;
                       delete this.unique;
                  }
                  else if(this.default=='no' && this.type=='select' && this.title!='Nested Select'){
                       this[this.unique]=this.value.optionvalue;
                      delete this.unique; 
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
                       this[this.unique]=checkboxValue;
                       delete this.unique; 
                       delete this.value;
                       delete this.type;
                       delete this.default;
                       delete this.title;
                       delete this.options;
                  }
                   else if(this.default=='no' && this.type=='checkbox' && this.title=='Nested Checkbox'){
                       //this[this.unique]=this.options;
                       var checkboxValue=[];
                       delete this.type;
                       delete this.default;
                       delete this.title;
                       for(var i in this.options){
                          if(this.options[i].checked==false || this.options[i].checked==""){
                            delete this.options[i];
                         }
                         else{
                            
                            checkboxValue.push(this.options[i].optionvalue);
                            this[this.unique]=checkboxValue;
                            this.options[this.options[i].optionvalue]=this.options[i].nodes;
                            

                            if (typeof this.options[this.options[i].optionvalue] === "object" && this.options[i].nodes.length !=0) {
                                       // Recurse into children
                                        $.each(this.options[this.options[i].optionvalue], walker);
                                  }
                              
                             delete this.options[i];
                         }
                       }
                       // delete this.options; 
                        delete this.unique;  
                  }
                  else if(this.default=='yes' && this.title=="Description"){
                       this[this.unique]=$scope.editor1;
                       delete this.unique; 
                       delete this.value;
                       delete this.type;
                       delete this.default;
                       delete this.title;
                       delete this.media_option;
                  }
                  else if(this.default=='yes' && this.type=="select" && this.title!="Type"){
                        //console.log(this.unique);
                        //console.log(this.value)
                        this[this.unique]=this.value.id;
                        delete this.type;
                        delete this.default;
                        delete this.title;
                        delete this.options;
                        delete this.unique; 
                        delete this.value;
                  }
                  else if(this.default=='yes' && this.type=="select" && this.title=="Type"){
                        //console.log(this.unique);
                        //console.log(this.value)
                        $scope.UserInfo[this.unique]=this.value.id;
                        delete this.type;
                        delete this.default;
                        delete this.title;
                        delete this.options;
                        delete this.unique; 
                        delete this.value;
                  }
                  else if(this.default=='yes' && this.title=="Requester"){
                       if($scope.reqValue!=null){
                         this[this.unique]=$scope.reqValue;
                      }
                      else if($scope.userdt.id!=null){
                         this[this.unique]=$scope.userdt.id;
                      }
                        delete this.unique; 
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
                        this[this.unique]=this.value;
                        delete this.unique; 
                        delete this.value;
                        delete this.type;
                        delete this.default;
                        delete this.title;
                        
                  }
                  else if(this.title=='Attachment'){
                       delete this.unique; 
                       delete this.value;
                       delete this.type;
                       delete this.default;
                       delete this.title;
                  }
                  else if(this.title=='Captcha'){
                       delete this.default;
                       delete this.title;
                       delete this.agentShow;
                       delete this.customerDisplay;
                  }
                  else{
                       this[this.unique]=this.value;
                       delete this.unique; 
                       delete this.value;
                       delete this.type;
                       delete this.default;
                       delete this.title;
                  }
                  
                  }
                  console.log($scope.tree5);
                  $.each($scope.tree5, function(key,value){
                    if(this.options!=undefined){
                         for(var i in this.options){
                             $.each(this.options[i], function(key,value){
                                 if(typeof value=='object'){
                                     $.each(value, function(key,value){
                                            if(key==='options'){
                                               nest(value);
                                            }
                                            else{
                                               $scope.UserInfo[key]=value;
                                            }
                                     })
                                  }
                              })
                         }
                         delete this.options;
                      }
                  })
                  function nest(value){
                       for(var i in value){
                             $.each(value[i], function(key,value){
                                 if(typeof value=='object'){
                                     $.each(value, function(key,value){
                                            if(key==='options'){
                                               nest(value);
                                            }
                                            else{
                                               $scope.UserInfo[key]=value;
                                            }
                                     })
                                  }
                              })
                         }
                  }
                  $.each($scope.tree5, function(key,value){
                        if(typeof value=='object'){
                            $.each(value, function(key,value){
                                   $scope.UserInfo[key]=value; 
                                })
                        }
                  })
            var maxsize = ($scope.uploadSize / 1024) / 1024;
            var max_file_number = "{{ini_get('max_file_uploads')}}";
            var file_upload_max_size = "{{file_upload_max_size()}}";
            if($('#requesterName').val())
            {
             $scope.UserInfo['full_name']=document.getElementById('requesterName').value;
             }
             if($('#requesterMobile').val())
            {
             $scope.UserInfo['mobile']=document.getElementById('requesterMobile').value;
             }
             if($('#requesterEmail').val())
            {
             $scope.UserInfo['email']=document.getElementById('requesterEmail').value;
             }
            if($('.selected-dial-code').html())
            {
             $scope.UserInfo['code']=$('.selected-dial-code').html();
             }
            if (maxsize <= file_upload_max_size && total_file_number <= max_file_number) {
               console.log($scope.UserInfo);
                $scope.uploadArray.upload = Upload.upload({
                    url: "{{url('postedform')}}",
                    data:  $scope.UserInfo,
                }).success(function (data) {
               $('.well').css('display','block');      
               $('.well').html(data.result.success);
                $('.well').css({'color':'white','background':'#5cb85c','border-color':'#4cae4c'});
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
        .error(function(data){
              if(data.error!=undefined){
                    $('.well').html(data.error);
              }
              else{
                  var res = "";
                $.each(data, function (idx, topic) {
                   res += "<li>" + topic + "</li>";
                });
                $('.well').html(res);
              }
                x.currentTarget.disabled=false;
                x.currentTarget.innerHTML = 'Submit';
                $('.well').css('display','block');      
                $('.well').css({'color':'white','background':'#dd4b39','border-color':'#d73925'});
                $('html, body').animate({scrollTop: 0}, 500);
            })
                    
            } else if (maxsize > file_upload_max_size && total_file_number <= max_file_number) {
                alert('failed!! size and file number are maximum');
                x.currentTarget.disabled = false;
                x.currentTarget.innerHTML = "Submit";
            }
            else if (maxsize > file_upload_max_size) {
                alert('failed!! file size is maximum');
                x.currentTarget.disabled = false;
                x.currentTarget.innerHTML= "Submit";

            } else if (total_file_number <= max_file_number) {
                alert('failed!!   file number is maximum');
                x.currentTarget.disabled = false;
                x.currentTarget.innerHTML= "Submit";
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
            $scope.UserInfo.forEach(function (key,element) {
              if(typeof element==='object'){
               element.forEach( function(j) {
                   $scope.uploadSize += j.size;
                   total_file_number++;
                });
              }
            })
            
           $scope.tree5=angular.copy($scope.tree3);
            $.each($scope.tree5, walker);
      
                     function walker(key, value) {
                 
                  delete this.placeholder;
                  delete this.clientlabel;
                  delete this.name;
                  delete this.agentRequiredFormSubmit;
                  delete this.customerDisplay;
                  delete this.customerRequiredFormSubmit;
                  delete this.api;
                  delete this.format;
                  delete this.agentlabel;
                  delete this.errmsg;
                  delete this.pattern;
                  delete this.linkHelpTopic;
                  
                  if(this.value!=undefined && this.type=='radio' && this.default=='no' && this.title!='Nested Radio'){
                        this[this.unique]=this.value;
                       delete this.unique; 
                       delete this.value;
                       delete this.type;
                       delete this.default;
                       delete this.title;
                       delete this.options;
                       
                  }
                  else if(this.value!=undefined && this.type=='radio' && this.default=='no' && this.title=='Nested Radio'){
                       // this[this.unique]=this.value;
                       
                       delete this.type;
                       delete this.default;
                       delete this.title;
                          for(var i in this.options){
                            if(typeof this.value=="object"){
                            if(this.value!=this.options[i].optionvalue){
                                  delete this.options[i]
                            }
                            else{ 
                                  //console.log(this.options[i].optionvalue);
                                  this[this.unique]=this.options[i].optionvalue;
                                  this.options[this.value]=this.options[i].nodes;
                                 

                                  if (typeof this.options[this.value] === "object"  && this.options[i].nodes !=0) {
                                       // Recurse into children
                                        $.each(this.options[this.value], walker);
                                  }
                                  
                                  delete this.options[i];
                            }
                           }
                          }
                       
                       delete this.value;
                        //delete this.options; 
                        delete this.unique;
                  }

                  else if(this.default=='no' && this.type=='select' &&  this.title=='Nested Select'){
                       //this[this.unique]=this.options;
                      //delete this.unique; 
                       delete this.type;
                       delete this.default;
                       delete this.title;
                       for(var i in this.options){
                          if(typeof this.value=="object"){
                            if(this.value.id!=this.options[i].id){
                                  delete this.options[i];
                            }
                            else{
                                //console.log(this.options[i].optionvalue);
                                this[this.unique]=this.options[i].optionvalue;
                                this.options[this.value.optionvalue]=this.options[i].nodes;
                                 
                                 if (typeof this.options[this.value.optionvalue] === "object" && this.options[i].nodes !=0) {
                                       // Recurse into children
                                        $.each(this.options[this.value.optionvalue], walker);
                                  }
                                  
                                  delete this.options[i];
                            }
                           }
                          }
                      delete this.value;
                      // delete this.options;
                       delete this.unique;
                  }
                        else if(this.default=='yes' && this.type=='multiselect'){
                       //this[this.unique]=this.options;
                      //delete this.unique; 
                       delete this.type;
                       delete this.default;
                       delete this.title;
                       for(var i in this.options){
                          if(typeof this.value=="object"){
                            if(this.value.id!=this.options[i].id){
                                  delete this.options[i];
                            }
                            else{
                                //console.log(this.options[i].optionvalue);
                                this[this.unique]=this.options[i].id;
                                this.options[this.value.optionvalue]=this.options[i].nodes;
                                 
                                 if (typeof this.options[this.value.optionvalue] === "object" && this.options[i].nodes !=0) {
                                       // Recurse into children
                                        $.each(this.options[this.value.optionvalue], walker);
                                  }
                                  
                                  delete this.options[i];
                            }
                           }
                          }
                      delete this.value;
                      // delete this.options;
                       delete this.unique;
                  }
                  else if(this.default=='no' && this.type=='select' && this.title!='Nested Select'){
                       this[this.unique]=this.value.optionvalue;
                      delete this.unique; 
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
                       this[this.unique]=checkboxValue;
                       delete this.unique; 
                       delete this.value;
                       delete this.type;
                       delete this.default;
                       delete this.title;
                       delete this.options;
                  }
                   else if(this.default=='no' && this.type=='checkbox' && this.title=='Nested Checkbox'){
                       //this[this.unique]=this.options;
                       var checkboxValue=[];
                       delete this.type;
                       delete this.default;
                       delete this.title;
                       for(var i in this.options){
                          if(this.options[i].checked==false || this.options[i].checked==""){
                            delete this.options[i];
                         }
                         else{
                            
                            checkboxValue.push(this.options[i].optionvalue);
                            this[this.unique]=checkboxValue;
                            this.options[this.options[i].optionvalue]=this.options[i].nodes;
                            

                            if (typeof this.options[this.options[i].optionvalue] === "object" && this.options[i].nodes.length !=0) {
                                       // Recurse into children
                                        $.each(this.options[this.options[i].optionvalue], walker);
                                  }
                              
                             delete this.options[i];
                         }
                       }
                       // delete this.options; 
                        delete this.unique;  
                  }
                  else if(this.default=='yes' && this.title=="Description"){
                       this[this.unique]=$scope.editor1;
                       delete this.unique; 
                       delete this.value;
                       delete this.type;
                       delete this.default;
                       delete this.title;
                       delete this.media_option;
                  }
                  else if(this.default=='yes' && this.type=="select" && this.title!="Type"){
                        //console.log(this.unique);
                        //console.log(this.value)
                        this[this.unique]=this.value.id;
                        delete this.type;
                        delete this.default;
                        delete this.title;
                        delete this.options;
                        delete this.unique; 
                        delete this.value;
                  }
                  else if(this.default=='yes' && this.type=="select" && this.title=="Type"){
                        //console.log(this.unique);
                        //console.log(this.value)
                        $scope.UserInfo[this.unique]=this.value.id;
                        delete this.type;
                        delete this.default;
                        delete this.title;
                        delete this.options;
                        delete this.unique; 
                        delete this.value;
                  }
                  else if(this.default=='yes' && this.title=="Requester"){
                       if($scope.reqValue!=null){
                         this[this.unique]=$scope.reqValue;
                      }
                      else if($scope.userdt.id!=null){
                         this[this.unique]=$scope.userdt.id;
                      }
                        delete this.unique; 
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
                        this[this.unique]=this.value;
                        delete this.unique; 
                        delete this.value;
                        delete this.type;
                        delete this.default;
                        delete this.title;
                        
                  }
                  else if(this.title=='Attachment'){
                       delete this.unique; 
                       delete this.value;
                       delete this.type;
                       delete this.default;
                       delete this.title;
                  }
                  else if(this.title=='Captcha'){
                       delete this.default;
                       delete this.title;
                       delete this.agentShow;
                       delete this.customerDisplay;
                  }
                  else{
                       this[this.unique]=this.value;
                       delete this.unique; 
                       delete this.value;
                       delete this.type;
                       delete this.default;
                       delete this.title;
                  }
                  
                  }
                  console.log($scope.tree5);
                  $.each($scope.tree5, function(key,value){
                    if(this.options!=undefined){
                         for(var i in this.options){
                             $.each(this.options[i], function(key,value){
                                 if(typeof value=='object'){
                                     $.each(value, function(key,value){
                                            if(key==='options'){
                                               nest(value);
                                            }
                                            else{
                                               $scope.UserInfo[key]=value;
                                            }
                                     })
                                  }
                              })
                         }
                         delete this.options;
                      }
                  })
                  function nest(value){
                       for(var i in value){
                             $.each(value[i], function(key,value){
                                 if(typeof value=='object'){
                                     $.each(value, function(key,value){
                                            if(key==='options'){
                                               nest(value);
                                            }
                                            else{
                                               $scope.UserInfo[key]=value;
                                            }
                                     })
                                  }
                              })
                         }
                  }
                  $.each($scope.tree5, function(key,value){
                        if(typeof value=='object'){
                            $.each(value, function(key,value){
                                   $scope.UserInfo[key]=value; 
                                })
                        }
                  })
            var maxsize = ($scope.uploadSize / 1024) / 1024;
            var max_file_number = "{{ini_get('max_file_uploads')}}";
            var file_upload_max_size = "{{file_upload_max_size()}}";
              if($('#requesterName').val())
            {
             $scope.UserInfo['full_name']=document.getElementById('requesterName').value;
             }
             if($('#requesterMobile').val())
            {
             $scope.UserInfo['mobile']=document.getElementById('requesterMobile').value;
             }
             if($('#requesterEmail').val())
            {
             $scope.UserInfo['email']=document.getElementById('requesterEmail').value;
             }
            if($('.selected-dial-code').html())
            {
             $scope.UserInfo['code']=$('.selected-dial-code').html();
             }
             console.log( $scope.UserInfo);
            if (maxsize <= file_upload_max_size && total_file_number <= max_file_number) {
                $scope.uploadArray.upload = Upload.upload({
                    url: "{{url('postedform')}}",
                    data:  $scope.UserInfo,
                }).success(function (data) {
               $('.well').css('display','block');      
               $('.well').html(data.result.success);
                $('.well').css({'color':'white','background':'#5cb85c','border-color':'#4cae4c'});
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
        .error(function(data){
              if(data.error!=undefined){
                    $('.well').html(data.error);
              }
              else{
                  var res = "";
                $.each(data, function (idx, topic) {
                   res += "<li>" + topic + "</li>";
                });
                $('.well').html(res);
              }
                x.currentTarget.disabled=false;
                x.currentTarget.innerHTML = 'Submit';
                $('.well').css('display','block');      
                $('.well').css({'color':'white','background':'#dd4b39','border-color':'#d73925'});
                $('html, body').animate({scrollTop: 0}, 500);
            })
                    
            } else if (maxsize > file_upload_max_size && total_file_number <= max_file_number) {
                alert('failed!! size and file number are maximum');
                x.currentTarget.disabled = false;
                x.currentTarget.innerHTML = "Submit";
            }
            else if (maxsize > file_upload_max_size) {
                alert('failed!! file size is maximum');
                x.currentTarget.disabled = false;
                x.currentTarget.innerHTML= "Submit";

            } else if (total_file_number <= max_file_number) {
                alert('failed!!   file number is maximum');
                x.currentTarget.disabled = false;
                x.currentTarget.innerHTML= "Submit";
            }
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
        $scope.clientUserName=function(x,y){
            console.log(y);
            var charCode = $('#clientreq').val(); 
            $scope.userdt.id=null;
            $http.get("{{url('ticket/form/requester?term=')}}"+charCode+'&type=client').success(function (data) {
                 if(typeof data!="object"){
                    $scope.newReqField=true;
                    y.reqMail.$setValidity("server", true);
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
                       if('{{Lang::getLocale()}}'=='ar'){
                           $('.selected-dial-code').css({'float':'left','padding-left':'9px','padding-top':'6px'});
                           $('.intl-tel-input .selected-flag .iti-arrow').css('right','25px');
                           $('.selected-flag').css('padding-right','4px');
                           $('.col-sm-1,.col-sm-2,.col-sm-3,.col-sm-4,.col-sm-5,.col-sm-6,.col-sm-7,.col-sm-8,.col-sm-9,.col-sm-10,.col-sm-11,.col-sm-12').css('float','right');
                           $('.intl-tel-input .country-list').css('text-align','right');
                       }
                    },200);
                    
                 }
                 else{
                    $scope.newReqField=false;
                    $scope.reqValue=data.id;
                    y.reqMail.$setValidity("server", true);
                 }
            });
        };
       
       
        

    });
</script>

@endpush

