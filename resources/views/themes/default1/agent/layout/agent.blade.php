<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" ng-app="myApp">
        <title>Faveo | HELP DESK</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta name="_token" content="{!! csrf_token() !!}"/>
        <!-- faveo favicon -->
        <link rel="shortcut icon" href="{{asset("lb-faveo/media/images/favicon.ico")}}">
        <!-- Bootstrap 3.3.2 -->
        <link href="{{asset("lb-faveo/css/bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="{{asset("lb-faveo/css/font-awesome.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="{{asset("lb-faveo/css/ionicons.min.css")}}" rel="stylesheet">
        <!-- Theme style -->
        <link href="{{asset("lb-faveo/css/AdminLTE.css")}}" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link href="{{asset("lb-faveo/css/skins/_all-skins.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- iCheck -->
        <link href="{{asset("lb-faveo/plugins/iCheck/flat/blue.css")}}" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <link rel="stylesheet" href="{{asset("lb-faveo/css/tabby.css")}}" type="text/css">
        <link href="{{asset("lb-faveo/css/jquerysctipttop.css")}}" rel="stylesheet" type="text/css">
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <link rel="stylesheet" href="{{asset("lb-faveo/css/editor.css")}}" type="text/css">
        <link type="text/css" href="{{asset("lb-faveo/css/jquery.ui.css")}}" rel="stylesheet">
        <link type="text/css" href="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.css")}}" rel="stylesheet">
        <link href="{{asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css")}}" rel="stylesheet" type="text/css" />        
        <link rel="stylesheet" type="text/css" href="{{asset("lb-faveo/css/faveo-css.css")}}">
        <link rel="stylesheet" type="text/css" href="{{asset("lb-faveo/css/notification-style.css")}}">

        <link href="{{asset("lb-faveo/css/jquery.rating.css")}}" rel="stylesheet" type="text/css" />

        <!-- Select2 -->
        <link rel="stylesheet" href="{{asset("lb-faveo/plugins/select2/select2.min.css")}}">
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <script src="{{asset("lb-faveo/js/jquery-2.1.4.js")}}" type="text/javascript"></script>
        <script src="{{asset("lb-faveo/js/jquery2.1.1.min.js")}}" type="text/javascript"></script>

        @yield('HeadInclude')
    </head>
    <body class="skin-blue fixed">
        <div class="wrapper">
            <header class="main-header">
                <a href="http://www.faveohelpdesk.com" class="logo"><img src="{{ asset('lb-faveo/media/images/logo.png')}}" width="100px;"></a>
                <?php
                $company = App\Model\helpdesk\Settings\Company::where('id', '=', '1')->first();
                if ($company != null) {
                    
                }
                $replacetop = 0;
                $replacetop = \Event::fire('service.desk.agent.topbar.replace', array());

                if (count($replacetop) == 0) {
                    $replacetop = 0;
                } else {
                    $replacetop = $replacetop[0];
                }
                $replaceside = 0;
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
                    <?php $notifications = App\Http\Controllers\Common\NotificationController::getNotifications();
                    
                    ?>
                    <div class="collapse navbar-collapse" id="navbar-collapse">
                        @if($replacetop==0)
                        <ul class="tabs tabs-horizontal nav navbar-nav navbar-left">
                            
                            <li @yield('Dashboard')><a data-target="#tabA" href="#">{!! Lang::get('lang.dashboard') !!}</a></li>
                            <li @yield('Users')><a data-target="#tabB" href="#">{!! Lang::get('lang.users') !!}</a></li>
                            <li @yield('Tickets')><a data-target="#tabC" href="#">{!! Lang::get('lang.tickets') !!}</a></li>
                            <li @yield('Tools')><a data-target="#tabD" href="#">{!! Lang::get('lang.tools') !!}</a></li>
                            
                        </ul>
                        @else 
                            <?php \Event::fire('service.desk.agent.topbar', array()); ?>
                            @endif

                        <?php $noti = \App\Model\helpdesk\Notification\UserNotification::where('user_id', '=', Auth::user()->id)->where('is_read', '0')->get(); ?>

                        <ul class="nav navbar-nav navbar-right">
                            @if(Auth::user()->role == 'admin')
                            <li><a href="{{url('admin')}}">{!! Lang::get('lang.admin_panel') !!}</a></li>
                            @endif
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown notifications-menu" id="myDropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick="myFunction()">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-danger" id="count">{!! count($noti) !!}</span>
                                </a>
                                <ul class="dropdown-menu" style="width:500px">

                                    <div id="alert11" class="alert alert-success alert-dismissable" style="display:none;">
                                        <button id="dismiss11" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h4><i class="icon fa fa-check"></i>Alert!</h4>
                                        <div id="message-success1"></div>
                                    </div>

                                    <li id="refreshNote">

                                    <li class="header">You have {!! count($noti) !!} notifications. <a class="pull-right" id="read-all" href="#">Mark all as read.</a></li>

                                    <ul class="menu">
                                        @foreach($notifications as $notification)
                                        <?php $user = App\User::whereId($notification->user_id)->first(); ?>
                                        @if($notification->type == 'registration')
                                        @if($notification->is_read == 1)
                                        <li class="task" style="list-style: none; margin-left: -30px;"><span>&nbsp<img src="{{$user -> profile_pic}}" class="user-image"  style="width:6%;height: 5%" alt="User Image" />
                                                <a href="{!! route('user.show', $notification->model_id) !!}" id="{{$notification -> notification_id}}" class='noti_User'>
                                                    {!! $notification->message !!}
                                                </a></span>
                                        </li>
                                        @else
                                        <li style="list-style: none; margin-left: -30px;"><span>&nbsp<img src="{{$user -> profile_pic}}" class="user-image"  style="width:6%;height: 5%" alt="User Image" />
                                                <a href="{!! route('user.show', $notification->model_id) !!}" id="{{$notification -> notification_id}}" class='noti_User'>
                                                    {!! $notification->message !!}
                                                </a></span>
                                        </li>
                                        @endif
                                        @else

                                        <?php $ticket_number = App\Model\helpdesk\Ticket\Tickets::whereId($notification->model_id)->first(); ?>
                                        @if($notification->is_read == 1)
                                        <li  class="task" style="list-style: none;margin-left: -30px"><span>&nbsp<img src="{{$user -> profile_pic}}" class="img-circle"  style="width:6%;height: 5%" alt="User Image" />
                                                <a href="{!! route('ticket.thread', $notification->model_id) !!}" id='{{ $notification -> notification_id}}' class='noti_User'>
                                                    {!! $notification->message !!} with id "{!!$ticket_number->ticket_number!!}"
                                                </a></span>
                                        </li>
                                        @else
                                        <li style="list-style: none;margin-left: -30px"><span>&nbsp<img src="{{$user -> profile_pic}}" class="img-circle"  style="width:6%;height: 5%" alt="User Image" />
                                                <a href="{!! route('ticket.thread', $notification->model_id) !!}" id='{{ $notification -> notification_id}}' class='noti_User'>
                                                    {!! $notification->message !!} with id "{!!$ticket_number->ticket_number!!}"
                                                </a></span>
                                        </li>
                                        @endif
                                        @endif
                                        @endforeach

                                    </ul>
                            </li>
                            <li class="footer no-border"><div class="col-md-5"></div><div class="col-md-2">
                                    <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}" style="display: none;" id="notification-loader">
                                </div><div class="col-md-5"></div></li>
                            <li class="footer"><a href="{{ url('notifications-list')}}">View all</a>
                            </li>

                        </ul>
                        </li>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                @if(Auth::user())
                                <img src="{{Auth::user()->profile_pic}}"class="user-image" alt="User Image"/>
                                <span class="hidden-xs">{{Auth::user()->first_name." ".Auth::user()->last_name}}</span>
                                @endif          
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header"  style="background-color:#343F44;">     
                                    <img src="{{Auth::user()->profile_pic}}" class="img-circle" alt="User Image" />                                        
                                    <p>
                                        {{Auth::user()->first_name." ".Auth::user()->last_name}} - {{Auth::user()->role}}
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

                                    <img src="{{Auth::user()->profile_pic}}" class="img-circle" alt="User Image" />

                                </a>
                            </div>
                        </div>
                        @endif
                        <div class="info" style="text-align:center;">
                            @if(Auth::user())
                            <p>{{Auth::user()->first_name." ".Auth::user()->last_name}}</p>
                            @endif
                            @if(Auth::user() && Auth::user()->active==1)
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                            @else
                            <a href="#"><i class="fa fa-circle"></i> Offline</a>
                            @endif
                        </div>
                    </div>
                    <!-- search form -->
                    {{-- < form action = "#" method = "get" class = "sidebar-form" > --}}
                    {{-- < div class = "input-group" > --}}
                    {{-- < input type = "text" name = "q" class = "form-control" placeholder = "Search..." / > --}}
                    {{-- < span class = "input-group-btn" > --}}
                    {{-- < button type = 'submit' name = 'seach' id = 'search-btn' class = "btn btn-flat" > < i class = "fa fa-search" > < /i></button > --}}
                    {{-- < /span> --}}
                    {{-- < /div> --}}
                    {{-- < /form> --}}
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul id="side-bar" class="sidebar-menu">

                        @if($replaceside==0)
                        @yield('sidebar')
                        <li class="header">{!! Lang::get('lang.Tickets') !!}</li>
                        <?php
                        if (Auth::user()->role == 'admin') {
//$inbox = App\Model\helpdesk\Ticket\Tickets::all();
                            $myticket = App\Model\helpdesk\Ticket\Tickets::where('assigned_to', Auth::user()->id)->where('status', '1')->get();
                            $unassigned = App\Model\helpdesk\Ticket\Tickets::where('assigned_to', '=', null)->where('status', '=', '1')->get();
                            $tickets = App\Model\helpdesk\Ticket\Tickets::where('status', '1')->get();
                            $deleted = App\Model\helpdesk\Ticket\Tickets::where('status', '5')->get();
                        } elseif (Auth::user()->role == 'agent') {
//$inbox = App\Model\helpdesk\Ticket\Tickets::where('dept_id','',Auth::user()->primary_dpt)->get();
                            $myticket = App\Model\helpdesk\Ticket\Tickets::where('assigned_to', Auth::user()->id)->where('status', '1')->get();
                            $unassigned = App\Model\helpdesk\Ticket\Tickets::where('assigned_to', '=', null)->where('status', '=', '1')->where('dept_id', '=', Auth::user()->primary_dpt)->get();
                            $tickets = App\Model\helpdesk\Ticket\Tickets::where('status', '1')->where('dept_id', '=', Auth::user()->primary_dpt)->get();
                            $deleted = App\Model\helpdesk\Ticket\Tickets::where('status', '5')->where('dept_id', '=', Auth::user())->get();
                        }
                        if (Auth::user()->role == 'agent') {
                            $dept = App\Model\helpdesk\Agent\Department::where('id', '=', Auth::user()->primary_dpt)->first();
                            $overdues = App\Model\helpdesk\Ticket\Tickets::where('status', '=', 1)->where('isanswered', '=', 0)->where('dept_id', '=', $dept->id)->orderBy('id', 'DESC')->get();
                        } else {
                            $overdues = App\Model\helpdesk\Ticket\Tickets::where('status', '=', 1)->where('isanswered', '=', 0)->orderBy('id', 'DESC')->get();
                        }
                        $i = count($overdues);
                        if ($i == 0) {
                            $overdue_ticket = 0;
                        } else {
                            $j = 0;
                            foreach ($overdues as $overdue) {
                                $sla_plan = App\Model\helpdesk\Manage\Sla_plan::where('id', '=', $overdue->sla)->first();

                                $ovadate = $overdue->created_at;
                                $new_date = date_add($ovadate, date_interval_create_from_date_string($sla_plan->grace_period)) . '<br/><br/>';
                                if (date('Y-m-d H:i:s') > $new_date) {
                                    $j++;
                                    //$value[] = $overdue;
                                }
                            }
                            // dd(count($value));
                            if ($j > 0) {
                                $overdue_ticket = $j;
                            } else {
                                $overdue_ticket = 0;
                            }
                        }
                        ?>
                        <li @yield('inbox')>
                             <a href="{{ url('/ticket/inbox')}}" id="load-inbox">
                                <i class="fa fa-envelope"></i> <span>{!! Lang::get('lang.inbox') !!}</span> <small class="label pull-right bg-green"><?php echo count($tickets); ?></small>                                            </a>
                        </li>
                        <li @yield('myticket')>
                             <a href="{{url('ticket/myticket')}}" id="load-myticket">
                                <i class="fa fa-user"></i> <span>{!! Lang::get('lang.my_tickets') !!} </span>
                                <small class="label pull-right bg-green">{{count($myticket)}}</small>
                            </a>
                        </li>
                        <li @yield('unassigned')>
                             <a href="{{url('unassigned')}}" id="load-unassigned">
                                <i class="fa fa-th"></i> <span>{!! Lang::get('lang.unassigned') !!}</span>
                                <small class="label pull-right bg-green">{{count($unassigned)}}</small>
                            </a>
                        </li>
                        <li @yield('overdue')>
                             <a href="{{url('ticket/overdue')}}" id="load-unassigned">
                                <i class="fa fa-calendar-times-o"></i> <span>{!! Lang::get('lang.overdue') !!}</span>
                                <small class="label pull-right bg-green">{{$overdue_ticket}}</small>
                            </a>
                        </li>
                        <li @yield('trash')>
                             <a href="{{url('trash')}}">
                                <i class="fa fa-trash-o"></i> <span>{!! Lang::get('lang.trash') !!}</span>
                                <small class="label pull-right bg-green">{{count($deleted)}}</small>
                            </a>
                        </li>
                        <li class="header">{!! Lang::get('lang.Departments') !!}</li>
                        <?php
                        $depts = App\Model\helpdesk\Agent\Department::all();
                        foreach ($depts as $dept) {
                            $open = App\Model\helpdesk\Ticket\Tickets::where('status', '=', '1')->where('isanswered', '=', 0)->where('dept_id', '=', $dept->id)->get();
                            $open = count($open);
                            $underprocess = App\Model\helpdesk\Ticket\Tickets::where('status', '=', '1')->where('assigned_to', '>', 0)->where('dept_id', '=', $dept->id)->get();
                            $underprocess = count($underprocess);
                            $closed = App\Model\helpdesk\Ticket\Tickets::where('status', '=', '2')->where('dept_id', '=', $dept->id)->get();
                            $closed = count($closed);
                            // $underprocess = 0;
                            // foreach ($inbox as $ticket4) {
                            //  if ($ticket4->assigned_to == null) {
                            //  } else {
                            //      $underprocess++;
                            //  }
                            // }
                            if (Auth::user()->role == 'admin') {
                                ?>
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-folder-open"></i> <span>{!! $dept->name !!}</span> <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="{!! url::route('dept.open.ticket',$dept->name) !!}"><i class="fa fa-circle-o"></i>{!! Lang::get('lang.open') !!}<small class="label pull-right bg-green">{!! $open !!}</small></a></li>
                                        <li><a href="{!! url::route('dept.inprogress.ticket',$dept->name) !!}"><i class="fa fa-circle-o"></i>{!! Lang::get('lang.inprogress') !!}<small class="label pull-right bg-green">{!! $underprocess !!}</small></a></li>
                                        <li><a href="{!! url::route('dept.closed.ticket',$dept->name) !!}"><i class="fa fa-circle-o"></i>{!! Lang::get('lang.closed') !!}<small class="label pull-right bg-green">{!! $closed !!}</small></a></li>
                                    </ul>
                                </li>
                            <?php } if (Auth::user()->role == 'agent' && Auth::user()->primary_dpt == $dept->id) { ?>
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-folder-open"></i> <span>{!! $dept->name !!}</span> <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="{!! url::route('dept.open.ticket',$dept->name) !!}"><i class="fa fa-circle-o"></i>{!! Lang::get('lang.open') !!}<small class="label pull-right bg-green">{!! $open !!}</small></a></li>
                                        <li><a href="{!! url::route('dept.inprogress.ticket',$dept->name) !!}"><i class="fa fa-circle-o"></i>{!! Lang::get('lang.inprogress') !!}<small class="label pull-right bg-green">{!! $underprocess !!}</small></a></li>
                                        <li><a href="{!! url::route('dept.closed.ticket',$dept->name) !!}"><i class="fa fa-circle-o"></i>{!! Lang::get('lang.closed') !!}<small class="label pull-right bg-green">{!! $closed !!}</small></a></li>
                                    </ul>
                                </li>
                            <?php }
                        }
                        ?>

                        @endif
<?php \Event::fire('service.desk.agent.sidebar', array()); ?>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            <?php
            $agent_group = Auth::user()->assign_group;
            $group = App\Model\helpdesk\Agent\Groups::where('id', '=', $agent_group)->where('group_status', '=', '1')->first();
// dd($group); 
            ?>
            <!-- Right side column. Contains the navbar and content of the page -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="tab-content" style="background-color: white;padding: 0 20px 0 20px">
                    <div class="collapse navbar-collapse" id="navbar-collapse">
                        <div class="tabs-content">
                            @if($replacetop==0)
                            <div class="tabs-pane @yield('dashboard-bar')"  id="tabA">
                                <ul class="nav navbar-nav">
                                    <li id="bar" @yield('dashboard') ><a href="{{url('dashboard')}}">{!! Lang::get('lang.dashboard') !!}</a></li>
                                    <li id="bar" @yield('profile') ><a href="{{url('profile')}}">{!! Lang::get('lang.profile') !!}</a></li>
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
                                    <li id="bar" @yield('open')><a href="{{ url('/ticket/open')}}" id="load-open">{!! Lang::get('lang.open') !!}</a></li>
                                    <li id="bar" @yield('answered')><a href="{{ url('/ticket/answered')}}" id="load-answered">{!! Lang::get('lang.answered') !!}</a></li>
                                    <li id="bar" @yield('myticket')><a href="{{ url('/ticket/myticket')}}" >{!! Lang::get('lang.my_tickets') !!}</a></li>
                                    {{-- < li id = "bar" @yield('ticket') > < a href = "{{ url('ticket') }}" >Ticket</a></li> --}}
                                    {{-- < li id = "bar" @yield('overdue') > < a href = "{{ url('/ticket/overdue') }}" >Overdue</a></li> --}}
                                    <li id="bar" @yield('assigned')><a href="{{ url('/ticket/assigned')}}" id="load-assigned" >{!! Lang::get('lang.assigned') !!}</a></li>
                                    <li id="bar" @yield('closed')><a href="{{ url('/ticket/closed')}}" >{!! Lang::get('lang.closed') !!}</a></li>
                                    <?php if ($group->can_create_ticket == 1) { ?>
                                        <li id="bar" @yield('newticket')><a href="{{ url('/newticket')}}" >{!! Lang::get('lang.create_ticket') !!}</a></li>
<?php } ?>
                                </ul>
                            </div>
                            <div class="tabs-pane @yield('tools-bar')" id="tabD">
                                <ul class="nav navbar-nav">
                                    <li id="bar" @yield('tools')><a href="{{ url('/canned/list')}}" >{!! Lang::get('lang.canned_response') !!}</a></li>
                                    <li id="bar" @yield('kb')><a href="{{ url('/comment')}}" >{!! Lang::get('lang.knowledge_base') !!}</a></li>
                                </ul>
                            </div>
                            @endif
<?php \Event::fire('service.desk.agent.topsubbar', array()); ?>
                        </div>
                    </div>
                </div>
                <section class="content-header">
                    <!--<div class="row">-->
                    <!--<div class="col-md-6">-->
                    @yield('PageHeader')
                    <!--</div>-->
                    <!--<div class="pull-right">-->
                    {!! Breadcrumbs::renderIfExists() !!}
                    <!--</div>-->
                    <!--</div>-->
                </section>
                <!-- Main content -->
                <section class="content">
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
        {{-- // <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> --}}

        <script src="{{asset("lb-faveo/js/ajax-jquery.min.js")}}"></script>

        {{-- // <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script> --}}

        <script src="{{asset("lb-faveo/js/bootstrap-datetimepicker4.7.14.min.js")}}" type="text/javascript"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="{{asset("lb-faveo/js/bootstrap.min.js")}}" type="text/javascript"></script>
        <!-- Slimscroll -->
        <script src="{{asset("lb-faveo/plugins/slimScroll/jquery.slimscroll.min.js")}}" type="text/javascript"></script>
        <!-- FastClick -->
        <script src="{{asset("lb-faveo/plugins/fastclick/fastclick.min.js")}}"></script>
        <!-- AdminLTE App -->
        <script src="{{asset("lb-faveo/js/app.min.js")}}" type="text/javascript"></script>
        <!-- AdminLTE for demo purposes -->
        {{-- // <script src="{{asset("dist/js/demo.js")}}" type="text/javascript"></script> --}}
    <!-- iCheck -->
    <script src="{{asset("lb-faveo/plugins/iCheck/icheck.min.js")}}" type="text/javascript"></script>
    {{-- maskinput --}}
    {{-- // <script src="js/jquery.maskedinput.min.js" type="text/javascript"></script> --}}
    {{-- jquery ui --}}
    <script src="{{asset("lb-faveo/js/jquery.ui.js")}}" type="text/javascript"></script>
    <script src="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>
    <script src="{{asset("lb-faveo/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
    <!-- Page Script -->

    {{-- // <script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script> --}}
    <script type="text/javascript" src="{{asset("lb-faveo/js/jquery.dataTables1.10.10.min.js")}}"></script>

    <script type="text/javascript" src="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.js")}}"></script>
    <script src="{{asset("lb-faveo/js/jquery.rating.pack.js")}}" type="text/javascript"></script>

    <script src="{{asset("lb-faveo/plugins/select2/select2.full.min.js")}}" ></script>
    <script src="{{asset("lb-faveo/plugins/moment/moment.js")}}" ></script>
    <script>
                function myFunction() {

                document.getElementById("count").innerHTML = "0";
                }
    </script>
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
//$(".city").html(html);
                        }
                });
        });
        });
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
    <script>
                $(function() {
                // Enable iCheck plugin for checkboxes
                // iCheck for checkbox and radio inputs
                // $('input[type="checkbox"]').iCheck({
                // checkboxClass: 'icheckbox_flat-blue',
                // radioClass: 'iradio_flat-blue'
                // });
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
    <script type="text/javascript">
                //     $(document).ready(function() {
                //         $("#content").Editor();
                //     });
                // </script>
   <!-- // <script src="../plugins/jQuery/jQuery-2.1.3.min.js"></script> -->
    <script src="{{asset("lb-faveo/js/tabby.js")}}"></script>
     <!-- // <script src="{{asset("dist/js/editor.js")}}"></script> -->
    <!-- CK Editor -->
    <!-- // <script src="{{asset("//cdn.ckeditor.com/4.4.3/standard/ckeditor.js")}}"></script> -->
    {{-- // <script src="{{asset("lb-faveo/downloads/CKEditor.js")}}"></script> --}}
<script src="{{asset("lb-faveo/plugins/filebrowser/plugin.js")}}"></script>
<script src="{{asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}" type="text/javascript"></script>
<script>
            // $(function () {
            // //Add text editor
            // $("textarea").wysihtml5();
            // });
</script>
<script type="text/javascript">
            $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
            });
</script>
@yield('FooterInclude')
</body>
</html>