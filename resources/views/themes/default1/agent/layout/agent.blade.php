<!DOCTYPE html>                 
<html ng-app="fbApp">
    <head>
        <meta charset="UTF-8">
        <title>Faveo | HELP DESK</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta name="_token" content="{!! csrf_token() !!}"/>
        <!-- faveo favicon -->
        <link href="{{asset("lb-faveo/media/images/favicon.ico")}}" rel="shortcut icon">
        <!-- Bootstrap 3.3.2 -->
        <link href="{{asset("lb-faveo/css/bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="{{asset("lb-faveo/css/font-awesome.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="{{asset("lb-faveo/css/ionicons.min.css")}}" rel="stylesheet"  type="text/css" />
        <!-- Theme style --> 
        <link href="{{asset("lb-faveo/css/AdminLTE.css")}}" rel="stylesheet" type="text/css" id="adminLTR"/> 
        <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
        <link href="{{asset("lb-faveo/css/skins/_all-skins.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- iCheck -->
        <link href="{{asset("lb-faveo/plugins/iCheck/flat/blue.css")}}" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <link href="{{asset("lb-faveo/css/tabby.css")}}" rel="stylesheet" type="text/css"/>

        <link href="{{asset("lb-faveo/css/jquerysctipttop.css")}}" rel="stylesheet" type="text/css"/>
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <link href="{{asset("lb-faveo/css/editor.css")}}" rel="stylesheet" type="text/css"/>

        <link href="{{asset("lb-faveo/css/jquery.ui.css")}}" rel="stylesheet" rel="stylesheet"/>

        <link href="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.css")}}" rel="stylesheet"  type="text/css"/>

        <link href="{{asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css")}}" rel="stylesheet" type="text/css"/>

        <link href="{{asset("lb-faveo/css/faveo-css.css")}}" rel="stylesheet" type="text/css" />

        <link href="{{asset("lb-faveo/css/notification-style.css")}}" rel="stylesheet" type="text/css" >

        <link href="{{asset("lb-faveo/css/jquery.rating.css")}}" rel="stylesheet" type="text/css" />
        <!-- Select2 -->
        <link href="{{asset("lb-faveo/plugins/select2/select2.min.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{asset("css/close-button.css")}}" rel="stylesheet" type="text/css" />

        <!--Daterangepicker-->
        <link rel="stylesheet" href="{{asset("lb-faveo/plugins/daterangepicker/daterangepicker.css")}}" rel="stylesheet" type="text/css" />
        <!--calendar -->
        <!-- fullCalendar 2.2.5-->
        <link href="{{asset('lb-faveo/plugins/fullcalendar/fullcalendar.min.css')}}" rel="stylesheet" type="text/css" />

        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <script src="{{asset("lb-faveo/js/jquery-2.1.4.js")}}" type="text/javascript"></script>

        <script src="{{asset("lb-faveo/js/jquery2.1.1.min.js")}}" type="text/javascript"></script>

        @yield('HeadInclude')
        <style type="text/css">
            #bar {
                border-right: 1px solid rgba(204, 204, 204, 0.41);
            }
            #bar a{
                color: #FFF;
            }
            #bar a:hover, #bar a:focus{
                background-color: #357CA5;
            }

        </style>
    </head>
    <?php $segment = ""; ?>
    <body class="skin-blue fixed" ng-controller="MainCtrl">
        <div class="wrapper">
            <header class="main-header">
                <a href="http://www.faveohelpdesk.com" class="logo"><img src="{{ asset('lb-faveo/media/images/logo.png')}}" width="100px;"></a>
                <?php
                $replacetop = \Event::fire('service.desk.agent.topbar.replace', array());

                if (count($replacetop) == 0) {
                    $replacetop = 0;
                } else {
                    $replacetop = $replacetop[0];
                }

                $replaceside = \Event::fire('service.desk.agent.sidebar.replace', array());

                if (count($replaceside) == 0) {
                    $replaceside = 0;
                } else {
                    $replaceside = $replaceside[0];
                }
                ?>

                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="collapse navbar-collapse" id="navbar-collapse">
                        @if($replacetop==0)
                        <ul class="tabs tabs-horizontal nav navbar-nav navbar-left">
                            <li @yield('Dashboard')><a id="dash" data-target="#tabA" href="{{URL::route('dashboard')}}" onclick="clickDashboard(event);">{!! Lang::get('lang.dashboard') !!}</a></li>
                            <li @yield('Users')><a data-target="#tabB" href="#">{!! Lang::get('lang.users') !!}</a></li>
                            <li @yield('Tickets')><a data-target="#tabC" href="#">{!! Lang::get('lang.tickets') !!}</a></li>
                            <li @yield('Tools')><a data-target="#tabD" href="#">{!! Lang::get('lang.tools') !!}</a></li>
                            @if($auth_user_role == 'admin')
                            <li @yield('Report')><a href="{{URL::route('report.index')}}" onclick="clickReport(event);">Report</a></li>
                            @endif
                            <?php \Event::fire('calendar.topbar', array()); ?>
                        </ul>
                        @else
                        <?php \Event::fire('service.desk.agent.topbar', array()); ?>
                        @endif

                        <ul class="nav navbar-nav navbar-right">
                            @if($auth_user_role == 'admin')
                            <li><a href="{{url('admin')}}">{!! Lang::get('lang.admin_panel') !!}</a></li>

                            @endif
                            @include('themes.default1.update.notification')
                            <!-- START NOTIFICATION --> 
                            @include('themes.default1.inapp-notification.notification')
                            
                            <!-- END NOTIFICATION --> 
                            <!-- User Account: style can be found in dropdown.less -->
                            
                        <li class="dropdown">
                            <?php $src = Lang::getLocale().'.png'; ?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><img src="{{asset("lb-faveo/flags/$src")}}"></img> &nbsp;<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                @foreach($langs as $key => $value)
                                            <?php $src = $key.".png"; ?>
                                            <li><a href="#" id="{{$key}}" onclick="changeLang(this.id)"><img src="{{asset("lb-faveo/flags/$src")}}"></img>&nbsp;{{$value}}</a></li>
                                @endforeach       
                            </ul>
                        </li>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                @if($auth_user_id)
                                <img src="{{$auth_user_profile_pic}}"class="user-image" alt="User Image"/>
                                <span class="hidden-xs">{{$auth_name}}</span>
                                @endif
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header"  style="background-color:#343F44;">
                                    <img src="{{$auth_user_profile_pic}}" class="img-circle" alt="User Image" />
                                    <p>
                                        {{$auth_name}} - {{$auth_user_role}}
                                        <small></small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer" style="background-color:#1a2226;">
                                    <div class="pull-left">
                                        <a href="{{URL::route('profile')}}" class="btn btn-info btn-sm"><b>{!! Lang::get('lang.profile') !!}</b></a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{url('auth/logout')}}" class="btn btn-danger btn-sm"><b>{!! Lang::get('lang.sign_out') !!}</b></a>
                                    </div>
                                </li>

                            </ul>

                        </li>

                        </ul>

                    </div>
                    
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <div class="user-panel">
                        @if (trim($__env->yieldContent('profileimg')))
                        <h1>@yield('profileimg')</h1>
                        @else
                        <div class = "row">
                            <div class="col-xs-3"></div>
                            <div class="col-xs-2" style="width:50%;">
                                <a href="{!! url('profile') !!}">
                                    <img src="{{$auth_user_profile_pic}}" class="img-circle" alt="User Image" />
                                </a>
                            </div>
                        </div>
                        @endif
                        <div class="info" style="text-align:center;">
                            @if($auth_user_id)
                            <p>{{$auth_name}}</p>
                            @endif
                            @if($auth_user_id && $auth_user_active==1)
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                            @else
                            <a href="#"><i class="fa fa-circle"></i> Offline</a>
                            @endif
                        </div>
                    </div>
                    <ul id="side-bar" class="sidebar-menu">
                        @if($replaceside==0)
                        @yield('sidebar')
                        <li class="header">{!! Lang::get('lang.Tickets') !!}</li>
                        
                        <li @yield('inbox')>
                             <a href="{{ url('/tickets')}}" id="load-inbox">
                                <i class="fa fa-envelope"></i> <span>{!! Lang::get('lang.inbox') !!}</span> <small class="label pull-right bg-green">{{$tickets -> count()}}</small>                                            
                            </a>
                        </li>
                        <li @yield('myticket')>
                             <a href="{{ url('/tickets?show=mytickets')}}" id="load-myticket">
                                <i class="fa fa-user"></i> <span>{!! Lang::get('lang.my_tickets') !!} </span>
                                <small class="label pull-right bg-green">{{$myticket -> count()}}</small>
                            </a>
                        </li>
                        <li @yield('unassigned')>
                             <a href="{{ url('/tickets?assigned[]=0')}}" id="load-unassigned">
                                <i class="fa fa-th"></i> <span>{!! Lang::get('lang.unassigned') !!}</span>
                                <small class="label pull-right bg-green">{{$unassigned -> count()}}</small>
                            </a>
                        </li>
                        <li @yield('overdue')>
                             <a href="{{url('/tickets?show=overdue')}}" id="load-unassigned">
                                <i class="fa fa-calendar-times-o"></i> <span>{!! Lang::get('lang.overdue') !!}</span>
                                <small class="label pull-right bg-green">{{$overdues->count()}}</small>
                            </a>
                        </li>
                       
                        <li @yield('trash')>
                             <a href="{{ url('/tickets?show=trash')}}">
                                <i class="fa fa-trash-o"></i> <span>{!! Lang::get('lang.trash') !!}</span>
                                <small class="label pull-right bg-green">{{$deleted -> count()}}</small>
                            </a>
                        </li>
                        <li class="header">{!! Lang::get('lang.Departments') !!}</li>
                        <?php
            $flattened = $department->flatMap(function ($values) {
                return $values->keyBy('status');
            });
            $statuses = $flattened->keys();
            ?>
                            <?php
                                $segments = \Request::segments();
                                foreach($segments as $seg){
                                    $segment.="/".$seg;
                                }
                                if(count($segments) > 2) {
                                    $dept2 = $segments[1]; 
                                    $status2 = $segments[2];
                                } else {
                                     $dept2 = ''; 
                                    $status2 = '';
                                }
                            ?>
                        @foreach($department as $name=>$dept) 
                        
                        <li class="treeview @if($dept2 === $name) @yield('ticket-bar') @endif ">
                            <a href="#">
                                <i class="fa fa-folder-open"></i> <span>{!! $name !!}</span> <i class="fa fa-angle-left pull-right"></i>
                            </a>
                           @foreach($statuses as $status)
                           @if($dept->get($status))
                           <ul class="treeview-menu">
                                <li @if($status2 == $dept->get($status)->status && $dept2 === $name) @yield('inbox') @endif><a href="{{url('tickets/'.$name.'/'.$dept->get($status)->status)}}"><i class="fa fa-circle-o"></i> {!!$dept->get($status)->status !!}<small class="label pull-right bg-green">{{$dept->get($status)->count}}</small></a></li>
                            </ul>
                           @endif
                            @endforeach
                            
                        </li>
                        @endforeach
                        @else

<?php \Event::fire('service.desk.agent.sidebar', array()); ?>
                        @endif
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                
                    <div class="tab-content" style="background-color: #80B5D3; position: fixed; width:100% ;padding: 0 0px 0 0px; z-index:999">                    <div class="collapse navbar-collapse" id="navbar-collapse">
                        <div class="tabs-content">
                            @if($replacetop==0)
                            <div class="tabs-pane @yield('dashboard-bar')"  id="tabA">
                                <ul class="nav navbar-nav">
                                </ul>
                            </div>
                            <div class="tabs-pane @yield('user-bar')" id="tabB">
                                <ul class="nav navbar-nav">
                                    <li id="bar" @yield('user')><a href="{{ url('user')}}" >{!! Lang::get('lang.user_directory') !!}</a></li></a></li>
                                    <li id="bar" @yield('organizations')><a href="{{ url('organizations')}}" >{!! Lang::get('lang.organizations') !!}</a></li></a></li>
                                    
                                </ul>
                            </div>
                            <div class="tabs-pane @yield('ticket-bar')" id="tabC">
                                <ul class="nav navbar-nav">
                                    <li id="bar" @yield('answered')><a href="{{ url('/tickets?last-response-by[]=Agent')}}" id="load-answered">{!! Lang::get('lang.answered') !!}</a></li>
                                    <li id="bar" @yield('assigned')><a href="{{ url('/tickets?assigned[]=1')}}" id="load-unassigned">{!! Lang::get('lang.assigned') !!}</a></li>
                                    <li id="bar" @yield('closed')><a href="{{ url('/tickets?show=closed')}}" >{!! Lang::get('lang.closed') !!}</a></li>
                                    <li id="bar" @yield('newticket')><a href="{{ url('/newticket')}}" >{!! Lang::get('lang.create_ticket') !!}</a></li>
                                </ul>
                            </div>
                            <div class="tabs-pane @yield('tools-bar')" id="tabD">
                                <ul class="nav navbar-nav">
                                    <li id="bar" @yield('tools')><a href="{{ url('/canned/list')}}" >{!! Lang::get('lang.canned_response') !!}</a></li>
                                    <li id="bar" @yield('kb')><a href="{{ url('/comment')}}" >{!! Lang::get('lang.knowledge_base') !!}</a></li>
                                </ul>
                            </div>
                            @if($auth_user_role == 'admin')
                            <div class="tabs-pane @yield('report-bar')" id="tabD">
                                <ul class="nav navbar-nav">
                                </ul>
                            </div>
                            @endif
                            @endif
<?php \Event::fire('service.desk.agent.topsubbar', array()); ?>
                        </div>
                    </div>
                </div>
                @if ($segment == '/dashboard')
                <!-- do nothing-->
                @else
                <br/><br/>
                @endif
                <section class="content-header">
                    @yield('PageHeader')
                    {!! Breadcrumbs::renderIfExists() !!}
                </section>
                <!-- Main content -->
                <section class="content">
                @if (!$is_mail_conigured)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="callout callout-warning lead">
                                <h4><i class="fa fa-exclamation-triangle"></i>&nbsp;{{Lang::get('Alert')}}</h4>
                                <p style="font-size:0.8em">
                                @if (\Auth::user()->role == 'admin')
                                    {{Lang::get('lang.system-outgoing-incoming-mail-not-configured')}}&nbsp;<a href="{{URL::route('emails.create')}}">{{Lang::get('lang.confihure-the-mail-now')}}</a>
                                @else
                                    {{Lang::get('lang.system-mail-not-configured-agent-message')}}
                                @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                    @yield('content')
                </section><!-- /.content -->
            </div>
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> {!! Config::get('app.version') !!}
                </div>
                <strong>{!! Lang::get('lang.copyright') !!} &copy; {!! date('Y') !!}  <a href="{!! $company->website !!}" target="_blank">{!! $company->company_name !!}</a>.</strong> {!! Lang::get('lang.all_rights_reserved') !!}. {!! Lang::get('lang.powered_by') !!} <a href="http://www.faveohelpdesk.com/" target="_blank">Faveo</a>
            </footer>
        </div><!-- ./wrapper -->

        <script src="{{asset("lb-faveo/js/ajax-jquery.min.js")}}" type="text/javascript"></script>

        <script src="{{asset("lb-faveo/js/bootstrap-datetimepicker4.7.14.min.js")}}" type="text/javascript"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="{{asset("lb-faveo/js/bootstrap.min.js")}}" type="text/javascript"></script>
        <!-- Slimscroll -->
        <script src="{{asset("lb-faveo/plugins/slimScroll/jquery.slimscroll.min.js")}}" type="text/javascript"></script>
        <!-- FastClick -->
        <script src="{{asset("lb-faveo/plugins/fastclick/fastclick.min.js")}}"  type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="{{asset("lb-faveo/js/app.min.js")}}" type="text/javascript"></script>

        <!-- iCheck -->
        <script src="{{asset("lb-faveo/plugins/iCheck/icheck.min.js")}}" type="text/javascript"></script>
        <!-- jquery ui -->
        <script src="{{asset("lb-faveo/js/jquery.ui.js")}}" type="text/javascript"></script>

        <script src="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>

        <script src="{{asset("lb-faveo/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
        <!-- Page Script -->
        <script src="{{asset("lb-faveo/js/jquery.dataTables1.10.10.min.js")}}" type="text/javascript" ></script>

        <script type="text/javascript" src="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.js")}}"  type="text/javascript"></script>

        <script src="{{asset("lb-faveo/js/jquery.rating.pack.js")}}" type="text/javascript"></script>

        <script src="{{asset("lb-faveo/plugins/select2/select2.full.min.js")}}" type="text/javascript"></script>

        <script src="{{asset("lb-faveo/plugins/moment/moment.js")}}" type="text/javascript"></script>

        <!-- full calendar-->
        <script src="{{asset('lb-faveo/plugins/fullcalendar/fullcalendar.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('lb-faveo/plugins/daterangepicker/daterangepicker.js')}}" type="text/javascript"></script>
        <script>
                    $(document).ready(function () {

            $('.noti_User').click(function () {
            var id = this.id;
                    var dataString = 'id=' + id;
                    $.ajax
                    ({
                    type: "POST",
                            url: "{{url('mark-read')}}" + "/" + id,
                            data: dataString,
                            cache: false,
                            success: function (html)
                            {
                            }
                    });
            });
            });
                    $('#read-all').click(function () {

            var id2 = <?php echo $auth_user_id ?>;
                    var dataString = 'id=' + id2;
                    $.ajax
                    ({
                    type: "POST",
                            url: "{{url('mark-all-read')}}" + "/" + id2,
                            data: dataString,
                            cache: false,
                            beforeSend: function () {
                            $('#myDropdown').on('hide.bs.dropdown', function () {
                            return false;
                            });
                                    $("#refreshNote").hide();
                                    $("#notification-loader").show();
                            },
                            success: function (response) {
                            $("#refreshNote").load("<?php echo $_SERVER['REQUEST_URI']; ?>  #refreshNote");
                                    $("#notification-loader").hide();
                                    $('#myDropdown').removeClass('open');
                            }
                    });
            });</script>
        <script>
                    $(function() {
                    // Enable check and uncheck all functionality
                    $(".checkbox-toggle").click(function() {
                    var clicks = $(this).data('clicks');
                            if (clicks) {
                    //Uncheck all checkboxes
                    $("input[type='checkbox']", ".mailbox-messages").iCheck("uncheck");
                    } else {
                    //Check all checkboxes
                    $("input[type='checkbox']", ".mailbox-messages").iCheck("check");
                    }
                    $(this).data("clicks", !clicks);
                    });
                            //Handle starring for glyphicon and font awesome
                            $(".mailbox-star").click(function(e) {
                    e.preventDefault();
                            //detect type
                            var $this = $(this).find("a > i");
                            var glyph = $this.hasClass("glyphicon");
                            var fa = $this.hasClass("fa");
                            //Switch states
                            if (glyph) {
                    $this.toggleClass("glyphicon-star");
                            $this.toggleClass("glyphicon-star-empty");
                    }
                    if (fa) {
                    $this.toggleClass("fa-star");
                            $this.toggleClass("fa-star-o");
                    }
                    });
                    });</script>

        <script src="{{asset("lb-faveo/js/tabby.js")}}" type="text/javascript"></script>

        <script src="{{asset("lb-faveo/plugins/filebrowser/plugin.js")}}" type="text/javascript"></script>

        <script src="{{asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}" type="text/javascript"></script>

        <script type="text/javascript">
                    $.ajaxSetup({
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
                    });</script>
        <script type="text/javascript">
                    function clickDashboard(e) {
                    if (e.ctrlKey === true) {
                    window.open('{{URL::route("dashboard")}}', '_blank');
                    } else {
                    window.location = "{{URL::route('dashboard')}}";
                    }
                    }

            function clickReport(e) {
            if (e.ctrlKey === true) {
            window.open('{{URL::route("report.index")}}', '_blank');
            } else {
            window.location = "{{URL::route('report.index')}}";
            }
            }
        </script>
        
        <script src="{{asset("lb-faveo/js/angular/angular.min.js")}}" type="text/javascript"></script>
        <script src="{{asset("lb-faveo/js/angular/ng-scrollable.min.js")}}" type="text/javascript"></script>
        <script src="{{asset("lb-faveo/js/angular/angular-moment.min.js")}}" type="text/javascript"></script>
        <script src="{{asset("lb-faveo/js/angular/angular-recaptcha.min.js")}}" type="text/javascript"></script>
        <script src="{{asset("lb-faveo/js/angular/angular-translate.js")}}" type="text/javascript"></script>

        <script>
    $(function() {
      
        
        $('input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-blue'
        });
        $('input[type="radio"]:not(.not-apply)').iCheck({
            radioClass: 'iradio_flat-blue'
        });
    
    });        
</script>
<script src="{{asset('lb-faveo/js/angular/ng-flow-standalone.js')}}"></script>
<script src="{{asset('lb-faveo/js/angular/fusty-flow.js')}}"></script>
<script src="{{asset('lb-faveo/js/angular/fusty-flow-factory.js')}}"></script>
<script src="{{asset('lb-faveo/js/angular/ng-file-upload.js')}}"></script>
<script src="{{asset('lb-faveo/js/angular/ng-file-upload-shim.min.js')}}"></script>
<script>
 var app = angular.module('fbApp', ['vcRecaptcha','angularMoment','flow','ngFileUpload','pascalprecht.translate']).directive('whenScrolled', function() {
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
app.constant("CSRF_TOKEN", '{{ csrf_token() }}');
app.directive('mediaLibScrolled', function() {
    return function(scope, elm, attr) {
        var raw = elm[0];
        console.log(raw);
        elm.bind('scroll', function() {

            if (raw.scrollTop + raw.offsetHeight >= raw.scrollHeight) {
                scope.$apply(attr.mediaLibScrolled);
            }
        });
    };
});
app.config(['flowFactoryProvider', function (flowFactoryProvider) {
    
    flowFactoryProvider.on('fileSuccess', function (file,message) {
      console.log(file,message);
        $('#mytabs a[href="#menu1"]').tab('show');
        $("#progressHide").hide();
        $("#progressHide").find('.transfer-box').remove();
    });
   
    flowFactoryProvider.factory = fustyFlowFactory;
  }]);
app.config(['$translateProvider', function($translateProvider){
    $translateProvider.translations('en', {
        "Requester"     : "Requester",
        "Subject"       : "Subject",
        "Type"          : "Type",
        "Status"        : "Status",
        "Priority"      : "Priority",
        "Help Topic"    : "Help Topic",
        "Assigned"      : "Assigned",
        "Description"   : "Description",
        "Company"       : "Company"
    });
    $translateProvider.translations('ar', {

        "Requester"     : "الطالب",
        "Subject"       : "موضوع",
        "Type"          : "اكتب",
        "Status"        : "الحالة",
        "Priority"      : "أفضلية",
        "Help Topic"    : "موضوع المساعدة",
        "Assigned"      : "تعيين",
        "Description"   : "وصف",
        "Company"       : "شركة"
    });
    if('{{Lang::getLocale()}}'=='ar'){
       $translateProvider.preferredLanguage('ar');
    }
    else{
         $translateProvider.preferredLanguage('en');
    }
}]);
</script>
<script type="text/javascript">
                function changeLang(lang) {
                    location.href = "swtich-language/"+lang;
                }
            </script>
<script type="text/javascript">
 $(function () {
       if('{{Lang::getLocale()}}'=='ar'){
    var adminRtl = document.createElement('link');
    adminRtl.id = 'id-rtl';
    adminRtl.rel = 'stylesheet';
    adminRtl.href = '{{asset("lb-faveo/rtl/css/AdminLTE.css")}}';
    document.head.appendChild(adminRtl);

     var cssRtl = document.createElement('link');
    cssRtl.id = 'id-csstrtl';
    cssRtl.rel = 'stylesheet';
    cssRtl.href = '{{asset("lb-faveo/rtl/css/rtl.css")}}';
    document.head.appendChild(cssRtl);

     var bootRtl = document.createElement('link');
    bootRtl.id = 'id-bootrtl';
    bootRtl.rel = 'stylesheet';
    bootRtl.href = '{{asset("lb-faveo/rtl/css/bootstrap-rtl.min.css")}}';
    document.head.appendChild(bootRtl);


        
          $('#adminLTR').remove();
        $('.container').attr('dir','RTL');
        $('.formbilder').attr('dir','RTL');
        $('.content-area').attr('dir','RTL');
        // agentpanel
        $('.content').attr('dir','RTL');
        $('.info').attr('dir','RTL');
        $('.table').attr('dir','RTL');
        $('.box-primary').attr('dir','RTL');
        // box-header with-borderclass="box box-primary"
        $('.dataTables_paginate').find('.row').attr('dir','RTL');
        // dataTables_paginate paging_full_numbers
        $('.sidebar-menu').attr('dir','RTL');
        $('.sidebar-menu').find('.pull-right').removeClass("pull-right");
        $('.sidebar-menu').find('.label').addClass("pull-left");
        $('.content').find('.btn').removeClass("pull-right");
        $('.content').find('.btn').addClass("pull-left");
        $('.tabs-horizontal').removeClass("navbar-left");
        $('.tabs-horizontal').addClass("navbar-right");
        $('#right-menu').removeClass("navbar-right");
        $('#right-menu').addClass("navbar-left");
        $('.navbar-nav').find('li').css("float","right");
        $('#rtl1').css('display','none');
        $('#ltr1').css('display','block');
        $('#rtl2').css('display','none');
        $('#ltr2').css('display','block');
        $('#rtl3').css('display','none');
        $('#ltr3').css('display','block');  
        $('#rtl4').css('display','none');
        $('#ltr4').css('display','block');  
        $('.box-header').find('.pull-right').addClass("pull-left");
       $('.box-header').find('.pull-right').removeClass("pull-right");
         $('.btn').removeClass("pull-left");
        $('.iframe').attr('dir','RTL');
         $('.box-footer').find('a').removeClass("pull-right");
         $('.box-footer').find('a').addClass("pull-left");
         $('.box-footer').find('div').removeClass("pull-right");
         $('.box-footer').find('div').addClass("pull-left");
         $('.col-md-3').css('float','right');
         $('.user-footer').css('float','none');
         $('.user-header').css('float','none');
         $('.sidebar-toggle').css('width','60px');
         $('.dropdown-menu').css('right','inherit');
         $('.dropdown-menu').css('left','0');
// chart-data
        // label
          $('.box-header').find('.btn-primary').find('.pull-right').removeClass("pull-right");
        $('.box-header').find('.btn-primary').addClass("pull-left");
        $('.main-footer').find('.pull-right').removeClass("pull-right");
        $('.main-footer').find('.hidden-xs').addClass("pull-left");
        
        setTimeout(function(){  
        $('#cke_details').addClass( "cke_rtl" );
        $(".cke_wysiwyg_frame").contents().find("body").attr('dir','RTL');

        }, 3000);
        $('iframe').contents().find("body").attr('dir','RTL');
        /*$('#wys-form').remove();
        $('#mobile-RTL').css('display','block');
        $('#mobile-normal').css('display','none');
        $('#form-foot1').css('display','block');
        $('.list-inline').attr('dir','RTL');*/
       };
    });
</script>
<?php Event::fire('show.calendar.script', array()); ?>
<?php Event::fire('load-calendar-scripts', array()); ?>
        @yield('FooterInclude')
         @stack('scripts')
    </body>
</html>