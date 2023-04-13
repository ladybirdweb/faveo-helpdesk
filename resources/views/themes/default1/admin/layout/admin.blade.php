<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Faveo | HELP DESK</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- faveo favicon -->
        <link href="{{asset("lb-faveo/media/images/favicon.ico")}}" rel="shortcut icon">
               <!-- Bootstrap 4.3.1 -->
{{--        <link href="{{asset("lb-faveo/css/bootstrap4.min.css")}}" rel="stylesheet" type="text/css" />--}}

        <!-- Font Awesome Icons -->
        <link href="{{asset("lb-faveo/css/font-awesome-5.min.css")}}" rel="stylesheet" type="text/css" />

        <!-- Ionicons -->
        <link href="{{asset("lb-faveo/css/ionicons.min.css")}}" rel="stylesheet"  type="text/css" />

        <!-- Theme style -->
        <link href="{{asset("lb-faveo/adminlte3/css/adminlte3.2.0.min.css")}}" rel="stylesheet" type="text/css" />

        <link href="{{asset("lb-faveo/adminlte3/plugins/overlayScrollbars/overlayScrollbars3.2.0.min.css")}}" rel="stylesheet"  type="text/css" />

        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <link href="{{asset("lb-faveo/css/editor.css")}}" rel="stylesheet" type="text/css"/>

        <link href="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.css")}}" rel="stylesheet"  type="text/css"/>

        <link href="{{asset("lb-faveo/css/jquery.rating.css")}}" rel="stylesheet" type="text/css" />

        <!-- Select2 -->
        <link href="{{asset("lb-faveo/plugins/select2/select2.3.2.0.min.css")}}" rel="stylesheet" type="text/css" />

        <link href="{{asset("css/close-button.css")}}" rel="stylesheet" type="text/css" />
        <!--Daterangepicker-->
        <link rel="stylesheet" href="{{asset("lb-faveo/css/bootstrap-datetimepicker4.7.14.min.css")}}" rel="stylesheet" type="text/css" />

        <link href="{{asset("lb-faveo/plugins/summernote/summernote-bs5.min.css")}}" rel="stylesheet" type="text/css" />

        <link href="{{asset("lb-faveo/css/jquery.ui.3.2.0.css")}}" rel="stylesheet" type="text/css" />
        <!-- Colorpicker -->

        <link href="{{asset("lb-faveo/plugins/colorpicker/bootstrap-colorpicker.min.css")}}" rel="stylesheet" type="text/css" />

         <script src="{{asset("lb-faveo/js/jquery-3.6.3.min.js")}}" type="text/javascript"></script>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

         <script src="{{asset("lb-faveo/js/jquery-migrate.js")}}" type="text/javascript"></script>
          <script src="{{asset("lb-faveo/js/jquery.ui.3.2.0.js")}}" type="text/javascript"></script>
        <script src="{{asset("lb-faveo/js/popper.min.js")}}" type="text/javascript"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="{{asset("lb-faveo/js/bootstrap4.min.js")}}" type="text/javascript"></script>
        @yield('HeadInclude')

        <style type="text/css">

            .dataTables_wrapper table {display: table !important;}

            .product-description { overflow: visible !important;white-space: unset !important; }

            .noti_User { color: #6c757d !important; }

            .brand-image{float: none !important; margin-left: 0 !important;}

            .table { display: block;width: 100%;overflow-x: auto; }

            td{ word-break: break-all !important; }

            .table { width: 100% !important;display: table !important; }

            .list-group-item{ margin-bottom: auto !important; }

            .help-block { color : #dd4b39; }

             .text-red { color: red; }

             .nav-sidebar .nav-header:not(:first-of-type) {
                padding: 0.5rem;
            }

           .has-error label {
                color: #dd4b39 !important;
            }

            .has-error .form-control {
                border-color: #dd4b39 !important;
                box-shadow: none;
            }

            .btn.disabled, .btn[disabled], fieldset[disabled] .btn {
                box-shadow: none;
                cursor: not-allowed;
                opacity: 0.65;
                pointer-events: none;
            }
        </style>
    </head>
    <body class="skin-yellow sidebar-mini layout-fixed layout-navbar-fixed text-sm">

        <?php
        $replacetop = 0;
        $replacetop = \Illuminate\Support\Facades\Event::dispatch('service.desk.admin.topbar.replace', []);
        if (count($replacetop) == 0) {
            $replacetop = 0;
        } else {
            $replacetop = $replacetop[0];
        }
        $replaceside = 0;
        $replaceside = \Illuminate\Support\Facades\Event::dispatch('service.desk.admin.sidebar.replace', []);
        if (count($replaceside) == 0) {
            $replaceside = 0;
        } else {
            $replaceside = $replaceside[0];
        }
        //dd($replacetop);
        ?>

        <div class="wrapper">

            <nav class="main-header navbar navbar-expand  navbar-light">

                <!-- Sidebar toggle button-->
                <ul class="navbar-nav">

                    <li class="nav-item">

                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>

                <?php $notifications = App\Http\Controllers\Common\NotificationController::getNotifications(); ?>

                <ul class="navbar-nav">

                    @if($replacetop==0)
                    <li class="nav-item d-none d-sm-inline-block">

                        <a id="dash" @yield('settings') href="{!! url('dashboard') !!}"  class="nav-link">
                            {!! Lang::get('lang.agent_panel') !!}
                        </a>
                    </li>
                    @else
                    <?php \Illuminate\Support\Facades\Event::dispatch('service.desk.admin.topbar', []); ?>
                    @endif
                </ul>

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="{{url('admin')}}" class="nav-link">{!! Lang::get('lang.admin_panel') !!}</a>
                    </li>

                    @include('themes.default1.update.notification')

                    <li class="nav-item dropdown notifications-menu" id="myDropdown">

                        <a href="#" class="nav-link" data-toggle="dropdown" onclick="myFunction()">

                            <i class="fas fa-bell"></i>

                            <span class="badge badge-warning navbar-badge" id="count">{!! $notifications->count() !!}</span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">

                            <div id="alert11" class="alert alert-success alert-dismissable" style="display:none;">

                                <button id="dismiss11" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                                <h4><i class="icon fas fa-check"></i>Alert!</h4>

                                <div id="message-success1"></div>
                            </div>

                            <ul class="products-list product-list-in-card pl-2 pr-2" style="height: 350px;overflow-y: scroll;">

                                <li class="dropdown-header">You have {!! $notifications->count() !!} notifications.

                                    <a class="float-right" id="read-all" href="#">Mark all as read.</a>
                                </li>

                                @if($notifications->count())
                                @foreach($notifications->orderBy('created_at', 'desc')->get()->take(10) as $notification)

                                @if($notification->notification->type->type == 'registration')
                                @if($notification->is_read == 1)

                                <li class="item" class="task">

                                    <div class="product-img">

                                        <img src="{{$notification -> users -> profile_pic}}" alt="Product Image" class="img-size-50 img-circle">
                                    </div>

                                    <div class="product-info">

                                        <span class="product-description">

                                            <a href="{!! route('user.show', $notification->notification->model_id) !!}" id="{{$notification -> notification_id}}"
                                                class='noti_User'>{!! $notification->notification->type->message !!}
                                            </a>
                                        </span>
                                    </div>
                                </li>

                                @else

                                <li class="item">

                                    <div class="product-img">

                                        <img src="{{$notification -> users -> profile_pic}}" alt="Product Image" class="img-size-50 img-circle">
                                    </div>

                                    <div class="product-info">

                                        <span class="product-description">

                                            <a href="{!! route('user.show', $notification->notification->model_id) !!}" id="{{$notification -> notification_id}}"
                                                class='noti_User'>{!! $notification->notification->type->message !!}
                                            </a>
                                        </span>
                                    </div>
                                </li>
                                @endif
                                @else
                                @if($notification->is_read == 1)

                                <li class="item" class="task">

                                    <div class="product-img">

                                        <img src="{{$notification -> users -> profile_pic}}" alt="Product Image" class="img-size-50 img-circle">
                                    </div>

                                    <div class="product-info">

                                        <span class="product-description">

                                            <a href="{!! route('ticket.thread', $notification->notification->model_id) !!}" id='{{ $notification -> notification_id}}'
                                                class='noti_User'>
                                                {!! $notification->notification->type->message !!} with id "{!!$notification->notification->model->ticket_number!!}"
                                            </a>
                                        </span>
                                    </div>
                                </li>

                                @elseif($notification->notification->model)

                                <li class="item">

                                    <div class="product-img">

                                        <img src="{{$notification -> users -> profile_pic}}" alt="Product Image" class="img-size-50 img-circle">
                                    </div>

                                    <div class="product-info">

                                        <span class="product-description">

                                            <a href="{!! route('ticket.thread', $notification->notification->model_id) !!}" id='{{ $notification -> notification_id}}'
                                                class='noti_User'>
                                                {!! $notification->notification->type->message !!} with id "{!!$notification->notification->model->ticket_number!!}"
                                            </a>
                                        </span>
                                    </div>
                                </li>
                                @endif
                                @endif
                                @endforeach
                                @endif

                                <li class="item" style="position: relative;top: -5px;">

                                    <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}" style="display: none;margin-left: 100px;" id="notification-loader"
                                        class="img-size-50">
                                </li>

                                <li class="dropdown-footer"><a class="text-dark" href="{{ url('notifications-list')}}">View all</a>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item dropdown">

                        <?php $src = Lang::getLocale().'.png'; ?>

                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <img src="{{asset("lb-faveo/flags/$src")}}">
                        </a>

                       <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right p-0" style="width: 290px;">

                           @foreach($langs as $key => $value)
                            <?php $src = $key.".png"; ?>
                            <a href="#" class="dropdown-item" id="{{$key}}" onclick="changeLang(this.id)"><img src="{{asset("lb-faveo/flags/$src")}}">&nbsp;{{$value[0]}}&nbsp;
                            @if(Lang::getLocale() == "ar")
                            &rlm;
                            @endif
                            ({{$value[1]}})</a>
                            @endforeach
                       </div>
                    </li>

                    <li class="nav-item dropdown user-menu">

                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            @if(Auth::user())
                            <img src="{{Auth::user()->profile_pic}}"class="user-image img-circle elevation-2" alt="User Image"/>
                            <span class="d-none d-md-inline">{!! Auth::user()->first_name." ".Auth::user()->last_name !!}</span>
                            @endif
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right">
                            <!-- User image -->
                            <li class="user-header bg-secondary"  style="background-color:#343F44;">
                                @if(Auth::user())
                                <img src="{{Auth::user()->profile_pic}}" class="img-circle elevation-2" alt="User Image" />

                                <p style="margin-top: 0px;">{!! Auth::user()->first_name !!}{!! " ". Auth::user()->last_name !!}
                                    <small class="text-capitalize">{{Auth::user()->role}}</small>
                                </p>
                                @endif
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">

                                <a href="{{url('admin-profile')}}" class="btn btn-primary btn-flat">{!! Lang::get('lang.profile') !!}</a>

                                <a href="{{url('auth/logout')}}" class="btn btn-danger btn-flat float-right">{!! Lang::get('lang.sign_out') !!}</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar elevation-4 sidebar-dark-orange">

                <a href="http://www.faveohelpdesk.com" class="brand-link navbar-dark" style="text-align: center;">
                    <img src="{{ asset('lb-faveo/media/images/logo.png')}}" class="brand-image" alt="Company Log0">
                </a>

                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">

                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">

                       <div class="image">

                            <img id="sidebar-profile-img" src="{{Auth::user()->profile_pic}}" alt="User Image" width="auto" height="auto"
                                class="img-circle elevation-2" style="width: 30px;height: 30px;">
                        </div>

                       <div class="info">
                            @if(Auth::user())
                           <a class="d-block" href="{!! url('profile') !!}">{!! Auth::user()->first_name !!}{!! " ". Auth::user()->last_name !!}</a>
                            @endif
                       </div>
                    </div>

                    <nav class="mt-2">

                        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                            @if($replaceside==0)

                            <li class="nav-header">{!! Lang::get('lang.settings-2') !!}</li>

                            <li @yield('staff-menu-parent') class="nav-item">

                                <a  href="#" @yield('Staffs') class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>{!! Lang::get('lang.staffs') !!} <i class="right fas fa-angle-left"></i></p>
                                </a>

                                <ul @yield('staff-menu-open') class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="{{ url('agents') }}" @yield('agents') class="nav-link">
                                            <i class="nav-icon fas fa-user "></i>
                                            <p>{!! Lang::get('lang.agents') !!}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ url('departments') }}" @yield('departments') class="nav-link">
                                            <i class="nav-icon fas fa-sitemap"></i>
                                            <p>{!! Lang::get('lang.departments') !!}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ url('teams') }}" @yield('teams') class="nav-link">
                                            <i class="nav-icon fas fa-users"></i>
                                            <p>{!! Lang::get('lang.teams') !!}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ url('groups') }}" @yield('groups') class="nav-link">
                                            <i class="nav-icon fas fa-object-group"></i>
                                            <p>{!! Lang::get('lang.groups') !!}</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li @yield('email-menu-parent') class="nav-item">

                                <a href="#" @yield('Emails') class="nav-link">
                                    <i class="nav-icon fas fa-envelope"></i>
                                    <p>{!! Lang::get('lang.email') !!} <i class="fas fa-angle-left right"></i></p>
                                </a>

                                <ul @yield('email-menu-open') class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="{{ url('emails') }}" @yield('emails') class="nav-link">
                                            <i class="nav-icon fas fa-envelope"></i>
                                            <p>{!! Lang::get('lang.emails') !!}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ url('banlist') }}" @yield('ban') class="nav-link">
                                            <i class="nav-icon fas fa-ban"></i>
                                            <p>{!! Lang::get('lang.ban_lists') !!}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ url('template-sets') }}" @yield('template') class="nav-link">
                                            <i class="nav-icon fas fa-reply"></i>
                                            <p>{!! Lang::get('lang.templates') !!}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{url('getemail')}}" @yield('email') class="nav-link">
                                            <i class="nav-icon fas fa-at"></i>
                                            <p>{!! Lang::get('lang.email-settings') !!}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ url('queue') }}" @yield('queue') class="nav-link">
                                            <i class="nav-icon fas fa-upload"></i>
                                            <p>{!! Lang::get('lang.queues') !!}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ url('getdiagno') }}" @yield('diagnostics') class="nav-link">
                                            <i class="nav-icon fas fa-plus"></i>
                                            <p>{!! Lang::get('lang.diagnostics') !!}</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li @yield('manage-menu-parent') class="nav-item">

                                <a href="#" @yield('Manage') class="nav-link">
                                    <i class="nav-icon fas fa-cubes"></i>
                                    <p>{!! Lang::get('lang.manage') !!} <i class="fas fa-angle-left right"></i></p>
                                </a>

                                <ul @yield('manage-menu-open') class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="{{url('helptopic')}}" @yield('help') class="nav-link">
                                            <i class="nav-icon fas fa-file-alt"></i>
                                            <p>{!! Lang::get('lang.help_topics') !!}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{url('sla')}}" @yield('sla') class="nav-link">
                                            <i class="nav-icon fas fa-clock"></i>
                                            <p>{!! Lang::get('lang.sla_plans') !!}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{url('forms')}}" @yield('forms') class="nav-link">
                                            <i class="nav-icon fas fa-file-alt"></i>
                                            <p>{!! Lang::get('lang.forms') !!}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{url('workflow')}}" @yield('workflow') class="nav-link">
                                            <i class="nav-icon fas fa-sitemap"></i>
                                            <p>{!! Lang::get('lang.workflow') !!}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{url('ticket/priority')}}" @yield('priority') class="nav-link">
                                            <i class="nav-icon fas fa-asterisk"></i>
                                            <p>{!! Lang::get('lang.priority') !!}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{url('url/settings')}}" @yield('url') class="nav-link">
                                            <i class="nav-icon fas fa-server"></i>
                                            <p>{!! Lang::get('lang.url') !!}</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li @yield('ticket-menu-parent') class="nav-item">

                                <a href="#" @yield('Tickets') class="nav-link">
                                    <i class="nav-icon fas fa-ticket-alt"></i>
                                    <p>{!! Lang::get('lang.tickets') !!} <i class="fas fa-angle-left right"></i></p>
                                </a>

                                <ul @yield('ticket-menu-open') class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="{{url('getticket')}}" @yield('tickets') class="nav-link">
                                            <i class="nav-icon fas fa-file-alt"></i>
                                            <p>{!! Lang::get('lang.ticket') !!}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{url('getresponder')}}" @yield('auto-response') class="nav-link">
                                            <i class="nav-icon fas fa-reply-all"></i>
                                            <p>{!! Lang::get('lang.auto_response') !!}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{url('getalert')}}" @yield('alert') class="nav-link">
                                            <i class="nav-icon fas fa-bell"></i>
                                            {!! Lang::get('lang.alert_notices') !!}
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{url('setting-status')}}" @yield('status') class="nav-link">
                                            <i class="nav-icon fas fa-plus-square"></i>
                                            <p>{!! Lang::get('lang.status') !!}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{url('getratings')}}" @yield('ratings') class="nav-link">
                                            <i class="nav-icon fas fa-star"></i>
                                            <p>{!! Lang::get('lang.ratings') !!}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{url('close-workflow')}}" @yield('close-workflow') class="nav-link">
                                            <i class="nav-icon fa fa-sitemap"></i>
                                            <p>{!! Lang::get('lang.close-workflow') !!}</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li @yield('settings-menu-parent') class="nav-item">

                                <a href="#" @yield('Settings') class="nav-link">
                                    <i class="nav-icon fas fa-cog"></i>
                                    <p>{!! Lang::get('lang.settings') !!} <i class="fas fa-angle-left right"></i></p>
                                </a>

                                <ul @yield('settings-menu-open') class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="{{url('getcompany')}}" @yield('company') class="nav-link">
                                            <i class="nav-icon fas fa-building"></i>
                                            <p>{!! Lang::get('lang.company') !!}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{url('getsystem')}}" @yield('system') class="nav-link">
                                            <i class="nav-icon fas fa-laptop"></i>
                                            <p>{!! Lang::get('lang.system') !!}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ url('social/media') }}" @yield('social-login') class="nav-link">
                                            <i class="nav-icon fas fa-globe"></i>
                                            <p>{!! Lang::get('lang.social-login') !!}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{url('languages')}}" @yield('languages') class="nav-link">
                                            <i class="nav-icon fas fa-language"></i>
                                            <p>{!! Lang::get('lang.language') !!}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{url('job-scheduler')}}" @yield('cron') class="nav-link">
                                            <i class="nav-icon fas fa-hourglass"></i>
                                            <p>{!! Lang::get('lang.cron') !!}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{url('security')}}" @yield('security') class="nav-link">
                                            <i class="nav-icon fas fa-lock"></i>
                                            <p>{!! Lang::get('lang.security') !!}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{url('settings-notification')}}" @yield('notification') class="nav-link">
                                            <i class="nav-icon fas fa-bell"></i>
                                            <p>{!! Lang::get('lang.notifications') !!}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{url('storage')}}" @yield('storage') class="nav-link">
                                            <i class="nav-icon fas fa-save"></i>
                                            <p>{!! Lang::get('storage::lang.storage') !!}</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li @yield('error-menu-parent') class="nav-item">

                                <a href="#" @yield('error-bugs') class="nav-link">
                                    <i class="nav-icon fas fa-heartbeat"></i>
                                    <p>{!! Lang::get('lang.error-debug') !!} <i class="fas fa-angle-left right"></i></p>
                                </a>

                                <ul @yield('error-menu-open') class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="{{ route('err.debug.settings') }}" @yield('debugging-option') class="nav-link">
                                            <i class="nav-icon fas fa-bug"></i>
                                            <p>{!! Lang::get('lang.debug-options') !!}</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li @yield('widget-menu-parent') class="nav-item">

                                <a href="#" @yield('Themes') class="nav-link">
                                    <i class="nav-icon fas fa-chart-pie"></i>
                                    <p>{!! Lang::get('lang.widgets') !!} <i class="fas fa-angle-left right"></i></p>
                                </a>

                                <ul @yield('widget-menu-open') class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="{{ url('widgets') }}" @yield('widget') class="nav-link">
                                            <i class="nav-icon fas fa-list-alt"></i>
                                            <p>{!! Lang::get('lang.widgets') !!}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ url('social-buttons') }}" @yield('social') class="nav-link">
                                            <i class="nav-icon fas fa-cubes"></i>
                                            <p>{!! Lang::get('lang.social') !!}</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('plugins') }}" @yield('Plugins') class="nav-link">
                                    <i class="nav-icon fas fa-plug"></i>
                                    <p>{!! Lang::get('lang.plugin') !!}</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('api') }}" @yield('API') class="nav-link">
                                    <i class="nav-icon fas fa-cogs"></i>
                                    <p>{!! Lang::get('lang.api') !!}</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('logs') }}" @yield('Log') class="nav-link">
                                    <i class="nav-icon fas fa-lock"></i>
                                    <p>Logs</p>
                                </a>
                            </li>
                            @endif
                            <?php \Illuminate\Support\Facades\Event::dispatch('service.desk.admin.sidebar', []); ?>
                        </ul>
                    </nav>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <div class="content-wrapper" style="padding-bottom: 1px;">

                <div class="content-header">
                  <div class="container-fluid">
                    <div class="row mb-2">
                      <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@yield('PageHeader')</h1>
                      </div><!-- /.col -->
                      <div class="col-sm-6">

                        {!! Breadcrumbs::render() !!}
                      </div><!-- /.col -->
                    </div><!-- /.row -->
                  </div><!-- /.container-fluid -->
                </div>

                <section class="content">

                    <div class="container-fluid">

                    </div>
                </section>

                <!-- Main content -->
                <section class="content">

                    @if($dummy_installation == 1 || $dummy_installation == '1')

                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fas  fa-exclamation-triangle"></i> {{Lang::get('lang.dummy_data_installation_message')}}
                        <a href="{{route('clean-database')}}">{{Lang::get('lang.click')}}</a> {{Lang::get('lang.clear-dummy-data')}}
                    </div>

                    @elseif (!$is_mail_conigured)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="callout callout-warning bg-warning">
                                <p>
                                    <i class="fas fa-exclamation-triangle"></i>
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
                <!-- /.content-wrapper -->
            </div>

            <footer class="main-footer">

                <div class="float-right d-none d-sm-block">

                    <span style="font-weight: 500">{!! Lang::get('lang.version') !!}</span> {!! Config::get('app.version') !!}
                </div>

                <span style="font-weight: 500">{!! Lang::get('lang.copyright') !!} &copy; {!! date('Y') !!}  <a href="{!! $company->website !!}" target="_blank">{!! $company->company_name !!}</a>.</span> {!! Lang::get('lang.all_rights_reserved') !!}. {!! Lang::get('lang.powered_by') !!} <a href="http://www.faveohelpdesk.com/" target="_blank">Faveo</a>
            </footer>
        </div><!-- ./wrapper -->

        <script src="{{asset("lb-faveo/adminlte3/js/adminlte3.2.0.min.js")}}" type="text/javascript"></script>
        <!-- Slimscroll -->
        <script src="{{asset("lb-faveo/adminlte3/plugins/overlayScrollbars/overlayScrollbars3.2.0.min.js")}}" type="text/javascript"></script>

        <script src="{{asset("lb-faveo/plugins/datatables/jquery.dataTables.3.2.0.js")}}" type="text/javascript"></script>

        <script src="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap4.3.2.0.js")}}" type="text/javascript"></script>

        <script src="{{asset("lb-faveo/js/jquery.rating.pack.js")}}" type="text/javascript"></script>

        <script src="{{asset("lb-faveo/plugins/select2/select2.full.3.2.0.min.css.js")}}" type="text/javascript"></script>

        <script src="{{asset("lb-faveo/plugins/moment/moment.3.2.0.js")}}" type="text/javascript"></script>

        <!-- full calendar-->
        <script src="{{asset('lb-faveo/plugins/fullcalendar/fullcalendar.min.js')}}" type="text/javascript"></script>

        <script src="{{asset('lb-faveo/plugins/daterangepicker/daterangepicker.3.2.0.js')}}" type="text/javascript"></script>

        <script src="{{asset("lb-faveo/js/bootstrap-datetimepicker4.7.14.min.js")}}" type="text/javascript"></script>

        <script src="{{asset("lb-faveo/plugins/summernote/summernote-bs5.min.js")}}" type="text/javascript"></script>

        <script src="{{asset("lb-faveo/plugins/iCheck/icheck.min.js")}}" type="text/javascript"></script>

        <!-- Colorpicker -->
        <script src="{{asset("lb-faveo/plugins/colorpicker/bootstrap-colorpicker.min.js")}}" ></script>

        @if (trim($__env->yieldContent('no-toolbar')))
            <h1>@yield('no-toolbar')</h1>
        @else
            <script>
            $(function () {
            //Add text editor
                $("textarea").summernote({
                    height: 300,
                    tabsize: 2,
                    toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']]
                  ]
                  });
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

    <!-- CK Editor -->
    <script src="{{asset("lb-faveo/plugins/filebrowser/plugin.js")}}"></script>
    <script src="{{asset("lb-faveo/js/languagechanger.js")}}" type="text/javascript"></script>
    @yield('FooterInclude')
</body>
</html>
