<html>
    <head>
        <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
        <style>
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
                color: #72C4E2;
                display: table;
                /*font-size: 100;*/
                font-family: "Source Sans Pro","Helvetica Neue",Helvetica,Arial,sans-serif;
            }
            a {
                font-size: 150;
                color: #FFC907;
            }
            #body{
                font-size:22;
            }
            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }
            .content {
                text-align: center;
                display: inline-block;
            }
            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title"><a>404</a> {!! Lang::get('lang.not_found') !!}.</div>
                <div class="error-content" id="body">
                    <h3><i class="fa fa-warning text-yellow"></i> {!! Lang::get('lang.oops_page_not_found') !!}.</h3>
                    <p>
                        {!! Lang::get('lang.we_could_not_find_the_page_you_were_looking_for') !!}.
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>