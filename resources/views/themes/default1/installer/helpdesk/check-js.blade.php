@extends('themes.default1.installer.layout.installer2')
@section('license')
active
@stop
@section('content')
    <div id="no-js">
    <noscript>
        <!-- <meta http-equiv="refresh" content="0;url=step1"> -->
       
        <div class="woocommerce-message woocommerce-tracker" >
                <center id="fail" style="font-size: 1.3em">JavaScript Disabled!</center>
                <p style="font-size:1.0em">Hello, Sparky! You are just a few steps away from your support system. It looks like that JavaScript is not supported or disabled in your browser. FAVEO doesn't work properly without JavaScript, and it may cause errors in installation process. Please check and enable JavaScript in your browser in order to install and run FAVEO to its full extent.</p>
                 <p class="wc-setup-actions step">
            Have you enabled JavaScript?&nbsp;
                <a href="{!! $url !!}">Click here</a> to reload the page now.
            </p>
        </div>
    </noscript>
    </div>
   
@stop