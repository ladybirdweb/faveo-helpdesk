<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>SUPPORT CENTER</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" href="{{asset("lb-faveo/media/images/favicon.ico")}}">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{asset("lb-faveo/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="{{asset("lb-faveo/plugins/iCheck/square/blue.css")}}" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
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
                  <img src="{{asset('lb-faveo/media/company')}}{{'/'}}{{$company->logo}}" alt="User Image" width="200px" />
                @else
                  @if($system->name)
                    {!! $system->name !!}
                  @else
                    <b>SUPPORT</b> CENTER
                  @endif
                @endif
                </a>
      </div><!-- /.login-logo -->
        <div class="login-box-body">
       @yield('body')
    </div><!-- /.login-box -->
    <div class="login-box-msg">
    </br>
      <p class="text-muted">{!! Lang::get('lang.copyright') !!} &copy; {!! date('Y') !!}  <a href="{!! $company->website !!}">{!! $company->company_name !!}</a>. {!! Lang::get('lang.all_rights_reserved') !!}. {!! Lang::get('lang.powered_by') !!} <a href="http://www.faveohelpdesk.com/"  target="_blank">Faveo</a></p>
    </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="{{asset("lb-faveo/plugins/iCheck/icheck.min.js")}}" type="text/javascript"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>