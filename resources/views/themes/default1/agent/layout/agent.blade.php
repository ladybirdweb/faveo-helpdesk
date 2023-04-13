<!DOCTYPE html>
<html>
    
    <head>
    
        <meta charset="UTF-8" ng-app="myApp">
    
        <title>Faveo | HELP DESK</title>
    
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    
        <meta name="_token" content="{!! csrf_token() !!}"/>
    
        <!-- faveo favicon -->
        <link href="{{asset("lb-faveo/media/images/favicon.ico")}}" rel="shortcut icon">
    
       <!-- Bootstrap 4.3.1 -->
        <link href="{{asset("lb-faveo/css/bootstrap4.min.css")}}" rel="stylesheet" type="text/css" />
    
        <!-- Font Awesome Icons -->
        <link href="{{asset("lb-faveo/css/font-awesome-5.min.css")}}" rel="stylesheet" type="text/css" />
    
        <!-- Ionicons -->
        <link href="{{asset("lb-faveo/css/ionicons.min.css")}}" rel="stylesheet"  type
        ="text/css" />
    
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

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

        <link href="{{asset("lb-faveo/css/jquery.ui.css")}}" rel="stylesheet" type="text/css" />
        <script src="{{asset("lb-faveo/js/jquery-3.6.3.min.js")}}" type="text/javascript"></script>
        <script src="{{asset("lb-faveo/js/jquery-migrate.js")}}" type="text/javascript"></script>
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

            td{ word-break: break-word !important; }

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
        
        <div class="wrapper">

            <?php
            $replacetop = \Illuminate\Support\Facades\Event::dispatch('service.desk.agent.topbar.replace', []);

            if (count($replacetop) == 0) {
                $replacetop = 0;
            } else {
                $replacetop = $replacetop[0];
            }

            $replaceside = \Illuminate\Support\Facades\Event::dispatch('service.desk.agent.sidebar.replace', []);

            if (count($replaceside) == 0) {
                $replaceside = 0;
            } else {
                $replaceside = $replaceside[0];
            }
            ?>

             <nav class="main-header navbar navbar-expand  navbar-light">
                
                <!-- Sidebar toggle button-->
                <ul class="navbar-nav">
                  
                    <li class="nav-item">
                
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="nav-icon fas fa-bars"></i></a>
                    </li>
                </ul>

                @if($replacetop==0)


                <ul class="navbar-nav">

                    <li class="nav-item d-none d-sm-inline-block">

                        <a id="dash" @yield('Dashboard') href="{{URL::route('dashboard')}}" onclick="clickDashboard(event);" 
                            class="nav-link">
                            {!! Lang::get('lang.dashboard') !!}
                        </a>
                    </li>
                    
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="#tab_user" data-toggle="tab" @yield('Users') class="nav-link" onclick="clickUser(event);" id="user_tab">
                            {!! Lang::get('lang.users') !!}
                        </a>
                    </li>
                    
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="#tab_ticket" data-toggle="tab" @yield('Tickets') class="nav-link" onclick="clickTickets(event);" id="ticket_tab">
                            {!! Lang::get('lang.tickets') !!}
                        </a>
                    </li>
                    
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="#tab_tools" data-toggle="tab" @yield('Tools') class="nav-link" onclick="clickTools(event);" id="tools_tab">
                            {!! Lang::get('lang.tools') !!}
                        </a>
                    </li>
                    
                    @if($auth_user_role == 'admin')
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="{{URL::route('report.index')}}" onclick="clickReport(event);" @yield('Report') class="nav-link">{!! Lang::get('lang.report') !!}</a>
                    </li>
                    @endif
                    
                    <?php \Illuminate\Support\Facades\Event::dispatch('calendar.topbar', []); ?>
                </ul>
                @else
                <?php \Illuminate\Support\Facades\Event::dispatch('service.desk.agent.topbar', []); ?>
                @endif

                <ul class="navbar-nav ml-auto">
                    
                    @if($auth_user_role == 'admin')

                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="{{url('admin')}}" class="nav-link">{!! Lang::get('lang.admin_panel') !!}</a>
                    </li>
                    @endif

                    @include('themes.default1.update.notification')

                    <li class="nav-item dropdown notifications-menu" id="myDropdown">

                        <a href="#" class="nav-link" data-toggle="dropdown" onclick="myFunction()">
                            
                            <i class="nav-icon  fas fa-bell"></i>
                            
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
                            @if($auth_user_id)
                            <img src="{{$auth_user_profile_pic}}"class="user-image img-circle elevation-2" alt="User Image"/>
                            <span class="d-none d-md-inline">{{$auth_name}}</span>
                            @endif
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right">
                            <!-- User image -->
                            <li class="user-header bg-secondary"  style="background-color:#343F44;">

                                <img src="{{$auth_user_profile_pic}}" class="img-circle elevation-2" alt="User Image" />

                                <p style="margin-top: 0px;">{{$auth_name}}
                                    <small class="text-capitalize">{{$auth_user_role}}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                
                                <a href="{{URL::route('profile')}}" class="btn btn-primary btn-flat">{!! Lang::get('lang.profile') !!}</a>
                                
                                <a href="{{url('auth/logout')}}" class="btn btn-danger btn-flat float-right">{!! Lang::get('lang.sign_out') !!}</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar elevation-4 sidebar-dark-black">

                <a href="http://www.faveohelpdesk.com" class="brand-link " style="text-align: center;">
                    <img src="{{ asset('lb-faveo/media/images/logo.png')}}" class="brand-image" alt="Company Log0">
                </a>

                <div class="sidebar">
        
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        @if (trim($__env->yieldContent('profileimg')))
                        <div class="image">
                            @yield('profileimg')
                        </div>
                        @else
                       <div class="image">

                            <img id="sidebar-profile-img" src="{{$auth_user_profile_pic}}" alt="User Image" width="auto" height="auto" 
                                class="img-circle elevation-2" style="width: 30px;height: 30px;">
                        </div>
                        @endif
                       <div class="info">
                            @if($auth_user_id)
                           <a class="d-block" href="{!! url('profile') !!}">{{$auth_name}}</a>
                            @endif
                       </div>
                    </div>

                    <nav class="mt-2">
                        
                        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                            
                            @if($replaceside==0)
                            @yield('sidebar')
                            <li class="nav-header">{!! Lang::get('lang.Tickets') !!}</li>

                            <li class="nav-item">
                                <a href="{{ url('tickets')}}" id="load-inbox" @yield('inbox') class="nav-link">
                                    <i class="nav-icon fas fa-envelope"></i> 
                                    <p>{!! Lang::get('lang.inbox') !!}</p> 
                                    <small class="right badge badge-success">{{$tickets -> count()}}</small>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{url('/tickets?show=mytickets')}}" id="load-myticket" @yield('myticket') class="nav-link">
                                    <i class="nav-icon fas fa-user"></i> 
                                    <p>{!! Lang::get('lang.my_tickets') !!} </p>
                                    <small class="right badge badge-success">{{$myticket -> count()}}</small>
                                </a>
                            </li>

                            <li class="nav-item">
                                 <a href="{{url('/tickets?assigned[]=0')}}" id="load-unassigned" @yield('unassigned')  class="nav-link">
                                    <i class="nav-icon fas fa-th"></i> 
                                    <p>{!! Lang::get('lang.unassigned') !!}</p>
                                    <small class="right badge badge-success">{{$unassigned -> count()}}</small>
                                </a>
                            </li>

                            <li class="nav-item">
                                 <a href="{{url('/tickets?show=overdue')}}" id="load-unassigned" @yield('overdue') class="nav-link">
                                    <i class="nav-icon fas fa-calendar-times"></i> 
                                    <p>{!! Lang::get('lang.overdue') !!}</p>
                                    <small class="right badge badge-success">{{$overdues->count()}}</small>
                                </a>
                            </li>

                            <li class="nav-item">
                                 <a href="{{url('/tickets?show=trash')}}" @yield('trash') class="nav-link">
                                    <i class="nav-icon fas fa-trash"></i> 
                                    <p>{!! Lang::get('lang.trash') !!}</p>
                                    <small class="right badge badge-success">{{$deleted -> count()}}</small>
                                </a>
                            </li>

                            <li class="nav-header">{!! Lang::get('lang.Departments') !!}</li>

                            <?php
                            $flattened = $department->flatMap(function ($values) {
                                return $values->keyBy('status');
                            });
                            $statuses = $flattened->keys();
                            ?>
                            <?php
                                $segments = \Request::segments();
                                $segment = "";
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

                            <li class="nav-item">
                                
                                <a href="#" @if($dept2 === $name) @yield('ticket-bar') @endif class="nav-link">
                                    <i class="nav-icon fas fa-folder-open"></i>
                                    <p>{!! $name !!}<i class="right fas fa-angle-left"></i></p>
                                </a>
                                
                                @foreach($statuses as $status)
                                @if($dept->get($status))

                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="{!! url('tickets?departments='.$name.'&status='.$dept->get($status)->status) !!}" @if($status2 == $dept->get($status)->status && $dept2 === $name) @yield('inbox') @endif class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{!!$dept->get($status)->status !!}</p>
                                            <small class="right badge badge-success">{{$dept->get($status)->count}}</small>
                                        </a>
                                    </li>
                                </ul>
                                @endif
                                @endforeach
                            </li>
                            @endforeach
                            @else

                            <?php \Event::dispatch('service.desk.agent.sidebar', []); ?>
                            @endif
                        </ul>
                    </nav>
                </div>
            </aside>

            <?php
            $agent_group = $auth_user_assign_group;
            $group = App\Model\helpdesk\Agent\Groups::where('id', '=', $agent_group)->first();
            ?>
            <!-- Right side column. Contains the navbar and content of the page -->
            <div class="content-wrapper" style="padding-bottom: 1px;">

                <div class="tab-content" style="position: fixed;z-index: 1;width: 100%;">
                  @if($replacetop==0)
                  <div @yield('user') class="tab-pane" id="tab_user">
                        
                        <nav class="navbar navbar-expand  navbar-light">
                          
                          <ul class="navbar-nav">
                            
                            <li class="nav-item d-none d-sm-inline-block">
                              <a href="{{ url('user')}}" @yield('user-directory') class="nav-link">{!! Lang::get('lang.user_directory') !!}</a>
                            </li>

                            <li class="nav-item d-none d-sm-inline-block">
                              <a href="{{ url('organizations')}}" @yield('organizations') class="nav-link">{!! Lang::get('lang.organizations') !!}</a>
                            </li>
                          </ul>
                        </nav>
                    </div>

                    <div @yield('ticket') class="tab-pane" id="tab_ticket">
                        
                        <nav class="navbar navbar-expand navbar-light">
                          
                          <ul class="navbar-nav">
                            
                            <li class="nav-item d-none d-sm-inline-block">
                              <a href="{{ url('/tickets?last-response-by[]=Client') }}" @yield('open') class="nav-link" id="load-open">{!! Lang::get('lang.not-answered') !!}</a>
                            </li>

                            <li class="nav-item d-none d-sm-inline-block">
                              <a href="{{ url('/tickets?last-response-by[]=Agent')}}" @yield('answered') class="nav-link" id="load-answered">{!! Lang::get('lang.answered') !!}</a>
                            </li>

                            <li class="nav-item d-none d-sm-inline-block">
                              <a href="{{ url('/tickets?assigned[]=1') }}"  @yield('assigned') class="nav-link" id="load-assigned">{!! Lang::get('lang.assigned') !!}</a>
                            </li>

                            <li class="nav-item d-none d-sm-inline-block">
                              <a href="{{ url('/tickets?show=closed') }}" @yield('closed') class="nav-link">{!! Lang::get('lang.closed') !!}</a>
                            </li>

                            <?php if ($group->can_create_ticket == 1) { ?>
                            <li class="nav-item d-none d-sm-inline-block">
                              <a href="{{ url('/newticket')}}" @yield('newticket') class="nav-link">{!! Lang::get('lang.create_ticket') !!}</a>
                            </li>
                            <?php } ?>
                          </ul>
                        </nav>
                    </div>

                    <div @yield('tool') class="tab-pane" id="tab_tools">
                        
                        <nav class="navbar navbar-expand  navbar-light">
                          
                          <ul class="navbar-nav">
                            
                            <li class="nav-item d-none d-sm-inline-block">
                              <a href="{{ url('/canned/list')}}" @yield('tools') class="nav-link">{!! Lang::get('lang.canned_response') !!}</a>
                            </li>

                            <li class="nav-item d-none d-sm-inline-block">
                              <a href="{{ url('/comment')}}" @yield('kb') class="nav-link">{!! Lang::get('lang.knowledge_base') !!}</a>
                            </li>
                          </ul>
                        </nav>
                    </div>
                    @endif
                    <?php \Event::dispatch('service.desk.agent.topsubbar', []); ?>
                  <!-- /.tab-pane -->
                </div>
                <!-- Content Header (Page header) -->
                <div class="tab-content" style="background-color: #80B5D3; position: fixed; width:100% ;padding: 0 0px 0 0px; z-index:999">
                    <div class="collapse navbar-collapse" id="navbar-collapse">
                        <div class="tabs-content">
                            @if($replacetop==0)
                            
                          
                      
                            
                            @endif
<?php \Illuminate\Support\Facades\Event::dispatch('service.desk.agent.topsubbar', []); ?>
                        </div>
                    </div>
                </div>

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
                        
                        @if($dummy_installation == 1 || $dummy_installation == '1')
                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fas  fa-exclamation-triangle"></i> @if (\Auth::user()->role == 'admin')
                                {{Lang::get('lang.dummy_data_installation_message')}} <a href="{{route('clean-database')}}">{{Lang::get('lang.click')}}</a> {{Lang::get('lang.clear-dummy-data')}}
                            @else
                                {{Lang::get('lang.clear-dummy-data-agent-message')}}
                            @endif
                        </div>
                        @elseif (!$is_mail_conigured)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="callout callout-warning bg-warning">    
                                    <p>
                                        <i class="fa fa-exclamation-triangle"></i>
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
                    </div>
                </section>
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
        {{-- jquery ui --}}
        <script src="{{asset("lb-faveo/js/jquery.ui.js")}}" type="text/javascript"></script>
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

        <script src="{{asset("lb-faveo/js/languagechanger.js")}}" type="text/javascript"></script>
        <script src="{{asset("lb-faveo/plugins/filebrowser/plugin.js")}}" type="text/javascript"></script>

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

                    function clickUser(e) {
                        $("#ticket_tab").removeClass("active");
                        $("#tools_tab").removeClass("active");
                        $("#tab_ticket").removeClass("active");
                        $("#tab_ticket").css('display',"none");
                        $("#tab_tools").removeClass("active");
                        $("#tab_tools").css('display',"none");
                        $("#tab_user").css('display',"block");
                    }

                    function clickTickets(e) {
                        $("#user_tab").removeClass("active");
                        $("#tools_tab").removeClass("active");
                        $("#tab_user").removeClass("active");
                        $("#tab_user").css('display',"none");
                        $("#tab_tools").removeClass("active");
                        $("#tab_tools").css('display',"none");
                        $("#tab_ticket").css('display',"block");
                    }

                    function clickTools(e) {
                        $("#ticket_tab").removeClass("active");
                        $("#user_tab").removeClass("active");
                        $("#tab_ticket").removeClass("active");
                        $("#tab_ticket").css('display',"none");
                        $("#tab_tools").css('display',"block");
                        $("#tab_user").removeClass("active");
                        $("#tab_user").css('display',"none");
                    }

            function clickReport(e) {
            if (e.ctrlKey === true) {
            window.open('{{URL::route("report.index")}}', '_blank');
            } else {
            window.location = "{{URL::route('report.index')}}";
            }
            }
        </script>
        <script>
</script>
<?php \Illuminate\Support\Facades\Event::dispatch('show.calendar.script', []); ?>
<?php \Illuminate\Support\Facades\Event::dispatch('load-calendar-scripts', []); ?>
        @yield('FooterInclude')
    </body>
</html>
