<style type="text/css">
 @keyframes spinner {
  to {transform: rotate(360deg);}
}
 
.spinner:before {
  content: '';
  box-sizing: border-box;
  position: absolute;
  
  left: 50%;
  width: 20px;
  height: 20px;
  margin-top: -10px;
  margin-left: -10px;
  border-radius: 50%;
  border: 2px solid #ccc;
  border-top-color: #333;
  animation: spinner .6s linear infinite;
}
</style>
<li class="dropdown notifications-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" ng-click="fbNotify()" title="In app Notifiaction">
        <i class="fa fa-bell-o"></i>
        <span class="label label-warning" ng-bind="notiNum"></span>
    </a>
    <ul class="dropdown-menu" style="background: #fff;border: 1px solid rgba(100, 100, 100, .4);border-radius: 0 0 2px 2px;box-shadow: 0 3px 8px rgba(0, 0, 0, .25);color: #1d2129;overflow: visible;position: absolute !important;width: 430px !important;z-index: -1;">
        <li class="header"><div class="cool" style="width: 50%;"><b>Notifications</b></div></li>
        <li>
            <!-- inner menu: contains the actual data -->

            <div>
                <ul class="list-group" style="outline: none;overflow-x: hidden;overflow-y: auto; height: 425px;margin-bottom: 0px;" when-scrolled="loadApi()">
                    <li class="row list-group-item" id=seen@{{$index}}  ng-repeat="noti in notifications.data">
                        <a href="javascript:void(0)" class="link" alt="" style="color: #1d2129;display: block;padding: 6px 30px 5px 12px;position: relative;" ng-click="newTab(noti.url,noti.id)">
                            <div class="col-sm-12">
                                <div class="col-sm-2" style="padding-right: 0px;padding-left: 0px;">
                                    <img  alt="" class="notiimg" ng-src="@{{noti.requester.profile_pic}}" style="display: block;height: 44px;margin-right: 12px;width: 44px;">
                                </div>               
                                <div class="col-sm-10" style="padding-right: 0px;padding-left: 0px;">

                                    <div class="cont" style="display: flex;flex-direction: column;justify-content: center;margin-top: -1px;min-height: 50px;word-wrap: break-word;overflow: hidden;">
                                        <span><b>@{{noti.user}}</b>
                                            <span ng-bind-html="$sce.trustAsHtml(noti.message)">
                                            </span>
                                        </span>
                                        <div class="date" direction="left" style="padding-top: 3px;margin-top: -1px;">
                                            <span style="color: #90949c;"><time am-time-ago="noti.created_at"></time></span>
                                        </div>
                                    </div>
                                </div>                         
                            </div>
                        </a>
                    </li>
                    <li class="row list-group-item" ng-hide="showing" style="padding :35px;">
                         <div class="spinner" >
                     
                         </div>
                      </li>
                </ul>
            </div>                    

        </li>
        
    </ul>
</li>
@push('scripts')
<script>
    var app = angular.module('fbApp', ['angularMoment']).directive('whenScrolled', function() {
    return function(scope, elm, attr) {
        var raw = elm[0];
        console.log(raw);
        elm.bind('scroll', function() {

            if (raw.scrollTop + raw.offsetHeight >= raw.scrollHeight) {
                scope.$apply(attr.whenScrolled);
            }
        });
    };
});

  app.controller('MainCtrl', function($scope,$http, $sce,$window) {
        $scope.$sce=$sce;
         $scope.count=0;
         var count_api = "{!! url('notification/api/unseen/count') !!}/{{Auth::user()->id}}";
        $http.get(count_api).success(function(data){
                  
                  if(data.count>9){
                       $scope.notiNum="9+";
                  }
                  else{
                       $scope.notiNum=data.count;
                  } 
             })
  	$scope.fbNotify=function(){
        var notification_url = "{!! url('notification/api') !!}/{{Auth::user()->id}}";
       $http.get(notification_url).success(function(data){
           $scope.showing=true;
       	  $scope.notifications=data;
          console.log($scope.notifications);
          for(var i in $scope.notifications.data){
          if($scope.notifications.data[i].requester.changed_by_first_name==null&&$scope.notifications.data[i].requester.changed_by_last_name==null&&$scope.notifications.data[i].requester.changed_by_user_name==null){
               $scope.notifications.data[i]['user']=$scope.notifications.data[i].by;
          }
          else if($scope.notifications.data[i].requester.changed_by_first_name==""&&$scope.notifications.data[i].requester.changed_by_last_name==""&&$scope.notifications.data[i].requester.changed_by_user_name==""){
               $scope.notifications.data[i]['user']=$scope.notifications.data[i].by;
          }
          else if($scope.notifications.data[i].requester.changed_by_first_name==""&&$scope.notifications.data[i].requester.changed_by_last_name==""){
               $scope.notifications.data[i]['user']=$scope.notifications.data[i].requester.changed_by_user_name;
          }
          else if($scope.notifications.data[i].requester.changed_by_first_name==null&&$scope.notifications.data[i].requester.changed_by_last_name==null){
               $scope.notifications.data[i]['user']=$scope.notifications.data[i].requester.changed_by_user_name;
          }
          else if($scope.notifications.data[i].requester.changed_by_first_name==null){
               $scope.notifications.data[i]['user']=$scope.notifications.data[i].requester.changed_by_last_name;
          }
          else if($scope.notifications.data[i].requester.changed_by_last_name==null){
               $scope.notifications.data[i]['user']=$scope.notifications.data[i].requester.changed_by_first_name;
          }
          else{
          	   $scope.notifications.data[i]['user']=$scope.notifications.data[i].requester.changed_by_first_name+" "+$scope.notifications.data[i].requester.changed_by_last_name;
          }
        }
        setTimeout(function(){ 
             for(var i in $scope.notifications.data){
             if($scope.notifications.data[i].seen=="0"){
              var id='seen'+i;
                   var seenColor=document.getElementById(id);
                    seenColor.style.backgroundColor ="#edf2fa";
             }
        }
         }, 100);
          
        
       })
     };
      $scope.loadApi= function() {
           $scope.count++;
            $scope.showing=false; 
            if($scope.notifications.next_page_url==null){
                $scope.showing=true; 
            }
            
      	/*console.log($scope.notifications.next_page_url);*/
        if($scope.count==1){
          if($scope.notifications.next_page_url!=null){
            $http.get($scope.notifications.next_page_url).success(function(data){
          	  console.log(data);
              $scope.showing=true;
              [].push.apply($scope.notifications.data, data.data);
                 $scope.notifications.next_page_url=data.next_page_url;
                for(var i in $scope.notifications.data){
          if($scope.notifications.data[i].requester.changed_by_first_name==null&&$scope.notifications.data[i].requester.changed_by_last_name==null&&$scope.notifications.data[i].requester.changed_by_user_name==null){
               $scope.notifications.data[i]['user']=$scope.notifications.data[i].by;
          }
          else if($scope.notifications.data[i].requester.changed_by_first_name==""&&$scope.notifications.data[i].requester.changed_by_last_name==""&&$scope.notifications.data[i].requester.changed_by_user_name==""){
               $scope.notifications.data[i]['user']=$scope.notifications.data[i].by;
          }
          else if($scope.notifications.data[i].requester.changed_by_first_name==""&&$scope.notifications.data[i].requester.changed_by_last_name==""){
               $scope.notifications.data[i]['user']=$scope.notifications.data[i].requester.changed_by_user_name;
          }
          else if($scope.notifications.data[i].requester.changed_by_first_name==null&&$scope.notifications.data[i].requester.changed_by_last_name==null){
               $scope.notifications.data[i]['user']=$scope.notifications.data[i].requester.changed_by_user_name;
          }
          else if($scope.notifications.data[i].requester.changed_by_first_name==null){
               $scope.notifications.data[i]['user']=$scope.notifications.data[i].requester.changed_by_last_name;
          }
          else if($scope.notifications.data[i].requester.changed_by_last_name==null){
               $scope.notifications.data[i]['user']=$scope.notifications.data[i].requester.changed_by_first_name;
          }
          else{
          	   $scope.notifications.data[i]['user']=$scope.notifications.data[i].requester.changed_by_first_name+" "+$scope.notifications.data[i].requester.changed_by_last_name;
          }
        }
                setTimeout(function(){ 
                 for(var i in $scope.notifications.data){
                   if($scope.notifications.data[i].seen=="0"){
                       document.getElementById('seen'+i).style.backgroundColor ="#edf2fa";
             }
        }
        
         }, 100);
          })
          .error(function (data, status, header, config) {
                self.ResponseDetails = "Data: " + data;
                    console.log(self.ResponseDetails);
            })
            }else{
                $scope.showing=true;
            }
        }
        else{
        setTimeout(function(){ 
          if($scope.notifications.next_page_url!=null){
            $http.get($scope.notifications.next_page_url).success(function(data){
              console.log(data);
              $scope.showing=true;
              [].push.apply($scope.notifications.data, data.data);
                 $scope.notifications.next_page_url=data.next_page_url;
              for(var i in $scope.notifications.data){
          if($scope.notifications.data[i].requester.changed_by_first_name==null&&$scope.notifications.data[i].requester.changed_by_last_name==null&&$scope.notifications.data[i].requester.changed_by_user_name==null){
               $scope.notifications.data[i]['user']=$scope.notifications.data[i].by;
          }
          else if($scope.notifications.data[i].requester.changed_by_first_name==""&&$scope.notifications.data[i].requester.changed_by_last_name==""&&$scope.notifications.data[i].requester.changed_by_user_name==""){
               $scope.notifications.data[i]['user']=$scope.notifications.data[i].by;
          }
          else if($scope.notifications.data[i].requester.changed_by_first_name==""&&$scope.notifications.data[i].requester.changed_by_last_name==""){
               $scope.notifications.data[i]['user']=$scope.notifications.data[i].requester.changed_by_user_name;
          }
          else if($scope.notifications.data[i].requester.changed_by_first_name==null&&$scope.notifications.data[i].requester.changed_by_last_name==null){
               $scope.notifications.data[i]['user']=$scope.notifications.data[i].requester.changed_by_user_name;
          }
          else if($scope.notifications.data[i].requester.changed_by_first_name==null){
               $scope.notifications.data[i]['user']=$scope.notifications.data[i].requester.changed_by_last_name;
          }
          else if($scope.notifications.data[i].requester.changed_by_last_name==null){
               $scope.notifications.data[i]['user']=$scope.notifications.data[i].requester.changed_by_first_name;
          }
          else{
          	   $scope.notifications.data[i]['user']=$scope.notifications.data[i].requester.changed_by_first_name+" "+$scope.notifications.data[i].requester.changed_by_last_name;
          }
        }
                setTimeout(function(){ 
                 for(var i in $scope.notifications.data){
                   if($scope.notifications.data[i].seen=="0"){
                       document.getElementById('seen'+i).style.backgroundColor ="#edf2fa";
             }
          }
        
        
         }, 100);
          })
          .error(function (data, status, header, config) {
                self.ResponseDetails = "Data: " + data;
                    console.log(self.ResponseDetails);
            })
        }

                       }, 5000);
          }
      };
      $scope.newTab=function(x,y){
         var url=x;
         
      var config={
          params:{
              notification_id:y
          }
        }
      var api = "{!! url('notification/api/seen') !!}/{{Auth::user()->id}}";
            $http.get(api,config)
            .success(function(data){
                 //alert("success");  
            })
            .error(function(data){
              //alert("failed");
            });
             if(url==""||url==null){
               //alert("sorry");
             }
             else{
                 $window.open(x, '_blank');
             }
          }

          
     
});
</script>
@endpush