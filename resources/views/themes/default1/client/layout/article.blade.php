<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">

        <title> Faveo Knowledge Base</title>

        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- fullCalendar 2.2.5-->
        <link href="{{asset("lb-faveo/plugins/fullcalendar/fullcalendar.min.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{asset("lb-faveo/plugins/fullcalendar/fullcalendar.print.css")}}" rel="stylesheet" type="text/css" media='print' />
        <link href="{{asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="{{asset("lb-faveo/dist/css/app.css")}}" rel="stylesheet" type="text/css" />
        <script src="ckeditor/ckeditor.js"></script>
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        @yield('HeadInclude')
    </head>
    <body>
        <div id="page" class="hfeed site">
            <header id="masthead" class="site-header" role="banner">
                <div class="container">
                    <div id="logo" class="site-logo text-center" style="font-size: 40px">
                        <a href="{{url('/')}}" rel="home"><?php $company = App\Model\kb\Settings::where('id', '=', '1')->first(); ?>
                            @if($company->logo)
                            <img src="{{asset('lb-faveo/dist/image')}}{{'/'}}{{$company->logo}}" class="logo" alt="" width="200"/>
                            @elseif($company->company_name)
                            <b>{{$company->company_name}} </b>
                        @else
                        <b>Knowledge</b> Base
                        @endif
                        </a>
                    </div><!-- #logo -->

                    <div id="navbar" class="navbar-wrapper text-center">
                        <nav class="navbar navbar-default site-navigation" role="navigation">

                            <ul class="nav navbar-nav navbar-menu">
                                <li class="active"><a href="{{route('home')}}">Home</a></li>
                                <li><a href="#">KnowledgeBase</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('article-list')}}">Articles</a></li>  
                                    </ul>
                                </li>
                                </li>
                                <?php $pages = App\Model\kb\Page::where('status', '1')->where('visibility', '1')->get();
                                ?>
                                @foreach($pages as $page)
                                    <li><a href="{{route('pages',$page->name)}}">{{$page->name}}</a></li>
                                @endforeach
                                <li><a href="{{route('contact')}}">Contact us</a></li>

                            @if(Auth::user())


                            <li><a href="#" >My Profile</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <div class="banner-wrapper user-menu text-center clearfix">
                                            @if(Auth::user())
                                    @if(Auth::user()->profile_pic)
                                        <img src="{{asset('lb-faveo/dist/img')}}{{'/'}}{{Auth::user()->profile_pic}}" class="img-circle" alt="User Image"/>
                                    @else
                                        <img src="{{ Gravatar::src(Auth::user()->email) }}" class="img-circle" alt="User Image">
                                    @endif
                                    @endif  
                                            <span class="hidden-xs">{!! Auth::user()->firstname." ".Auth::user()->lastname !!}</span>
                                            <div class="banner-content">
                                                <a href="{{url('client-profile')}}" class="btn btn-custom btn-xs">Edit Profile</a> <a href="{{url('auth/logout')}}" class="btn btn-custom btn-xs">Log out</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            </ul><!-- .navbar-user -->
                            @else
                            <ul class="nav navbar-nav navbar-login">
                                <li><a href="#" class="collapsed" data-toggle="collapse" data-target="#login-form">Login <i class="sub-indicator fa fa-chevron-circle-down fa-fw text-muted"></i></a></li>
                            </ul><!-- .navbar-login -->

                            <div id="login-form" class="login-form collapse fade clearfix">

                                {!!  Form::open(['action'=>'Auth\AuthController@postLogin', 'method'=>'post']) !!}  
                                <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">

                                    {!! Form::text('email',null,['placeholder'=>'Email','class' => 'form-control']) !!}
                                    {!! $errors->first('email', '<spam class="help-block">:message</spam>') !!}
                                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

                                </div>

                                <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                                    {!! Form::password('password',['placeholder'=>'Password','class' => 'form-control']) !!}
                                    {!! $errors->first('password', '<spam class="help-block">:message</spam>') !!}
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                </div>
                                <ul class="list-unstyled pull-left">
                                    <li><a href="{{url('password/email')}}">Forgot password</a><br></li>
                                    <li><a href="{{url('auth/register')}}">Create Account</a></li>
                                </ul>
                                <button type="submit" class="btn btn-custom pull-right">Login</button>
                                {!! Form::close() !!}
                            </div><!-- #login-form -->
                            @endif 
                        </nav><!-- #site-navigation -->
                    </div><!-- #navbar -->
                    <div id="header-search" class="site-search clearfix">
                        @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissable">
                            <i class="fa  fa-check-circle"></i>
                            <b>Success!</b>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{Session::get('success')}}
                        </div>
                        @endif
                        <!-- failure message -->
                        @if(Session::has('fails'))
                        <div class="alert alert-danger alert-dismissable">
                            <i class="fa fa-ban"></i>
                            <b>Alert!</b> Failed.
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{Session::get('fails')}}
                        </div>
                        @endif
                        <div id="header-search" class="site-search clearfix" style="padding-top: 30px;"><!-- #header-search -->
                            {!!Form::open(['method'=>'get','action'=>'client\kb\UserController@search','class'=>'search-form clearfix'])!!}
                            <div class="form-border">

                                <div class="form-inline ">
                                    <div class="form-group">
                                        <input type="text" name="s" class="search-field form-control input-lg" title="Enter search term" placeholder="Have a question? Type your search term here..." />
                                    </div>
                                    <button type="submit" class="search-submit btn btn-custom btn-lg pull-right">Search</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <!-- Right side column. Contains the navbar and content of the page -->
            @yield('breadcrumb')
            <!-- Main content -->
            <div id="main" class="site-main clearfix">
                <div class="container">
                    <div class="content-area">
                        <div class="row">
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
            <footer id="colophon" class="site-footer" role="contentinfo">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="widget-area">
                                <section id="section-about" class="section">
                                    <?php $footer = App\Model\kb\Footer::whereId('1')->first(); ?>
                                    <h2 class="section-title h4 clearfix">{{$footer->title}}</h2>
                                    <div class="textwidget">
                                        <p>{!!$footer->footer!!}</p>
                                    </div>
                                </section><!-- #section-about -->
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="widget-area">
                                <section id="section-latest-news" class="section">
                                    <?php $footer2 = App\Model\kb\Footer2::whereId('1')->first(); ?>
                                    @if($footer2->title)
                                    <h2 class="section-title h4 clearfix">{{$footer2->title}}</h2>
                                    <p>{!!$footer2->footer!!}</p>	
                                    @else
                                    <h2 class="section-title h4 clearfix">Categories</h2>
                                    <?php $categorys = App\Model\kb\Category::get(); ?>
                                    @foreach($categorys as $category)
                                    <p><a href="{{url('category-list/'.$category->slug)}}">{{$category->name}}</a> </p>
                                    @endforeach
                                    @endif
                                </section><!-- #section-latest-news -->
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="widget-area">
                                <section id="section-newsletter" class="section">
                                    <?php $footer3 = App\Model\kb\Footer3::whereId('1')->first(); ?>
                                    <h2 class="section-title h4 clearfix">{{$footer3->title}}</h2>
                                    <p>{!!$footer3->footer!!}</p>
                                </section><!-- #section-newsletter -->
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="widget-area">
                                <section id="section-newsletter" class="section">
                                    <?php $footer4 = App\Model\kb\Footer4::whereId('1')->first(); ?>
                                    <h2 class="section-title h4 clearfix">{{$footer4->title}}</h2>
                                    <p style="list-style: none;">{!!$footer4->footer!!}</p>
                                </section>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr />
                    <div class="row">
                        <div class="site-info col-md-6">
                            <p class="text-muted">Copyright &copy; {!! date('Y') !!}  <a href="{!! $company->website !!}">{!! $company->company_name !!}</a>. All rights reserved. Powered by <a href="http://www.faveohelpdesk.com/">Faveo</a></p>
                        </div>
                        <div class="site-social text-right col-md-6">
                            <?php $social = App\Model\kb\Social::where('id', '1')->first(); ?>
                            <ul class="list-inline hidden-print">
                                @if($social->facebook)
                                <li><a href="{{$social->facebook}}" class="btn btn-social btn-facebook"><i class="fa fa-facebook fa-fw"></i></a></li>
                                @endif
                                @if($social->twitter)
                                <li><a href="{{$social->twitter}}" class="btn btn-social btn-twitter"><i class="fa fa-twitter fa-fw"></i></a></li>
                                @endif
                                @if($social->google)
                                <li><a href="{{$social->google}}" class="btn btn-social btn-google-plus"><i class="fa fa-google-plus fa-fw"></i></a></li>
                                @endif
                                @if($social->linkedin)
                                <li><a href="{{$social->linkedin}}" class="btn btn-social btn-linkedin"><i class="fa fa-linkedin fa-fw"></i></a></li>
                                @endif
                                @if($social->vimeo)
                                <li><a href="{{$social->vimeo}}" class="btn btn-social btn-vimeo"><i class="fa fa-vimeo-square fa-fw"></i></a></li>
                                @endif
                                @if($social->youtube)
                                <li><a href="{{$social->youtube}}" class="btn btn-social btn-youtube"><i class="fa fa-youtube-play fa-fw"></i></a></li>
                                @endif
                                @if($social->pinterest)
                                <li><a href="{{$social->pinterest}}" class="btn btn-social btn-pinterest"><i class="fa fa-pinterest fa-fw"></i></a></li>
                                @endif
                                @if($social->dribbble)
                                <li><a href="{{$social->dribbble}}" class="btn btn-social btn-dribbble"><i class="fa fa-dribbble fa-fw"></i></a></li>
                                @endif
                                @if($social->flickr)
                                <li><a href="{{$social->flickr}}" class="btn btn-social btn-flickr"><i class="fa fa-flickr fa-fw"></i></a></li>
                                @endif
                                @if($social->instagram)
                                <li><a href="{{$social->instagram}}" class="btn btn-social btn-instagram"><i class="fa fa-instagram fa-fw"></i></a></li>
                                @endif
                                @if($social->rss)
                                <li><a href="{{$social->rss}}" class="btn btn-social btn-rss"><i class="fa fa-rss fa-fw"></i></a></li>
                                @endif

                            </ul>
                        </div>
                    </div>
            </footer><!-- #colophon -->

        </div>
        <!-- jQuery 2.1.3 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- Slimscroll -->
        <script src="{{asset("lb-faveo/dist/js/superfish.js")}}" type="text/javascript"></script>
        <script src="{{asset("lb-faveo/dist/js/mobilemenu.js")}}" type="text/javascript"></script>
        <script src="{{asset("lb-faveo/dist/js/know.js")}}" type="text/javascript"></script>
        <script src="{{asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}" type="text/javascript"></script>

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

    </body>
</html>     

