<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link       http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright  Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @category   ZendService
 * @package    ZendService_Apple
 * @subpackage UnitTests
 */

namespace ZendServiceTest\Apple\Apns;

use ZendServiceTest\Apple\Apns\TestAsset\MessageClient;
use ZendService\Apple\Apns\Message;
use ZendService\Apple\Apns\Response\Message as MessageResponse;

/**
 * @category   ZendService
 * @package    ZendService_Apple
 * @subpackage UnitTests
 * @group      ZendService
 * @group      ZendService_Apple
 * @group      ZendService_Apple_Apns
 */
class MessageClientTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->apns = new MessageClient();
        $this->message = new Message();
    }

    protected function setupValidBase()
    {
        $this->apns->open(MessageClient::SANDBOX_URI, __DIR__ . '/TestAsset/certificate.pem');
        $this->message->setToken('662cfe5a69ddc65cdd39a1b8f8690647778204b064df7b264e8c4c254f94fdd8');
        $this->message->setId(time());
        $this->message->setAlert('bar');
    }

    public function testConnectThrowsExceptionOnInvalidEnvironment()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->apns->open(5, __DIR__ . '/TestAsset/certificate.pem');
    }

    public function testSetCertificateThrowsExceptionOnNonString()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->apns->open(MessageClient::PRODUCTION_URI, array('foo'));
    }

    public function testSetCertificateThrowsExceptionOnMissingFile()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->apns->open(MessageClient::PRODUCTION_URI, 'foo');
    }

    public function testSetCertificatePassphraseThrowsExceptionOnNonString()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->apns->open(MessageClient::PRODUCTION_URI, __DIR__ . '/TestAsset/certificate.pem', array('foo'));
    }

    public function testOpen()
    {
        $ret = $this->apns->open(MessageClient::SANDBOX_URI, __DIR__ . '/TestAsset/certificate.pem');
        $this->assertEquals($this->apns, $ret);
        $this->assertTrue($this->apns->isConnected());
    }

    public function testClose()
    {
        $this->apns->open(MessageClient::SANDBOX_URI, __DIR__ . '/TestAsset/certificate.pem');
        $this->apns->close();
        $this->assertFalse($this->apns->isConnected());
    }

    public function testOpenWhenAlreadyOpenThrowsException()
    {
        $this->setExpectedException('RuntimeException');
        $this->apns->open(MessageClient::SANDBOX_URI, __DIR__ . '/TestAsset/certificate.pem');
        $this->apns->open(MessageClient::SANDBOX_URI, __DIR__ . '/TestAsset/certificate.pem');
    }

    public function testSendReturnsTrueOnSuccess()
    {
        $this->setupValidBase();
        $response = $this->apns->send($this->message);
        $this->assertEquals(MessageResponse::RESULT_OK, $response->getCode());
        $this->assertNull($response->getId());
    }

    public function testSendResponseOnProcessingError()
    {
        $this->setupValidBase();
        $this->apns->setReadResponse(pack('CCN*', 1, 1, 12345));
        $response = $this->apns->send($this->message);
        $this->assertEquals(MessageResponse::RESULT_PROCESSING_ERROR, $response->getCode());
        $this->assertEquals(12345, $response->getId());
    }

    public function testSendResponseOnMissingToken()
    {
        $this->setupValidBase();
        $this->apns->setReadResponse(pack('CCN*', 2, 2, 12345));
        $response = $this->apns->send($this->message);
        $this->assertEquals(MessageResponse::RESULT_MISSING_TOKEN, $response->getCode());
        $this->assertEquals(12345, $response->getId());
    }

    public function testSendResponseOnMissingTopic()
    {
        $this->setupValidBase();
        $this->apns->setReadResponse(pack('CCN*', 3, 3, 12345));
        $response = $this->apns->send($this->message);
        $this->assertEquals(MessageResponse::RESULT_MISSING_TOPIC, $response->getCode());
        $this->assertEquals(12345, $response->getId());
    }

    public function testSendResponseOnMissingPayload()
    {
        $this->setupValidBase();
        $this->apns->setReadResponse(pack('CCN*', 4, 4, 12345));
        $response = $this->apns->send($this->message);
        $this->assertEquals(MessageResponse::RESULT_MISSING_PAYLOAD, $response->getCode());
        $this->assertEquals(12345, $response->getId());
    }

    public function testSendResponseOnInvalidTokenSize()
    {
        $this->setupValidBase();
        $this->apns->setReadResponse(pack('CCN*', 5, 5, 12345));
        $response = $this->apns->send($this->message);
        $this->assertEquals(MessageResponse::RESULT_INVALID_TOKEN_SIZE, $response->getCode());
        $this->assertEquals(12345, $response->getId());
    }

    public function testSendResponseOnInvalidTopicSize()
    {
        $this->setupValidBase();
        $this->apns->setReadResponse(pack('CCN*', 6, 6, 12345));
        $response = $this->apns->send($this->message);
        $this->assertEquals(MessageResponse::RESULT_INVALID_TOPIC_SIZE, $response->getCode());
        $this->assertEquals(12345, $response->getId());
    }

    public function testSendResponseOnInvalidPayloadSize()
    {
        $this->setupValidBase();
        $this->apns->setReadResponse(pack('CCN*', 7, 7, 12345));
        $response = $this->apns->send($this->message);
        $this->assertEquals(MessageResponse::RESULT_INVALID_PAYLOAD_SIZE, $response->getCode());
        $this->assertEquals(12345, $response->getId());
    }

    public function testSendResponseOnInvalidToken()
    {
        $this->setupValidBase();
        $this->apns->setReadResponse(pack('CCN*', 8, 8, 12345));
        $response = $this->apns->send($this->message);
        $this->assertEquals(MessageResponse::RESULT_INVALID_TOKEN, $response->getCode());
        $this->assertEquals(12345, $response->getId());
    }

    public function testSendResponseOnUnknownError()
    {
        $this->setupValidBase();
        $this->apns->setReadResponse(pack('CCN*', 255, 255, 12345));
        $response = $this->apns->send($this->message);
        $this->assertEquals(MessageResponse::RESULT_UNKNOWN_ERROR, $response->getCode());
        $this->assertEquals(12345, $response->getId());
    }
}
