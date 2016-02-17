@extends('themes.default1.installer.layout.installer')

@section('license')
done
@stop

@section('environment')
done
@stop

@section('database')
active
@stop

@section('content') 

    <h1 style="text-align: center;">Database Setup</h1>
        This test will check prerequisites required to install Faveo<br/><br/>
<?php
/**
 * Faveo HELPDESK Probe
 *
 * Copyright (c) 2014 Ladybird Web Solution.
 *
 */
// -- Please provide valid database connection parameters ------------------------------
$default = Session::get('default');
$host = Session::get('host');
$username = Session::get('username');
$password = Session::get('password');
$databasename = Session::get('databasename');
$port = Session::get('port');

define('DB_HOST', $host); // Address of your MySQL server (usually localhost)
define('DB_USER', $username); // Username that is used to connect to the server
define('DB_PASS', $password); // User's password
define('DB_NAME', $databasename); // Name of the database you are connecting to
define('DB_PORT', $port); // Name of the database you are connecting to

define('PROBE_VERSION', '4.2');
define('PROBE_FOR', '<b>Faveo</b> HELPDESK 1.0 and Newer');

define('STATUS_OK', 'Ok');
define('STATUS_WARNING', 'Warning');
define('STATUS_ERROR', 'Error');

class TestResult {

    var $message;
    var $status;

    function TestResult($message, $status = STATUS_OK) {
        $this->message = $message;
        $this->status = $status;
    }

} // TestResult

if (DB_HOST && DB_USER && DB_NAME) {
    ?>
<?php

    $mysqli_ok = true;
    $results = array();
    // error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    error_reporting(0);

    if($default == 'mysql') {
        if ($connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME)) {
            $results[] = new TestResult('Connected to database as ' . DB_USER . '@' . DB_HOST . DB_PORT, STATUS_OK);
            if (mysqli_select_db($connection, DB_NAME)) {
                $results[] = new TestResult('Database "' . DB_NAME . '" selected', STATUS_OK);
                $mysqli_version = mysqli_get_server_info($connection);
                if (version_compare($mysqli_version, '5') >= 0) {
                    $results[] = new TestResult('MySQL version is ' . $mysqli_version, STATUS_OK);
                    // $have_inno = check_have_inno($connection);
                } else {
                    $results[] = new TestResult('Your MySQL version is ' . $mysqli_version . '. We recommend upgrading to at least MySQL5!', STATUS_ERROR);
                    $mysqli_ok = false;
                } // if
            } else {
                $results[] = new TestResult('Failed to select database. ' . mysqli_error(), STATUS_ERROR);
                $mysqli_ok = false;
            } // if
        } else {
            $results[] = new TestResult('Failed to connect to database. ' . mysqli_error(), STATUS_ERROR);
            $mysqli_ok = false;
        } // if
    } 
    // elseif($default == 'pgsql') {
    //     if ($connection2 = pg_connect("'host='.DB_HOST.' port='.DB_PORT.' dbname='.DB_NAME.' user='.DB_USER.' password='.DB_PASS.")) {
    //         $results[] = new TestResult('Connected to database as ' . DB_USER . '@' . DB_HOST, STATUS_OK);
    //     } else {
    //         $results[] = new TestResult('Failed to connect to database. <br> PgSQL said: ' . mysqli_error(), STATUS_ERROR);
    //         $mysqli_ok = false;
    //     }
    // } elseif($default == 'sqlsrv') {
        
    // }
    // ---------------------------------------------------
    //  Validators
    // ---------------------------------------------------
// dd($results);

    foreach ($results as $result) {
        print '<span class="' . strtolower($result->status) . '">' . $result->status . '</span> &mdash; ' . $result->message . '<br/>';
    } // foreach
    ?>
<!-- </ul> -->
<?php } else { ?>
      <p>Database test is <strong>turned off</strong>. To turn it On, please open probe.php in your favorite text editor and set DB_XXXX connection parameters in database section at the beginning of the file:</p>
      <ul>
        <li>DB_HOST &mdash; Address of your MySQL server (usually localhost)</li>
        <li>DB_USER &mdash; Username that is used to connect to the server</li>
        <li>DB_PASS &mdash; User's password</li>
        <li>DB_NAME &mdash; Name of the database you are connecting to</li>
      </ul>
      <p>Once these settings are set, probe.php will check if your database meets the system requirements.</p>
<?php $mysqli_ok = null;?>
<?php }  ?>

<?php if ($mysqli_ok !== null) {?>
<?php if ($mysqli_ok) {?>

<p id="verdict" class="all_ok"><span class="ok">Ok</span> &mdash; This system can run <b>Faveo</b> HELPDESK</p>

<h2 id="conn">Database connection successful</h3>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<span id="wait">Please wait this may take a while......</span>

{!! Form::open( ['id'=>'form','method' => 'POST'] )!!}
{{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
    <!-- <b>default</b><br> -->
    <input type="hidden" name="default" value="{!! $default !!}"/>
    <!-- <b>Host</b><br> -->
    <input type="hidden"  name="host" value="{!! $host !!}"/>
    <!-- <b>Database Name</b><br> -->
    <input type="hidden" name="databasename" value="{!! $databasename !!}"/>
    <!-- <b>User Name</b><br> -->
    <input type="hidden" name="username" value="{!! $username !!}"/>
    <!-- <b>User Password</b><br> -->
    <input type="hidden" name="password" value="{!! $password !!}"/>
    <!-- <b>Port</b><br> -->
    <input type="hidden" name="port" value="{!! $port !!}"/>

    <input type="submit" style="display:none;">

</form>
<div id="show" style="display:none;">
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-9">
            <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}"><br/><br/><br/>
        </div>
    </div>
</div>

    <div style="border-bottom: 1px solid #eee;">
        <p class="wc-setup-actions step">
            <a href="{{URL::route('account')}}" class="pull-right" id="next" style="text-color:black"><input type="submit" id="submitme" class="button-primary button button-large button-next" value="Continue"> </a>
            <a href="{{URL::route('configuration')}}" class="button button-large button-next" style="float: left">Previous</a>
        </p>
    </div>
<br/>

<script type="text/javascript">

// submit a ticket
$(document).ready(function () {
    $("#form").submit();
});

    // Edit a ticket
        $('#form').on('submit', function() {
            $.ajax({
                type: "POST",
                url: "{!! route('postconnection') !!}",
                dataType: "html",
                data: $(this).serialize(),
                beforeSend: function() {
                    $("#conn").hide();
                    $("#show").show();
                    $("#wait").show();
                },
                success: function(response) {
                    // $("#dismis").trigger("click");
                    if (response == 1) {
                        $("#show").hide();
                        $("#wait").hide();
                        $("#conn").show();
                        // $("#next1").trigger("click");
                    } else if (response == 0) {
                        alert('Please check all your fields');
                    }
                }
            })
            return false;
        });

</script>

<?php } else {?>
    <p id="verdict" class="not_ok">This system does not meet <b>Faveo</b> HELPDESK system requirements</p>
            <a href="{{URL::route('configuration')}}"><button type="submit" id="submitme" class="button-danger button button-large button-next" style="background-color: #d43f3a;color:#fff;" value="Error">Back</button></a><br/><br/>
      <?php } // if ?>
    <div id="legend">
        {{-- <ul> --}}
        <span class="ok">Ok</span> &mdash; All Ok <br/>
        <span class="warning">Warning</span> &mdash; Not a deal breaker, but it's recommended to have this installed for some features to work<br/>
        <span class="error">Error</span> &mdash; <b>Faveo</b> HELPDESK require this feature and can't work without it<br/><br/>
        {{-- </ul> --}}
    </div>
<?php } // if ?>

@stop
