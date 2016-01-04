<?php

require_once "../../build/bugsnag.phar";

$bugsnag = new Bugsnag_Client("YOUR-API-KEY-HERE");
$bugsnag->notifyError("Broken", "Something broke", array("tab" => array("paying" => true, "object" => (object)array("key" => "value"), "null" => NULL, "string" => "test", "int" => 4)));

?>
