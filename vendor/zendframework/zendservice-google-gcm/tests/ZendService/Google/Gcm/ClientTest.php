<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link       http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright  Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @category   ZendService
 * @package    ZendService_Google
 * @subpackage UnitTests
 */

namespace ZendServiceTest\Google\Gcm;

use Zend\Http\Client\Adapter\Test;
use Zend\Http\Client as HttpClient;
use ZendService\Google\Gcm\Client;
use ZendService\Google\Gcm\Message;
use ZendService\Google\Gcm\Response;

/**
 * @category   ZendService
 * @package    ZendService_Google
 * @subpackage UnitTests
 * @group      ZendService
 * @group      ZendService_Google
 * @group      ZendService_Google_Gcm
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    protected $httpAdapter;
    protected $httpClient;
    protected $gcmClient;
    protected $message;

    protected function _createJSONResponse($id, $success, $failure, $ids, $results)
    {
        return json_encode(array(
            'multicast_id' => $id,
            'success' => $success,
            'failure' => $failure,
            'canonical_ids' => $ids,
            'results' => $results
        ));
    }

    public function setUp()
    {
        $this->httpClient = new HttpClient();
        $this->httpAdapter = new Test();
        $this->httpClient->setAdapter($this->httpAdapter);
        $this->gcmClient = new Client();
        $this->gcmClient->setHttpClient($this->httpClient);
        $this->gcmClient->setApiKey('testing');
        $this->message = new Message();
        $this->message->addRegistrationId('testing');
        $this->message->addData('testKey', 'testValue');
    }

    public function testSetApiKeyThrowsExceptionOnNonString()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->gcmClient->setApiKey(array());
    }

    public function testSetApiKey()
    {
        $key = 'a-login-token';
        $this->gcmClient->setApiKey($key);
        $this->assertEquals($key, $this->gcmClient->getApiKey());
    }

    public function testGetHttpClientReturnsDefault()
    {
        $gcm = new Client();
        $this->assertEquals('Zend\Http\Client', get_class($gcm->getHttpClient()));
        $this->assertTrue($gcm->getHttpClient() instanceof HttpClient);
    }

    public function testSetHttpClient()
    {
        $client = new HttpClient();
        $this->gcmClient->setHttpClient($client);
        $this->assertEquals($client, $this->gcmClient->getHttpClient());
    }

    public function testSendThrowsExceptionWhenServiceUnavailable()
    {
        $this->setExpectedException('RuntimeException');
        $this->httpAdapter->setResponse('HTTP/1.1 503 Service Unavailable' . "\r\n\r\n");
        $this->gcmClient->send($this->message);
    }

    public function testSendThrowsExceptionWhenServerUnavailable()
    {
        $this->setExpectedException('RuntimeException');
        $this->httpAdapter->setResponse('HTTP/1.1 500 Internal Server Error' . "\r\n\r\n");
        $this->gcmClient->send($this->message);
    }

    public function testSendThrowsExceptionWhenInvalidAuthToken()
    {
        $this->setExpectedException('RuntimeException');
        $this->httpAdapter->setResponse('HTTP/1.1 401 Unauthorized' . "\r\n\r\n");
        $this->gcmClient->send($this->message);
    }

    public function testSendThrowsExceptionWhenInvalidPayload()
    {
        $this->setExpectedException('RuntimeException');
        $this->httpAdapter->setResponse('HTTP/1.1 400 Bad Request' . "\r\n\r\n");
        $this->gcmClient->send($this->message);
    }

    public function testSendResultInvalidRegistrationId()
    {
        $body = $this->_createJSONResponse(101, 0, 1, 0, array(array('error' => 'InvalidRegistration')));
        $this->httpAdapter->setResponse(
            'HTTP/1.1 200 OK' . "\r\n" .
            'Context-Type: text/html' . "\r\n\r\n" .
            $body
        );
        $response = $this->gcmClient->send($this->message);
        $result = $response->getResults();
        $result = array_shift($result);
        $this->assertEquals('InvalidRegistration', $result['error']);
        $this->assertEquals(0, $response->getSuccessCount());
        $this->assertEquals(0, $response->getCanonicalCount());
        $this->assertEquals(1, $response->getFailureCount());
    }

    public function testSendResultMismatchSenderId()
    {
        $body = $this->_createJSONResponse(101, 0, 1, 0, array(array('error' => 'MismatchSenderId')));
        $this->httpAdapter->setResponse(
            'HTTP/1.1 200 OK' . "\r\n" .
            'Context-Type: text/html' . "\r\n\r\n" .
            $body
        );
        $response = $this->gcmClient->send($this->message);
        $result = $response->getResults();
        $result = array_shift($result);
        $this->assertEquals('MismatchSenderId', $result['error']);
        $this->assertEquals(0, $response->getSuccessCount());
        $this->assertEquals(0, $response->getCanonicalCount());
        $this->assertEquals(1, $response->getFailureCount());
    }

    public function testSendResultNotRegistered()
    {
        $body = $this->_createJSONResponse(101, 0, 1, 0, array(array('error' => 'NotRegistered')));
        $this->httpAdapter->setResponse(
            'HTTP/1.1 200 OK' . "\r\n" .
            'Context-Type: text/html' . "\r\n\r\n" .
            $body
        );
        $response = $this->gcmClient->send($this->message);
        $result = $response->getResults();
        $result = array_shift($result);
        $this->assertEquals('NotRegistered', $result['error']);
        $this->assertEquals(0, $response->getSuccessCount());
        $this->assertEquals(0, $response->getCanonicalCount());
        $this->assertEquals(1, $response->getFailureCount());
    }

    public function testSendResultMessageTooBig()
    {
        $body = $this->_createJSONResponse(101, 0, 1, 0, array(array('error' => 'MessageTooBig')));
        $this->httpAdapter->setResponse(
            'HTTP/1.1 200 OK' . "\r\n" .
            'Context-Type: text/html' . "\r\n\r\n" .
            $body
        );
        $response = $this->gcmClient->send($this->message);
        $result = $response->getResults();
        $result = array_shift($result);
        $this->assertEquals('MessageTooBig', $result['error']);
        $this->assertEquals(0, $response->getSuccessCount());
        $this->assertEquals(0, $response->getCanonicalCount());
        $this->assertEquals(1, $response->getFailureCount());
    }

    public function testSendResultSuccessful()
    {
        $body = $this->_createJSONResponse(101, 1, 0, 0, array(array('message_id' => '1:2342')));
        $this->httpAdapter->setResponse(
            'HTTP/1.1 200 OK' . "\r\n" .
            'Context-Type: text/html' . "\r\n\r\n" .
            $body
        );
        $response = $this->gcmClient->send($this->message);
        $result = $response->getResults();
        $result = array_shift($result);
        $this->assertEquals('1:2342', $result['message_id']);
        $this->assertEquals(1, $response->getSuccessCount());
        $this->assertEquals(0, $response->getCanonicalCount());
        $this->assertEquals(0, $response->getFailureCount());
    }

    public function testSendResultSuccessfulWithRegistrationId()
    {
        $body = $this->_createJSONResponse(101, 1, 0, 1, array(array('message_id' => '1:2342', 'registration_id' => 'testfoo')));
        $this->httpAdapter->setResponse(
            'HTTP/1.1 200 OK' . "\r\n" .
            'Context-Type: text/html' . "\r\n\r\n" .
            $body
        );
        $response = $this->gcmClient->send($this->message);
        $result = $response->getResults();
        $result = array_shift($result);
        $this->assertEquals('1:2342', $result['message_id']);
        $this->assertEquals('testfoo', $result['registration_id']);
        $this->assertEquals(1, $response->getSuccessCount());
        $this->assertEquals(1, $response->getCanonicalCount());
        $this->assertEquals(0, $response->getFailureCount());
    }
}
