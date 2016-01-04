<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" id="gradient">

<head>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Faveo HELPDESK</title>
    <script type="text/javascript" src="js/jquery.js"></script>
    <link rel="stylesheet" href="css/load-styles.css" type="text/css" media="all">
    <link rel="stylesheet" href="css/css.css" type="text/css" media="all">
    <link rel="stylesheet" href="css/admin.css" type="text/css" media="all">
    <link rel="stylesheet" href="css/wc-setup.css" type="text/css" media="all">
    <link rel="stylesheet" href="css/activation.css" type="text/css" media="all">
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all">

    <body class="wc-setup wp-core-ui">
        <h1 id="wc-logo"><a href="#"><img src="images/App-Store.png" alt="faveo"></a></h1>
        <ol class="wc-setup-steps">
            <li class="done">Licence Agreement</li>
            <li class="done">Environment Test</li>

            <li class="active">Database Setup</li>
            <li class="">Locale Information</li>
            <li class="">Ready</li>
        </ol>
        <div class="wc-setup-content">

            <form>


                <p class="wc-setup-actions step">

                    Test/Probe Prerequisites required to be installed Probe
                    <br><span class="ok">ok</span> — Connected to database as root@localhost
                    <br><span class="ok">ok</span> — Database "faveo" selected
                    <br><span class="ok">ok</span> — MySQL version is 5.6.17
                    <br><span class="ok">ok</span>, this system can run FaveoHELPDESK
                    <h1>Database connection successfull</h1>

                    <br>




                    <p class="wc-setup-actions step">
                        <input type="submit" id="submitme" class="button-danger button button-large button-next" style="background-color: #d43f3a;color:#fff;" value="Error">
                        <a href="step3.html" class="button button-large button-next" style="float: left;">Previous</a>
                    </p>
                    <h2>Legend</h2>
                <br><span class="ok">ok</span> — All OK
                <br><span class="warning">Warning</span> — Not a deal breaker, but it's recommended to have this installed for some features to work
                <br><span class="error">Error</span>— Faveo HELPDESK require this feature and can't work without it
                    <br>
                </p>


            </form>
        </div>

        <span class="select2-hidden-accessible" aria-live="polite" role="status"></span>
    </body>

</html>