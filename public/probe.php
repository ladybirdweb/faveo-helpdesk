<?php
error_reporting();

$extensions = [
    'curl',
    'ctype',
    'imap',
    'mbstring',
    'mcrypt',
    'mysql',
    'openssl',
    'tokenizer',
    'zip',
    'pdo',
    'mysqli',
    'bcmath',
    'iconv',
    'XML-DOM', //for HTML email processing
    'json',
    //'ioncube_loader_dar_5.6',
];
?>
<html>
    <head>
        <style>
            table {
                width:100%;
            }
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
            th, td {
                padding: 5px;
                text-align: left;
            }
            table#t01 tr:nth-child(even) {
                background-color: #eee;
            }
            table#t01 tr:nth-child(odd) {
                background-color:#fff;
            }
            table#t01 th {
                background-color: black;
                color: white;
            }
        </style>
    </head>
    <body>
        <table>
            <tr>
                <th>Extensions</th>
                <th>Status</th>
            </tr>
            <?php
            foreach ($extensions as $extension) {
                echo '<tr>';
                if (!extension_loaded($extension)) {
                    echo '<td>'.$extension."</td>  <td style='color:red'>Not loading"
                    ."<p>To enable this, please open '".php_ini_loaded_file()."' and add 'extension = ".$extension."'</p>"
                    .'</td>';
                } else {
                    echo '<td>'.$extension."</td>  <td style='color:green'>Loading</td>";
                }
                echo '</tr>';
            }
            echo '<tr>';
            if (phpversion() >= 7.1) {
                echo "<td>PHP Version</td>  <td style='color:green'>".phpversion().'</td>';
            } else {
                echo "<td>PHP Version</td>  <td style='color:red'>".phpversion().'<p>Please upgrade PHP Version to 7.1+ </p></td>';
            }
            echo '</tr>';
            echo '<tr>';
            $env = '../.env';
            if (!is_file($env)) {
                echo "<td>.env file</td>  <td style='color:green'>Not found</td>";
            } else {
                echo "<td>.env file</td>  <td style='color:red'>Yes Found<p>Please delete  '$env' </p></td>";
            }
            echo '</tr>';
            echo '<tr>';
            $redirect = in_array('mod_rewrite', apache_get_modules());
            if ($redirect) {
                echo "<td>Rewrite Engine</td>  <td style='color:green'>ON</td>";
            } else {
                echo "<td>Rewrite Engine</td>  <td style='color:red'>OFF</td>";
            }
            echo '</tr>';
            ?>
            
        </table>
        <p style='color:red'>* Please delete the file 'probe.php' once you have fixed all the issues.</p>
    </body>
</html>