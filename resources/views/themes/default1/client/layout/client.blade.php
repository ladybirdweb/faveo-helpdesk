<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <?php
        $title = App\Model\helpdesk\Settings\System::where('id', '=', '1')->first();
        if (isset($title->name)) {
            $title_name = $title->name;
        } else {
            $title_name = "SUPPORT CENTER";
        }
        ?>
        <title> @yield('title') {!! strip_tags($title_name) !!} </title>
        <!-- faveo favicon -->
        <link href="{{asset("lb-faveo/media/images/favicon.ico")}}"  rel="shortcut icon" >


        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap  4.0.0 -->  
        
        <link href="{{asset("lb-faveo/css/bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- Admin LTE CSS3 -->
        <link href="{{asset("lb-faveo/css/AdminLTEsemi.css")}}" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="{{asset("lb-faveo/css/font-awesome.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="{{asset("lb-faveo/css/ionicons.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- fullCalendar 2.2.5-->
        <link href="{{asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css")}}" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="{{asset("lb-faveo/css/jquery.rating.css")}}" rel="stylesheet" type="text/css" />

        <link href="{{asset("lb-faveo/css/app.css")}}" rel="stylesheet" type="text/css" />

        <link href="{{asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css")}}" rel="stylesheet" type="text/css" />

        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="{{asset("lb-faveo/js/jquery2.1.1.min.js")}}" type="text/javascript"></script>
        @yield('HeadInclude')
    </head>
    <body>
    <!-- <style>
        .site-navigation{
            padding-left: 10px;
            padding-right: 10px;
        }
        </style> -->
        <div id="page" class="hfeed site">
            <header id="masthead" class="site-header" role="banner">
                <div class="container" style="">
                    <div id="logo" class="site-logo text-center" style="font-size: 30px;">
                        <?php
                        $company = App\Model\helpdesk\Settings\Company::where('id', '=', '1')->first();
                        $system = App\Model\helpdesk\Settings\System::where('id', '=', '1')->first();
                        ?>
                        @if($system->url)
                        <a href="{!! $system->url !!}" rel="home">
                            @else
                            <a href="{{url('/')}}" rel="home">
                                @endif
                                @if($company->use_logo == 1)
                                <img src="{{asset('uploads/company')}}{{'/'}}{{$company->logo}}" alt="User Image" width="200px" height="200px"/>
                                @else
                                @if($system->name)
                                {!! $system->name !!}
                                @else
                                <b>SUPPORT</b> CENTER
                                @endif
                                @endif
                            </a>
                    </div><!-- #logo -->
                    <button style="float: right;margin: 10px;" class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="navbar" aria-controls="#navbar" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button> <!-- collapse -->
                    <div id="navbar" class="navbar-wrapper text-center">
                         <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
                     <nav class="navbar navbar-light bg-light site-navigation navbar-expand-md" role="navigation">
                            <ul class="navbar-nav navbar-menu">
                        
                            <li class="nav-item active" @yield('home')><a class="nav-link" href="{{url('/')}}">{!! Lang::get('lang.home') !!}</a></li>
                                @if($system->first()->status == 1)
                                <li class="nav-item" @yield('submit')><a class="nav-link" href="{{URL::route('form')}}">{!! Lang::get('lang.submit_a_ticket') !!}</a></li>
                                @endif
                                <li  class="nav-item dropdown" @yield('kb')><a class="dropdowntoggle nav-link" href="{!! url('knowledgebase') !!}">{!! Lang::get('lang.knowledge_base') !!}</a>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                                        <li><a class="dropdown-item" href="{{route('category-list')}}">{!! Lang::get('lang.categories') !!}</a></li>
                                        <li class="dropdown-submenu"><a class="dropdown-item" href="{{route('article-list')}}">{!! Lang::get('lang.articles') !!}</a></li>
                                        <!-- <li class="dropdown-submenu"><a href="{{route('category-list')}}">{!! Lang::get('lang.categories') !!}</a></li> -->

                                    </ul>
                                    
                                </li>
                                <?php $pages = App\Model\kb\Page::where('status', '1')->where('visibility', '1')->get();
                                ?>
                                @foreach($pages as $page)
                                <li><a href="{{route('pages',$page->slug)}}">{{$page->name}}</a></li>
                                @endforeach
                                
                                @if(Auth::user())
                                <li class="nav-item" @yield('myticket')><a class="nav-link" href="{{url('mytickets')}}">{!! Lang::get('lang.my_tickets') !!}</a></li>

                                {{-- <li class="nav-item" @yield('contact')><a class="nav-link" href="{{route('contact')}}">Contact us</a></li> --}}
                                <li class="nav-item dropdown" @yield('profile')><a class="dropdowntoggle nav-link" href="#" >{!! Lang::get('lang.my_profile') !!}</a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                                        <li>
                                            <div class="banner-wrapper user-menu text-center clearfix">
                                                <img src="{{Auth::user()->profile_pic}}"class="img-circle" alt="User Image" height="80" width="80"/>
                                                <h3 class="banner-title text-info h4">{{Auth::user()->first_name." ".Auth::user()->last_name}}</h3>
                                                <div class="banner-content">
                                                    {{-- <a href="{{url('kb/client-profile')}}" class="btn btn-custom btn-xs">{!! Lang::get('lang.edit_profile') !!}</a> --}} <a href="{{url('auth/logout')}}" class="btn btn-custom btn-xs">{!! Lang::get('lang.log_out') !!}</a>
                                                </div>
                                                @if(Auth::user())
                                                @if(Auth::user()->role != 'user')
                                                <div class="banner-content">
                                                    <a href="{{url('dashboard')}}" class="btn btn-custom btn-xs">{!! Lang::get('lang.dashboard') !!}</a>
                                                </div>
                                                @endif
                                                @endif
                                                @if(Auth::user())
                                                @if(Auth::user()->role == 'user')
                                                <div class="banner-content">
                                                    <a href="{{url('client-profile')}}" class="btn btn-custom btn-xs">{!! Lang::get('lang.profile') !!}</a>
                                                </div>
                                                @endif
                                                @endif
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul><!-- .navbar-user -->
                            @else
                            </ul>
                            @if(isset($errors))
                            <ul class="nav navbar-nav navbar-login">
                                <li 
                                <?php
                                if (is_object($errors)) {
                                    if ($errors->first('email') || $errors->first('password')) {
                                        ?> class="sfHover" 
                                            <?php
                                        }
                                    }
                                    ?> 
                                    ><a href="#"  data-toggle="collapse"  
                                        <?php
                                        if (is_object($errors)) {
                                            if ($errors->first('email') || $errors->first('password')) {
                                                
                                            } else {
                                                ?> class="collapsed" 
                                            <?php
                                        }
                                    }
                                    ?> 
                                    data-target="#login-form">{!! Lang::get('lang.login') !!} <i class="sub-indicator fa fa-chevron-circle-down fa-fw text-muted"></i></a></li>
                            </ul><!-- .navbar-login -->
                            @endif
                            <div id="login-form" @if(isset($errors))<?php if ($errors->first('email') || $errors->first('password')) { ?> class="login-form collapse fade clearfix in" <?php } else { ?> class="login-form collapse fade clearfix" <?php } ?>@endif >
                                 <div class="row">
                                    <div class="col-md-12">
                                        {!!  Form::open(['action'=>'Auth\AuthController@postLogin', 'method'=>'post']) !!}
                                        @if(Session::has('errors'))
                                        @if(Session::has('check'))
                                        <?php goto b; ?>
                                        @endif
                                        @if(Session::has('error'))
                                        <div class="alert alert-danger alert-dismissable">
                                            
                                            {!! Session::get('error') !!}
                                           
                                        </div>
                                         @endif
                                        <?php b: ?>
                                        @endif
                                        <div class="form-group has-feedback @if(isset($errors)) {!! $errors->has('email') ? 'has-error' : '' !!} @endif">
                                            {!! Form::text('email',null,['placeholder'=>Lang::get('lang.e-mail'),'class' => 'form-control']) !!}
                                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                        </div>
                                        <div class="form-group has-feedback @if(isset($errors)) {!! $errors->has('password') ? 'has-error' : '' !!} @endif">
                                            {!! Form::password('password',['placeholder'=>Lang::get('lang.password'),'class' => 'form-control']) !!}
                                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                            <?php \Event::fire('auth.login.form'); ?>
                                            <a href="{{url('password/email')}}" style="font-size: .8em" class="pull-left">{!! Lang::get('lang.forgot_password') !!}</a>
                                        </div>
                                        <div class="form-group pull-left">
                                         <input type="checkbox" name="remember"> {!! Lang::get("lang.remember") !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-custom  .btn-sm ">{!! Lang::get('lang.login') !!}</button>
                                        {!! Form::close() !!}
                                        </div>
                                    </div>
                                    {{Lang::get('lang.or')}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-unstyled">
                                            <a href="{{url('auth/register')}}" style="font-size: 1.2em">{!! Lang::get('lang.create_account') !!}</a>
                                        </ul>
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        @include('themes.default1.client.layout.social-login')
                                    </div>
                                </div>
                            </div><!-- #login-form -->
                            @endif
                            <!-- <ul class="nav navbar-nav navbar-menu">

                            <li class="dropdown">
                                    <?php $src = Lang::getLocale().'.png'; ?>
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><img src="{{asset("lb-faveo/flags/$src")}}"></img> &nbsp;<span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            @foreach($langs as $key => $value)
                                                <?php $src = $key.".png"; ?>
                                                <li><a href="#" id="{{$key}}" onclick="changeLang(this.id)"><img src="{{asset("lb-faveo/flags/$src")}}"></img>&nbsp;{{$value[0]}}&nbsp;
                                            @if(Lang::getLocale() == "ar")
                                                &rlm;
                                            @endif
                                                ({{$value[1]}})</a></li>
                                            @endforeach       
                                        </ul>
                                </li>
                            </ul> -->
                        </nav><!-- #site-navigation -->
                    </div><!-- #navbar -->
                    <div id="header-search" class="site-search clearfix" style="padding-bottom:5px"><!-- #header-search -->
                        {!!Form::open(['method'=>'get','action'=>'Client\kb\UserController@search','class'=>'search-form clearfix'])!!}
                        <div class="form-border">
                            <div class="form-inline ">
                                <div class="form-group">
                                    <input type="text" name="s" class="search-field form-control input-lg" title="Enter search term" placeholder="{!! Lang::get('lang.have_a_question?_type_your_search_term_here') !!}" required/>
                                </div>
                                <button  type="submit" class="search-submit btn btn-custom btn-lg  pull-right">{!! Lang::get('lang.search') !!}</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
   
    <div class="site-hero clearfix">
  
            
                {!! Breadcrumbs::render() !!}
            </div>
            <!-- Main content -->
            <div id="main" class="site-main clearfix">
                <div class="container">
                    <div class="content-area">
                        <div class="row">
                            @if(Session::has('success'))
                            <div class="alert alert-success alert-dismissable">
                                <i class="fa  fa-check-circle"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{Session::get('success')}}
                            </div>
                            @endif
                            @if(Session::has('warning'))
                            <div class="alert alert-warning alert-dismissable">
                                <i class="fa  fa-check-circle"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {!! Session::get('warning') !!}
                            </div>
                            @endif
                            <!-- failure message -->
                            @if(Session::has('fails'))
                            @if(Session::has('check'))
                            <?php goto a; ?>
                            @endif
                            <div class="alert alert-danger alert-dismissable">
                                <i class="fa fa-ban"></i>
                                <b>{!! Lang::get('lang.alert') !!} !</b>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{Session::get('fails')}}
                            </div>
                            <?php a: ?>
                            @endif
                            @yield('content')
                            <div id="sidebar" class="site-sidebar col-md-3">
                                <div class="widget-area">
                                    <section id="section-banner" class="section">
                                        @yield('check')
                                    </section><!-- #section-banner -->
                                    <section id="section-categories" class="section">
                                        @yield('category')
                                    </section><!-- #section-categories -->
                                </div>
                            </div><!-- #sidebar -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-wrapper -->
            <?php
            $footer1 = App\Model\helpdesk\Theme\Widgets::where('name', '=', 'footer1')->first();
            $footer2 = App\Model\helpdesk\Theme\Widgets::where('name', '=', 'footer2')->first();
            $footer3 = App\Model\helpdesk\Theme\Widgets::where('name', '=', 'footer3')->first();
            $footer4 = App\Model\helpdesk\Theme\Widgets::where('name', '=', 'footer4')->first();
            ?>
            <footer id="colophon" class="site-footer" role="contentinfo">
                <div class="container">
                    <div class="row col-md-12">
                        @if($footer1->title == null)
                        @else
                        <div class="col-md-3">
                            <div class="widget-area">
                                <section id="section-about" class="section">
                                    <h2 class="section-title h4 clearfix">{!!$footer1->title!!}</h2>
                                    <div class="textwidget">
                                        <p>{!!$footer1->value!!}</p>
                                    </div>
                                </section><!-- #section-about -->
                            </div>
                        </div>
                        
                        <!-- <div class=""> -->
                        @endif
                        @if($footer2->title == null)
                        @else
                        <div class="col-md-3">
                            <div class="widget-area">
                                <section id="section-latest-news" class="section">
                                    <h2 class="section-title h4 clearfix">{!!$footer2->title!!}</h2>
                                    <div class="textwidget">
                                        <p>{!! $footer2->value !!}</p>
                                    </div>
                                </section><!-- #section-latest-news -->
                            </div>
                        </div>
                        @endif
                        @if($footer3->title == null)
                        @else
                        <div class="col-md-3"> 
                            <div class="widget-area">
                                <section id="section-newsletter" class="section">
                                    <h2 class="section-title h4 clearfix">
                                    {!!$footer3->title!!}</h2>
                                    <div class="textwidget">
                                        <p> {!! $footer3->value !!}</p>
                                    </div>
                                
                                </section><!-- #section-newsletter -->
                            </div>
                        </div>
                        @endif
                        @if($footer4->title == null)
                        @else
                        <div class="col-md-3">
                            <div class="widget-area">
                                <section id="section-newsletter" class="section">
                                    <h2 class="section-title h4 clearfix">{{$footer4->title}}</h2>
                                    <div class="textwidget">
                                        <p>{!! $footer4->value !!}</p>
                                    </div>
                                </section>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="clearfix"></div>
                    <hr style="color:#E5E5E5"/>
                    
                    <div class="row">
                        
                        <div class="site-info col-md-6">
                            <p class="text-muted">{!! Lang::get('lang.copyright') !!} &copy; {!! date('Y') !!}  <a href="{!! $company->website !!}" target="_blank">{!! $company->company_name !!}</a>. {!! Lang::get('lang.all_rights_reserved') !!}. {!! Lang::get('lang.powered_by') !!} <a href="http://www.faveohelpdesk.com/"  target="_blank">Faveo</a></p>
                        </div>
                        <div class="site-social text-right col-md-6">
                            <?php $socials = App\Model\helpdesk\Theme\Widgets::all(); ?>
                            <ul class="list-inline hidden-print">
                                @foreach($socials as $social)
                                @if($social->name == 'facebook')
                                @if($social->value)
                                <li><a href="{!! $social->value !!}" class="btn btn-social btn-facebook" target="_blank"><i class="fa fa-facebook fa-fw"></i></a></li>
                                @endif
                                @endif
                                @if($social->name == "twitter")
                                @if($social->value)
                                <li><a href="{{ $social->value }}" class="btn btn-social btn-twitter" target="_blank"><i class="fa fa-twitter fa-fw"></i></a></li>
                                @endif
                                @endif
                                @if($social->name == "google")
                                @if($social->value)
                                <li><a href="{{$social->value}}" class="btn btn-social btn-google-plus" target="_blank"><i class="fa fa-google-plus fa-fw"></i></a></li>
                                @endif
                                @endif
                                @if($social->name == "linkedin")
                                @if($social->value)
                                <li><a href="{{$social->value}}" class="btn btn-social btn-linkedin" target="_blank"><i class="fa fa-linkedin fa-fw"></i></a></li>
                                @endif
                                @endif
                                @if($social->name == "vimeo")
                                @if($social->value)
                                <li><a href="{{$social->value}}" class="btn btn-social btn-vimeo" target="_blank"><i class="fa fa-vimeo-square fa-fw"></i></a></li>
                                @endif
                                @endif
                                @if($social->name == "youtube")
                                @if($social->value)
                                <li><a href="{{$social->value}}" class="btn btn-social btn-youtube" target="_blank"><i class="fa fa-youtube-play fa-fw"></i></a></li>
                                @endif
                                @endif
                                @if($social->name == "pinterest")
                                @if($social->value)
                                <li><a href="{{$social->value}}" class="btn btn-social btn-pinterest" target="_blank"><i class="fa fa-pinterest fa-fw"></i></a></li>
                                @endif
                                @endif
                                @if($social->name == "dribbble")
                                @if($social->value)
                                <li><a href="{{$social->value}}" class="btn btn-social btn-dribbble" target="_blank"><i class="fa fa-dribbble fa-fw"></i></a></li>
                                @endif
                                @endif
                                @if($social->name == "flickr")
                                @if($social->value)
                                <li><a href="{{$social->value}}" class="btn btn-social btn-flickr" target="_blank"><i class="fa fa-flickr fa-fw"></i></a></li>
                                @endif
                                @endif
                                @if($social->name == "instagram")
                                @if($social->value)
                                <li><a href="{{$social->value }}" class="btn btn-social btn-instagram" target="_blank"><i class="fa fa-instagram fa-fw"></i></a></li>
                                @endif
                                @endif
                                @if($social->name == "rss")
                                @if($social->value)
                                <li><a href="{{$social->value}}" class="btn btn-social btn-rss" target="_blank"><i class="fa fa-rss fa-fw"></i></a></li>
                                @endif
                                @endif
                                @if($social->name == "skype")
                                @if($social->value)
                                <li><a href="{{$social->value}}" class="btn btn-social btn-twitter" target="_blank"><i class="fa fa-skype fa-fw"></i></a></li>
                                @endif
                                @endif
                                @if($social->name == "stumble")
                                @if($social->value)
                                <li><a href="{{$social->value}}" class="btn btn-social btn-google-plus" target="_blank"><i class="fa fa-stumbleupon fa-fw"></i></a></li>
                                @endif
                                @endif
                                @if($social->name == "deviantart")
                                @if($social->value)
                                <li><a href="{{$social->value}}" class="btn btn-social btn-success" target="_blank"><i class="fa fa-deviantart fa-fw"></i></a></li>
                                @endif
                                @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
            </footer><!-- #colophon -->
            <!-- jQuery 2.1.1 -->
            <script src="{{asset("lb-faveo/js/jquery2.1.1.min.js")}}" type="text/javascript"></script>
            <!-- Bootstrap 3.3.2 JS -->
            <script src="{{asset("lb-faveo/js/bootstrap.min.js")}}" type="text/javascript"></script>
            <!-- Slimscroll -->
            <script src="{{asset("lb-faveo/js/superfish.js")}}" type="text/javascript"></script>

            <script src="{{asset("lb-faveo/js/mobilemenu.js")}}" type="text/javascript"></script>

            <script src="{{asset("lb-faveo/js/know.js")}}" type="text/javascript"></script>

            <script src="{{asset("lb-faveo/js/jquery.rating.pack.js")}}" type="text/javascript"></script>

            <script src="{{asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}" type="text/javascript"></script>

            <script src="{{asset("lb-faveo/plugins/iCheck/icheck.min.js")}}" type="text/javascript"></script>

            <script src="{{asset("lb-faveo/js/languagechanger.js")}}" type="text/javascript"></script>

            <script src="{{asset("lb-faveo/js/languagechanger.js")}}" type="text/javascript"></script>
            
            <script>
$(function () {
//Enable check and uncheck all functionality
    $(".checkbox-toggle").click(function () {
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
    $(".mailbox-star").click(function (e) {
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
          
    </body>
</html>