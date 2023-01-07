<?php

/*
 * This file is part of the Mremi\UrlShortener library.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\UrlShortener\Tests\Provider\Wechat;

use GuzzleHttp\ClientInterface;
use Mremi\UrlShortener\Exception\InvalidApiResponseException;
use Mremi\UrlShortener\Model\LinkInterface;
use Mremi\UrlShortener\Provider\Bitly\AuthenticationInterface;
use Mremi\UrlShortener\Provider\Wechat\WechatProvider;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Tests WechatProvider class.
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class WechatProviderTest extends TestCase
{
    /**
     * @var object
     */
    private $provider;

    /**
     * Initializes the provider.
     */
    protected function setUp()
    {
        $auth = $this->createMock(AuthenticationInterface::class);

        $this->provider = $this->getMockBuilder(WechatProvider::class)
            ->setConstructorArgs([$auth])
            ->setMethods(['createClient'])
            ->getMock();
    }

    /**
     * Cleanups the provider.
     */
    protected function tearDown()
    {
        $this->provider = null;
    }

    /**
     * Tests the shorten method throws exception if Wechat returns a string.
     */
    public function testShortenThrowsExceptionIfApiResponseIsString()
    {
        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage('Wechat response is probably mal-formed because cannot be json-decoded.');

        $this->mockClient($this->getMockResponseAsString());

        $this->provider->shorten($this->getBaseMockLink());
    }

    /**
     * Tests the shorten method throws exception if Wechat returns a response with no errcode.
     */
    public function testShortenThrowsExceptionIfApiResponseHasNoErrorCode()
    {
        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage('Property "errcode" does not exist within Wechat response.');

        $this->mockClient($this->getMockResponseAsInvalidObject());

        $this->provider->shorten($this->getBaseMockLink());
    }

    /**
     * Tests the shorten method throws exception if Wechat returns an invalid status code.
     */
    public function testShortenThrowsExceptionIfApiResponseHasInvalidStatusCode()
    {
        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage('Wechat returned status code "40001" with message "invalid credential, access_token is invalid or not latest hint: [miSs30226vr31!]"');

        $this->mockClient($this->getMockResponseWithInvalidStatusCode());

        $this->provider->shorten($this->getBaseMockLink());
    }

    /**
     * Tests the shorten method with a valid Wechat's response.
     */
    public function testShortenWithValidApiResponse()
    {
        $response = $this->getBaseMockResponse();

        $apiRawResponse = <<<'JSON'
{
    "errcode": 0,
    "errmsg": "ok",
    "short_url": "https://w.url.cn/s/ATYfzFm"
}
JSON;

        $stream = $this->getBaseMockStream();
        $stream
            ->expects($this->once())
            ->method('getContents')
            ->will($this->returnValue($apiRawResponse));

        $response
            ->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($stream));

        $link = $this->getMockLongLink();
        $link
            ->expects($this->once())
            ->method('setShortUrl')
            ->with($this->equalTo('https://w.url.cn/s/ATYfzFm'));

        $this->mockClient($response);

        $this->provider->shorten($link);
    }

    /**
     * Tests the expand method throws exception if Wechat returns a string.
     */
    public function testExpandThrowsExceptionIfApiResponseIsString()
    {
        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage('Wechat does not support expand url yet.');

        //$this->mockClient($this->getMockResponseAsString());

        $this->provider->expand($this->getBaseMockLink());
    }

    /**
     * Gets mock of response.
     *
     * @return object
     */
    private function getBaseMockResponse()
    {
        return $this->createMock(ResponseInterface::class);
    }

    /**
     * Gets mock of stream.
     *
     * @return object
     */
    private function getBaseMockStream()
    {
        return $this->createMock(StreamInterface::class);
    }

    /**
     * Returns an invalid response string.
     *
     * @return object
     */
    private function getMockResponseAsString()
    {
        $stream = $this->getBaseMockStream();
        $stream
            ->expects($this->once())
            ->method('getContents')
            ->will($this->returnValue('foo'));

        $response = $this->getBaseMockResponse();

        $response
            ->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($stream));

        return $response;
    }

    /**
     * Returns an invalid response object.
     *
     * @return object
     */
    private function getMockResponseAsInvalidObject()
    {
        $response = $this->getBaseMockResponse();

        $apiRawResponse = <<<'JSON'
{
    "errmsg": "ok",
    "url": "https://w.url.cn/s/AK0wSn1"
}
JSON;

        $stream = $this->getBaseMockStream();
        $stream
            ->expects($this->once())
            ->method('getContents')
            ->will($this->returnValue($apiRawResponse));

        $response
            ->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($stream));

        return $response;
    }

    /**
     * Returns a response with an invalid status code.
     *
     * @return object
     */
    private function getMockResponseWithInvalidStatusCode()
    {
        $response = $this->getBaseMockResponse();

        $apiRawResponse = <<<'JSON'
{
    "errcode": 40001,
    "errmsg": "invalid credential, access_token is invalid or not latest hint: [miSs30226vr31!]"
}
JSON;

        $stream = $this->getBaseMockStream();
        $stream
            ->expects($this->once())
            ->method('getContents')
            ->will($this->returnValue($apiRawResponse));

        $response
            ->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($stream));

        return $response;
    }

    /**
     * Mocks the client.
     *
     * @param object $response
     */
    private function mockClient($response)
    {
        $client = $this->getMockBuilder(ClientInterface::class)
            ->setMethods(['send', 'sendAsync', 'request', 'requestAsync', 'getConfig', 'get', 'post'])
            ->getMock();
        $client
            ->expects($this->once())
            ->method('post')
            ->will($this->returnValue($response));

        $this->provider
            ->expects($this->once())
            ->method('createClient')
            ->will($this->returnValue($client));
    }

    /**
     * Gets mock of link.
     *
     * @return object
     */
    private function getBaseMockLink()
    {
        return $this->createMock(LinkInterface::class);
    }

    /**
     * Gets mock of short link.
     *
     * @return object
     */
    private function getMockShortLink()
    {
        $link = $this->getBaseMockLink();

        $link
            ->expects($this->once())
            ->method('getShortUrl')
            ->will($this->returnValue('https://w.url.cn/s/ATYfzFm'));

        return $link;
    }

    /**
     * Gets mock of long link.
     *
     * @return object
     */
    private function getMockLongLink()
    {
        $link = $this->getBaseMockLink();

        $link
            ->expects($this->once())
            ->method('getLongUrl')
            ->will($this->returnValue('http://www.google.com/'));

        return $link;
    }
}
