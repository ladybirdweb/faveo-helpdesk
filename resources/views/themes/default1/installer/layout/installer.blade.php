<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta name="viewport" content="width=device-width">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Faveo HELPDESK</title>
        <link rel="stylesheet" href="{{asset("lb-faveo/installer/css/load-styles.css")}}" type="text/css" media="all">
        <link rel="stylesheet" href="{{asset("lb-faveo/installer/css/css.css")}}" type="text/css" media="all">
        <link rel="stylesheet" href="{{asset("lb-faveo/installer/css/admin.css")}}" type="text/css" media="all">
        <link rel="stylesheet" href="{{asset("lb-faveo/installer/css/wc-setup.css")}}" type="text/css" media="all">
        <link rel="stylesheet" href="{{asset("lb-faveo/installer/css/activation.css")}}" type="text/css" media="all">
        <link rel="stylesheet" href="{{asset("lb-faveo/installer/css/style.css")}}" type="text/css" media="all">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

        <style type="text/css">

            td input {
                padding: 3px;
                margin-left: 150px;
                width: 280px;
            }

            td select {
                width: 290px;
                margin-left: 150px;
                font-size: 17px;
            }

            i {
                float: right;
                padding-top: 7px;
                padding-left: 5px;
            }

            #sectool {
                min-width: 200px;
                padding: 5px;
                line-height: 20px;
                min-height: 18px;
                background-color: #3AA7D9;
                float: right;
                border-radius: 5px;
                box-shadow: 5px 6px #88C8E5;
                margin-top: 30px;
    /*            position: absolute;*/
                top: 100px;
            }

            #sectool p{
                 text-align: justify;
                 text-align-last: center;
                 font-size: 14px;
                 color: aliceblue;
                 width: 200px;
                 word-wrap: break-word;
                 font-style: italic;
                 font-weight: 600;
                 font-variant: normal;
            }

            blockquote  {
                padding:10px 20px;
            }

            blockquote  {
                border:1px solid #FF3048;
                page-break-inside:avoid;
            }

            blockquote{
                padding:10px 20px;
                margin:0 0 20px;
                font-size:12.5px;
                border-left: 5px solid #DD0019;
                background-color: #FFE8EB;
                border-radius: 2px;
            }

            
        </style>
    </head>
    <body class="wc-setup wp-core-ui">
        <h1 id="wc-logo"><a href="#">
            <img src="{{asset("lb-faveo/installer/images/faveo.png")}}" alt="faveo"></a></h1>
    <ol class="wc-setup-steps">
        <li class="@yield('licence')">Licence Agreement</li>
        <li class="@yield('environment')">Environment Test</li>
        <li class="@yield('database')">Database Setup</li>
        <li class="@yield('locale')">Locale Information</li>
        <li class="@yield('ready')">Ready</li>
    </ol>
    <div class="wc-setup-content">
        @yield('content')
    </div>
    <center>&copy;<?php echo date('Y')?>. Powered by <a href="http://www.faveohelpdesk.com">Faveo </a></center>
    {{-- // <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script> --}}
    {{-- // <script src="{{asset("lb-faveo/installer/js/index.js ")}}"></script> --}}
    </body>
</html>    