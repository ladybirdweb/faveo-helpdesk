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
          <div class="row" style="margin:15px;width:100%">
              <div class="col-sm-3" style="padding: 0px;line-height: 2.5">
                 <label>@{{node.label}}</label><span ng-show="node.agentRequiredFormSubmit==true" style="color:red">*</span>
              </div>
              <div class="col-sm-8" style="padding: 0px">
                <input type="text" name="textfield@{{$index}}"  ng-if="node.type=='text'" class="form-control" style="border-radius: 0px;width:85%" ng-model="node.value" ng-required="@{{node.agentRequiredFormSubmit}}">
                <span style="color:red" ng-show="faveoClientForm.textfield@{{$index}}.$dirty && faveoClientForm.textfield@{{$index}}.$invalid">
                                          <span ng-show="faveoClientForm.textfield@{{$index}}.$error.required">@{{node.label}} is required.</span>
                </span>
                <input type="number" name="numberfield@{{$index}}"  ng-if="node.type=='number'" class="form-control" style="border-radius: 0px;width:85%" ng-model="node.value" ng-required="@{{node.agentRequiredFormSubmit}}">
                <span style="color:red" ng-show="faveoClientForm.numberfield@{{$index}}.$dirty && faveoClientForm.numberfield@{{$index}}.$invalid">
                                          <span ng-show="faveoClientForm.numberfield@{{$index}}.$error.required">@{{node.label}} is required.</span>
                </span>
                <input type="text"  name="datefield@{{$index}}" ng-if="node.type=='date'" class="form-control" style="border-radius: 0px;width:85%" >
                <span style="color:red" ng-show="faveoClientForm.datefield@{{$index}}.$dirty && faveoClientForm.datefield@{{$index}}.$invalid">
                                          <span ng-show="faveoClientForm.datefield@{{$index}}.$error.required">@{{node.label}} is required.</span>
                </span>
                <div class="input-group" ng-if="node.type=='email'&& node.label=='Requester'" style="width:100%">
                           <input type="text" class="form-control"  style="border-radius: 0px;width:85%"  ng-model="node.value"  ng-keypress="requesterEmail($event,$index)">
                            <span ng-show="loado@{{$index}}" style="width:15%"><img src="{{asset("lb-faveo/media/images/gifloader.gif")}}" style="width:20px;height:20px"></span>
                
                                  <div class="input-group-btn" ng-show="node.customerCCfield">
                                      <button class="btn btn-default" type="button" style="margin-right: 0px;" >Add new requester</button>
                                      <button class="btn btn-default" type="button"  style="margin-right: 0px;border-radius: 0px" ng-click="showCc()" ng-hide="displayCc">Cc</button></span>
                                  </div>
                            <ul class="dropdown-menu" style="width:100%;display:block" ng-if="reqstr">
                                  <li ng-repeat="email in reqEmails"><a href="javascript:void(0)" ng-click="selectReq(email,$parent.$index)">@{{email.name}}(@{{email.first_name
}} @{{email.last_name}})</a></li>
                            </ul>
                </div>
                <div ng-if="newReqField && node.type=='email'&& node.label=='Requester'" style="margin-top:15px;">
                    <input type="text" name="requsName@{{$index}}" class="form-control" style="border-radius:0;margin-top:10px;width:85%" ng-model="req.name" placeholder="Add Requester Name" id="requesterName" ng-required="@{{node.agent_name}}"/>
                                <span style="color:red" ng-show="faveoClientForm.requsName@{{$index}}.$dirty && faveoClientForm.requsName@{{$index}}.$invalid">
                                          <span ng-show="faveoClientForm.requsName@{{$index}}.$error.required">@{{node.label}} is required.</span>
                                </span>
                    <input type="email" name="requsEmail@{{$index}}" class="form-control" style="border-radius:0;margin-top:10px;width:85%" ng-model="req.email" ng-pattern="emailFormat" placeholder="Add Requester Email" id="requesterEmail" ng-required="@{{node.agent_email}}"/>
                                <span style="color:red" ng-show="faveoClientForm.requsEmail@{{$index}}.$dirty && faveoClientForm.requsEmail@{{$index}}.$invalid">
                                          <span ng-show="faveoClientForm.requsEmail@{{$index}}.$error.required">Email is required.</span>
                                          <span ng-show="faveoClientForm.requsEmail@{{$index}}.$error.pattern">Invalid email address.</span>
                                </span>   
                    <div class="row" style="width:85%">
                    <div class="col-sm-3" style="margin-top:10px">
                        <input type="tel" class="form-control" id="telCode"style="visibility:hidden"/>
                    </div>
                    <div class="col-sm-9">
                     <input type="text" name="requsMobile@{{$index}}" class="form-control" style="border-radius:0;margin-top:10px" ng-model="req.mobile" placeholder="Add Requester mobile" ng-pattern="/^[0-9]{1,99}$/" id="requesterMobile" ng-required="@{{node.customer_mobile}}"/> 
                                <span style="color:red" ng-show="faveoClientForm.requsMobile@{{$index}}.$dirty && faveoClientForm.requsMobile@{{$index}}.$invalid">
                                          <span ng-show="faveoClientForm.requsMobile@{{$index}}.$error.required">Mobile No is required.</span>
                                          <span ng-show="faveoClientForm.requsMobile@{{$index}}.$error.pattern">Invalid Mobile Number.</span>
                                </span> 
                    </div>
                    </div>
                </div>
                <div class="input-group" ng-if="node.title=='Requester'&&node.displayCc" style="margin-top: 5px;">
                           <input type="text" class="form-control" style="border-radius: 0px" placeholder="Enter a Cc">
                                  <div class="input-group-btn">
                                     <button class="btn btn-default" type="button" style="margin-right: 0px;border-radius: 0px" ng-click="showCc()">Hide Cc</button>
                                  </div>
                </div>
                <textarea name="description0"  class="form-control" ng-if="node.type=='textarea'&& node.default=='no'" style="border-radius: 0px;width:85%" ng-model="node.value" ng-required="@{{node.agentRequiredFormSubmit}}"></textarea>
                <div ng-if="node.type=='textarea'&&node.title=='Description'" style="width:85%">
                     @include('themes.default1.inapp-notification.wyswyg-editor')
                     <textarea name="description" id="description@{{$index}}" class="form-control"  style="border-radius: 0px;" ng-model="node.value"></textarea>
                    <span style="color:red" ng-show="description">
                                          <span>Description is required.</span>
                    </span>  
                    <div id="file_details"></div>    
                </div>
                <div ng-if="node.type=='select'&&node.default=='yes'">
                <select  ng-model="node.value" name="selected@{{$index}}" id="seletom@{{$index}}" ng-options="option.optionvalue for option in node.options" class="form-control" style="border-radius: 0px;width:85%;display:inline-block" ng-required="@{{node.agentRequiredFormSubmit}}" ng-click="getSelectOptions(node.api,$index,$event)">
                  <option value="">Select</option>
                </select>
                <span ng-show="loado@{{$index}}" style="width:15%"><img src="{{asset("lb-faveo/media/images/gifloader.gif")}}" style="width:20px;height:20px"></span>
                </div>
                <select  ng-model="node.value"    name="selected@{{$index}}" ng-if="node.type=='select'&&node.default=='no'&&node.customerDisplay" ng-options="option.optionvalue for option in node.options" class="form-control" style="border-radius: 0px;width:85%" ng-required="@{{node.agentRequiredFormSubmit}}">
                  <option value="">Select</option>
                </select>
                <span style="color:red" ng-show="faveoClientForm.selected@{{$index}}.$dirty && faveoClientForm.selected@{{$index}}.$invalid">
                  <span ng-show="faveoClientForm.selected@{{$index}}.$error.required">@{{node.label}} is required.</span>
               </span>
                <ul class="list-group" ng-if="node.type=='radio'" style="border:none">
                      <li ng-repeat="option in node.options"  class="list-group-item" style="border:none">
                                          <input type="radio" name="selection@{{$parent.$index}}" id="happy@{{$index}}" ng-model="node.value" value="@{{option}}"ng-required="!node.value"/>
                                            <label for="happy@{{$index}}">@{{option.optionvalue}}</label>
                      </li>
                </ul>
                <ul class="list-group" ng-if="node.type=='checkbox'" style="border:none">
                      <li ng-repeat="option in node.options"  class="list-group-item" style="border:none">
                                          <input type="checkbox" name="selection@{{$parent.$index}}@{{$index}}" id="happy" ng-model="node.value" value="@{{option}}" ng-click="checkboxValue(option)">
                                            <label for="selection@{{$parent.$index}}@{{$index}}">@{{option.optionvalue}}</label>
                      </li>
                </ul>
              </div>
              <div class="col-sm-12"  ng-repeat="option in node.options" ng-if="option.nodes.length>0 && node.value">
                  <ul ng-model="option.nodes" ng-class="{hidden: collapsed}" style="list-style-type:none;margin-left: -70px" ng-if="option==node.value">
                      <li  ng-repeat="node in option.nodes" ng-include="'nodes_renderer2.html'">
                    </li>
                  </ul>
              </div>

       
          </div>
          <ul  ng-model="node.nodes" ng-class="{hidden: collapsed}" style="list-style-type:none">
            <li ng-repeat="node in node.nodes"  ng-include="'nodes_renderer2.html'">
            </li>
          </ul>
        </script>
        <div class="col-sm-10" style="border: 1px solid gainsboro;">
            <form name="faveoClientForm" novalidate>
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
                <div style="text-align:center"  id="loader">
                        <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}" >
                </div>
            </div> 
            <div class="row">
                <div class="col-sm-12" style="border-top:1px solid gainsboro;background-color: white;padding:5px;text-align: right">
                    <button type="button" class="btn btn-info" ng-disabled="faveoClientForm.$invalid"  ng-click="getEditor($event,requesterName)">Submit</button>
                </div>
            </div>
            </form>
        </div>
    </div>
    
    
    
    
    
</div><!-- /. box -->

@stop
@push('scripts')
<script src="{{asset('vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
<script src="{{asset("lb-faveo/js/intlTelInput.js")}}"></script>
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
          },2000);
//         
        })
        
       
     
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
          
          $scope.tree3.forEach(function (k) {
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
            }
           if($('#requesterName').val())
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
            }  
             
          
          $scope.editorValues['inline']=$scope.inlinImage;
          $scope.editorValues['attachment']=$scope.attachmentImage;
          $scope.editorValues['api']=true;
          console.log($scope.editorValues);
          
          $scope.uploadArray.upload = Upload.upload({
                    url: "{{route('post.newticket')}}",
                    data: $scope.editorValues,
                }).success(function(data){
            x.currentTarget.disabled = false;
            x.currentTarget.innerHTML = 'Submit';
            $scope.editorValues['Requester_name']="";
            $scope.editorValues['Requester_email']="";
            $scope.editorValues['Requester_name']="";
            $('.well').css('display','block');      
            $('.well').html(data.success);
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
          
          $scope.tree3.forEach(function (k) {
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
            }
           if($('#requesterName').val())
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
            }  
             
          
          $scope.editorValues['inline']=$scope.inlinImage;
          $scope.editorValues['attachment']=$scope.attachmentImage;
          $scope.editorValues['api']=true;
          console.log($scope.editorValues);
          
          $scope.uploadArray.upload = Upload.upload({
                    url: "{{route('post.newticket')}}",
                    data: $scope.editorValues,
                }).success(function(data){
            x.currentTarget.disabled = false;
            x.currentTarget.innerHTML = 'Submit';
            $scope.editorValues['Requester_name']="";
            $scope.editorValues['Requester_email']="";
            $scope.editorValues['Requester_name']="";
            $('.well').css('display','block');      
            $('.well').html(data.success);
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
    
    
    
            
        $scope.getSelectOptions=function(x,y,z){
            var dependancy = x;
            $scope['loado'+y]=true;
            $http.get("{{url('ticket/form/dependancy?dependency=')}}"+dependancy).success(function (data) {
                 $('#seletom'+y).attr('ng-click',null).unbind('click');
                 $('#seletom'+y).css('max-height','100%');
                 $scope.tree3[y].options=data;
                 $scope['loado'+y]=false;
            });
        }
         $scope.requesterEmail=function(e,y){
            $scope['loado'+y]=true;
            setTimeout(function(){
            var charCode = e.currentTarget.value; 
            $http.get("{{url('ticket/form/requester?term=')}}"+charCode).success(function (data) {
                 $scope.reqEmails=data;    
                $scope['loado'+y]=false; 
                $scope.reqstr=true;
                 if(data==""){
                    $scope.reqstr=false;
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
            });
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


