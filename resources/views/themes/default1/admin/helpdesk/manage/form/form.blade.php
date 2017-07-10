@extends('themes.default1.admin.layout.admin')
<style>
   input[type="radio"]:focus, input[type="checkbox"]:focus {
       outline: none !important;
     }
</style>
@section('Manage')
active
@stop

@section('manage-bar')
active
@stop

@section('forms')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{!! Lang::get('lang.forms') !!}</h1>
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')
<ol class="breadcrumb">
</ol>
@stop
<!-- /breadcrumbs -->
<!-- content -->
@section('content')
        <link href="{{asset('lb-faveo/js/form/angular-ui-tree.css')}}" rel="stylesheet" type="text/css" > 
        <link href="{{asset('lb-faveo/js/form/app.css')}}" rel="stylesheet" type="text/css" >
  
<style>
     .tree-node{
        margin:10px;
     }
     .angular-ui-tree-empty {
    border: 1px solid gainsboro;
    min-height: 500px;
    height: 100%;
    background-color: white;
    background-image: none;
  }
  .list-group{
    border: 1px solid #ddd;
  }
  .list-group-item{
    border: none;
  }
  .list-inline > li {
    padding: 0px;
  }
  .sticky {
      position: fixed;
      top: 50px;
      z-index: 100;
      -webkit-box-shadow: 0 2px 6px rgba(63,63,63,0.1);
      box-shadow: 0 2px 6px rgba(63,63,63,0.1);
      
  }
  
  </style>
<div class="box" ng-controller="CloningCtrl">
   
    <div class="box-body with-border">
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        @endif
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif
        @if(Session::has('warn'))
        <div class="alert alert-warning alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('warn')}}
        </div>
        @endif
        <!--Code-->
        
        <div class="container">
            <div class="well col-sm-10" style="display:none"></div>
  <!-- Nested node template -->
<script type="text/ng-template" id="nodes_renderer1.html">
  <div ui-tree-handle class="tree-node tree-node-content" style="margin:0px">
    <span>@{{node.title}}</span>
  </div> 
  <ol ui-tree-nodes="" ng-model="node.nodes" ng-class="{hidden: collapsed}" class="list-inline">
    <li ng-repeat="node in node.nodes" ui-tree-node ng-include="'nodes_renderer1.html'">
    </li>
  </ol>
</script>
<script type="text/ng-template" id="nodes_renderer2.html">
  <div class="tree-node">
    <div class="pull-left tree-handle" ui-tree-handle>
      <span class="glyphicon glyphicon-list"></span>
    </div>
    <div class="tree-node-content dropdown">
     
       <label>@{{node.title}}</label>
      
      <a class="pull-right btn btn-danger btn-xs" data-nodrag ng-click="remove(this)" ng-show="node.default=='no'" style="padding: 3px 5px"><span class="glyphicon glyphicon-remove"> </span></a>
      <a class="pull-right btn btn-info btn-xs collapser"  data-toggle="collapse" aria-controls="collapseExample" style="padding: 3px 5px"><span class="glyphicon glyphicon glyphicon-pencil"></span></a>
      <div class="panel-collapse collapse" id="collapseExample" style="margin-top: 10px;">
        <ul class="list-group" >
           <li class="list-group-item row" ng-show="node.title=='Requester'" style="margin-left: 0px;margin-right: 0px">
             <div class="col-sm-9">
                  <h3>Behaviour</h3>
             </div>
             <div class="col-sm-3">
                  <button type="button" class="btn btn-default btn-sm" ng-show="node.default=='yes'" disabled="true">Default</button>
             </div>
             <div class="col-sm-10">
                <h4>For Agent</h4>
                <div class="col-sm-2" style="padding-right: 0px"><input type="checkbox" class="form-control" ng-model="node.agentCCfield" style="margin-top: -6px;width: 17%;float: right"></div>
                <div class="col-sm-10" ><p>Display CC Field</p></div>
             </div>
          </li>
          <li class="list-group-item row" ng-show="node.title!='Requester'" style="margin-left: 0px;margin-right: 0px">
             <div class="col-sm-9"><h3>Behaviour</h3></div>
             <div class="col-sm-3">
                  <button type="button" class="btn btn-default btn-sm" ng-show="node.default=='yes'" disabled="true">Default</button>
             </div>
             <div class="col-sm-6">
                <h4>For Agent</h4>
                <div class="col-sm-2" style="padding-right: 0px"><input type="checkbox" class="form-control" ng-model="node.agentRequiredFormSubmit" style="margin-top: -6px;width: 35%;float: right;"></div>
                <div class="col-sm-10" ><p>Required when submitting the form</p></div>
             </div>
             <div class="col-sm-6">
                <h4>For Customers</h4>
                <div class="col-sm-2"  style="padding-right: 0px"><input type="checkbox" class="form-control" ng-model="node.customerDisplay" style="margin-top: -6px;width: 35%;float: right"></div>
                <div class="col-sm-10" ><p>Display to customer</p></div>
                <div class="col-sm-2" style="padding-right: 0px"><input type="checkbox" class="form-control" ng-model="node.customerRequiredFormSubmit" style="margin-top: -6px;width: 35%;float: right;"></div>
                <div class="col-sm-10" ><p>Required when submitting the form</p></div>
             </div>
          </li>
          <li class="list-group-item row" ng-show="node.label==''||node.label!=null" style="margin-left: 0px;margin-right: 0px">
             <div class="col-sm-3" style="line-height: 2.5"><label>Label</label></div>
             <div class="col-sm-9"><input type="text" name="" class="form-control" ng-model="node.label" style="border-radius: 0px" ng-disabled="node.default=='yes'"></div>
          </li>
<!--           <li class="list-group-item row" ng-show="node.placeholder==''||node.placeholder!=null" style="margin-left: 0px;margin-right: 0px">
              <div class="col-sm-3" style="line-height: 2.5"><label>Placeholder</label></div>
             <div class="col-sm-9"><input type="text" class="form-control" name="" ng-model="node.placeholder" style="border-radius:0px"></div>
          </li>
          <li class="list-group-item row" ng-show="node.name==''||node.name!=null&&node.title!='Requester'" style="margin-left: 0px;margin-right: 0px">
              <div class="col-sm-3" style="line-height: 2.5"><label>Name</label></div>
             <div class="col-sm-9"><input type="text" class="form-control" name="" ng-model="node.name" style="border-radius: 0px"></div>
          </li> -->
          <li class="list-group-item row" ng-show="node.title=='Api'" style="margin-left: 0px;margin-right: 0px">
              <div class="col-sm-3" style="line-height: 2.5"><label>Api Link</label></div>
             <div class="col-sm-9"><input type="text" class="form-control" name="" ng-model="node.api" style="border-radius: 0px"></div>
             <div class="col-sm-3" style="line-height: 2.5"><label>Format</label></div>
             <div class="col-sm-9">@{{node.format}}-->Ex:[{'id':'1','optionvalue':'Your Options-1'},{'id':'2','optionvalue':'Your Options-2'}]</div>
          </li>
           <li class="list-group-item row"   style="margin-left: 0px;margin-right: 0px" ng-repeat="option in node.options" ng-show="node.type=='radio'||node.type=='select' ||node.type=='checkbox' && node.default=='no'" >
              <div class="col-sm-3" style="line-height: 2.5"><label>Option@{{$index+1}}</label></div>
             <div class="col-sm-6"><input type="text" class="form-control" name="" ng-model="option.optionvalue" style="border-radius: 0px">
             </div>
             <div class="col-sm-3">
                  <a class="pull-right btn btn-danger btn-xs" data-nodrag ng-click="removeOption(this,$index)" style="padding: 3px 5px">
                      <span class="glyphicon glyphicon-remove"> </span>
                  </a>
                  <div class="dropdown" ng-show="node.title=='Nested Select'||node.title=='Nested Radio' ||node.title=='Nested Checkbox'">
                      <a class="pull-right btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" data-nodrag  style="margin-right: 8px;">
                         <span class="glyphicon glyphicon-plus"></span> Add
                      </a>
                      <ul class="dropdown-menu">
                          <li ng-repeat="Ifield in tree1"><a href="javascript:void(0)" ng-click="newSubForm(this,Ifield.title,$parent.$index)">@{{Ifield.title}}</a></li>
                      </ul>
                  </div>
             </div>
            <ol class="col-sm-12" ui-tree-nodes="" ng-model="option.nodes" ng-class="{hidden: collapsed}">
                <li ng-repeat="node in option.nodes" ui-tree-node ng-include="'nodes_renderer2.html'"></li>
            </ol> 
          </li>
          <li class="list-group-item row"   style="margin-left: 0px;margin-right: 0px"  ng-show="node.value=='Status'">
              <div class="col-sm-5">
                    <label>For Agents</label>
                </div>
              <div class="col-sm-5">
                    <label>For Customers</label>
              </div>
              
           </li>
           <li class="list-group-item row"   style="margin-left: 0px;margin-right: 0px;text-align: center;" ng-show="node.title=='Nested Select'||node.title=='Nested Radio'||node.title=='Nested Checkbox'">
                 <input type="button" name="addOption" class="btn btn-default" value="Add Option" ng-click="addOption(this,node.type)">
          </li>
          <li class="list-group-item row"   style="margin-left: 0px;margin-right: 0px;text-align: center;" ng-show="node.title!='Nested Radio' && node.type=='radio'||node.title!='Nested Checkbox' && node.type=='checkbox'||node.type=='select' && node.title!='Nested Select'&& node.default=='no'">
                 <input type="button" name="addOption" class="btn btn-default" value="Add Option" ng-click="addTypeOption(this,node.type)">
          </li>
       </ul>
      </div>
    </div>
  </div>
  <ol ui-tree-nodes="" ng-model="node.nodes" ng-class="{hidden: collapsed}">
    <li ng-repeat="node in node.nodes" ui-tree-node ng-include="'nodes_renderer2.html'">
    </li>
  </ol>
</script>
<div class="row">
<div class="col-sm-11"  id="content1">
<div  class="col-sm-12" style="background-color: white;" id="category">
    <div class="col-sm-6">
    <h3>Create a New Ticket(Drag Here)</h3>
    </div>
    <div class="col-sm-5" style="margin-top: 10px">

{!!Form::button('<i class="fa fa-floppy-o" aria-hidden="true">&nbsp;&nbsp;</i>'.Lang::get('lang.save'),['type' => 'submit', 'class' =>'btn btn-primary','ng-click'=>'editFormValue()','style'=>'float: right;','id'=>'save'])!!}

    </div>
    <div ui-tree id="tree1-root" data-clone-enabled="true" data-nodrop-enabled="true" class="col-sm-12">
      <ol ui-tree-nodes="" ng-model="tree1" class="list-inline" style="margin-bottom: 15px;">
        <li ng-repeat="node in tree1" ui-tree-node ng-include="'nodes_renderer1.html'" ng-click="addToTree(node)"></li>
      </ol>
    </div>
  </div>
  <div class="col-sm-12">
    <h3>Ticket Fields(Drop Here)</h3>
    <div ui-tree id="tree2-root" data-clone-enabled="true" id="drp">
      <ol ui-tree-nodes="" ng-model="tree2" id="drp">
        <li ng-repeat="node in tree2" ui-tree-node ng-include="'nodes_renderer2.html'">
         
        </li>
      </ol>
    </div>
  </div>
</div>
</div>
        
        <!--end Code-->
    </div>
</div>
</div>
@stop

@push('scripts')



<script>
$(function () {
   $('body').on('click', '[data-toggle=collapse]', function (e) {
        
       $(this).next().collapse('toggle');
});

});

$(document).ready(function() {
var stickyNavTop = parseInt($('#category').offset().top)-100;

var stickyNav = function(){
var scrollTop = $(window).scrollTop();

if (scrollTop > stickyNavTop) {
    var width=$('#category').outerWidth(); 
    $('#category').addClass('sticky');
    $('#category').css('width',width);
} else {
    $('#category').removeClass('sticky'); 
}
};
 
stickyNav();
 
$(window).scroll(function() {
  stickyNav();
});
});

</script>

<script>
(function () {
  'use strict';
  app.controller('CloningCtrl', ['$scope','$http', function ($scope,$http) {
     $http.get("{{url('form/ticket')}}").success(function(data){
         $scope.tree2 = data[0];
     })
     $scope.node1=['submit','button'];
      $scope.remove = function (scope) {
        scope.remove();
      };

      $scope.toggle = function (scope) {
        scope.toggle();
      };
      $scope.addOption = function (scope,x) {
          var nodeData = scope.$modelValue.options;
          var index=scope.$modelValue.options.length;
          if(x=='checkbox'){
             nodeData.push({
              'optionvalue':'Value',
              'checked':'',
              'nodes':[]
           })

          }
          else if(x=='select'){
            nodeData.push({
              'id':index+1,
              'optionvalue':'Value',
              'nodes':[]
           })
          }
          else{
           nodeData.push({
              'optionvalue':'Value',
              'nodes':[]
           })
         }
      };
      $scope.addTypeOption= function (scope,x) {
          var nodeData = scope.$modelValue.options;
        if(x=='checkbox'){
             nodeData.push({
              'optionvalue':'Value',
              'checked':''
           })
          }
        else{
           nodeData.push({
              'optionvalue':'Value'
           })
          }
      };
      
      $scope.removeOption = function (scope,y) {
          var nodeData = scope.$modelValue.options;
           nodeData.splice(y,1);
      };
      $scope.addToTree = function (scope) {
          $scope.tree2.push(scope);
      };
      $scope.editFormValue=function(){
          $('#save').attr('disabled','disabled');
          $http.post("{{url('forms')}}",$scope.tree2).success(function(data){
        $('.well').css('display','block');      
        $('.well').html(data);
        $('.well').css('color','green');
        $('html, body').animate({scrollTop:0}, 500);
         setTimeout(function(){
             location.reload();
         },2000);      
          }).error(function(data){
              $('.well').css('display','block');      
              $('.well').html(data);
              $('.well').css('color','red');
          })
       

       }
       $scope.newSubFormCheckbox=function(scope,x,y){}
      $scope.newSubForm=function(scope,x,y){

        var nodeData = scope.$modelValue.options[y];
       
       if(x=='Nested Select'){
        nodeData.nodes.push({
           'title': 'Nested Select',
           'label': 'Nested Select',
           'type': 'select',
           'placeholder':'',
           'name':'',
           'value':'',
           'agentRequiredFormSubmit':true,
           'customerDisplay':true,
           'customerRequiredFormSubmit':false,
           'options':[
              {
                 'id':1,
                 'optionvalue':'Value',
                 'nodes':[]
              }
            ],
            'default':'no'
          });
       }
       else if(x=='Nested Radio'){
        nodeData.nodes.push({
         'title': 'Nested Radio',
        'label': 'Nested Radio',
        'type':'radio',
        'placeholder':'',
        'name':'',
        'value':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':false,
        'options':[
           {
              'optionvalue':'Value',
              'nodes':[]
           }
        ],
        'default':'no'
          });
       }
       else if(x=='Nested Checkbox'){
        nodeData.nodes.push({
          'title': 'Nested Checkbox',
          'label': 'Nested Checkbox',
          'type':'checkbox',
          'placeholder':'',
          'name':'',
          'agentRequiredFormSubmit':true,
          'customerDisplay':true,
          'customerRequiredFormSubmit':false,
          'options':[
           {
              'optionvalue':'Value',
              'checked':'',
              'nodes':[]
           }
        ],
          'default':'no'
         });
      }
       else if(x=='Text Field'){
        nodeData.nodes.push({
        'title': 'Text Field',
        'label':'Text Field',
        'type':'text',
        'placeholder':'',
        'name':'',
        'value':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':false,
        'default':'no'
      });
       }
       else if(x=='Text Area'){
        nodeData.nodes.push({
        'title': 'Text Area',
        'label':'Text Area',
        'type':'textarea',
        'placeholder':'',
        'name':'',
        'value':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':false,
        'default':'no'
      });
       }
       else if(x=='Number'){
        nodeData.nodes.push({
        'title': 'Number',
        'label':'Number',
        'type':'number',
        'placeholder':'',
        'name':'',
        'value':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':false,
        'default':'no'
      });
       }
       else if(x=='Select'){
        nodeData.nodes.push({
        'title': 'Select',
        'label': 'Select',
        'type':'select',
        'placeholder':'',
        'name':'',
        'value':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':false,
        'options':[
           {
              'optionvalue':'Value',
           }
        ],
        'default':'no'
      });
       }
       else if(x=='Radio'){
        nodeData.nodes.push({
        'title': 'Radio',
        'label':'Radio',
        'type':'radio',
        'name':'',
        'value':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':false,
        'options':[
           {
              'optionvalue':'Value'
           }
        ],
        'default':'no'
      });
       }
       else if(x=='Checkbox'){
        nodeData.nodes.push({
        'title': 'Checkbox',
        'label':'Checkbox',
        'type':'checkbox',
        'name':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':false,
        'options':[
           {
              'optionvalue':'Value',
              'checked':''
           }
        ],
        'default':'no'
      });
       }
       else if(x=='Date'){
        nodeData.nodes.push({
        'title': 'Date',
        'label':'Date',
        'type':'date',
        'name':'',
        'value':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':false,
        'default':'no'
      });
       }


      };


      $scope.tree1 = [{
        'title': 'Text Field',
        'label':'Text FIeld',
        'type':'text',
        'placeholder':'',
        'name':'',
        'value':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':false,
        'default':'no'
      }, {
        'title': 'Text Area',
        'label':'Text Area',
        'type':'textarea',
        'placeholder':'',
        'name':'',
        'value':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':false,
        'default':'no'
      },{
        'title': 'Number',
        'label':'Number',
        'type':'number',
        'placeholder':'',
        'name':'',
        'value':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':false,
        'default':'no'
      },{
        'title': 'Nested Select',
        'label': 'Nested Select',
        'type':'select',
        'placeholder':'',
        'name':'',
        'value':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':false,
        'options':[
           {
              'id':1,
              'optionvalue':'Value',
              'nodes':[]
           }
        ],
        'default':'no'
      },{
        'title': 'Nested Radio',
        'label': 'Nested Radio',
        'type':'radio',
        'placeholder':'',
        'name':'',
        'value':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':false,
        'options':[
           {
              'optionvalue':'Value',
              'nodes':[]
           }
        ],
        'default':'no'
      },{
        'title': 'Nested Checkbox',
        'label': 'Nested Checkbox',
        'type':'checkbox',
        'placeholder':'',
        'name':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':false,
        'options':[
           {
              'optionvalue':'Value',
              'checked':'',
              'nodes':[]
           }
        ],
        'default':'no'
      },{
        'title': 'Select',
        'label': 'Select',
        'type':'select',
        'placeholder':'',
        'name':'',
        'value':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':false,
        'options':[
           { 
              'optionvalue':'Value',
           }
        ],
        'default':'no'
      },
      {
        'title': 'Radio',
        'label':'Radio',
        'type':'radio',
        'name':'',
        'value':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':false,
        'options':[
           {
              'optionvalue':'Value'
           }
        ],
        'default':'no'
      }, {
        'title': 'Checkbox',
        'label':'Checkbox',
        'type':'checkbox',
        'name':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':false,
        'options':[
           {
              'optionvalue':'Value',
              'checked':''
           }
        ],
        'default':'no'
      },{
        'title': 'Date',
        'label':'Date',
        'type':'date',
        'name':'',
        'value':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':false,
        'default':'no'
      },
      {
        'title': 'Api',
        'label':'Api',
        'type':'text',
        'name':'',
        'value':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':true,
        'customerRequiredFormSubmit':false,
        'default':'no',
        'api':'',
        'format':'Json'
      }
      ];
      
    }]);

   
})();

</script>

@endpush