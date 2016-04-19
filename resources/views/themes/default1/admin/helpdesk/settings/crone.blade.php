@extends('themes.default1.admin.layout.admin')

@section('Settings')
active
@stop

@section('settings-bar')
active
@stop

@section('cron')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
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

<!-- open a form -->
{!! Form::model($emails,['url' => 'post-scheduler', 'method' => 'PATCH']) !!}
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{Lang::get('lang.cron')}}</h3> <div class="pull-right">
                    {!! Form::submit(Lang::get('lang.save'),['class'=>'btn btn-primary'])!!}
                </div>
            </div>
            <!-- check whether success or not -->
            @if(Session::has('success'))
            <div class="alert alert-success alert-dismissable">
                <i class="fa  fa-check-circle"></i>
                <b>Success!</b>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {!!Session::get('success')!!}
            </div>
            @endif
            <!-- failure message -->
            @if(Session::has('fails'))
            <div class="alert alert-danger alert-dismissable">
                <i class="fa fa-ban"></i>
                <b>Fail!</b>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {!!Session::get('fails')!!}
            </div>
            @endif
            <div class="box-body table-responsive"style="overflow:hidden;">
             <div class="alert  alert-dismissable" style="background: #F3F3F3">
                <i class="fa  fa-info-circle"></i>&nbsp;{!!Lang::get('lang.crone-url-message')!!}
                <a href="http://ladybirdweb.com/support/show/cron-job-scheduling" style="color:black" target="blank">{!!Lang::get('lang.click')!!}</a> {!!Lang::get('lang.check-cron-set')!!}
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            </div>
            <div class="col-md-6">
            <div class="info-box">
  <!-- Apply any bg-* class to to the icon to color it -->
  <span class="info-box-icon bg-aqua"><i class="fa fa-cloud-download"></i></span>
  <div class="info-box-content">
   <i class="fa fa-clipboard pull-right" title="{!!Lang::get('lang.click-url-copy')!!}" onclick="copyToClipboard('#p1')"></i>
    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('email_fetching',Lang::get('lang.email_fetch')) !!}<br>
                            {!! Form::checkbox('email_fetching',1,true) !!}&nbsp;{{Lang::get('lang.fetch_auto-corn')}}
                        </div>
                    </div>
    <div class="col-md-12">
            <em><span class="info-box-text" style="background: #F3F3F3" id='p1'></span></em>
            <!-- <div class="btn btn-default btn-xs pull-right" onclick="copyToClipboard('#p1')">Copy URL</div> -->
    </div>

    


  </div><!-- /.info-box-content -->
</div><!-- /.info-box -->
</div>
<div class="col-md-6">
                <div class="info-box">
  <!-- Apply any bg-* class to to the icon to color it -->
  <span class="info-box-icon bg-aqua"><i class="fa fa-cloud-upload"></i></span>
  <div class="info-box-content">
   <i class="fa fa-clipboard pull-right" title="{!!Lang::get('lang.click-url-copy')!!}" onclick="copyToClipboard('#p2')"></i>
    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('email_fetching',Lang::get('lang.notification-email')) !!}<br>
                            {!! Form::checkbox('notification_cron',1,true) !!}&nbsp;{{Lang::get('lang.cron_notification')}}
                        </div>
                    </div>
    <div class="col-md-12">
            <em><span class="info-box-text" style="background: #F3F3F3" id='p2'></span></em>
            <!-- <div class="btn btn-default btn-xs pull-right" onclick="copyToClipboard('#p1')">Copy URL</div> -->
    </div>

    


  </div><!-- /.info-box-content -->
</div><!-- /.info-box -->
                
            </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
  alert('{!!Lang::get("lang.clipboard-copy-message")!!}');
}
$(document).ready(function(){
    var path = $(location).attr('href');
    // alert(path);
    // var str = path;
    path  = path.replace("job-scheduler","readmails");
    path2 = path.replace("readmails", "notification");
    document.getElementById("p1").innerHTML = path;
    document.getElementById("p2").innerHTML = path2;
})
</script>
@stop
