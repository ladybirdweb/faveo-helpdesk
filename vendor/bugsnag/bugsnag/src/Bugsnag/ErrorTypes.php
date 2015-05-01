<?php

class Bugsnag_ErrorTypes
{
    private static $ERROR_TYPES = array(
        E_ERROR => array(
            'name' => 'PHP Fatal Error',
            'severity' => 'error',
        ),

        E_WARNING => array(
            'name' => 'PHP Warning',
            'severity' => 'warning',
        ),

        E_PARSE => array(
            'name' => 'PHP Parse Error',
            'severity' => 'error',
        ),

        E_NOTICE => array(
            'name' => 'PHP Notice',
            'severity' => 'info',
        ),

        E_CORE_ERROR => array(
            'name' => 'PHP Core Error',
            'severity' => 'error',
        ),

        E_CORE_WARNING => array(
            'name' => 'PHP Core Warning',
            'severity' => 'warning',
        ),

        E_COMPILE_ERROR => array(
            'name' => 'PHP Compile Error',
            'severity' => 'error',
        ),

        E_COMPILE_WARNING => array(
            'name' => 'PHP Compile Warning',
            'severity' => 'warning',
        ),

        E_USER_ERROR => array(
            'name' => 'User Error',
            'severity' => 'error',
        ),

        E_USER_WARNING => array(
            'name' => 'User Warning',
            'severity' => 'warning',
        ),

        E_USER_NOTICE => array(
            'name' => 'User Notice',
            'severity' => 'info',
        ),

        E_STRICT => array(
            'name' => 'PHP Strict',
            'severity' => 'info',
        ),

        E_RECOVERABLE_ERROR => array(
            'name' => 'PHP Recoverable Error',
            'severity' => 'error',
        ),

        // E_DEPRECATED (Since PHP 5.3.0)
        8192 => array(
            'name' => 'PHP Deprecated',
            'severity' => 'info',
        ),

        // E_USER_DEPRECATED (Since PHP 5.3.0)
        16384 => array(
            'name' => 'User Deprecated',
            'severity' => 'info',
        ),
    );

    public static function isFatal($code)
    {
        return self::getSeverity($code) == 'error';
    }

    public static function getName($code)
    {
        if (array_key_exists($code, self::$ERROR_TYPES)) {
            return self::$ERROR_TYPES[$code]['name'];
        } else {
            return "Unknown";
        }
    }

    public static function getSeverity($code)
    {
        if (array_key_exists($code, self::$ERROR_TYPES)) {
            return self::$ERROR_TYPES[$code]['severity'];
        } else {
            return "error";
        }
    }

    public static function getLevelsForSeverity($severity)
    {
        $levels = 0;
        foreach (Bugsnag_ErrorTypes::$ERROR_TYPES as $level => $info) {
            if ($info['severity'] == $severity) {
                $levels |= $level;
            }
        }

        return $levels;
    }
}
