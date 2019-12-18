<?php

namespace Codacy\Coverage\Parser;


use Codacy\Coverage\Util\JsonProducer;

class ParserTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Running against tests/res/phpunit-clover
     */
    public function testParsersProduceSameResult()
    {
        $cloverParser = new CloverParser('tests/res/phpunit-clover/clover.xml', '/home/jacke/Desktop/codacy-php');
        $xunitParser = new PhpUnitXmlParser('tests/res/phpunit-clover/index.xml', '/home/jacke/Desktop/codacy-php');
        $xunitParser->setDirOfFileXmls('tests/res/phpunit-clover');
        $expectedJson = file_get_contents('tests/res/expected.json', true);

        $jsonProducer = new JsonProducer();

        $jsonProducer->setParser($cloverParser);

        $cloverJson = $jsonProducer->makeJson();

        $jsonProducer->setParser($xunitParser);

        $xunitJson = $jsonProducer->makeJson();

        $this->assertJsonStringEqualsJsonString($expectedJson, $cloverJson);

        $this->assertJsonStringEqualsJsonString($expectedJson, $xunitJson);
    }

    public function testConstructorOnNullRootDir()
    {
        $parser = new PhpUnitXmlParser('tests/res/phpunitxml/index.xml');
        $parser->setDirOfFileXmls("tests/res/phpunitxml");
        $report = $parser->makeReport();

        $this->assertEquals(69, $report->getTotal());
        $this->assertEquals(10, sizeof($report->getFileReports()));
    }
}
