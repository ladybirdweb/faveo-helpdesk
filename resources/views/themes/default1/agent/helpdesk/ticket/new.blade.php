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
        <div class="container">
           <div class="well col-sm-10" style="display:none"></div>
        <!-- Nested node template -->

        <script type="text/ng-template" id="nodes_renderer2.html">
          <ng-form name="faveoClientForm">
          <div class="row" style="margin:15px;width:100%">
              <div class="col-sm-3" style="padding: 0px;line-height: 2.5">
                 <label>@{{node.label}}</label><span ng-show="node.agentRequiredFormSubmit==true" style="color:red">*</span>
              </div>
              <div class="col-sm-8" style="padding: 0px">
                <input type="text" name="textfield@{{$index}}"  ng-if="node.type=='text'&& node.title!='Api'" class="form-control" style="border-radius: 0px;width:85%" ng-model="node.value" ng-required="@{{node.agentRequiredFormSubmit}}">
                <span style="color:red" ng-show="faveoClientForm.textfield@{{$index}}.$dirty && faveoClientForm.textfield@{{$index}}.$invalid">
                                          <span ng-show="faveoClientForm.textfield@{{$index}}.$error.required">@{{node.label}} is required.</span>
                </span>
                <input type="text" name="numberfield@{{$index}}"  ng-if="node.type=='number'" class="form-control numberOnly" style="border-radius: 0px;width:85%" ng-model="node.value" ng-required="@{{node.agentRequiredFormSubmit}}" >
                <span style="color:red" ng-show="faveoClientForm.numberfield@{{$index}}.$dirty && faveoClientForm.numberfield@{{$index}}.$invalid">
                                          <span ng-show="faveoClientForm.numberfield@{{$index}}.$error.required">@{{node.label}} is required.</span>
                </span>
                <input type="text"  name="datefield@{{$index}}" ng-if="node.type=='date'" class="form-control" style="border-radius: 0px;width:85%" >
                <span style="color:red" ng-show="faveoClientForm.datefield@{{$index}}.$dirty && faveoClientForm.datefield@{{$index}}.$invalid">
                                          <span ng-show="faveoClientForm.datefield@{{$index}}.$error.required">@{{node.label}} is required.</span>
                </span>
                <div ng-if="node.type=='email'&& node.label=='Requester'">
                <div class="input-group"  style="width:85%">
                           <input type="text" class="form-control" id="requestro" style="border-radius: 0px;height: 34px"  ng-model="node.value" ng-required="@{{node.agentRequiredFormSubmit}}" ng-keypress="requesterEmail($event,$index)"  placeholder="Requester Email">
                                  <div class="input-group-btn">
                                      <button class="btn btn-default" type="button" style="margin-right: 0px;border-radius: 0px;" data-toggle="modal" data-target="#myModal9">Add new requester</button>
                                      <span ng-if="node.agentCCfield==true">
                                      <button class="btn btn-default" type="button"  style="margin-right: 0px;border-radius: 0px" ng-click="showCc()" ng-hide="displayCc">Cc</button></span>
                                      </span>
                                  </div>
                          <ul class="dropdown-menu" style="width:85%;display:block" ng-if="reqstr">
                               <li ng-repeat="email in reqEmails"><a href="javascript:void(0)" ng-click="selectReq(email,$parent.$index)">@{{email.name}}(@{{email.first_name}} @{{email.last_name}})</a></li>
                          </ul>
                </div>
                <span ng-show="loado@{{$index}}" style="width: 13%;float: right;margin-top: -27px;">
                     <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}" style="width:20px;height:20px">
                </span>
                </div>
                <div style="width: 100%" ng-if="node.title=='Requester'&&displayCc">
                <div class="input-group"  style="margin-top: 5px;width: 85%;display:inline-block;">
                          <!--  <input type="text" class="form-control" style="border-radius: 0px;height:34px;width:85%" placeholder="Enter a Cc"           ng-keypress="requesterCc($event,$index)"> -->
                            <select class="form-control"  id="selecti2" multiple="multiple"></select>
                                  <div class="input-group-btn">
                                     <button class="btn btn-default" type="button" style="margin-top: 5px;margin-right: 0px;border-radius: 0px" ng-click="showCc()">Hide Cc</button>
                                  </div>
                           <ul class="dropdown-menu" style="width:85%;display:block" ng-if="reqstr">
                                  <li ng-repeat="email in reqEmails"><a href="javascript:void(0)" ng-click="selectReq(email,$parent.$index)"><div style="width: 10%;display: inline-block;"><img ng-src="@{{email.profile_pic}}" width="25px" height="25px"></div><div style="width: 90%;display: inline-block;">@{{email.email}}(@{{email.first_name}} @{{email.last_name}})</div></a></li>
                          </ul>
                </div>
                <span ng-show="loado@{{$index}}" style="width:15%"><img src="{{asset("lb-faveo/media/images/gifloader.gif")}}" style="width:20px;height:20px"></span>
                </div>
                <textarea name="descript@{{$index}}"  class="form-control" ng-if="node.type=='textarea'&& node.default=='no'" style="border-radius: 0px;width:85%" ng-model="node.value" ng-required="@{{node.agentRequiredFormSubmit}}"></textarea>
                <span style="color:red" ng-show="faveoClientForm.descript@{{$index}}.$dirty && faveoClientForm.descript@{{$index}}.$invalid">
                                          <span ng-show="faveoClientForm.descript@{{$index}}.$error.required">@{{node.label}} is required.</span>
                </span>
                <div ng-if="node.type=='textarea'&&node.title=='Description'" style="width:85%">
                     @include('themes.default1.inapp-notification.wyswyg-editor')
                     <textarea name="description" id="description@{{$index}}" class="form-control"  style="border-radius: 0px;" ng-model="node.value"></textarea>
                    <span style="color:red" ng-show="description">
                                          <span>Description is required.</span>
                    </span>  
                    <div id="file_details"></div>    
                </div>
                <div ng-if="node.type=='select'&&node.default=='yes'||node.title=='Api'">
                <select  ng-model="node.value" name="selected@{{$index}}" id="seletom@{{$index}}" ng-options="option.optionvalue for option in node.options" class="form-control" style="border-radius: 0px;width:85%;display:inline-block" ng-required="@{{node.agentRequiredFormSubmit}}" ng-click="getSelectOptions(node.api,$index,$event)">
                  <option value="">Select</option>
                </select>
                <span ng-show="loado@{{$index}}" style="width:15%"><img src="{{asset("lb-faveo/media/images/gifloader.gif")}}" style="width:20px;height:20px"></span>
                <div style="color:red" ng-show="faveoClientForm.selected@{{$index}}.$dirty && faveoClientForm.selected@{{$index}}.$invalid">
                    <span ng-show="faveoClientForm.selected@{{$index}}.$error.required">@{{node.label}} is required.</span>
                  </div>
                </div>
                <div ng-if="node.type=='select'&&node.default=='no'">
                <select  ng-model="node.value"    name="selected@{{$index}}"  ng-options="option.optionvalue for option in node.options" class="form-control" style="border-radius: 0px;width:85%" ng-required="@{{node.agentRequiredFormSubmit}}">
                  <option value="">Select</option>
                </select>
                  <span style="color:red" ng-show="faveoClientForm.selected@{{$index}}.$dirty && faveoClientForm.selected@{{$index}}.$invalid">
                    <span ng-show="faveoClientForm.selected@{{$index}}.$error.required">@{{node.label}} is required.</span>
                  </span>
                </div>
                <ul class="list-group" ng-if="node.type=='radio'" style="border:none">
                      <li ng-repeat="option in node.options"  class="list-group-item" style="border:none">
                                          <input type="radio" name="selection@{{$parent.$index}}" id="happy@{{$index}}" ng-model="node.value" value="@{{option.optionvalue}}" ng-required="!node.value"/>
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
        <div class="col-sm-12" >
          <form name="faveoForm">
            <div class="row" style="margin-right:0px">
                <div class="col-sm-12">
                    <ul  ng-model="tree3"  style="list-style-type:none">
                        <li ng-repeat="node in tree3"  ng-include="'nodes_renderer2.html'">
                            
                        </li>
                    </ul>

                </div>
                <div style="text-align:center"  id="loader">
                        <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}" >
                </div>
            </div> 
            <div class="row">
                <div class="col-sm-11" style="border-top:1px solid gainsboro;background-color: white;padding:5px;text-align: right">
                    <button type="button" class="btn btn-primary" ng-disabled="faveoForm.$invalid"  data-ng-click="getEditor($event,faveoForm)">Submit</button>
                </div>
            </div>
            </form>
        </div>
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
                                          <span ng-show="addnewRequester.requsName@{{$index}}.$error.required">@{{node.label}} is required.</span>
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
                     <input type="text" name="requsMobile@{{$index}}" class="form-control" style="border-radius:0;margin-top:10px" ng-model="req.mobile" placeholder="Requester mobile" ng-pattern="/^[0-9]{1,99}$/" id="requesterMobile"/> 
                                <span style="color:red" ng-show="addnewRequester.requsMobile@{{$index}}.$dirty && addnewRequester.requsMobile@{{$index}}.$invalid">
                                          <span ng-show="addnewRequester.requsMobile@{{$index}}.$error.pattern">Invalid Mobile Number.</span>
                                </span> 
                    </div>
                        </div>
                         <label>Company</label>
                             <input type="text" class="form-control"  style="border-radius:0;margin-top:10px;width:85%" ng-model="req.company" placeholder="Requester company" id="requesterCompany" ng-required="@{{node.agent_name}}"/>
                        <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                  <button type="button" class="btn btn-info" id="req2" ng-disabled="addnewRequester.$invalid" ng-click="addnewRequestervalue()">Add</button>
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
       $('.dropdown-menu').hide();
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



app.controller('CreateTicketAgent', function($scope,$http, $sce,$window,$compile,Upload){
    $scope.disable=true;
      $scope.inlineImage=true;
      $scope.arrayImage=[];
      $scope.attachmentImage=[];
      $scope.inlinImage=[];
      $scope.editorValues={};
         $scope.tree3 = [];
        $scope.uploadArray=[];
        $scope.emailFormat = /^[a-z]+[a-z0-9._]+@[a-z]+\.[a-z.]{2,5}$/;
        $http.get("{{url('form/ticket')}}").success(function (data) {
            $scope.tree3 = data[0];
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
//         
        })
        
    
     function walker(key, value) {
          // ...do what you like with `key` and `value`
          display("Visited " + value);
      
          if (typeof value === "object") {
              // Recurse into children
              $.each(value, walker);
          }
      }
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
      $scope.addnewRequestervalue=function(){
            $('#req2').attr('disabled','disabled');
            $scope.requesterObj={};
             
            $scope.requesterObj['full_name']=document.getElementById('requesterName').value;

            $scope.requesterObj['code']=$('.selected-dial-code').html();
             
            $scope.requesterObj['mobile']=document.getElementById('requesterMobile').value;
            
            $scope.requesterObj['email']=document.getElementById('requesterEmail').value;

            $scope.requesterObj['company']=document.getElementById('requesterCompany').value;
            
            $http.post('{{url("create/requester")}}',$scope.requesterObj).success(function(data){
                  //console.log(data);
                  $scope.reqId=data.response.user.id;
                  document.getElementById('requestro').value=data.response.user.first_name+" <"+data.response.user.email+">";
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

       for(var i in $scope.tree3) {
         if($scope.tree3[i].title=='Description' && $scope.tree3[i].agentRequiredFormSubmit==true){
         if($(".cke_wysiwyg_frame").contents().find("body").text()){
          x.currentTarget.disabled=true;
          x.currentTarget.value='Sending, please wait...';
          $scope.editoro = $(".cke_wysiwyg_frame").contents().find("body").html();
            if ($scope.editoro == '<p><br></p>') {
                $scope.editor1 = "";
            }
            else {
                $scope.editor1 = $scope.editoro;
            }
         
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
          
          /*$scope.tree3.forEach(function (k) {
               for(var i in $scope.tree3){
                if($scope.tree3[i].label==k.label){
                   if($scope.tree3[i].label!=$scope.tree3[i].title){
                      $scope.tree3[i].label=k.label+'_'+i; 
                  }
                }
              }
            })*/
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
          /* for(var i in $scope.tree3) {
               if($scope.tree3[i].default=='no'){
                var a=$scope.tree3[i].label;
                var b=a.split('_');
                if($scope.tree3[i].type=='select'){
                    $scope['formDetails'+i]=[];
                    var array=$scope['formDetails'+i];
                  array[b[0]]=$scope.tree3[i].value.id;
                  $scope.editorValues[$scope.tree3[i].label]=array;
                }
                else{
                  $scope['formDetails'+i]=[];
                  var array=$scope['formDetails'+i];
                  array[b[0]]=$scope.tree3[i].value;
                  $scope.editorValues[$scope.tree3[i].label]=array;
               } 
              }
              else{
                if($scope.tree3[i].title=='Description'){
                  $scope.editorValues[$scope.tree3[i].label]=$scope.editor1;
                }
                else if($scope.tree3[i].type=='select'){
                  $scope.editorValues[$scope.tree3[i].label]=$scope.tree3[i].value.id;
                }
                else{
                  
                  $scope.editorValues[$scope.tree3[i].label]=$scope.tree3[i].value;
               }
              }
            }*/
           
             if($scope.reqValue!=null){
            $scope.editorValues['Requester']=parseInt($scope.reqValue, 10);
            }  
              if($("#selecti2").val()){
                $scope.tree5['cc']=$("#selecti2").val();
              }
          
          $scope.tree5['inline']=$scope.inlinImage;
          $scope.tree5['attachment']=$scope.attachmentImage;
          $scope.tree5['api']=true;
          
         $scope.uploadArray.upload = Upload.upload({
                    url: "{{route('post.newticket')}}",
                    data: $scope.tree5,
                }).success(function(data){
                  console.log(data);
            x.currentTarget.disabled = false;
            x.currentTarget.innerHTML = 'Submit';
            $('.well').css('display','block');      
            $('.well').html(data.message);
            $('.well').css('color','green');
            $('html, body').animate({scrollTop:0}, 500);
            setTimeout(function(){
                  //location.reload();  
            },2000);
             //location.reload();
          })
          .error(function(data){
                x.currentTarget.disabled=false;
                x.currentTarget.value="Create Ticket";
                $('.well').css('display','block');      
                $('.well').html(data.error);
                $('.well').css('color','red');
                $('html, body').animate({scrollTop: 0}, 500);
            })
            
          }
            else{
                $scope.description=true;
            }
            }
            else if($scope.tree3[i].title=='Description' && $scope.tree3[i].agentRequiredFormSubmit==false){
           
               x.currentTarget.disabled=true;
          x.currentTarget.value='Sending, please wait...';
          $scope.editoro = $(".cke_wysiwyg_frame").contents().find("body").html();
            if ($scope.editoro == '<p><br></p>') {
                $scope.editor1 = "";
            }
            else {
                $scope.editor1 = $scope.editoro;
            }
         
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
          
          /*$scope.tree3.forEach(function (k) {
               for(var i in $scope.tree3){
                if($scope.tree3[i].label==k.label){
                   if($scope.tree3[i].label!=$scope.tree3[i].title){
                      $scope.tree3[i].label=k.label+'_'+i; 
                  }
                }
              }
            })
            
           for(var i in $scope.tree3) {
               if($scope.tree3[i].default=='no'){
                var a=$scope.tree3[i].label;
                var b=a.split('_');
                if($scope.tree3[i].type=='select'){
                    $scope['formDetails'+i]=[];
                    var array=$scope['formDetails'+i];
                  array[b[0]]=$scope.tree3[i].value.id;
                  $scope.editorValues[$scope.tree3[i].label]=array;
                }
                else{
                  $scope['formDetails'+i]=[];
                  var array=$scope['formDetails'+i];
                  array[b[0]]=$scope.tree3[i].value;
                  console.log(array[0]);
                  $scope.editorValues[$scope.tree3[i].label]=array;
               } 
              }
              else{
                if($scope.tree3[i].title=='Description'){
                  $scope.editorValues[$scope.tree3[i].label]=$scope.editor1;
                }
                else if($scope.tree3[i].type=='select'){
                  $scope.editorValues[$scope.tree3[i].label]=$scope.tree3[i].value.id;
                }
                else{
                  
                  $scope.editorValues[$scope.tree3[i].label]=$scope.tree3[i].value;
               }
              }
            }*/
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
                          $scope.deltearray.push(key);
                      }
                      else if('Subject' in value){
                        $scope.tree5['Subject']=value.Subject;
                         $scope.deltearray.push(key);
                      }
                      else if('Type' in value){
                        $scope.tree5['Type']=value.Type;
                        $scope.deltearray.push(key);
                      }
                      else if('Status' in value){
                        $scope.tree5['Status']=value.Status;
                        $scope.deltearray.push(key);
                      }
                      else if('Priority' in value){
                        $scope.tree5['Priority']=value.Priority;
                        $scope.deltearray.push(key);
                      }
                      else if ('Help Topic' in value){
                         var array=Object.values(value)
                        $scope.tree5['Help Topic']=array[0];
                        $scope.deltearray.push(key);
                      }
                      else if('Assigned' in value){
                        $scope.tree5['Assigned']=value.Assigned;
                        $scope.deltearray.push(key);
                      }
                      else if('Description' in value){
                        $scope.tree5['Description']=value.Description;
                        $scope.deltearray.push(key);
                      }
                  }
                  
                  console.log($scope.tree5)
           /*if($('#requesterName').val())
            {
            $scope.editorValues['Requester_name']=document.getElementById('requesterName').value;
             }
             if($('#requesterMobile').val())
            {
            $scope.editorValues['Requester_mobile']=document.getElementById('requesterMobile').value;
             }
             if($('#requesterEmail').val())
            {
            $scope.editorValues['Requester_email']=document.getElementById('requesterEmail').value;
             }
             if($('.selected-dial-code').html())
            {
            $scope.editorValues['Requester_code']=$('.selected-dial-code').html();
             }
             if($scope.reqValue!=null){
            $scope.editorValues['Requester']=parseInt($scope.reqValue, 10);
            }*/  
             
          
          $scope.tree5['inline']=$scope.inlinImage;
          $scope.tree5['attachment']=$scope.attachmentImage;
          $scope.tree5['api']=true;
          
          
          $scope.uploadArray.upload = Upload.upload({
                    url: "{{route('post.newticket')}}",
                    data: $scope.tree5,
                }).success(function(data){
            x.currentTarget.disabled = false;
            x.currentTarget.innerHTML = 'Submit';
            $('.well').css('display','block');      
            $('.well').html(data.message);
            $('.well').css('color','green');
            $('html, body').animate({scrollTop:0}, 500);
            setTimeout(function(){
                  location.reload();
            },2000);
             //location.reload();
          })
          .error(function(data){
                x.currentTarget.disabled=false;
                x.currentTarget.value="Create Ticket";
                $('.well').css('display','block');      
                $('.well').html(data.error);
                $('.well').css('color','red');
                $('html, body').animate({scrollTop: 0}, 500);
            })
            }
            }
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
    
    
    $scope.bou=0;
          
        $scope.getSelectOptions=function(x,y,z){
             $scope.bou++;
            var dependancy = x;
            if($scope.bou==1){
            $scope['loado'+y]=true;
            $http.get("{{url('ticket/form/dependancy?dependency=')}}"+dependancy).success(function (data) {
                 $('#seletom'+y).attr('ng-click',null).unbind('click');
                 $scope.tree3[y].options=data;
                 $('#seletom'+y).css('height', parseInt($('#seletom'+y+' option').length) * 33);
                 console.log($('#seletom'+y).css('height'));
                 $scope['loado'+y]=false;
                 $scope.bou=0;
            });
            }
           
        }
        $scope.requesterEmail=function(e,y){
            $scope['loado'+y]=true;
            setTimeout(function(){
            var charCode = e.currentTarget.value; 
            $http.get("{{url('ticket/form/requester?term=')}}"+charCode).success(function (data) {
                 $scope.reqEmails=data;    
                 $scope.reqstr=true;
                 $scope['loado'+y]=false;
                 if(data==""){
                    $scope.reqstr=false;
                  }
                })
          },100);
          }
        
        $scope.selectReq=function(x,y){
            $scope.reqValue=x.id;
            $scope.tree3[y].value=x.name;
            $scope.reqstr=false;
            $scope.newReqField=false;
        }
});
</script>
@endpush


