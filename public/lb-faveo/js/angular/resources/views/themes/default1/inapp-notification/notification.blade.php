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
<li class="dropdown notifications-menu"  ng-controller="MainCtrl">
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
                                            <span style="color: #90949c;">@{{noti.created_at}}</span>
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
<script src="{{asset('lb-faveo/js/angular/ng-flow-standalone.js')}}"></script>
<script src="{{asset('lb-faveo/js/angular/fusty-flow.js')}}"></script>
<script src="{{asset('lb-faveo/js/angular/fusty-flow-factory.js')}}"></script>

<script>
    

  app.controller('MainCtrl', function($scope,$http, $sce,$window,$compile){
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
          
          
    /**
     * Wyswyg editor
     */
    
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
      $scope.getEditor=function(){
          $("#t1").hide();
          $("#show3").show();
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

              var serialize=$("#form3").serialize();
              console.log(serialize);
          $scope.editorValues={};
          $scope.editorValues['content']=$scope.editor1;
          $scope.editorValues['inline']=$scope.inlinImage;
          $scope.editorValues['attachment']=$scope.attachmentImage;
          console.log($scope.editorValues);
          var config={
                 headers : {
                      'Content-Type' : 'application/json'
                  }
          }
          var url = "{{url('/thread/reply')}}?"+serialize;
          
          $http.post(url,$scope.editorValues,config).success(function(data){
              if(data.result.success!=null){
                   location.reload();
              }
          })
          .error(function(data){
                $("#show3").hide();
                $("#t1").show();
                var res = "";
                $.each(data, function (idx, topic) {
                   res += "<li>" + topic + "</li>";
                });
                $("#reply-response").html("<div class='alert alert-danger'><strong>Whoops!</strong> There were some problems with your input.<br><br><ul>" +res+ "</ul></div>");
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