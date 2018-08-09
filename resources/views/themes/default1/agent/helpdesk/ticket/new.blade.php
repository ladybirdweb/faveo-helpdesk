@extends('themes.default1.agent.layout.agent')
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
<div class="well" style="display:none;"></div>
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
        
    </div><!-- /.box-header -->
        <div class="row">
           
        <!-- Nested node template -->

        <script type="text/ng-template" id="nodes_renderer2.html">
          <ng-form name="faveoClientForm">
          <div class="row" style="margin:15px;width:100%">
              <div class="col-sm-2" style="padding: 0px;" >
                 <label ng-bind-html="$sce.trustAsHtml(node.agentlabel)" class="@{{node.unique}}"></label><span ng-show="node.agentRequiredFormSubmit==true && node.agentlabel!=''" style="color:red">*</span>
              </div>
              <div class="col-sm-9" style="padding: 0px">
                <input type="text" name="textfield@{{$index}}"  ng-if="node.type=='text'&& node.title!='Api'" class="form-control" style="border-radius: 0px;width:85%" ng-model="node.value" ng-required="@{{node.agentRequiredFormSubmit}}" ng-pattern="node.pattern" ng-disabled="node.disable">
                <span style="color:red" ng-show="faveoClientForm.textfield@{{$index}}.$dirty && faveoClientForm.textfield@{{$index}}.$invalid" >
                                          <span ng-show="faveoClientForm.textfield@{{$index}}.$error.required">@{{node.agentlabel}} is required.</span>
                                          <span ng-show="faveoClientForm.textfield@{{$index}}.$error.pattern">@{{node.errmsg}}</span>
                </span>
                <input type="number"  name="numberfield@{{$index}}"  ng-if="node.type=='number'" class="form-control" style="border-radius: 0px;width:85%" ng-model="node.value" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" ng-required="@{{node.agentRequiredFormSubmit}}" ng-disabled="node.disable">
                <span style="color:red" ng-show="faveoClientForm.numberfield@{{$index}}.$dirty && faveoClientForm.numberfield@{{$index}}.$invalid">
                                          <span ng-show="faveoClientForm.numberfield@{{$index}}.$error.required">@{{node.agentlabel}} is required.</span>
                </span>
                <input type="text"  name="datefield@{{$index}}" ng-if="node.type=='date'" class="form-control" style="border-radius: 0px;width:85%" ng-pattern="/^[0,1]?\d{1}\/(([0-2]?\d{1})|([3][0,1]{1}))\/(([1]{1}[9]{1}[9]{1}\d{1})|([2-9]{1}\d{3}))$/" ng-required="@{{node.agentRequiredFormSubmit}}" placeholder="MM/DD/YYYY" ng-model="node.value">
                <span style="color:red" ng-show="faveoClientForm.datefield@{{$index}}.$dirty && faveoClientForm.datefield@{{$index}}.$invalid">
                                          <span ng-show="faveoClientForm.datefield@{{$index}}.$error.required">@{{node.agentlabel}} is required.</span>
                                          <span ng-show="faveoClientForm.datefield@{{$index}}.$error.pattern">Please Enter Valid Correct Format-MM/DD/YYYY</span>
                </span>
                <div ng-if="node.type=='email'&& node.title=='Requester'">
                <div class="input-group"  style="width:85%">
                           <input type="text" name="reqMail" class="form-control" id="requestro" style="border-radius: 0px;height: 34px"  ng-model="node.value" ng-required="@{{node.agentRequiredFormSubmit}}" ng-keydown="requesterEmail($event,$index,faveoClientForm)"  placeholder="Requester Email" ng-disabled="node.disable">
                                  <div class="input-group-btn">
                                      <button class="btn btn-default" type="button" style="margin-right: 0px;border-radius: 0px;height: 34px" data-toggle="modal" data-target="#myModal9" ng-click="getcusForm(faveoClientForm)">Add new requester</button>
                                      <span ng-if="node.agentCCfield==true">
                                      <button class="btn btn-default" type="button"  style="margin-right: 0px;border-radius: 0px;height: 34px" ng-click="showCc()" ng-hide="displayCc">Cc</button></span>
                                      </span>
                                  </div>
                          <ul class="dropdown-menu menu2" style="width:85%;display:block" ng-if="reqstr">
                               <li ng-repeat="email in reqEmails"><a href="javascript:void(0)" ng-click="selectReq(email,$parent.$index)">@{{email.name}}(@{{email.first_name}} @{{email.last_name}})</a></li>
                          </ul>
                </div>
                <span ng-show="loado@{{$index}}" style="width: 13%;float: right;margin-top: -27px;">
                     <img src="{{asset("lb-faveo/media/images/25.gif")}}" style="width:20px;height:20px">
                </span>
                <span ng-show="newAgent" style="color:red">Requester not Existing.Please add a new Requester</span>
                </div>
                <div style="width: 100%" ng-if="node.title=='Requester'&&displayCc">
                <div class="input-group"  style="margin-top: 5px;width: 85%;display:inline-block;">
                          <!--  <input type="text" class="form-control" style="border-radius: 0px;height:34px;width:85%" placeholder="Enter a Cc"           ng-keypress="requesterCc($event,$index)"> -->
                            <select class="form-control"  id="selecti2" multiple="multiple"></select>
                                  <div class="input-group-btn">
                                     <button class="btn btn-default" type="button" style="margin-top: 5px;margin-right: 0px;border-radius: 0px" ng-click="showCc()">Hide Cc</button>
                                  </div>
                </div>
                </div>
                <textarea name="descript@{{$index}}"  class="form-control" ng-if="node.type=='textarea'&& node.default=='no'" style="border-radius: 0px;width:85%" ng-model="node.value" ng-required="@{{node.agentRequiredFormSubmit}}" ng-pattern="node.pattern" ng-disabled="node.disable"></textarea>
                <span style="color:red" ng-show="faveoClientForm.descript@{{$index}}.$dirty && faveoClientForm.descript@{{$index}}.$invalid">
                                          <span ng-show="faveoClientForm.descript@{{$index}}.$error.required">@{{node.agentlabel}} is required.</span>
                                           <span ng-show="faveoClientForm.descript@{{$index}}.$error.pattern">@{{node.errmsg}}</span>
                </span>
                <div ng-if="node.type=='textarea'&&node.title=='Description'" style="width:85%">
                     <div ng-show="node.media_option">@include('themes.default1.inapp-notification.wyswyg-editor')</div>
                     <textarea name="description" id="description@{{$index}}" class="form-control"  style="border-radius: 0px;" ng-model="node.value"></textarea>
                    <span style="color:red" ng-show="description">
                                          <span>Description is required.</span>
                    </span>  
                    <div id="file_details"></div>    
                </div>
                <div ng-if="node.title=='Attachment'" style="margin-top:20px">
                   <div id="@{{node.unique}}" ></div>
                        <label class="btn-bs-file btn btn-sm btn-default @{{node.unique}}">
                              <i class="fa fa-plus"></i>&nbspAttach files
                         <input type="file" multiple ng-model="filename" valid-file onchange="angular.element(this).scope().updateList(this,angular.element(this).scope().node.unique)" ng-required="@{{node.agentRequiredFormSubmit}}"/>
                        </label>
                        <p><i>Max File Upload size : {{file_upload_max_size()}}MB and Max Number of Files :{{ini_get('max_file_uploads')}}</i></p>
                        <span style="color:red;display:none;" class="@{{node.unique}}1">
                                          <span>@{{node.agentlabel}} is required.</span>
                        </span>
                </div>
                <div ng-if="node.type=='select'&&node.default=='yes'||node.title=='Api'">

                <select  ng-model="node.value" name="selected@{{$index}}" id="@{{node.unique}}" ng-options="option.optionvalue for option in node.options" class="form-control" style="border-radius: 0px;width:85%;display:inline-block" ng-required="@{{node.agentRequiredFormSubmit}}" ng-click="getSelectOptions(node.api,$event,$index)" ng-disabled="node.disable">
                  <option value="">Select</option>
                </select>
                <span ng-show="loado@{{$index}}" style="width:15%"><img src="{{asset("lb-faveo/media/images/25.gif")}}" style="width:20px;height:20px"></span>
                <div style="color:red" ng-show="faveoClientForm.selected@{{$index}}.$dirty && faveoClientForm.selected@{{$index}}.$invalid">
                    <span ng-show="faveoClientForm.selected@{{$index}}.$error.required">@{{node.agentlabel}} is required.</span>
                  </div>
                </div>

              <div ng-if="node.title=='Help Topic'&&node.default=='yes'">
                <select  ng-model="node.value"    name="selected@{{$index}}"  ng-options="option.optionvalue for option in node.options" class="form-control" style="border-radius: 0px;width:85%" ng-required="@{{node.agentRequiredFormSubmit}}" ng-change="nestSelectRTL(node.value)" ng-disabled="node.disable">
                  <option value="">Select</option>
                </select>
                  <span style="color:red" ng-show="faveoClientForm.selected@{{$index}}.$dirty && faveoClientForm.selected@{{$index}}.$invalid">
                    <span ng-show="faveoClientForm.selected@{{$index}}.$error.required">@{{node.agentlabel}} is required.</span>
                  </span>
              </div>
              <div ng-if="node.title=='Department'&&node.linkDept">
                <select  ng-model="node.value"    name="selected@{{$index}}"  ng-options="option.optionvalue for option in node.options" class="form-control" style="border-radius: 0px;width:85%" ng-required="@{{node.agentRequiredFormSubmit}}" ng-change="nestSelectRTL()" ng-disabled="node.disable">
                  <option value="">Select</option>
                </select>
                  <span style="color:red" ng-show="faveoClientForm.selected@{{$index}}.$dirty && faveoClientForm.selected@{{$index}}.$invalid">
                    <span ng-show="faveoClientForm.selected@{{$index}}.$error.required">@{{node.agentlabel}} is required.</span>
                  </span>
              </div>
              <div vc-recaptcha key="servicKey" ng-if="node.title=='Captcha'&&node.agentShow"></div>
                <div ng-if="node.type=='select'&&node.default=='no'">
                <select  ng-model="node.value"    name="selected@{{$index}}"  ng-options="option.optionvalue for option in node.options" class="form-control" style="border-radius: 0px;width:85%" ng-required="@{{node.agentRequiredFormSubmit}}" ng-change="nestSelectRTL()" ng-disabled="node.disable">
                  <option value="">Select</option>
                </select>
                  <span style="color:red" ng-show="faveoClientForm.selected@{{$index}}.$dirty && faveoClientForm.selected@{{$index}}.$invalid">
                    <span ng-show="faveoClientForm.selected@{{$index}}.$error.required">@{{node.agentlabel}} is required.</span>
                  </span>
                </div>
                <ul class="list-group" ng-if="node.type=='radio'" style="border:none">
                      <li ng-repeat="option in node.options"  class="list-group-item" style="border:none">
                                          <input type="radio" name="selection@{{node.unique}}" id="happy@{{$index}}" ng-model="node.value" value="@{{option.optionvalue}}" ng-required="@{{node.agentRequiredFormSubmit}}" ng-click="nestedRadioRTL()" ng-disabled="node.disable"/>
                                            <label for="happy@{{$index}}">@{{option.optionvalue}}</label>
                      </li>
                      <div ng-if="node.agentlabel=='' && node.agentRequiredFormSubmit==true" style="color: red">(*Fields are Required)</div>
                </ul>
                <ul class="list-group" ng-if="node.type=='checkbox'" style="border:none">
                      <label ng-repeat="option in node.options"  class="list-group-item" style="border:none">
                                           <input type="checkbox" 
                                                name="selectedValue[]"  ng-model="option.checked"   value="@{{option.optionvalue}}" ng-click="updateSelection($parent.$index,option.optionvalue)" ng-required="checkBoxArray@{{$parent.$index}}.length==0" ng-disabled="node.disable">
                                           <span ng-bind-html="$sce.trustAsHtml(option.optionvalue)"></span>
                          <ul ng-model="option.nodes" ng-class="{hidden: collapsed}"  style="list-style-type:none;margin-left: -70px" ng-if="option.checked==true && option.nodes.length>0" class='rtlCheck'>
                              <li  ng-repeat="node in option.nodes" ng-include="'nodes_renderer2.html'" ng-click="prevent($event)"></li>
                       </ul>
                      </label>
                      <div ng-if="node.agentlabel=='' && node.agentRequiredFormSubmit==true" style="color: red">(*Fields are Required)</div>
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
        <div class="col-sm-12" >
          <form name="faveoForm">
            <div  style="margin-right:0px">
                <div class="col-sm-12">
                    <ul  ng-model="tree3"  style="list-style-type:none">
                        <li ng-repeat="node in tree3"  ng-include="'nodes_renderer2.html'">
                            
                        </li>
                    </ul>
                </div>
                <div style="text-align:center"  id="loader">
                        <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}" >
                </div>
            
                <div class="col-sm-12" style="border-top:1px solid gainsboro;background-color: white;padding:5px;text-align: right">
                    <button type="button" class="btn btn-primary" id="submitForm" ng-disabled="faveoForm.$invalid"  data-ng-click="getEditor($event,faveoForm)">Submit</button>
                </div>
            </div>
            </form>
        </div>
    </div>
    <!-- popup for media -->
    <div class="modal fade" id="selectpopup">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{!!Lang::get('lang.information') !!}</h4>
                </div>
                <div class="select-popup1 col-sm-12">
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="dismis2">{!!Lang::get('lang.ok')!!}</button>
                    
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    
    <!-- popup for new requester-->
    <div class="modal fade" id="addpopup">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{!!Lang::get('lang.new_requester_added') !!}</h4>
                </div>
                <div class="success-popup1 col-sm-12">
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="dismis2">{!!Lang::get('lang.ok')!!}</button>
                    
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <div id="myModal9" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                      
                        <!-- Modal content-->
                        <div class="modal-content">
                        <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Add New Requester</h4>
                        </div>
                        <div class="modal-body">
                         <form name="addnewRequester" >
                             <div class="well" style="color: red;" ng-show="errorResponse">
                               @{{erroro}}
                             </div>
                             <label>Name<span style="color:red">*</span></label>
                             <input type="text" name="requsName@{{$index}}" class="form-control" style="border-radius:0;margin-top:10px;width:85%" ng-model="req.name" placeholder="Requester Name" id="requesterName" ng-required="@{{node.agent_name}}"/>
                                <span style="color:red" ng-show="addnewRequester.requsName@{{$index}}.$dirty && addnewRequester.requsName@{{$index}}.$invalid">
                                          <span ng-show="addnewRequester.requsName@{{$index}}.$error.required">@{{node.agentlabel}} is required.</span>
                                </span>
                    <label style="display: block">Email<span style="color:red">*</span></label>
                    <input type="email" name="requsEmail@{{$index}}" class="form-control" style="border-radius:0;margin-top:10px;width:85%" ng-model="req.email" ng-pattern="emailFormat" placeholder="Requester Email" id="requesterEmail" required/>
                                <span style="color:red" ng-show="addnewRequester.requsEmail@{{$index}}.$dirty && addnewRequester.requsEmail@{{$index}}.$invalid">
                                          <span ng-show="addnewRequester.requsEmail@{{$index}}.$error.required">Email is required.</span>
                                          <span ng-show="addnewRequester.requsEmail@{{$index}}.$error.pattern">Invalid email address.</span>
                                </span> 
                    <label style="display: block">Mobile</label>  
                    <div class="row" style="width:85%">
                    <div class="col-sm-3" style="margin-top:10px">
                        <input type="tel" class="form-control" id="telCode" style="visibility:hidden"/>
                    </div>
                    <div class="col-sm-9">
                     <input type="text" name="requsMobile@{{$index}}" class="form-control" style="border-radius:0;margin-top:10px" ng-model="req.mobile" placeholder="Requester mobile" ng-pattern="/^[0-9]{1,99}$/" id="requesterMobile" ng-maxlength="15"/> 
                                <span style="color:red" ng-show="addnewRequester.requsMobile@{{$index}}.$dirty && addnewRequester.requsMobile@{{$index}}.$invalid">
                                          <span ng-show="addnewRequester.requsMobile@{{$index}}.$error.pattern">Invalid Mobile Number.</span>
                                          <span>Maximum 15 Numbers Only</span>
                                </span> 
                    </div>
                        </div>
                         <label>Company</label>
                             <input type="text" class="form-control"  style="border-radius:0;margin-top:10px;width:85%" ng-model="req.company" placeholder="Requester company" id="requesterCompany" ng-required="@{{node.agent_name}}"/>
                        <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                  <button type="button" class="btn btn-info" id="req2" ng-disabled="addnewRequester.$invalid" ng-click="addnewRequestervalue($event)">Add</button>
                        </div>
                        </form>
                      </div>

                   </div>
                    
                </div>
                </div>  
    
    
    
</div><!-- /. box -->
@stop
@push('scripts')
<script src="{{asset('vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
<script src="{{asset("lb-faveo/js/intlTelInput.js")}}"></script>
<script>
  $(document).click(function(e) {
       $('.menu2').hide();
  })
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
</script>
<script>
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
app.controller('CreateTicketAgent', function($scope,$http, $sce,$window,$compile,Upload,$rootScope,$location,vcRecaptchaService){
  $scope.servicKey="{{commonSettings('google', 'service_key')}}";
     $scope.$sce=$sce;
    $rootScope.disable=true;
      $rootScope.inlineImage=true;
      $rootScope.arrayImage=[];
      $scope.attachmentImage=[];
      $scope.inlinImage=[];
      $scope.editorValues={};
         $scope.tree3 = [];
        $scope.uploadArray=[];
        $scope.multiAttach=[];
        $scope.value=[];
        $scope.UserInfo=[];
        $scope.emailFormat = /^[a-z]+[a-z0-9._]+@[a-z]+\.[a-z.]{2,5}$/;
        $http.get("{{url('form/ticket')}}").success(function (data) {
           $http.get("{{url('ticket/form/dependancy?dependency=helptopic')}}").success(function (data1) {
           for(var i in data[0]){

              if(data[0][i].api=="helptopic"){

                  data[0][i].options=data1;  
                  $http.get("{{url('ticket/form/dependancy?dependency=department')}}").success( function (data2) {
                        for(var i in data[0]){
                            if(data[0][i].api=="department"&& !data[0][i].linkHelpTopic){
                                 data[0][i].options=data2;
                                 data[0][i]['linkDept']=true;  
                              }
                            if(data[0][i].api=="department"&& data[0][i].linkHelpTopic){
                                 //alert('0')
                                  data[0][i]['linkDept']=false;
                                  $scope.departmentAgentLabel=data[0][i].agentlabel;
                                 data[0][i].agentlabel='';  
                            }
                          }
                          $scope.tree3 = data[0];
                          console.log($scope.tree3);
                    
        
            //console.log($scope.tree3);
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
                  if(value.title=='Captcha'&&value.agentShow){
                        $scope.agentCaptcha=true;
                  }
                  else{
                        vcRecaptchaService.getResponse=function(){
                            return null;
                        };
                  }
                };
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
              if(typeof value==='object'){
                if(value.agentlabel!=""){
                 for(var a in value.agentlabel){
                  if(value.agentlabel[a].language==='{{Lang::getLocale()}}'){
                     value.agentlabel=value.agentlabel[a].label;
                     break;
                  }
                }
                }
              }
              if(typeof value==='object'){
                if(value.agentlabel!=""){
                for(var a in value.agentlabel){
                  if(typeof value.agentlabel ==='object'){
                    if(value.agentlabel[a].language !=='{{Lang::getLocale()}}'){
                       if(a==0){
                        value.agentlabel=value.agentlabel[a].label;
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
                        value.errmsg=value.agentlabel[a].label;
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
                          if (value !== null && typeof value === "object" && value.type!='checkbox' && value.type!='select'&&value.type!='multiselect') {
                              
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
           console.log($scope.tree3)
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
                {"name": "styles", "groups": ["styles"]},
                {"name": "about", "groups": ["about"]}
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
                            console.log(countryCode)
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
                 })  
              }
           }
        })
//         
        })
 
 
   $scope.multiselect=function(x){
       var dependancy=$( "#"+x+" option:selected" ).text();
       //alert(dependancy);
       $.each($scope.tree3,broker);
                 function broker(key,value){
                     if(typeof value=="object" && value.type=="multiselect"){
                         if(value.unique==x){
                               $http.get("{{url('ticket/form/dependancy?dependency=')}}"+dependancy).success(function (data) {
                                        if(data!=null){
                                           
                                        }
                                  });
                         }
                         $.each(value,broker);
                     }
                 }
       /*var dependancy=$scope.tree3[x].value.optionvalue;
            */
   }
   $scope.getImageApi=function(){
      localStorage.setItem('mediaURL', "{{url('media/files')}}");   
      $http.get("{{url('media/files')}}").success(function(data){
          $rootScope.arrayImage=data;
          $scope.apiCalled=true;
      })
  }
  /*$scope.language=function(obj){
      
      return function(){
          alert('1')
          for(var i in obj.optionvalue){
            if(obj.optionvalue[i].language=='{{Lang::getLocale()}}'){
                 return obj.optionvalue[i].option;
            } 
          }
      }
  }*/  $scope.nestSelectRTL=function(x){
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
              if(typeof value==='object'){
                if(value.agentlabel!=""){
                 for(var a in value.agentlabel){
                  if(value.agentlabel[a].language==='{{Lang::getLocale()}}'){
                     value.agentlabel=value.agentlabel[a].label;
                     break;
                  }
                }
                }
              }
              if(typeof value==='object'){
                if(value.agentlabel!=""){
                for(var a in value.agentlabel){
                  if(typeof value.agentlabel ==='object'){
                    if(value.agentlabel[a].language !=='{{Lang::getLocale()}}'){
                       if(a==0){
                        value.agentlabel=value.agentlabel[a].label;
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
                        value.errmsg=value.agentlabel[a].label;
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
                                $scope.tree3[i]['linkDept']=true;
                             for(var a in $scope.departmentAgentLabel){
                                if($scope.departmentAgentLabel[a].language==='{{Lang::getLocale()}}'){
                                         $scope.tree3[i].agentlabel=$scope.departmentAgentLabel[a].label;
                                           break;
                                }
                                else if($scope.departmentAgentLabel[a].language !=='{{Lang::getLocale()}}'){
                                    if(a==0){
                                        $scope.tree3[i].agentlabel=$scope.departmentAgentLabel[a].label;
                                    }
                                }
                            }
                            console.log($scope.tree3[i]);
                            $scope.tree3[i].options=data;
                          }
                        }
                        console.log($scope.tree3);
                     })
                     
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
      $scope.insert=function(x,i,pathname,name,z){
            
           if(z!=0){
              $('label[for="happy0"]>img').css({'border': 'none','box-shadow': 'none'});
           }
           else{
              $('label[for="happy0"]>img').css({'border': '1px solid #fff','box-shadow': '0 0 0 4px #0073aa'});
           }
           if(z==1){
               $('label[for="happy1"]>img').css({'border': '1px solid #fff','box-shadow': '0 0 0 4px #0073aa'});
           }
           else{
              $('label[for="happy1"]>img').css({'border': 'none','box-shadow': 'none'});
           }
           $rootScope.disable=false;
          
           $rootScope.preview=true;
           $rootScope.viewImage=$rootScope.arrayImage[i]
           if(x=="image"){
               $rootScope.inlineImage=false;
               $rootScope.viewImage=i;
               $rootScope.pathName=pathname;
               $rootScope.fileName=name;
           }
           else if(x=="text"){
               $rootScope.inlineImage=true;
               $rootScope.viewImage="{{asset('lb-faveo/media/images/txt.png')}}";
               $rootScope.pathName=pathname;
               $rootScope.fileName=name;
           }
           else{
               $rootScope.inlineImage=true;
               $rootScope.viewImage="{{asset('lb-faveo/media/images/common.png')}}";
               $rootScope.pathName=pathname;
               $rootScope.fileName=name;
           }
      }
      $scope.noInsert=function(){
           $rootScope.disable=true;
           $rootScope.inlineImage=true;
           $('input[type="radio"]:checked + label>img').css({'border': 'none','box-shadow': 'none'});
      }
       $scope.showCc = function () {
            $scope.displayCc = !$scope.displayCc;
            $(function(){
      // turn the element to select2 select style
      setTimeout(function(){
      $("#selecti2").select2({
       
            minimumInputLength: 1,
            tags: true,
            ajax: {
                   url: "{{url('get/requester/cc')}}",
                   dataType: 'json',
                   type: "GET",
                   data: function (term) {
                       return term;
                    },
          processResults: function (data) {
            return {
                results: $.map(data.response, function (value) {
                    return {
                        image:value.profile_pic,
                        text: value.first_name+"("+value.email+")",
                        id: value.email
                    }
                })
            };
        },
        cache: true
    },
    templateResult: formatState,
    createTag: function (params) {
     
    var term = $.trim(params.term);

     function validateEmail(term) {
                   var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(term);
      }
    if (validateEmail(term)) {
    

    return {
      id: term,
      text: term,
      newTag: true // add additional parameters
    }
  }
  }
});
  function formatState (state) { 
       if (!state.id) { 
            return state.text; 
       } 
       if(state.image){
       var $state = $( '<div><div style="width: 8%;display: inline-block;"><img src='+state.image+' width="25px" height="25px"></div><div style="width: 90%;display: inline-block;">'+state.text+'</div></div>');
        return $state;
      }
      else{
        var $state = $( '<div style="width: 90%;display: inline-block;">'+state.text+'</div>');
        return $state;
      }
  }
      $("#selecti2").css('display','none')
    },100)
    });
        }
       $scope.pushToEditor=function(){
          var radios = document.getElementsByName('selection');
           for (var i = 0, length = radios.length; i < length; i++) {
             if (radios[i].checked) {
                 var attaremove=$rootScope.arrayImage.data[i].filename;
                 console.log(attaremove);
                   $scope.attachmentImage.push($rootScope.arrayImage.data[i]);
                   $compile($("#file_details").append("<div type='hidden' id='hidden' style='background-color: #f5f5f5;border: 1px solid #dcdcdc;font-weight: bold;margin-top:9px;overflow-y: hidden;padding: 4px 4px 4px 8px;max-width: 448px;' contenteditable='false'>"+$rootScope.arrayImage.data[i].filename+"("+$rootScope.arrayImage.data[i].size+"bytes)<i class='fa fa-times' aria-hidden='true' style='float:right;cursor: pointer;' ng-click='remove($event)'></i></div>"))($scope);
                }
          }
      }
      $scope.deleteToLibrary=function(){

        var radios = document.getElementsByName('selection');
           $scope.deleteFile={};
           for (var i = 0, length = radios.length; i < length; i++) {
             if (radios[i].checked) {

                  $scope.deleteFile['file']=$rootScope.arrayImage.data[i].pathname;
                  console.log($scope.deleteFile);
//                  if (confirm('Are you sure you want to delete this thing into the database?')) {
                       $http.post('{{url("media/files/delete")}}',$scope.deleteFile).success(function(data){
                       //  alert(data[0]);
                       $('#selectpopup').modal('show');
                       $('.select-popup1').empty(data[0]);
                       $('.select-popup1').append(data[0]);
                         
                         $rootScope.preview=false;
                       $http.get("{{url('media/files')}}").success(function(data){
                                 $rootScope.arrayImage=data;
                            })
                      })
                 
              }
           }
      }
      $scope.pushImage=function(){
           var radios = document.getElementsByName('selection');
           for (var i = 0, length = radios.length; i < length; i++) {
             if (radios[i].checked) {
                 
                $(".cke_wysiwyg_frame").contents().find("body").append("<img  src="+$rootScope.arrayImage.data[i].base_64+" alt='"+$rootScope.arrayImage.data[i].filename+"' width='150px' height='150px' />");
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

        $scope.removeAttache = function (x,y) {
            var id = x.currentTarget.parentNode;
            id.remove();
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
                    $compile($(output).append('<div id="hidden" style="list-style-type:none;background-color: #f5f5f5;border: 1px solid #dcdcdc;font-weight: bold;margin:8px;overflow-y: hidden;padding: 4px 4px 4px 8px;max-width: 448px;margin-left: 0px;" contenteditable="false">' + $scope.UserInfo[x][i].name + '(' + $scope.UserInfo[x][i].size + ')<div style="display:none">' + $scope.UserInfo[x][i].id + '</div><i class="fa fa-times" aria-hidden="true" style="float:right;cursor: pointer;" ng-click="removeAttache($event,\''+x+'\')"></i></div>'))($scope);
                   }
            }
            else {
                var output = document.getElementById(x);
                output.innerHTML = "";
                for (var i = 0; i < $scope.UserInfo[x].length; ++i) {
                    $compile($(output).append('<div id="hidden" style="list-style-type:none;background-color: #f5f5f5;border: 1px solid #dcdcdc;font-weight: bold;margin:8px;overflow-y: hidden;padding: 4px 4px 4px 8px;max-width: 448px;margin-left: 0px;" contenteditable="false">' + $scope.UserInfo[x][i].name + '(' + $scope.UserInfo[x][i].size + ')<div style="display:none">' + $scope.UserInfo[x][i].id + '</div><i class="fa fa-times" aria-hidden="true" style="float:right;cursor: pointer;" ng-click="removeAttache($event,\''+x+'\')"></i></div>'))($scope);
                }
            }
            console.log($scope.UserInfo);
        }
      $scope.getcusForm=function(e){
         console.log(e);
         $scope.reqoMail=e
         $scope.reqoMail.reqMail.$setValidity("server", true);
      }
      $scope.prevent=function($event){
             if ($event.stopPropagation) $event.stopPropagation();
        if ($event.preventDefault) $event.preventDefault();
        $event.cancelBubble = true;
        $event.returnValue = false;
        }
      $scope.addnewRequestervalue=function(x){
            x.currentTarget.innerHTML = "<i class='fa fa-circle-o-notch fa-spin fa-1x fa-fw'></i>Saving...";
            $('#req2').attr('disabled','disabled');
            $scope.requesterObj={};
             
            $scope.requesterObj['full_name']=document.getElementById('requesterName').value;

            $scope.requesterObj['code']=$('.selected-dial-code').html();
             
            $scope.requesterObj['mobile']=document.getElementById('requesterMobile').value;
            
            $scope.requesterObj['email']=document.getElementById('requesterEmail').value;

            $scope.requesterObj['company']=document.getElementById('requesterCompany').value;
            
            $http.post('{{url("create/requester")}}',$scope.requesterObj).success(function(data){
                  $('#req2').removeAttr('disabled');
//                  alert(data.response.message)
                 $('#addpopup').modal('show');
                 $('.success-popup1').empty(data.response.message);
                 $('.success-popup1').append(data.response.message);
                  
                  $scope.reqId=data.response.user.id;
                  document.getElementById('requestro').value=data.response.user.first_name+" <"+data.response.user.email+">";
                  $scope.newAgent=false;
                  $scope.reqoMail.reqMail.$setValidity("server", true);
                  for(var i in $scope.tree3){
                    if($scope.tree3[i].title=="Requester"){
                       $scope.tree3[i].value=data.response.user.first_name+" <"+data.response.user.email+">";
                    }
                  }
                  document.getElementById('requesterName').value="";
                  $('.selected-dial-code').html('');
                  document.getElementById('requesterMobile').value="";
                  document.getElementById('requesterEmail').value="";
                  document.getElementById('requesterCompany').value="";
                  if($('.well')[0]){
                    $scope.errorResponse=false;  
                  }
                  $('#myModal9').modal('toggle');
            })
            .error(function(data){
                 $('#req2').removeAttr('disabled');
                 $.each(data,function(key,value){
                      $scope.erroro=value[0];
                      $scope.errorResponse=true;
                 });
                 
            })
            
      }
  $scope.getEditor=function(x,form){
    //console.log(vcRecaptchaService.getResponse());
    if(vcRecaptchaService.getResponse() == ""&&$scope.agentCaptcha){ 
                alert("Please resolve the captcha and submit!")
            }
   else {
       for(var i in $scope.tree3) {
         if($scope.tree3[i].title=='Description' && $scope.tree3[i].agentRequiredFormSubmit==true){
         if($(".cke_wysiwyg_frame").contents().find("body").html()){
          x.currentTarget.disabled=true;
          x.currentTarget.innerHTML="<i class='fa fa-circle-o-notch fa-spin fa-1x fa-fw'></i>Saving...";
          $scope.editoro = $(".cke_wysiwyg_frame").contents().find("body").html();
            if ($scope.editoro == '<p><br></p>') {
                $scope.editor1 = "";
            }
            else {
                $scope.editor1 = $scope.editoro;
            }
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
          $scope.editor=$(".cke_wysiwyg_frame").contents().find("body").html();
          $scope.imagesAlt=[];     
          $("<div>" + $scope.editor + "</div>").find('img').each(function(i) {
              
              $scope.imagesAlt.push(this.alt);
              })
         
          for(var i in $scope.imagesAlt){
            if($rootScope.arrayImage.data!=undefined){
            var x=$.grep($rootScope.arrayImage.data, function(e){
                 return e.filename == $scope.imagesAlt[i];
               })
             $scope.inlinImage.push(x[0]);
           }
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
            if( $scope.inlinImage.length!=0){
               //console.log($scope.inlinImage);
              $scope.inlinImage.forEach(function(v){ if(typeof v=="object"){delete v.base_64;} });
           }
           if($scope.attachmentImage.length!=0){
              //console.log($scope.attachmentImage);
             $scope.attachmentImage.forEach(function(v){ if(typeof v=="object"){delete v.base_64;} });
            }
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
                       if($scope.reqId!=null){
                        this[this.unique]=$scope.reqId;
                      }
                      else if($scope.reqValue!=null){
                         this[this.unique]=$scope.reqValue;
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
             if($scope.reqValue!=null){
                    $scope.editorValues['Requester']=parseInt($scope.reqValue, 10);
                    
            }  
              if($("#selecti2").val()){
                $scope.UserInfo['cc']=$("#selecti2").val();
              }
          
          $scope.UserInfo['inline']=$scope.inlinImage;
          $scope.UserInfo['media_attachment']=$scope.attachmentImage;
          $scope.UserInfo['api']=true;

            var maxsize = ($scope.uploadSize / 1024) / 1024;
            var max_file_number = "{{ini_get('max_file_uploads')}}";
            var file_upload_max_size = "{{file_upload_max_size()}}";
            console.log($scope.UserInfo);
        if (maxsize <= file_upload_max_size && total_file_number <= max_file_number) { 
            if($scope.UserInfo['requester']!=undefined){
         $scope.uploadArray.upload = Upload.upload({
                    url: "{{route('post.newticket')}}",
                    data: $scope.UserInfo,
                }).success(function(data){
                  console.log(data);
            //x.currentTarget.innerHTML = 'Submit';
            $('.well').css('display','block');      
            $('.well').html(data.message);
            $('html, body').animate({scrollTop:0}, 500);
            $('.well').css({'color':'white','background':'#5cb85c','border-color':'#4cae4c'});
            setTimeout(function(){
                 location.reload();  
            },2000);
             //location.reload();
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
        }else{
             x.currentTarget.disabled=false;
                x.currentTarget.innerHTML="Submit";
                $('.well').css('display','block');      
                $('.well').html('Please choose requester from the dropdown');
                $('.well').css({'color':'white','background':'#dd4b39','border-color':'#d73925'});
                $('html, body').animate({scrollTop: 0}, 500);
        }
            }else if (maxsize > file_upload_max_size && total_file_number <= max_file_number) {
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
            else if($scope.tree3[i].title=='Description' && $scope.tree3[i].agentRequiredFormSubmit==false){
           
               x.currentTarget.disabled=true;
          x.currentTarget.innerHTML="<i class='fa fa-circle-o-notch fa-spin fa-1x fa-fw'></i>Saving...";
          $scope.editoro = $(".cke_wysiwyg_frame").contents().find("body").html();
            if ($scope.editoro == '<p><br></p>') {
                $scope.editor1 = "";
            }
            else {
                $scope.editor1 = $scope.editoro;
            }

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
         
          $scope.editor=$(".cke_wysiwyg_frame").contents().find("body").html();
          $scope.imagesAlt=[];     
          $("<div>" + $scope.editor + "</div>").find('img').each(function(i) {
              
              $scope.imagesAlt.push(this.alt);
              })
         
          for(var i in $scope.imagesAlt){
           if($rootScope.arrayImage.data!=undefined){
            var x=$.grep($rootScope.arrayImage.data, function(e){
                 return e.filename == $scope.imagesAlt[i];
               })
             $scope.inlinImage.push(x[0]);
           }
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
                       if($scope.reqId!=null){
                        this[this.unique]=$scope.reqId;
                      }
                      else if($scope.reqValue!=null){
                         this[this.unique]=$scope.reqValue;
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
                  console.log($scope.tree5)
                  $.each($scope.tree5, function(key,value){
                        if(typeof value=='object'){
                            $.each(value, function(key,value){
                                   $scope.UserInfo[key]=value; 
                                })
                        }
                  })
             if($scope.reqValue!=null){
                    $scope.editorValues['Requester']=parseInt($scope.reqValue, 10);
                    
            }  
              if($("#selecti2").val()){
                $scope.UserInfo['cc']=$("#selecti2").val();
              }
          
          $scope.UserInfo['inline']=$scope.inlinImage;
          $scope.UserInfo['media_attachment']=$scope.attachmentImage;
          $scope.UserInfo['api']=true;

            var maxsize = ($scope.uploadSize / 1024) / 1024;
            var max_file_number = "{{ini_get('max_file_uploads')}}";
            var file_upload_max_size = "{{file_upload_max_size()}}";
            //console.log($scope.UserInfo);
        if (maxsize <= file_upload_max_size && total_file_number <= max_file_number) { 
            if($scope.UserInfo['requester']=undefined){
         $scope.uploadArray.upload = Upload.upload({
                    url: "{{route('post.newticket')}}",
                    data: $scope.UserInfo,
                }).success(function(data){
                  console.log(data);
            $('.well').css('display','block');      
            $('.well').html(data.message);
            $('html, body').animate({scrollTop:0}, 500);
            $('.well').css({'color':'white','background':'#5cb85c','border-color':'#4cae4c'});
            setTimeout(function(){
                 location.reload();  
            },2000);
             //location.reload();
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
        }else{
             x.currentTarget.disabled=false;
                x.currentTarget.innerHTML="Submit";
                $('.well').css('display','block');      
                $('.well').html('Please choose requester from the dropdown');
                $('.well').css({'color':'white','background':'#dd4b39','border-color':'#d73925'});
                $('html, body').animate({scrollTop: 0}, 500);
        }
            }else if (maxsize > file_upload_max_size && total_file_number <= max_file_number) {
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
     $scope.callApi=function(){
         
         $scope.api2Called=true;
         if($rootScope.arrayImage.next_page_url==null){
                 $scope.api2Called=false;   
        }
         $http.get($rootScope.arrayImage.next_page_url).success(function(data){
              console.log(data);
                  $scope.api2Called=false;
              [].push.apply($rootScope.arrayImage.data, data.data);
              console.log($rootScope.arrayImage.data)
                 $rootScope.arrayImage.next_page_url=data.next_page_url;
         
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
             //alert('Please Select a Particular Month and Year')
                 $('#selectpopup').modal('show');
                 $('.select-popup1').empty('Please Select a Particular Month and Year');
                 $('.select-popup1').append('Please Select a Particular Month and Year');
        }
        else if(filter.type==""&&filter.year==""&&filter.month!=""&&filter.day!=""){
             //alert('Please Select a Particular Year')
                 $('#selectpopup').modal('show');
                 $('.select-popup1').empty('Please Select a Particular Year');
                 $('.select-popup1').append('Please Select a Particular Year');
        }
        else if(filter.type==""&&filter.year==""&&filter.month!=""&&filter.day==""){
            // alert('Please Select a Particular Year')
               $('#selectpopup').modal('show');
               $('.select-popup1').empty('Please Select a Particular Year');
               $('.select-popup1').append('Please Select a Particular Year');
        }
        else{
            var config={
              params:filter
            }
            console.log(config);
            $http.get("{{url('media/files')}}",config).success(function(data){
                $rootScope.arrayImage=data;
            })
        }
         
    } 
    
    
    $scope.bou=0;
          
        $scope.getSelectOptions=function(x,z,a){
            var y=z.currentTarget.id;
             $scope.bou++;
            var dependancy = x;
            if($scope.bou==1){
            $scope['loado'+a]=true;
            $http.get("{{url('ticket/form/dependancy?dependency=')}}"+dependancy).success(function (data) {
                 $('#'+y).attr('ng-click',null).unbind('click');
                 $.each($scope.tree3,broker);
                 function broker(key,value){
                     if(typeof value=="object" && value.type=="select"||value.type=="multiselect"){
                         if(value.unique==y){
                            this.options=data;
                            //console.log(value);
                         }
                         $.each(value,broker);
                     }
                 }
                 $('#'+y).css('height', parseInt($('#'+y+' option').length) * 33);
                 //console.log($('#seletom'+y).css('height'));
                 $scope['loado'+a]=false;
                 $scope.bou=0;
            });
            }
           
        }
        $scope.requesterEmail=function(e,y,x){
            
            $scope['loado'+y]=true;
            $scope.reqoMail=x;
            if (e.keyCode === 8 || e.keyCode ===46) {
                $scope.newAgent=true;
                $scope.reqoMail.reqMail.$setValidity("server", false);
                $scope['loado'+y]=false;
            }
            else{
              setTimeout(function(){
                var charCode = e.currentTarget.value; 
                $http.get("{{url('ticket/form/requester?term=')}}"+charCode).success(function (data) {
                 $scope.reqEmails=data;    
                 $scope.reqstr=true;
                 $scope['loado'+y]=false;
                 if(data==""){
                    $scope.reqstr=false;
                    $scope.newAgent=true;
                    $scope.reqoMail.reqMail.$setValidity("server", false);
                  }
                })
              },100);
          }
          }
        
        $scope.selectReq=function(x,y){
            $scope.reqValue=x.id;
            $scope.tree3[y].value=x.name;
            $scope.reqstr=false;
            $scope.newReqField=false;
            $scope.newAgent=false;
            $scope.reqoMail.reqMail.$setValidity("server", true);
        }
});
</script>
@endpush

