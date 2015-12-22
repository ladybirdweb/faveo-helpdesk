<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US">

<head>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Faveo HELPDESK | Setup Wizard</title>
    <script type="text/javascript" src="{{asset("lb-faveo/js/jquery.js")}}"></script>
    <link rel="stylesheet" href="{{asset("lb-faveo/installer/css/load-styles.css")}}" type="text/css" media="all">
    <link rel="stylesheet" id="open-sans-css" href="{{asset("lb-faveo/installer/css/css.css")}}" type="text/css" media="all">
    <link rel="stylesheet" id="woocommerce_admin_styles-css" href="{{asset("lb-faveo/installer/css/admin.css")}}" type="text/css" media="all">
    <link rel="stylesheet" id="wc-setup-css" href="{{asset("lb-faveo/installer/css/wc-setup.css")}}" type="text/css" media="all">

    <link rel="stylesheet" id="woocommerce-activation-css" href="{{asset("lb-faveo/installer/css/activation.css")}}" type="text/css" media="
    all">
    <link href="{{asset("lb-faveo/dist/css/AdminLTE.css")}}" rel="stylesheet" type="text/css" />
    <link href="{{asset("lb-faveo/dist/css/skins/_all-skins.min.css")}}" rel="stylesheet" type="text/css" />
</head>
<body class="wc-setup wp-core-ui">
<style type="text/css">
a {
  color: #3c8dbc;
}
a:hover,
a:active,
a:focus {
  outline: none;
  text-decoration: none;
  color: #72afd2;
}
</style>
<h1 id="wc-logo"><a href="http://www.faveohelpdesk.com">
<img src="{{asset("lb-faveo/installer/images/faveo_logo.png")}}" alt="Faveo HELPDESK" style="margin-top:-30px;margin-bottom:-12px"></a></h1>
    <ol class="wc-setup-steps">
        <li class="active">Licence Agreement</li>
        <li class="">Store Locale</li>
        <li class="">Shipping &amp; Tax</li>
        <li class="">Payments</li>
        <li class="">Ready!</li>
    </ol>

@yield('content')

<center id="footer">&copy;<?php echo date('Y')?>. Powered by <a href="http://www.faveohelpdesk.com">Faveo </a></center>
</body>

</html>