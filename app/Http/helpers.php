<?php

function loging($context,$message,$level='error')
{
    
    \Log::$level($message.":-:-:-".$context);

}

