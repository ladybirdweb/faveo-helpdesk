<?php

# We used to have an autoloader, but it caused problems in some
# environments. So now we manually load the entire library upfront.
#
# The file is still called Autoload so that existing integration
# instructions continue to work.
require_once dirname(__FILE__).DIRECTORY_SEPARATOR."Client.php";
require_once dirname(__FILE__).DIRECTORY_SEPARATOR."Configuration.php";
require_once dirname(__FILE__).DIRECTORY_SEPARATOR."Diagnostics.php";
require_once dirname(__FILE__).DIRECTORY_SEPARATOR."Error.php";
require_once dirname(__FILE__).DIRECTORY_SEPARATOR."ErrorTypes.php";
require_once dirname(__FILE__).DIRECTORY_SEPARATOR."Notification.php";
require_once dirname(__FILE__).DIRECTORY_SEPARATOR."Request.php";
require_once dirname(__FILE__).DIRECTORY_SEPARATOR."Stacktrace.php";
