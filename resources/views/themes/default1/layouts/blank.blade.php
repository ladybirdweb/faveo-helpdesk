<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Faveo | HELP DESK</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
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
        <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
         <link rel="stylesheet" href="{{asset("dist/css/editor.css")}}" type="text/css">
         <link href="{{asset("plugins/filebrowser/plugin.js")}}" rel="stylesheet" type="text/css" />

         <script src="ckeditor/ckeditor.js"></script>
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
         @yield('HeadInclude')
    </head>
    <body class="skin-blue">
        <div class="wrapper">

            <header class="main-header">
<?php $company = App\Model\Settings\Company::where('id', '=', '1')->first();?>

                <img src="{{asset('dist')}}{{'/'}}{{$company->logo}}" class="logo" alt="User Image" />
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    @if(Auth::user())
                    @if(Auth::user()->role == 'agent')

                        <ul class="tabs tabs-horizontal nav navbar-nav">

                            <li @yield('Users')><a data-target="#tabF" href="#" >Users</a></li>


                        </ul>



                            @endif
                    @if(Auth::user()->role == 'admin')
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="navbar-collapse">
                        <ul class="tabs tabs-horizontal nav navbar-nav">
                            <li><a data-target="#tabA" href="#">Home</a></li>
                            <li @yield('Staffs')><a data-target="#tabB" href="#" >Staffs</a></li>
                            <li @yield('Emails')><a data-target="#tabC" href="#" >Emails</a></li>
                            <li @yield('Manage')><a data-target="#tabD" href="#" >Manage</a></li>
                            <li @yield('Settings')><a data-target="#tabE" href="#" >Settings</a></li>

                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="{{url('user')}}">Agent Panel</a></li>
                            <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="{{asset('dist/img')}}{{'/'}}{{Auth::user()->profile_pic}}"class="user-image" alt="User Image"/>
                  <span class="hidden-xs">{{Auth::user()->user_name}}</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="{{asset('dist/img')}}{{'/'}}{{Auth::user()->profile_pic}}" class="img-circle" alt="User Image" />
                    <p>

                   {{Auth::user()->user_name}} - {{Auth::user()->role}}
                      <small></small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="{{url('admin-profile')}}" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="{{url('auth/logout')}}" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>

              @elseif(Auth::user()->role == 'user' || Auth::user()->role == 'agent' )
              <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">



              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="{{asset('dist/img')}}{{'/'}}{{Auth::user()->profile_pic}}"class="user-image" alt="User Image"/>
                  <span class="hidden-xs">{{Auth::user()->user_name}}</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="{{asset('dist/img')}}{{'/'}}{{Auth::user()->profile_pic}}" class="img-circle" alt="User Image" />
                    <p>

                   {{Auth::user()->user_name}} - {{Auth::user()->role}}
                      <small></small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                    @if(Auth::user()->role == 'agent')
                      <a href="{{url('agent-profile')}}" class="btn btn-default btn-flat">Profile</a>
                    @else
                      <a href="{{url('user-profile')}}" class="btn btn-default btn-flat">Profile</a>

                    @endif
                    </div>
                    <div class="pull-right">
                      <a href="{{url('auth/logout')}}" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>

              @endif

              @else
              <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

              <li>
                  <a href="{{url('auth/login')}}" class="logo"><span>Sign In</span></a>
                </li>

                <li>
                  <a href="{{url('auth/register')}}" class="logo"><span>Register</span></a>
                </li>
                </ul>
                </div>

              @endif





            </ul>
          </div>
        </nav>
      </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                @if(Auth::user())
                @if(Auth::user()->role == 'agent')
                    <div class="user-panel">
                    <div class="pull-left image">
                      <img src="{{asset('dist/img')}}{{'/'}}{{Auth::user()->profile_pic}}" class="img-circle" alt="User Image" />
                    </div>
                    <div class="pull-left info">
                      <p>{{Auth::user()->user_name}}</p>
                      @if(Auth::user()->active==1)
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                      @else
                        <a href="#"><i class="fa fa-circle"></i> Offline</a>
                      @endif
                    </div>
                  </div>
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



                        <li class="header">TICKETS</li>
                        <li>
                            <a href="../widgets.html">
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



                         @elseif(Auth::user()->role == 'admin')
                    <div class="user-panel">
                    <div class="pull-left image">
                      <img src="{{asset('dist/img')}}{{'/'}}{{Auth::user()->profile_pic}}" class="img-circle" alt="User Image" />
                    </div>
                    <div class="pull-left info">
                      <p>{{Auth::user()->user_name}}</p>
                      @if(Auth::user()->active==1)
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                      @else
                        <a href="#"><i class="fa fa-circle"></i> Offline</a>
                      @endif
                    </div>
                  </div>
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



                        <li class="header">TICKETS</li>
                        <li>
                            <a href="../widgets.html">
                                <i class="fa fa-envelope"></i> <span>Inbox</span> <small class="label pull-right bg-green">5</small>
                            </a>
                        </li>
                        <li @yield('myticket')>
                            <a href="{{url('ticket/myticket')}}">
                                <i class="fa fa-user"></i> <span>My Tickets</span>
<?php $myticket = App\Model\Ticket\Tickets::where('user_id', Auth::user()->id)->get();?>
                                <small class="label pull-right bg-green">{{count($myticket) }}</small>
                            </a>
                        </li>
                        <li>
                            <a href="{{url('unassigned')}}">
                                <i class="fa fa-th"></i> <span>Unassigned</span>
<?php $unassigned = App\Model\Ticket\Tickets::where('assigned_to', '0')->get();?>
                                 <small class="label pull-right bg-green">{{count($unassigned)}}</small>
                            </a>
                        </li>
                        <li @yield('trash')>
                            <a href="{{url('trash')}}">
                                <i class="fa fa-trash-o"></i> <span>Trash</span>
<?php $deleted = App\Model\Ticket\Tickets::where('status', '5')->get();?>
                                 <small class="label pull-right bg-green">{{count($deleted)}}</small>
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



                        @elseif(Auth::user()->role == 'user')
                        <div class="user-panel">
            <div class="pull-left image">
              <img src="{{asset('dist/img')}}{{'/'}}{{Auth::user()->profile_pic}}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p>{{Auth::user()->user_name}}</p>
              @if(Auth::user()->active==1)
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
              @else
                <a href="#"><i class="fa fa-circle"></i> Offline</a>
              @endif
            </div>
          </div>
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
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="../../index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                <li><a href="../../index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
              </ul>
            </li>

            <li>
              <a href="{{url('myticket')}}">
                <i class="fa fa-th"></i> <span>MyTickets</span>
              </a>
            </li>

            <li>
              <a href="../widgets.html">
                <i class="fa fa-th"></i> <span>Submit a Tickets</span>
              </a>
            </li>

            </ul>
        </section>
        <!-- /.sidebar -->

        @endif

        @else

        <ul class="sidebar-menu">
            <li>
              <a href="{{url('getform')}}">
                <i class="fa fa-envelope"></i> <span>Open A New Ticket</span>
              </a>
            </li>
        </ul>
        <ul class="sidebar-menu">
            <li>
              <a href="{{url('checkticket')}}">
                <i class="fa fa-th"></i> <span>Check your Ticket</span>
              </a>
            </li>
        </ul>

        @endif

                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="tab-content" style="background-color: white;padding: 0 20px 0 20px">
                    <div class="collapse navbar-collapse" id="navbar-collapse">
                        <div class="tabs-content">
                            <div class="tabs-pane active" id="tabA">
                                <ul class="nav navbar-nav">

                                </ul>
                            </div>
                            <div class="tabs-pane @yield('staffs-bar')" id="tabB">
                                <ul class="nav navbar-nav">
                                     <li id="bar" @yield('staffs')><a href="{{ url('agents') }}" >Staffs</a></li></a></li>
                                    <li id="bar" @yield('departments')><a href="{{ url('departments') }}" >Departments</a></li></a></li>
                                    <li id="bar" @yield('teams')><a href="{{ url('teams') }}" >Teams</a></li></a></li>
                                    <li id="bar" @yield('groups')><a href="{{ url('groups') }}" >Groups</a></li></a></li>
                                </ul>
                            </div>
                            <div class="tabs-pane @yield('emails-bar')" id="tabC">
                                <ul class="nav navbar-nav">
                                    <li id="bar" @yield('emails')><a href="{{ url('emails') }}" >Emails</a></li></a></li>
                                    <li id="bar" @yield('ban')><a href="{{ url('banlist') }}" >Ban List</a></li>
                                    <li id="bar" @yield('template')><a href="{{ url('template') }}" >Template</a></li>
                                    <li id="bar" @yield('diagno')><a href="{{ url('getdiagno') }}" >Diagnostic</a></li>
                                </ul>
                            </div>
                            <div class="tabs-pane @yield('manage-bar')" id="tabD">
                                <ul class="nav navbar-nav">
                                    <li id="bar" @yield('help')><a href="{{url('helptopic')}}">Help Topic</a></li>
                                    <li id="bar" @yield('sla')><a href="{{url('sla')}}">SLA Plans</a></li>
                                    <li id="bar" @yield('forms')><a href="{{url('form')}}">Forms</a></li>
                                </ul>
                            </div>
                            <div class="tabs-pane @yield('settings-bar')" id="tabE">
                                <ul class="nav navbar-nav">
                                    <li id="bar" @yield('company')><a href="{{url('getcompany')}}">Company</a></li>
                                    <li id="bar" @yield('system')><a href="{{url('getsystem')}}">System</a></li>
                                    <li id="bar" @yield('email')><a href="{{url('getemail')}}">Email</a></li>
                                    <li id="bar" @yield('tickets')><a href="{{url('getticket')}}">Tickets</a></li>
                                    <li id="bar" @yield('access')><a href="{{url('getaccess')}}">Access</a></li>
                                    <li id="bar" @yield('auto-response')><a href="{{url('getresponder')}}">Auto-Responce</a></li>
                                    <li id="bar" @yield('alert')><a href="{{url('getalert')}}">Alert & Notice</a></li>

                                </ul>
                            </div>
                            <div class="tabs-pane @yield('user-bar')" id="tabF">
                                <ul class="nav navbar-nav">
                                <li id="bar" @yield('user')><a href="{{ url('user') }}" >User Directory</a></li></a></li>
                                 <li id="bar" @yield('organizations')><a href="{{ url('organizations') }}" >Organizations</a></li></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="content-header">
                     @yield('PageHeader')
                @yield('breadcrumbs')
                </section>

                <!-- Main content -->
                <section class="content">

                    @yield('content')
                </section><!-- /.content -->
            <!-- /.content-wrapper -->
            </div>
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 0.1
                </div>
                <strong>Copyright &copy; 2014-2015 <a href="http://www.ladybirdweb.com">Ladybird Web Solution</a>.</strong> All rights reserved.
            </footer>
        </div><!-- ./wrapper -->

        <!-- jQuery 2.1.3 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
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
        <script>
            $(function() {
                //Enable iCheck plugin for checkboxes
                //iCheck for checkbox and radio inputs
                $('input[type="checkbox"]').iCheck({
                    checkboxClass: 'icheckbox_flat-blue',
                    radioClass: 'iradio_flat-blue'
                });

                //Enable check and uncheck all functionality
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
            });
        </script>
         <script type="text/javascript">
        //     $(document).ready(function() {

        //         $("#content").Editor();

        //     });
        // </script>
        <!-- // <script src="../plugins/jQuery/jQuery-2.1.3.min.js"></script> -->
        <script src="{{asset("dist/js/tabby.js")}}"></script>
         <!-- // <script src="{{asset("dist/js/editor.js")}}"></script> -->
         <!-- CK Editor -->
    <script src="{{asset("//cdn.ckeditor.com/4.4.3/standard/ckeditor.js")}}"></script>
    <script src="{{asset("//cdn.ckeditor.com/4.4.3/full/ckeditor.js")}}"></script>
    <script src="{{asset("plugins/filebrowser/plugin.js")}}"></script>

@yield('FooterInclude')
    </body>
</html>