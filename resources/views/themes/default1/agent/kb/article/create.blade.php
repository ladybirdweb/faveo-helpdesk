@extends('themes.default1.agent.layout.agent')

@extends('themes.default1.agent.layout.sidebar')    

@section('article')
active
@stop

@section('add-article')
class="active"
@stop

@section('PageHeader')
<h1>{{Lang::get('lang.article')}}</h1>
@stop

@section('content')
 <script src="{{asset('vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
{!! Form::open(array('action' => 'Agent\kb\ArticleController@store' , 'method' => 'post') )!!}
<div class="row"  ng-controller="articleCreateCtrl">
    <div class="content-header">
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!} !</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif
        @if(!$category)
        <div class="alert alert-warning alert-dismissable">
            <i class="fa fa-info"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! Lang::get('lang.create_a_category') !!}
        </div>
        @endif
        @if(Session::has('errors'))
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @if($errors->first('name'))
            <li class="error-message-padding">{!! $errors->first('name', ':message') !!}</li>
            @endif
            @if($errors->first('slug'))
            <li class="error-message-padding">{!! $errors->first('slug', ':message') !!}</li>
            @endif
            @if($errors->first('description'))
            <li class="error-message-padding">{!! $errors->first('description', ':message') !!}</li>
            @endif
            @if($errors->first('type'))
            <li class="error-message-padding">{!! $errors->first('type', ':message') !!}</li>
            @endif
            @if($errors->first('status'))
            <li class="error-message-padding">{!! $errors->first('status', ':message') !!}</li>
            @endif
            @if($errors->first('category_id'))
            <li class="error-message-padding">{!! $errors->first('category_id', ':message') !!}</li>
            @endif
        </div>
        @endif
    </div>
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{!! Lang::get('lang.addarticle') !!}</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12 form-group {{ $errors->has('name') ? 'has-error' : '' }}" >
                        {!! Form::label('name',Lang::get('lang.name')) !!}<span class="text-red"> *</span>
                        {!! Form::text('name',null,['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                    {!! Form::label('description',Lang::get('lang.description')) !!}<span class="text-red"> *</span>
                    <div class="form-group" style="background-color:white">
                        @include('themes.default1.inapp-notification.wyswyg-editor-public')
                        {!! Form::textarea('description',null,['class' => 'form-control','id'=>'editor','size' => '128x20','placeholder'=>Lang::get('lang.enter_the_description')]) !!}
                    </div>
                    <script>
                        CKEDITOR.replace('description');
                </script>
                </div>
            </div>
        </div>
    </div>
    <ul style="list-style-type:none;">
        <li>
            <div class="col-sm-4">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{Lang::get('lang.publish')}}</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                            {!! Form::label('type',Lang::get('lang.status')) !!}

                            <div class="row">
                                <div class="col-xs-1">
                                    {!! Form::radio('type','1',true) !!}
                                </div>
                                <div class="col-xs-4">
                                    {{Lang::get('lang.published')}}
                                </div>
                                <div class="col-xs-1">
                                    {!! Form::radio('type','0',null) !!}
                                </div>
                                <div class="col-xs-4">
                                    {{Lang::get('lang.draft')}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                            {!! Form::label('status',Lang::get('lang.visibility')) !!}

                            <div class="row">
                                <div class="col-xs-1">
                                    {!! Form::radio('status','1',true) !!}
                                </div>
                                <div class="col-xs-4">  
                                    {{Lang::get('lang.public')}}
                                </div>
                                <div class="row">
                                    <div class="col-xs-1">
                                        {!! Form::radio('status','0',null) !!}
                                    </div>
                                    <div class="col-xs-4"> 
                                        {{Lang::get('lang.private')}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $format = App\Model\helpdesk\Settings\System::where('id', '1')->first()->date_time_format;
                        //$format = \App\Model\helpdesk\Utility\Date_time_format::where('id', $format)->first()->format;
                        $tz = App\Model\helpdesk\Settings\System::where('id', '1')->first()->time_zone;
                        //$tz = App\Model\helpdesk\Utility\Timezones::where('id', $tz)->first()->name;
                        date_default_timezone_set($tz);
                        $date = date($format);
                        $dateparse = date_parse_from_format($format, $date);
                        //dd($dateparse);
                        $month = $dateparse['month'];
                        $day = $dateparse['day'];
                        $year = $dateparse['year'];
                        $hour = $dateparse['hour'];
                        $minute = $dateparse['minute'];
//                            echo $date;
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::label('month',Lang::get('lang.publish_immediately')) !!}
                            </div>
                            <div class="col-md-12">
                                <span>
                                    {!! Form::selectMonth('month', $month)  !!}
                                    {!! Form::selectRange('day', 1, 31, $day)  !!}
                                    {!! Form::text('year',date('Y'),['style'=>'width: 50px;'])  !!}@
                                    <input type="text" name="hour" value="{{$hour}}" style="width: 30px;">:<input type="text" name="minute" value="{{$minute}}" style="width: 30px;" >
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer" style="background-color:#f5f5f5;" >
                        {!! Form::submit(Lang::get('lang.publish'),['class'=>'btn btn-primary'])!!}
                    </div>
                    </li>
                    <li>
                        <div class="col-md-4">
                            <div class="box box-default">
                                <div class="box-header with-border">
                                    <h3 class="box-title">{{Lang::get('lang.category')}}<span class="text-red"> *</span></h3>
                                </div>
                                <div class="box-body" style="height:190px; overflow-y:auto;">
                                    <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                                        {{-- {!! Form::label('category_id','Category') !!} --}}

                                        @foreach($category->toArray() as $key=>$val)
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-1">
                                                    <input type="radio" name="category_id[]" value="<?php echo $val; ?>">
                                                </div>
                                                <div class="col-md-10">
                                                    <?php echo $key; ?>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                {!! Form::close() !!}
                                <div class="box-footer" style="background-color:#f5f5f5;">
                                    <span class="btn btn-info btn-sm" data-toggle="modal" data-target="#j">{{Lang::get('lang.addcategory')}}</span>
                                    <div class="modal" id="j">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                {!! Form::open(['method'=>'post','action'=>'Agent\kb\CategoryController@store']) !!}
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title">{{Lang::get('lang.addcategory')}}</h4>
                                                </div>
                                                <div class="modal-body">
                                                    @include('themes.default1.agent.kb.category.form')
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="form-group">
                                                        {!! Form::submit('Add')!!}
                                                    </div>
                                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    </ul>
                </div>
                
<script>
    $(function() {
        
//        $('input[type="checkbox"]').iCheck({
//            checkboxClass: 'icheckbox_flat-blue'
//        });
//        $('input[type="radio"]').iCheck({
//            radioClass: 'iradio_flat-blue'
//        });
    
    });        
</script>


                @stop
                @push('scripts')
<script src="{{asset('lb-faveo/js/angular/ng-flow-standalone.js')}}"></script>
<script src="{{asset('lb-faveo/js/angular/fusty-flow.js')}}"></script>
<script src="{{asset('lb-faveo/js/angular/fusty-flow-factory.js')}}"></script>
<script>
    app.controller('articleCreateCtrl', function($scope,$http, $sce,$window,$compile){
        
      $scope.disable=true;
      $scope.inlineImage=true;
      $scope.arrayImage=[];
      $scope.inlinImage=[];
   $scope.getImageApi=function(){
       
      $http.get("{{url('media/files/public')}}").success(function(data){
          $scope.arrayImage=data;
          $scope.apiCalled=true;
          console.log($scope.arrayImage);
      })
  }
      $scope.insert=function(x,i,pathname,name){
          
           $scope.preview=true;
           $scope.viewImage=$scope.arrayImage[i]
           if(x=="image"){
               $scope.inlineImage=false;
               $scope.viewImage=i;
               $scope.pathName=i;
               $scope.fileName=name;
           }
      }
      $scope.noInsert=function(){
           $scope.disable=true;
           $scope.inlineImage=true;
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
      $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                     var target = $(e.target).attr("href") // activated tab
                     if(target=="#menu1"){
                          $http.get("{{url('media/files/public')}}").success(function(data){
                                 $scope.arrayImage=data;
                                  $scope.apiCalled=true;
                                  console.log($scope.arrayImage);
                            })
                     }
         });
      $scope.getEditor=function(){
          
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
            $http.get("{{url('media/files/public')}}",config).success(function(data){
                $scope.arrayImage=data;
            })
        }
         
    }  
         });
</script>

@endpush