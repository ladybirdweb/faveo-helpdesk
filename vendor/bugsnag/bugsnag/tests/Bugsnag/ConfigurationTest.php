<?php

class ConfigurationTest extends PHPUnit_Framework_TestCase
{
    /** @var Bugsnag_Configuration */
    protected $config;

    protected function setUp()
    {
        $this->config = new Bugsnag_Configuration();
    }

    public function testDefaultEndpoint()
    {
        $this->assertEquals($this->config->getNotifyEndpoint(), "https://notify.bugsnag.com");
    }

    public function testNonSSLEndpoint()
    {
        $this->config->useSSL = false;
        $this->assertEquals($this->config->getNotifyEndpoint(), "http://notify.bugsnag.com");
    }

    public function testCustomEndpoint()
    {
        $this->config->useSSL = false;
        $this->config->endpoint = "localhost";
        $this->assertEquals($this->config->getNotifyEndpoint(), "http://localhost");
    }

    public function testDefaultReleaseStageShouldNotify()
    {
        $this->assertTrue($this->config->shouldNotify());
    }

    public function testCustomReleaseStageShouldNotify()
    {
        $this->config->releaseStage = "staging";
        $this->assertTrue($this->config->shouldNotify());
    }

    public function testCustomNotifyReleaseStagesShouldNotify()
    {
        $this->config->notifyReleaseStages = array("banana");
        $this->assertFalse($this->config->shouldNotify());
    }

    public function testBothCustomShouldNotify()
    {
        $this->config->releaseStage = "banana";
        $this->config->notifyReleaseStages = array("banana");
        $this->assertTrue($this->config->shouldNotify());
    }

    public function testNotifier()
    {
        $this->assertEquals($this->config->notifier['name'], "Bugsnag PHP (Official)");
        $this->assertEquals($this->config->notifier['url'], "https://bugsnag.com");
    }

    public function testShouldIgnore()
    {
        $this->config->errorReportingLevel = E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED;

        $this->assertTrue($this->config->shouldIgnoreErrorCode(E_NOTICE));
    }

    public function testShouldNotIgnore()
    {
        $this->config->errorReportingLevel = E_ALL;

        $this->assertfalse($this->config->shouldIgnoreErrorCode(E_NOTICE));
    }
}
