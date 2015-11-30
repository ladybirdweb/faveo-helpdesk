<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Faveo | HELP DESK</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="{{asset("lb-faveo/downloads/bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- fullCalendar 2.2.5-->
        <link href="{{asset("lb-faveo/plugins/fullcalendar/fullcalendar.min.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{asset("lb-faveo/plugins/fullcalendar/fullcalendar.print.css")}}" rel="stylesheet" type="text/css" media='print' />
        <!-- Theme style -->
        <link href="{{asset("lb-faveo/dist/css/AdminLTE.css")}}" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link href="{{asset("lb-faveo/dist/css/skins/_all-skins.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- iCheck -->
        <link href="{{asset("lb-faveo/plugins/iCheck/flat/blue.css")}}" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <link rel="stylesheet" href="{{asset("lb-faveo/dist/css/tabby.css")}}" type="text/css">
        <link href="{{asset("lb-faveo/downloads/jquerysctipttop.css")}}" rel="stylesheet" type="text/css">
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <link rel="stylesheet" href="{{asset("lb-faveo/dist/css/editor.css")}}" type="text/css">
        <link href="{{asset("lb-faveo/plugins/filebrowser/plugin.js")}}" rel="stylesheet" type="text/css" />
        <link href="{{asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.css")}}" rel="stylesheet">    
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        @yield('HeadInclude')
    </head>
    <body class="skin-yellow fixed">
        <div class="wrapper">
            <header class="main-header">
                <a href="../../index2.html" class="logo"><b>Faveo </b>HELPDESK</a>
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
                            {{-- <li><a data-target="#tabA" href="#">Home</a></li> --}}
                            <li @yield('Staffs')><a data-target="#tabB" href="#">{!! Lang::get('lang.staffs') !!}</a></li>
                            <li @yield('Emails')><a data-target="#tabC" href="#">{!! Lang::get('lang.emails') !!}</a></li>
                            <li @yield('Manage')><a data-target="#tabD" href="#">{!! Lang::get('lang.manage') !!}</a></li>
                            <li @yield('Settings')><a data-target="#tabE" href="#">{!! Lang::get('lang.settings') !!}</a></li>
                            <li @yield('Themes')><a data-target="#tabF" href="#">{!! Lang::get('lang.themes') !!}</a></li>
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="{{url('user')}}">{!! Lang::get('lang.agent_panel') !!}</a></li>
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                @if(Auth::user())
                                    @if(Auth::user()->profile_pic)
                                        <img src="{{asset('lb-faveo/profilepic')}}{{'/'}}{{Auth::user()->profile_pic}}"class="user-image" alt="User Image"/>
                                    @else
                                        <img src="{{ Gravatar::src(Auth::user()->email) }}" class="user-image" alt="User Image">
                                    @endif
                                    <span class="hidden-xs">{!! Auth::user()->first_name." ".Auth::user()->last_name !!}</span>
                                @endif          
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header" style="background-color:#343F44;">
                                    @if(Auth::user())
                                        @if(Auth::user()->profile_pic)
                                            <img src="{{asset('lb-faveo/profilepic')}}{{'/'}}{{Auth::user()->profile_pic}}" class="img-circle" alt="User Image" />
                                        @else
                                            <img src="{{ Gravatar::src(Auth::user()->email) }}" class="img-circle" alt="User Image">
                                        @endif
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
                                        @if(Auth::user() && Auth::user()->profile_pic)
                                            <img src="{{asset('lb-faveo/profilepic')}}{{'/'}}{{Auth::user()->profile_pic}}" class="img-circle" alt="User Image" />
                                        @else
                                            <img src="{{ Gravatar::src(Auth::user()->email) }}" class="img-circle" alt="User Image">
                                        @endif
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
                                    <!-- search form -->
                                    {{-- <form action="#" method="get" class="sidebar-form"> --}}
                                        {{-- <div class="input-group"> --}}
                                            {{-- <input type="text" name="q" class="form-control" placeholder="Search..."/> --}}
                                            {{-- <span class="input-group-btn"> --}}
                                                {{-- <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button> --}}
                                            {{-- </span> --}}
                                        {{-- </div> --}}
                                    {{-- </form> --}}
                                    <!-- /.search form -->
                                    <!-- sidebar menu: : style can be found in sidebar.less -->
                                    <ul class="sidebar-menu">
                                                            <li class="header">{!! Lang::get('lang.Tickets') !!}</li>

<?php
$inbox = App\Model\helpdesk\Ticket\Tickets::get();
$myticket = App\Model\helpdesk\Ticket\Tickets::where('assigned_to', Auth::user()->id)->where('status','1')->get();
$unassigned = App\Model\helpdesk\Ticket\Tickets::where('assigned_to', '0')->where('status','1')->get();
$tickets = App\Model\helpdesk\Ticket\Tickets::where('status','1')->get();
$i = count($tickets);
?>
                                        <li>
                                            <a href="{{ url('/ticket/open') }}">
                                                <i class="fa fa-envelope"></i> <span>{!! Lang::get('lang.inbox') !!}</span> <small class="label pull-right bg-green">
                                                {!! $i !!}</small>
                                            </a>
                                        </li>

                                        <li @yield('myticket')>
                                             <a href="{{url('ticket/myticket')}}">
                                                <i class="fa fa-user"></i> <span>{!! Lang::get('lang.my_tickets') !!}</span>
                                               
                                                <small class="label pull-right bg-green">{{count($myticket) }}</small>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{url('unassigned')}}">
                                                <i class="fa fa-th"></i> <span>{!! Lang::get('lang.unassigned') !!}</span>
                                                
                                                <small class="label pull-right bg-green">{{count($unassigned)}}</small>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{url('trash')}}">
                                                <i class="fa fa-trash-o"></i> <span>{!! Lang::get('lang.trash') !!}</span>
                                                <?php $deleted = App\Model\helpdesk\Ticket\Tickets::where('status', '5')->get();?>
                                                <small class="label pull-right bg-green">{{count($deleted)}}</small>
                                            </a>
                                        </li>
                                        <li class="header">{!! Lang::get('lang.Updates') !!}</li>
                                        <li>
                                            <?php $update = App\Model\helpdesk\Utility\Version_Check::where('id','=',1)->first();
                                            if($update->current_version == $update->new_version){?>
                                                <a href="{!! URL::route('checkupdate') !!}" id="checkUpdate">
                                                    <span>{!! Lang::get('lang.no_new_updates') !!}!</span><br/>
                                                    <br/>
                                                    <i class="fa fa-inbox"></i> <span>{!! Lang::get('lang.check_for_updates') !!}.</span>
                                                    
                                                    <img  id="gif-update" src="{{asset("lb-faveo/dist/img/gifloader.gif")}}" style="width:12%; height:12%; margin-bottom:5%;margin-left:10%;display:none">
                                                    
                                                    <small class="label pull-right bg-green"></small>
                                                </a>
                                            <?php } elseif($update->current_version < $update->new_version) { ?>
                                                <a>
                                                    <i class="fa fa-inbox"></i> <span>Version {!! $update->new_version !!}  is Available</span>
                                                    <small class="label pull-right bg-green"></small>
                                                </a>
                                            <?php } ?>
                                        </li>
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
                                                    <li id="bar" @yield('staffs')><a href="{{ url('agents') }}" >{!! Lang::get('lang.staffs') !!}</a></li></a></li>
                                                    <li id="bar" @yield('departments')><a href="{{ url('departments') }}" >{!! Lang::get('lang.department') !!}</a></li></a></li>
                                                    <li id="bar" @yield('teams')><a href="{{ url('teams') }}" >{!! Lang::get('lang.teams') !!}</a></li></a></li>
                                                    <li id="bar" @yield('groups')><a href="{{ url('groups') }}" >{!! Lang::get('lang.groups') !!}</a></li></a></li>
                                                </ul>
                                            </div>
                                            <div class="tabs-pane @yield('emails-bar')" id="tabC">
                                                <ul class="nav navbar-nav">
                                                    <li id="bar" @yield('emails')><a href="{{ url('emails') }}" >{!! Lang::get('lang.incoming_emails') !!}</a></li></a></li>
                                                    <li id="bar" @yield('smtp')><a href="{{ url('getsmtp') }}" >{!! Lang::get('lang.outgoing_emails') !!}</a></li>
                                                    <li id="bar" @yield('ban')><a href="{{ url('banlist') }}" >{!! Lang::get('lang.ban_lists') !!}</a></li>
                                                    {{-- <li id="bar" @yield('template')><a href="{{ url('template') }}" >Template</a></li> --}}
                                                    <li id="bar" @yield('diagno')><a href="{{ url('getdiagno') }}" >{!! Lang::get('lang.diagnostics') !!}</a></li>
                                                </ul>
                                            </div>
                                            <div class="tabs-pane @yield('manage-bar')" id="tabD">
                                                <ul class="nav navbar-nav">
                                                    <li id="bar" @yield('help')><a href="{{url('helptopic')}}">{!! Lang::get('lang.help_topics') !!}</a></li>
                                                    <li id="bar" @yield('sla')><a href="{{url('sla')}}">{!! Lang::get('lang.sla_plans') !!}</a></li>
                                                    <li id="bar" @yield('forms')><a href="{{url('forms')}}">{!! Lang::get('lang.forms') !!}</a></li>
                                                </ul>
                                            </div>
                                            <div class="tabs-pane @yield('settings-bar')" id="tabE">
                                                <ul class="nav navbar-nav">
                                                    <li id="bar" @yield('company')><a href="{{url('getcompany')}}">{!! Lang::get('lang.company') !!}</a></li>
                                                    <li id="bar" @yield('system')><a href="{{url('getsystem')}}">{!! Lang::get('lang.system') !!}</a></li>
                                                    <li id="bar" @yield('email')><a href="{{url('getemail')}}">{!! Lang::get('lang.email') !!}</a></li>
                                                    <li id="bar" @yield('tickets')><a href="{{url('getticket')}}">{!! Lang::get('lang.ticket') !!}</a></li>
                                                    {{-- <li id="bar" @yield('access')><a href="{{ // url('getaccess')}}">Access</a></li> --}}
                                                    <li id="bar" @yield('auto-response')><a href="{{url('getresponder')}}">{!! Lang::get('lang.auto_responce') !!}</a></li>
                                                    <li id="bar" @yield('alert')><a href="{{url('getalert')}}">{!! Lang::get('lang.alert_notices') !!}</a></li>
                                                </ul>
                                            </div>
                                            <div class="tabs-pane @yield('theme-bar')" id="tabF">
                                                <ul class="nav navbar-nav">
                                                    <li id="bar" @yield('footer')><a href="{{ url('create-footer') }}" >{!! Lang::get('lang.footer1') !!}</a></li></a></li>
                                                    <li id="bar" @yield('footer2')><a href="{{ url('create-footer2') }}" >{!! Lang::get('lang.footer2') !!}</a></li></a></li>
                                                    <li id="bar" @yield('footer3')><a href="{{ url('create-footer3') }}" >{!! Lang::get('lang.footer3') !!}</a></li></a></li>
                                                    <li id="bar" @yield('footer4')><a href="{{ url('create-footer4') }}" >{!! Lang::get('lang.footer4') !!}</a></li></a></li>
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
                                    <b>Version</b> {!! Config::get('app.version') !!}
                                </div>
                                <?php  
                                $company = App\Model\helpdesk\Settings\Company::where('id','=','1')->first();
                                ?>
                                <strong>{!! Lang::get('lang.copyright') !!} &copy; {!! date('Y') !!}  <a href="{!! $company->website !!}">{!! $company->company_name !!}</a>.</strong> {!! Lang::get('lang.all_rights_reserved') !!}. {!! Lang::get('lang.powered_by') !!} <a href="http://www.faveohelpdesk.com/">Faveo</a>
                            </footer>
                    </div><!-- ./wrapper -->

                    <!-- jQuery 2.1.3 -->
                    <script src="{{asset("lb-faveo/downloads/ajax-jquery.min.js")}}"></script>
                    <!-- Bootstrap 3.3.2 JS -->
                    <script src="{{asset("lb-faveo/downloads/bootstrap.min.js")}}" type="text/javascript"></script>
                    <!-- Slimscroll -->
                    <script src="{{asset("lb-faveo/plugins/slimScroll/jquery.slimscroll.min.js")}}" type="text/javascript"></script>
                    <!-- FastClick -->
                    <script src="{{asset("lb-faveo/plugins/fastclick/fastclick.min.js")}}"></script>
                    <!-- AdminLTE App -->
                    <script src="{{asset("lb-faveo/dist/js/app.min.js")}}" type="text/javascript"></script>
                    <!-- AdminLTE for demo purposes -->
                    {{-- // <script src="{{asset("dist/js/demo.js")}}" type="text/javascript"></script> --}}
                    <!-- iCheck -->
                    <script src="{{asset("lb-faveo/plugins/iCheck/icheck.min.js")}}" type="text/javascript"></script>

                    <script src="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>

                    <script src="{{asset("lb-faveo/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
                    <!-- Page Script -->
                    <script src="{{asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}" type="text/javascript"></script>
                    <script>
                        $(function () {
                        //Add text editor
                        $("textarea").wysihtml5();
                        });
                    

// $(function(){
//     $("#checkUpdate").on('click',function(){        
//             $.ajax({
//                 type: "GET",
//                 url: "{!! URL::route('version-check') !!}",
//             beforeSend: function() {
//                 $("#gif-update").show();
//                 },
//             success:function(response){
//                 alert(response);
//                 $("#gif-update").hide();
//                 }

//             })
//         return false;
//     });
// });










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
                   <!-- // <script src="../plugins/jQuery/jQuery-2.1.3.min.js"></script> -->
                    <script src="{{asset("lb-faveo/dist/js/tabby.js")}}"></script>
                     <!-- // <script src="{{asset("dist/js/editor.js")}}"></script> -->
                    <!-- CK Editor -->
                    <!-- // <script src="{{asset("//cdn.ckeditor.com/4.4.3/standard/ckeditor.js")}}"></script> -->
                    <script src="{{asset("lb-faveo/plugins/filebrowser/plugin.js")}}"></script>

                    @yield('FooterInclude')
                    </body>
                    </html>