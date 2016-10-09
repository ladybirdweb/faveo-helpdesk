<?php

function loging($context, $message, $level = 'error',$array=[]) {

    \Log::$level($message . ":-:-:-" . $context,$array);
}

function checkArray($key, $array) {
    $value = "";
    if (array_key_exists($key, $array)) {
        $value = $array[$key];
    }
    return $value;
}

function mime($type) {
    if ($type == 'jpg' ||
            $type == 'png' ||
            $type == 'PNG' ||
            $type == 'JPG' ||
            $type == 'jpeg' ||
            $type == 'JPEG' ||
            $type == 'gif' ||
            $type == 'GIF' ||
            $type == 'image/jpeg' ||
            $type == 'image/jpg' ||
            $type == 'image/gif'||
            $type == "application/octet-stream"||
            $type == "image/png"||
            starts_with($type, 'image')){
        return "image";
    }
}
function removeUnderscore($string){
    if(str_contains($string, '_')===true){
        $string = str_replace('_', ' ', $string);
    }
    return ucfirst($string);
}
