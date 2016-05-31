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
                <p style="font-size:1.0em">Hello, Sparky! you are just few steps away from your support system. It looks like that JavaScript is disabled in your browser or not supported by your browser. FAVEO doesn't work properly without JavaScript and it may cause error in installation. Please check and enable JavaScript in your browser in order to install and run FAVEO to its full extent.</p>
            </div>
           <p class="wc-setup-actions step">
                <a href="{!! $url !!}"><input type="submit" id="submitme" class="button-primary button button-large button-next" value="Reload" name="accept1"></a>
            </p>
    </noscript>
    </div>
   
@stop