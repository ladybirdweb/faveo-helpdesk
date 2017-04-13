<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Faveo | HELP DESK</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- faveo favicon -->
        <link href="{{asset("lb-faveo/media/images/favicon.ico")}}" rel="shortcut icon"> 
        <!-- Bootstrap 3.3.2 -->
        <link href="{{asset("lb-faveo/css/bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="{{asset("lb-faveo/css/font-awesome.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="{{asset("lb-faveo/css/ionicons.min.css")}}" rel="stylesheet" type="text/css" >
        <!-- Theme style -->
        <link href="{{asset("lb-faveo/css/AdminLTE.css")}}" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
        <link href="{{asset("lb-faveo/css/skins/_all-skins.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- iCheck -->
        <link href="{{asset("lb-faveo/plugins/iCheck/flat/blue.css")}}" rel="stylesheet" type="text/css" />
        <!-- This controlls the top tabs -->
        <link href="{{asset("lb-faveo/css/tabby.css")}}" rel="stylesheet" type="text/css" >
        <!-- In app notification style -->
        <link href="{{asset("css/notification-style.css")}}" rel="stylesheet" type="text/css">

        <link href="{{asset("lb-faveo/css/jquerysctipttop.css")}}" rel="stylesheet" type="text/css">

        <link  href="{{asset("lb-faveo/css/editor.css")}}" rel="stylesheet" type="text/css">

        <link href="{{asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css")}}" rel="stylesheet" type="text/css" />

        <link href="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.css")}}" rel="stylesheet" type="text/css" >
        <!-- select2 -->
        <link href="{{asset("lb-faveo/plugins/select2/select2.min.css")}}" rel="stylesheet" type="text/css">
        <!-- Colorpicker -->
        
        <link href="{{asset("lb-faveo/plugins/colorpicker/bootstrap-colorpicker.min.css")}}" rel="stylesheet" type="text/css" />
        
        <script src="{{asset("lb-faveo/plugins/filebrowser/plugin.js")}}" type="text/javascript"></script>

        <script src="{{asset("lb-faveo/js/jquery-2.1.4.js")}}" type="text/javascript"></script>

        <script src="{{asset("lb-faveo/js/jquery2.1.1.min.js")}}" type="text/javascript"></script>
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        @yield('HeadInclude')
    </head>
    <body class="skin-yellow fixed">
        <?php
        $replacetop = 0;
        $replacetop = \Event::fire('service.desk.admin.topbar.replace', array());
        if (count($replacetop) == 0) {
            $replacetop = 0;
        } else {
            $replacetop = $replacetop[0];
        }
        $replaceside = 0;
        $replaceside = \Event::fire('service.desk.admin.sidebar.replace', array());
        if (count($replaceside) == 0) {
            $replaceside = 0;
        } else {
            $replaceside = $replaceside[0];
        }
        //dd($replacetop);
        ?>
        <div class="wrapper">
            <header class="main-header">
                <a href="http://www.faveohelpdesk.com" class="logo"><img src="{{ asset('lb-faveo/media/images/logo.png') }}" width="100px"></a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <?php $notifications = App\Http\Controllers\Common\NotificationController::getNotifications(); ?>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="navbar-collapse">

                        <ul class="nav navbar-nav navbar-left">
                            @if($replacetop==0)
                            <li @yield('settings')><a href="{!! url('dashboard') !!}">{!! Lang::get('lang.agent_panel') !!}</a></li>
                            @else
                            <?php \Event::fire('service.desk.admin.topbar', array()); ?>
                            @endif
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            @if($auth_user_role == 'admin')
                            <li><a href="{{url('admin')}}">{!! Lang::get('lang.admin_panel') !!}</a></li>

                            @endif

                            @include('themes.default1.update.notification')
                            <!-- START NOTIFICATION --> 
                            @include('themes.default1.inapp-notification.notification')
                            
                            <!-- END NOTIFICATION -->
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
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                @if(Auth::user())

                                <img src="{{Auth::user()->profile_pic}}"class="user-image" alt="User Image"/>

                                <span class="hidden-xs">{!! Auth::user()->first_name." ".Auth::user()->last_name !!}</span>
                                @endif
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header" style="background-color:#343F44;">
                                    @if(Auth::user())
                                    <img src="{{Auth::user()->profile_pic}}" class="img-circle" alt="User Image" />
                                    <p>
                                        {!! Auth::user()->first_name !!}{!! " ". Auth::user()->last_name !!} - {{Auth::user()->role}}
                                        <small></small>
                                    </p>
                                    @endif
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer"  style="background-color:#1a2226;">
                                    <div class="pull-left">
                                        <a href="{{url('admin-profile')}}" class="btn btn-info btn-sm"><b>{!! Lang::get('lang.profile') !!}</b></a>
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
                        <div class = "row">
                            <div class="col-xs-3"></div>
                            <div class="col-xs-2" style="width:50%;">
                                <a href="{!! url('profile') !!}">
                                    <img src="{{Auth::user()->profile_pic}}" class="img-circle" alt="User Image" />
                                </a>
                            </div>
                        </div>
                        <div class="info" style="text-align:center;">
                            @if(Auth::user())
                            <p>{!! Auth::user()->first_name !!}{!! " ". Auth::user()->last_name !!}</p>
                            @endif
                            @if(Auth::user() && Auth::user()->active==1)
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                            @else
                            <a href="#"><i class="fa fa-circle"></i> Offline</a>
                            @endif
                        </div>
                    </div>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        @if($replaceside==0)
                        <center><a href="{{url('admin')}}"><li class="header"><span style="font-size:1.5em;">{{ Lang::get('lang.admin_panel') }}</span></li></a></center>
                        <li class="header">{!! Lang::get('lang.settings-2') !!}</li>
                        <li class="treeview @yield('Staffs')">
                            <a  href="#">
                                <i class="fa fa-users"></i> <span>{!! Lang::get('lang.staffs') !!}</span> <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li @yield('agents')><a href="{{ url('agents') }}"><i class="fa fa-user "></i>{!! Lang::get('lang.agents') !!}</a></li>
                                <li @yield('departments')><a href="{{ url('departments') }}"><i class="fa fa-sitemap"></i>{!! Lang::get('lang.departments') !!}</a></li>
                                <li @yield('teams')><a href="{{ url('teams') }}"><i class="fa fa-users"></i>{!! Lang::get('lang.teams') !!}</a></li>
                                <li @yield('groups')><a href="{{ url('groups') }}"><i class="fa fa-users"></i>{!! Lang::get('lang.groups') !!}</a></li>
                            </ul>
                        </li>

                        <li class="treeview @yield('Emails')">
                            <a href="#">
                                <i class="fa fa-envelope-o"></i>
                                <span>{!! Lang::get('lang.email') !!}</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li @yield('emails')><a href="{{ url('emails') }}"><i class="fa fa-envelope"></i>{!! Lang::get('lang.emails') !!}</a></li>
                                <li @yield('ban')><a href="{{ url('banlist') }}"><i class="fa fa-ban"></i>{!! Lang::get('lang.ban_pluck') !!}</a></li>
                                <li @yield('template')><a href="{{ url('template-sets') }}"><i class="fa fa-mail-forward"></i>{!! Lang::get('lang.templates') !!}</a></li>
                                <li @yield('email')><a href="{{url('getemail')}}"><i class="fa fa-at"></i>{!! Lang::get('lang.email-settings') !!}</a></li>
                                <li @yield('queue')><a href="{{ url('queue') }}"><i class="fa fa-upload"></i>{!! Lang::get('lang.queues') !!}</a></li>
                                <li @yield('diagnostics')><a href="{{ url('getdiagno') }}"><i class="fa fa-plus"></i>{!! Lang::get('lang.diagnostics') !!}</a></li>
                               
                                <!-- <li><a href="#"><i class="fa fa-circle-o"></i> Auto Response</a></li> -->
                                <!-- <li><a href="#"><i class="fa fa-circle-o"></i> Rules/a></li> -->
                                <!-- <li><a href="#"><i class="fa fa-circle-o"></i> Breaklines</a></li> -->
                                <!-- <li><a href="#"><i class="fa fa-circle-o"></i> Log</a></li> -->
                            </ul>
                        </li>

                        <li class="treeview @yield('Manage')">
                            <a href="#">
                                <i class="fa  fa-cubes"></i>
                                <span>{!! Lang::get('lang.manage') !!}</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li @yield('help')><a href="{{url('helptopic')}}"><i class="fa fa-file-text-o"></i>{!! Lang::get('lang.help_topics') !!}</a></li>
                                <li @yield('sla')><a href="{{url('sla')}}"><i class="fa fa-clock-o"></i>{!! Lang::get('lang.sla_plans') !!}</a></li>
                                <li @yield('forms')><a href="{{url('forms')}}"><i class="fa fa-file-text"></i>{!! Lang::get('lang.forms') !!}</a></li>
                                <li @yield('workflow')><a href="{{url('workflow')}}"><i class="fa fa-sitemap"></i>{!! Lang::get('lang.workflow') !!}</a></li>
                                <li @yield('priority')><a href="{{url('ticket/priority')}}"><i class="fa fa-asterisk"></i>{!! Lang::get('lang.priority') !!}</a></li>
                                <li @yield('url')><a href="{{url('url/settings')}}"><i class="fa fa-server"></i>{!! Lang::get('lang.url') !!}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('Tickets')">
                            <a  href="#">
                                <i class="fa fa-ticket"></i> <span>{!! Lang::get('lang.tickets') !!}</span> <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li @yield('tickets')><a href="{{url('getticket')}}"><i class="fa fa-file-text"></i>{!! Lang::get('lang.ticket') !!}</a></li>
                                <li @yield('auto-response')><a href="{{url('getresponder')}}"><i class="fa fa-reply-all"></i>{!! Lang::get('lang.auto_response') !!}</a></li>
                                <li @yield('alert')><a href="{{url('getalert')}}"><i class="fa fa-bell"></i>{!! Lang::get('lang.alert_notices') !!}</a></li>
                                <li @yield('status')><a href="{{url('setting-status')}}"><i class="fa fa-plus-square-o"></i>{!! Lang::get('lang.status') !!}</a></li>
                                <li @yield('ratings')><a href="{{url('getratings')}}"><i class="fa fa-star"></i>{!! Lang::get('lang.ratings') !!}</a></li>
                                <li @yield('close-workflow')><a href="{{url('close-workflow')}}"><i class="fa fa-sitemap"></i>{!! Lang::get('lang.close-workflow') !!}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('Settings')">
                            <a href="#">
                                <i class="fa fa-cog"></i>
                                <span>{!! Lang::get('lang.settings') !!}</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li @yield('company')><a href="{{url('getcompany')}}"><i class="fa fa-building"></i>{!! Lang::get('lang.company') !!}</a></li>
                                <li @yield('system')><a href="{{url('getsystem')}}"><i class="fa fa-laptop"></i>{!! Lang::get('lang.system') !!}</a></li>
                                <li @yield('social-login')><a href="{{ url('social/media') }}"><i class="fa fa-globe"></i> {!! Lang::get('lang.social-login') !!}</a></li>
                                <li @yield('languages')><a href="{{url('languages')}}"><i class="fa fa-language"></i>{!! Lang::get('lang.language') !!}</a></li>
                                <li @yield('cron')><a href="{{url('job-scheduler')}}"><i class="fa fa-hourglass"></i>{!! Lang::get('lang.cron') !!}</a></li>
                                <li @yield('security')><a href="{{url('security')}}"><i class="fa fa-lock"></i>{!! Lang::get('lang.security') !!}</a></li>
                                <li @yield('notification')><a href="{{url('settings-notification')}}"><i class="fa fa-bell"></i>{!! Lang::get('lang.notifications') !!}</a></li>
                                <li @yield('storage')><a href="{{url('storage')}}"><i class="fa fa-save"></i>{!! Lang::get('storage::lang.storage') !!}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('error-bugs')">
                            <a href="#">
                                <i class="fa fa-heartbeat"></i>
                                <span>{!! Lang::get('lang.error-debug') !!}</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <!-- <li @yield('error-logs')><a href="{{ route('error.logs') }}"><i class="fa fa-list-alt"></i> {!! Lang::get('lang.view-logs') !!}</a></li> -->
                                <li @yield('debugging-option')><a href="{{ route('err.debug.settings') }}"><i class="fa fa-bug"></i> {!! Lang::get('lang.debug-options') !!}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('Themes')">
                            <a href="#">
                                <i class="fa fa-pie-chart"></i>
                                <span>{!! Lang::get('lang.widgets') !!}</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li @yield('widget')><a href="{{ url('widgets') }}"><i class="fa fa-list-alt"></i> {!! Lang::get('lang.widgets') !!}</a></li>
                                <li @yield('socail')><a href="{{ url('social-buttons') }}"><i class="fa fa-cubes"></i> {!! Lang::get('lang.social') !!}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('Plugins')">
                            <a href="{{ url('plugins') }}">
                                <i class="fa fa-plug"></i>
                                <span>{!! Lang::get('lang.plugin') !!}</span>
                            </a>
                        </li>
                        <li class="treeview @yield('API')">
                            <a href="{{ url('api') }}">
                                <i class="fa fa-cogs"></i>
                                <span>{!! Lang::get('lang.api') !!}</span>
                            </a>
                        </li>
                        <li class="treeview @yield('Log')">
                            <a href="{{ url('logs') }}">
                                <i class="fa fa-lock"></i>
                                <span>Logs</span>
                            </a>
                        </li>
                        @endif
                        <?php \Event::fire('service.desk.admin.sidebar', array()); ?>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <!--<div class="row">-->
                    <!--<div class="col-md-6">-->
                    @yield('PageHeader')
                    <!--</div>-->
                    {!! Breadcrumbs::renderIfExists() !!}
                    <!--</div>-->
                </section>

                <!-- Main content -->
                <section class="content">

                    @yield('content')
                </section><!-- /.content -->
                <!-- /.content-wrapper -->
            </div>
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> {!! Config::get('app.version') !!}
                </div>
                <?php
                $company = App\Model\helpdesk\Settings\Company::where('id', '=', '1')->first();
                ?>
                <strong>{!! Lang::get('lang.copyright') !!} &copy; {!! date('Y') !!}  <a href="{!! $company->website !!}" target="_blank">{!! $company->company_name !!}</a>.</strong> {!! Lang::get('lang.all_rights_reserved') !!}. {!! Lang::get('lang.powered_by') !!} <a href="http://www.faveohelpdesk.com/" target="_blank">Faveo</a>
            </footer>
        </div><!-- ./wrapper -->
        <!-- jQuery 2.1.3 -->
        <script src="{{asset("lb-faveo/js/ajax-jquery.min.js")}}" type="text/javascript"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="{{asset("lb-faveo/js/bootstrap.min.js")}}" type="text/javascript"></script>
        <!-- Slimscroll -->
        <script src="{{asset("lb-faveo/plugins/slimScroll/jquery.slimscroll.min.js")}}" type="text/javascript"></script>
        <!-- FastClick -->
        <script src="{{asset("lb-faveo/plugins/fastclick/fastclick.min.js")}}" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="{{asset("lb-faveo/js/app.min.js")}}" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="{{asset("lb-faveo/plugins/iCheck/icheck.min.js")}}" type="text/javascript"></script>
        
        <script src="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>
        
        <script src="{{asset("lb-faveo/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
        <!-- Page Script -->
        <script src="{{asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}" type="text/javascript"></script>

        <script src="{{asset("lb-faveo/js/jquery.dataTables1.10.10.min.js")}}"  type="text/javascript"></script>
        
        <script src="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.js")}}"  type="text/javascript"></script>
        <!-- Colorpicker -->
        <script src="{{asset("lb-faveo/plugins/colorpicker/bootstrap-colorpicker.min.js")}}" ></script>
        <!--date time picker-->
        <script src="{{asset("lb-faveo/js/bootstrap-datetimepicker4.7.14.min.js")}}" type="text/javascript"></script>
        <!-- select2 -->
         <script src="{{asset("lb-faveo/plugins/select2/select2.min.js")}}" ></script>

@if (trim($__env->yieldContent('no-toolbar')))
    <h1>@yield('no-toolbar')</h1>
@else
    <script>
    $(function () {
    //Add text editor
        $("textarea").wysihtml5();
    });
    </script>
@endif
    <script>
        $('#read-all').click(function () {

            var id2 = <?php echo \Auth::user()->id ?>;
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
    
    <script src="{{asset("lb-faveo/js/tabby.js")}}"></script>
    <!-- CK Editor -->
    <script src="{{asset("lb-faveo/plugins/filebrowser/plugin.js")}}"></script>

    @yield('FooterInclude')
</body>
<script>
    $(function() {
      
        
        $('input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-blue'
        });
        $('input[type="radio"]').iCheck({
            radioClass: 'iradio_flat-blue'
        });
    
    });        
</script>
<script type="text/javascript">
                function changeLang(lang) {
                    location.href = "swtich-language/"+lang;
                }
            </script>
</html>