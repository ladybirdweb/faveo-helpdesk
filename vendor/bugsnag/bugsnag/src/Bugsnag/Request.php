<?php

class Bugsnag_Request
{
    public static function isRequest()
    {
        return isset($_SERVER['REQUEST_METHOD']);
    }

    public static function getRequestMetaData()
    {
        $requestData = array();

        // Request Tab
        $requestData['request'] = array();
        $requestData['request']['url'] = self::getCurrentUrl();
        if (isset($_SERVER['REQUEST_METHOD'])) {
            $requestData['request']['httpMethod'] = $_SERVER['REQUEST_METHOD'];
        }

        if (!empty($_POST)) {
            $requestData['request']['params'] = $_POST;
        } else {
            if (isset($_SERVER['CONTENT_TYPE']) && stripos($_SERVER['CONTENT_TYPE'], 'application/json') === 0) {
                $requestData['request']['params'] = json_decode(file_get_contents('php://input'));
            }
        }

        $requestData['request']['ip'] = self::getRequestIp();
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $requestData['request']['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
        }

        $headers = self::getRequestHeaders();
        if (!empty($headers)) {
            $requestData['request']['headers'] = $headers;
        }

        return $requestData;
    }

    public static function getContext()
    {
        if (self::isRequest() && isset($_SERVER['REQUEST_METHOD']) && isset($_SERVER["REQUEST_URI"])) {
            return $_SERVER['REQUEST_METHOD'].' '.strtok($_SERVER["REQUEST_URI"], '?');
        } else {
            return null;
        }
    }

    public static function getUserId()
    {
        if (self::isRequest()) {
            return self::getRequestIp();
        } else {
            return null;
        }
    }

    public static function getCurrentUrl()
    {
        $schema = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) ? 'https://' : 'http://';

        return $schema.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }

    public static function getRequestIp()
    {
        return isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
    }

    public static function getRequestHeaders()
    {
        if (function_exists('getallheaders')) {
            return getallheaders();
        }

        $headers = array();

        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }

        return $headers;
    }
}
