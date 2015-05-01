<?php

require_once "../../build/bugsnag.phar";

$bugsnag = new Bugsnag_Client("066f5ad3590596f9aa8d601ea89af845");
$bugsnag->notifyError("Broken", "Something broke", array("tab" => array("paying" => true, "object" => (object)array("key" => "value"), "null" => NULL, "string" => "test", "int" => 4)));

?>
