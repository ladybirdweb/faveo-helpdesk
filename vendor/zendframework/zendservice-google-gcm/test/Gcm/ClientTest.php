<?php
/**
 * Zend Framework (http://framework.zend.com/).
 *
 * @link       http://github.com/zendframework/zf2 for the canonical source repository
 *
 * @copyright  Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 *
 * @category   ZendService
 */
namespace ZendServiceTest\Google\Gcm;

use PHPUnit\Framework\TestCase;
use Zend\Http\Client\Adapter\Test;
use Zend\Http\Client as HttpClient;
use ZendService\Google\Gcm\Client;
use ZendService\Google\Gcm\Message;

/**
 * @category   ZendService
 * @group      ZendService
 * @group      ZendService_Google
 * @group      ZendService_Google_Gcm
 */
class ClientTest extends TestCase
{
    /**
     * @var Test
     */
    protected $httpAdapter;
    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var Client
     */
    protected $gcmClient;

    /**
     * @var Message
     */
    protected $message;

    protected function createJSONResponse($id, $success, $failure, $ids, $results)
    {
        return json_encode([
            'multicast_id' => $id,
            'success' => $success,
            'failure' => $failure,
            'canonical_ids' => $ids,
            'results' => $results,
        ]);
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
        $this->expectException('InvalidArgumentException');
        $this->gcmClient->setApiKey([]);
    }

    public function testSetApiKey()
    {
        $key = 'a-login-token';
        $this->gcmClient->setApiKey($key);
        self::assertEquals($key, $this->gcmClient->getApiKey());
    }

    public function testGetHttpClientReturnsDefault()
    {
        self::assertInstanceOf('Zend\Http\Client', (new Client())->getHttpClient());
    }

    public function testSetHttpClient()
    {
        $client = new HttpClient();
        $this->gcmClient->setHttpClient($client);
        self::assertEquals($client, $this->gcmClient->getHttpClient());
    }

    public function testSendThrowsExceptionWhenServiceUnavailable()
    {
        $this->expectException('RuntimeException');
        $this->httpAdapter->setResponse('HTTP/1.1 503 Service Unavailable'."\r\n\r\n");
        $this->gcmClient->send($this->message);
    }

    public function testSendThrowsExceptionWhenServerUnavailable()
    {
        $this->expectException('RuntimeException');
        $this->httpAdapter->setResponse('HTTP/1.1 500 Internal Server Error'."\r\n\r\n");
        $this->gcmClient->send($this->message);
    }

    public function testSendThrowsExceptionWhenInvalidAuthToken()
    {
        $this->expectException('RuntimeException');
        $this->httpAdapter->setResponse('HTTP/1.1 401 Unauthorized'."\r\n\r\n");
        $this->gcmClient->send($this->message);
    }

    public function testSendThrowsExceptionWhenInvalidPayload()
    {
        $this->expectException('RuntimeException');
        $this->httpAdapter->setResponse('HTTP/1.1 400 Bad Request'."\r\n\r\n");
        $this->gcmClient->send($this->message);
    }

    public function testSendResultInvalidRegistrationId()
    {
        $body = $this->createJSONResponse(101, 0, 1, 0, [['error' => 'InvalidRegistration']]);
        $this->httpAdapter->setResponse(
            'HTTP/1.1 200 OK'."\r\n".
            'Context-Type: text/html'."\r\n\r\n".
            $body
        );
        $response = $this->gcmClient->send($this->message);
        $result = $response->getResults();
        $result = array_shift($result);
        self::assertEquals('InvalidRegistration', $result['error']);
        self::assertEquals(0, $response->getSuccessCount());
        self::assertEquals(0, $response->getCanonicalCount());
        self::assertEquals(1, $response->getFailureCount());
    }

    public function testSendResultMismatchSenderId()
    {
        $body = $this->createJSONResponse(101, 0, 1, 0, [['error' => 'MismatchSenderId']]);
        $this->httpAdapter->setResponse(
            'HTTP/1.1 200 OK'."\r\n".
            'Context-Type: text/html'."\r\n\r\n".
            $body
        );
        $response = $this->gcmClient->send($this->message);
        $result = $response->getResults();
        $result = array_shift($result);
        self::assertEquals('MismatchSenderId', $result['error']);
        self::assertEquals(0, $response->getSuccessCount());
        self::assertEquals(0, $response->getCanonicalCount());
        self::assertEquals(1, $response->getFailureCount());
    }

    public function testSendResultNotRegistered()
    {
        $body = $this->createJSONResponse(101, 0, 1, 0, [['error' => 'NotRegistered']]);
        $this->httpAdapter->setResponse(
            'HTTP/1.1 200 OK'."\r\n".
            'Context-Type: text/html'."\r\n\r\n".
            $body
        );
        $response = $this->gcmClient->send($this->message);
        $result = $response->getResults();
        $result = array_shift($result);
        self::assertEquals('NotRegistered', $result['error']);
        self::assertEquals(0, $response->getSuccessCount());
        self::assertEquals(0, $response->getCanonicalCount());
        self::assertEquals(1, $response->getFailureCount());
    }

    public function testSendResultMessageTooBig()
    {
        $body = $this->createJSONResponse(101, 0, 1, 0, [['error' => 'MessageTooBig']]);
        $this->httpAdapter->setResponse(
            'HTTP/1.1 200 OK'."\r\n".
            'Context-Type: text/html'."\r\n\r\n".
            $body
        );
        $response = $this->gcmClient->send($this->message);
        $result = $response->getResults();
        $result = array_shift($result);
        self::assertEquals('MessageTooBig', $result['error']);
        self::assertEquals(0, $response->getSuccessCount());
        self::assertEquals(0, $response->getCanonicalCount());
        self::assertEquals(1, $response->getFailureCount());
    }

    public function testSendResultSuccessful()
    {
        $body = $this->createJSONResponse(101, 1, 0, 0, [['message_id' => '1:2342']]);
        $this->httpAdapter->setResponse(
            'HTTP/1.1 200 OK'."\r\n".
            'Context-Type: text/html'."\r\n\r\n".
            $body
        );
        $response = $this->gcmClient->send($this->message);
        $result = $response->getResults();
        $result = array_shift($result);
        self::assertEquals('1:2342', $result['message_id']);
        self::assertEquals(1, $response->getSuccessCount());
        self::assertEquals(0, $response->getCanonicalCount());
        self::assertEquals(0, $response->getFailureCount());
    }

    public function testSendResultSuccessfulWithRegistrationId()
    {
        $body = $this->createJSONResponse(101, 1, 0, 1, [['message_id' => '1:2342', 'registration_id' => 'testfoo']]);
        $this->httpAdapter->setResponse(
            'HTTP/1.1 200 OK'."\r\n".
            'Context-Type: text/html'."\r\n\r\n".
            $body
        );
        $response = $this->gcmClient->send($this->message);
        $result = $response->getResults();
        $result = array_shift($result);
        self::assertEquals('1:2342', $result['message_id']);
        self::assertEquals('testfoo', $result['registration_id']);
        self::assertEquals(1, $response->getSuccessCount());
        self::assertEquals(1, $response->getCanonicalCount());
        self::assertEquals(0, $response->getFailureCount());
    }
}
