<?php

class RequestTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $_SERVER['REQUEST_METHOD'] = "GET";
        $_SERVER['REQUEST_URI'] = "/blah/blah.php?some=param";
        $_SERVER['REMOTE_ADDR'] = "123.45.67.8";
        $_SERVER['SERVER_PORT'] = "80";
        $_SERVER['HTTP_HOST'] = "example.com";
        $_SERVER['HTTP_USER_AGENT'] = "Example Browser 1.2.3";

        $_COOKIE = array("cookie" => "cookieval");
        $_SESSION = array("session" => "sessionval");
    }

    public function testIsRequest()
    {
        $this->assertTrue(Bugsnag_Request::isRequest());
    }

    public function testGetContext()
    {
        $this->assertEquals(Bugsnag_Request::getContext(), "GET /blah/blah.php");
    }

    public function testGetCurrentUrl()
    {
        $this->assertEquals(Bugsnag_Request::getCurrentUrl(), "http://example.com/blah/blah.php?some=param");
    }

    public function testRequestIp()
    {
        $this->assertEquals(Bugsnag_Request::getRequestIp(), "123.45.67.8");
    }
}
