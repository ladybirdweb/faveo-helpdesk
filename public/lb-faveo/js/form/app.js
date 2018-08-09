(function () {
  'use strict';
  app.controller('CloningCtrl', ['$scope','$http', function ($scope,$http) {
     $http.get("{{url('form/ticket')}}").success(function(data){
         $scope.tree2 = data;
     })
     $scope.node1=['submit','button'];
      $scope.remove = function (scope) {
        scope.remove();
      };

      $scope.toggle = function (scope) {
        scope.toggle();
      };
      $scope.addOption = function (scope) {
          var nodeData = scope.$modelValue.options;
           nodeData.push({
              'optionvalue':'Value',
              'nodes':[]
           })
      };
      $scope.addTypeOption= function (scope) {
          var nodeData = scope.$modelValue.options;
           nodeData.push({
              'optionvalue':'Value'
           })
      };
      $scope.addStatusOption= function (scope) {
          var nodeData = scope.$modelValue.options;
           nodeData.push({
              'forAgent':'',
              'forAgentField':'none',
              'forCustomer':'',
              'slaTimer':'yes',
              'slaTimerValue':true,
              'optionvalue':''
           })
      };
      $scope.removeOption = function (scope,y) {
          var nodeData = scope.$modelValue.options;
           nodeData.splice(y,1);
      };
      $scope.addToTree = function (scope) {
          $scope.tree2.push(scope);
      };
      $scope.editFormValue=function(){
          
      }
      $scope.newSubForm=function(scope,x,y){
        var nodeData = scope.$modelValue.options[y];
       
       if(x=='Nested Select'){
        nodeData.nodes.push({
           'title': 'Nested Select',
           'value': 'Nested Select',
           'type': 'select',
           'required':false,
           'placeholder':'',
           'name':'',
           'agentRequiredFormSubmit':true,
           'customerDisplay':false,
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
      };


      $scope.tree1 = [{
        'title': 'Text Field',
        'value':'Text FIeld',
        'type':'text',
        'placeholder':'',
        'name':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':false,
        'customerRequiredFormSubmit':false,
        'default':'no'
      }, {
        'title': 'Text Area',
        'value':'Text Area',
        'type':'textarea',
        'placeholder':'',
        'name':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':false,
        'customerRequiredFormSubmit':false,
        'default':'no'
      },{
        'title': 'Number',
        'value':'Number',
        'type':'mobile',
        'placeholder':'',
        'name':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':false,
        'customerRequiredFormSubmit':false,
        'default':'no'
      },{
        'title': 'Nested Select',
        'value': 'Nested Select',
        'type':'select',
        'placeholder':'',
        'name':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':false,
        'customerRequiredFormSubmit':false,
        'options':[
           {
              'optionvalue':'Value',
              'nodes':[]
           }
        ],
        'default':'no'
      },{
        'title': 'Select',
        'value': 'Select',
        'type':'select',
        'placeholder':'',
        'name':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':false,
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
        'value':'Radio',
        'type':'radio',
        'name':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':false,
        'customerRequiredFormSubmit':false,
        'options':[
           {
              'optionvalue':'Value'
           }
        ],
        'default':'no'
      }, {
        'title': 'Checkbox',
        'value':'Checkbox',
        'type':'checkbox',
        'name':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':false,
        'customerRequiredFormSubmit':false,
        'options':[
           {
              'optionvalue':'Value'
           }
        ],
        'default':'no'
      },{
        'title': 'Date',
        'value':'Date',
        'type':'date',
        'name':'',
        'agentRequiredFormSubmit':true,
        'customerDisplay':false,
        'customerRequiredFormSubmit':false,
        'default':'no'
      }
      ];
      
    }]);

   
})();
