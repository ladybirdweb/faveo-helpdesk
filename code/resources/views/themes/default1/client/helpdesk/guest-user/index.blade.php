@extends('themes.default1.client.layout.client')
@section('HeadInclude')
<link href="{{asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css")}}" rel="stylesheet" type="text/css" />
           <link href="{{asset("lb-faveo/dist/css/widgetbox.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{asset("lb-faveo/plugins/iCheck/flat/blue.css")}}" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
@stop
@section('home')
    class = "active"
@stop
@section('breadcrumb')
	<div class="site-hero clearfix">
                   
                                    <ol class="breadcrumb breadcrumb-custom">
                                            <li class="text">You are here: </li>
                                            <li><a href="{!! URL::route('home') !!}">Home</a></li>
                                    </ol>
                   </div>

@stop

@section('content')


						<div id="content" class="site-content col-md-12">

<div id="corewidgetbox">
    <div class="widgetrow text-center">
    @if(Auth::user())
    @else
        <span onclick="javascript: window.location.href='{{url('auth/register')}}';">
            <a href="{{url('auth/register')}}" class="widgetrowitem defaultwidget" style="background-image: URL('https://support.ebs.in/app/__swift/themes/client/images/icon_widget_register.png');">
                <span class="widgetitemtitle">Register</span>
            </a>
        </span>
    @endif
    @if(App\Model\helpdesk\Settings\System::first()->status == 1)
        <span onclick="javascript: window.location.href='https://support.ebs.in/app/index.php?/Tickets/Submit';">
            <a href="{{url('form')}}" class="widgetrowitem defaultwidget" style="background-image: URL('https://support.ebs.in/app/__swift/themes/client/images/icon_widget_submitticket.png');">
                <span class="widgetitemtitle">Submit a Ticket</span>
            </a>
        </span>
    @endif
        <span onclick="javascript: window.location.href='https://support.ebs.in/app/index.php?/News/List';">
            <a href="{{url('mytickets')}}" class="widgetrowitem defaultwidget" style="background-image: URL('https://support.ebs.in/app/__swift/themes/client/images/icon_widget_news.png');">
                <span class="widgetitemtitle">My Tickets</span>
            </a>
        </span>
    </div>
</div>
			
<script type="text/javascript"> $(function(){ $('.dialogerror, .dialoginfo, .dialogalert').fadeIn('slow');$("form").bind("submit", function(e){$(this).find("input:submit").attr("disabled", "disabled");});});</script>
				<script type="text/javascript" >try {if (top.location.hostname != self.location.hostname) { throw 1; }} catch (e) { top.location.href = self.location.href; }</script>
                                                </div>                                  
@stop