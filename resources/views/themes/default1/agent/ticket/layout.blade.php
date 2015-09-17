<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Faveo | HELP DESK</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="{{asset("downloads/bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="{{asset("downloads/font-awesome.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="{{asset("downloads/ionicons.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- fullCalendar 2.2.5-->
        <link href="{{asset("plugins/fullcalendar/fullcalendar.min.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{asset("plugins/fullcalendar/fullcalendar.print.css")}}" rel="stylesheet" type="text/css" media='print' />
        <!-- Theme style -->
        <link href="{{asset("dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link href="{{asset("dist/css/skins/_all-skins.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- iCheck -->
        <link href="{{asset("plugins/iCheck/flat/blue.css")}}" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <link rel="stylesheet" href="{{asset("dist/css/tabby.css")}}" type="text/css">
        <link href="{{asset("downloads/jquerysctipttop.css")}}" rel="stylesheet" type="text/css">
        <link href="{{asset("dist/css/skins/_all-skins.min.css")}}" rel="stylesheet" type="text/css" />
        <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- <link rel="stylesheet" href="{{asset("dist/css/tabby.css")}}" type="text/css"> -->

        <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

        <link href="{{asset("dist/css/editor.css")}}" type="text/css" rel="stylesheet"/>
        <script src="{{asset("dist/js/jquery-2.1.0.min.js")}}"></script>        
        <link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
        <div class="wrapper">
            <header class="main-header">
                <a href="../../index2.html" class="logo"><b>Faveo</b> HELP DESK</a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="navbar-collapse">
                        <ul class="tabs tabs-horizontal nav navbar-nav">
                            <li @yield('nav1') ><a data-target="#tabA" href="#">Home</a></li>
                            <li><a data-target="#tabB" href="#">Staff</a></li>
                            <li><a data-target="#tabC" href="#">Department</a></li>
                            <li><a data-target="#tabD" href="#">Users</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
                                    <span class="hidden-xs">Alexander Pierce</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
                                        <p>
                                            Alexander Pierce - Web Developer
                                            <small>Member since Nov. 2012</small>
                                        </p>
                                    </li>
                                    <!-- Menu Body -->
                                    <li class="user-body">
                                        <div class="col-xs-6 text-center">
                                            <a href="#">Department:Sales</a>
                                        </div>
                                        <div class="col-xs-6 text-center">
                                            <a href="#">Level 1 Support</a>
                                        </div>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="#" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <!-- <form class="navbar-form navbar-left" role="search">
                          <div class="form-group">
                            <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
                          </div>
                        </form> -->

                    </div><!-- /.navbar-collapse -->
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <!-- search form -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">

                        @yield('sidebar')

                        <li class="header">TICKETS</li>
                        <li>
                            <a href="{{ route('ticket') }}">
                                <i class="fa fa-envelope"></i> <span>Inbox</span> <small class="label pull-right bg-green">5</small>
                            </a>
                        </li>
                        <li>
                            <a href="../widgets.html">
                                <i class="fa fa-user"></i> <span>My Tickets</span> <small class="label pull-right bg-green">2</small>
                            </a>
                        </li>
                        <li>
                            <a href="../widgets.html">
                                <i class="fa fa-th"></i> <span>Unassigned</span> <small class="label pull-right bg-green">4</small>
                            </a>
                        </li>
                        <li>
                            <a href="../widgets.html">
                                <i class="fa fa-trash-o"></i> <span>Trash</span> <small class="label pull-right bg-green">89</small>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-folder-open"></i> <span>General</span> <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href=""><i class="fa fa-circle-o"></i>Open<small class="label pull-right bg-green">4</small></a></li>
                                <li><a href=""><i class="fa fa-circle-o"></i>Inprogress<small class="label pull-right bg-green">3</small></a></li>
                                <li><a href=""><i class="fa fa-circle-o"></i>Closed<small class="label pull-right bg-green">55</small></a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-folder-open"></i> <span>Support</span> <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href=""><i class="fa fa-circle-o"></i>Open<small class="label pull-right bg-green">1</small></a></li>
                                <li><a href=""><i class="fa fa-circle-o"></i>Inprogress<small class="label pull-right bg-green">6</small></a></li>
                                <li><a href=""><i class="fa fa-circle-o"></i>Closed<small class="label pull-right bg-green">88</small></a></li>
                            </ul>
                        </li>


                        <li class="header">LABELS</li>
                        <li><a href="#"><i class="fa fa-circle-o text-danger"></i> Important</a></li>
                        <li><a href="#"><i class="fa fa-circle-o text-warning"></i> Warning</a></li>
                        <li><a href="#"><i class="fa fa-circle-o text-info"></i> Information</a></li>
                    </ul>
                </section>
                <!-- /.sidebar -->      
            </aside>
            <!-- Right side column. Contains the navbar and content of the page -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="tab-content" style="background-color:#ddd ;padding: 0 20px 0 20px">
                    <div class="collapse navbar-collapse" id="navbar-collapse">
                        <div class="tabs-content">
                            <div class="tabs-pane active" id="tabA">
                                <ul class="nav navbar-nav">
                                    <li @yield('Home') ><a  href="#">Home</a></li>
                                    <li @yield('My') ><a href="#">My Preferences</a></li>
                                    <li><a href="#">Notification</a></li>
                                    <li><a href="#">Comments</a></li>
                                </ul>
                            </div>
                            <div class="tabs-pane" id="tabB">
                                <ul class="nav navbar-nav">
                                    <li><a href="#">Manage Tickets</a></li>
                                    <li><a href="#">Search</a></li>
                                    <li><a href="#">New Ticket</a></li>
                                    <li><a href="#">Views</a></li>
                                </ul>
                            </div>
                            <div class="tabs-pane" id="tabC">
                                <ul class="nav navbar-nav">
                                    <li><a href="#">Link5</a></li>
                                    <li><a href="#">Link6</a></li>
                                </ul>
                            </div>
                            <div class="tabs-pane" id="tabD">
                                <ul class="nav navbar-nav">
                                    <li><a href="#">Link7</a></li>
                                    <li><a href="#">Link8</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                @yield('content')

            </div><!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 2.0
                </div>
                <strong>Copyright &copy; 2014-2015 <a href="http://www.ladybirdweb.com">Ladybird Web Solution</a>.</strong> All rights reserved.
            </footer>
        </div><!-- ./wrapper -->


        <!-- jQuery 2.1.3 -->
        <script src="{{asset("downloads/jquery.min.js")}}"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="{{asset("downloads/bootstrap.min.js")}}" type="text/javascript"></script>
        <!-- Slimscroll -->
        <script src="{{asset("plugins/slimScroll/jquery.slimscroll.min.js")}}" type="text/javascript"></script>
        <!-- FastClick -->
        <script src='{{asset("plugins/fastclick/fastclick.min.js")}}'></script>
        <!-- AdminLTE App -->
        <script src="{{asset("dist/js/app.min.js")}}" type="text/javascript"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{asset("dist/js/demo.js")}}" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="{{asset("plugins/iCheck/icheck.min.js")}}" type="text/javascript"></script>
        <!-- Page Script -->
        <!-- // <script src="../plugins/jQuery/jQuery-2.1.3.min.js"></script> -->
        <script src="{{asset("dist/js/tabby.js")}}"></script>

        <script src="{{asset("dist/js/editor.js")}}"></script>
<script src="{{asset("plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}" type="text/javascript"></script>
        @yield('footer')

    </body>
</html>