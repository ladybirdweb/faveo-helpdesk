<?php

require_once 'Bugsnag_TestCase.php';

class ErrorTest extends Bugsnag_TestCase
{
    protected $config;
    protected $diagnostics;
    protected $error;

    protected function setUp()
    {
        $this->config = new Bugsnag_Configuration();
        $this->diagnostics = new Bugsnag_Diagnostics($this->config);
        $this->error = $this->getError();
    }

    public function testMetaData()
    {
        $this->error->setMetaData(array("Testing" => array("globalArray" => "hi")));

        $errorArray = $this->error->toArray();
        $this->assertEquals($errorArray['metaData']["Testing"]["globalArray"], "hi");
    }

    public function testMetaDataMerging()
    {
        $this->error->setMetaData(array("Testing" => array("globalArray" => "hi")));
        $this->error->setMetaData(array("Testing" => array("localArray" => "yo")));

        $errorArray = $this->error->toArray();
        $this->assertEquals($errorArray['metaData']["Testing"]["globalArray"], "hi");
        $this->assertEquals($errorArray['metaData']["Testing"]["localArray"], "yo");
    }

    public function testShouldIgnore()
    {
        $this->config->errorReportingLevel = E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED;

        $this->error->setPHPError(E_NOTICE, "Broken", "file", 123);

        $this->assertTrue($this->error->shouldIgnore());
    }

    public function testShouldNotIgnore()
    {
        $this->config->errorReportingLevel = E_ALL;

        $this->error->setPHPError(E_NOTICE, "Broken", "file", 123);

        $this->assertfalse($this->error->shouldIgnore());
    }

    public function testFiltering()
    {
        $this->error->setMetaData(array("Testing" => array("password" => "123456")));

        $errorArray = $this->error->toArray();
        $this->assertEquals($errorArray['metaData']['Testing']['password'], '[FILTERED]');
    }

    public function testNoticeName()
    {
        $this->error->setPHPError(E_NOTICE, "Broken", "file", 123);

        $errorArray = $this->error->toArray();
        $this->assertEquals($errorArray['exceptions'][0]['errorClass'], 'PHP Notice');
    }

    public function testErrorName()
    {
        $this->error->setPHPError(E_ERROR, "Broken", "file", 123);

        $errorArray = $this->error->toArray();
        $this->assertEquals($errorArray['exceptions'][0]['errorClass'], 'PHP Fatal Error');
    }

    public function testErrorPayloadVersion()
    {
        $this->error->setPHPError(E_ERROR, "Broken", "file", 123);

        $errorArray = $this->error->toArray();
        $this->assertEquals($errorArray['payloadVersion'], '2');
    }

    public function testNoticeSeverity()
    {
        $this->error->setPHPError(E_NOTICE, "Broken", "file", 123);

        $errorArray = $this->error->toArray();
        $this->assertEquals($errorArray['severity'], 'info');
    }

    public function testErrorSeverity()
    {
        $this->error->setPHPError(E_ERROR, "Broken", "file", 123);

        $errorArray = $this->error->toArray();
        $this->assertEquals($errorArray['severity'], 'error');
    }

    public function testManualSeverity()
    {
        $this->error->setSeverity("error");

        $errorArray = $this->error->toArray();
        $this->assertEquals($errorArray['severity'], 'error');
    }

    public function testInvalidSeverity()
    {
        $this->error->setSeverity("bunk");

        $errorArray = $this->error->toArray();
        $this->assertEquals($errorArray['severity'], 'warning');
    }

    public function testPreviousException()
    {
        if (version_compare(PHP_VERSION, '5.3.0', '>=')) {
            $exception = new Exception("secondly", 65533, new Exception("firstly"));

            $error = Bugsnag_Error::fromPHPException($this->config, $this->diagnostics, $exception);

            $errorArray = $error->toArray();

            $this->assertEquals(count($errorArray['exceptions']), 2);
            $this->assertEquals($errorArray['exceptions'][0]['message'], 'firstly');
            $this->assertEquals($errorArray['exceptions'][1]['message'], 'secondly');
        }
    }
    
    public function testErrorGroupingHash()
    {
        $this->error->setGroupingHash('herp#derp');

        $errorArray = $this->error->toArray();
        $this->assertEquals($errorArray['groupingHash'], 'herp#derp');
    }
    
    public function testErrorGroupingHashNotSet()
    {
        $errorArray = $this->error->toArray();
        $this->assertArrayNotHasKey('groupingHash', $errorArray);
    }
}
