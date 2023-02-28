<?php

/*
 * This file is part of the Mremi\UrlShortener library.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\UrlShortener\Tests\Provider\Bitly;

use GuzzleHttp\ClientInterface;
use Mremi\UrlShortener\Exception\InvalidApiResponseException;
use Mremi\UrlShortener\Model\LinkInterface;
use Mremi\UrlShortener\Provider\Bitly\AuthenticationInterface;
use Mremi\UrlShortener\Provider\Bitly\BitlyProvider;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Tests BitlyProvider class.
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class BitlyProviderTest extends TestCase
{
    /**
     * @var object
     */
    private $provider;

    /**
     * Tests the shorten method throws exception if Bit.ly returns a string.
     */
    public function testShortenThrowsExceptionIfApiResponseIsString()
    {
        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage('Bit.ly response is probably mal-formed because cannot be json-decoded.');

        $this->mockClient($this->getMockResponseAsString());

        $this->provider->shorten($this->getBaseMockLink());
    }

    /**
     * Tests the shorten method throws exception if Bit.ly returns an invalid status code.
     */
    public function testShortenThrowsExceptionIfApiResponseHasInvalidStatusCode()
    {
        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage('Bit.ly returned status code "404" with message "NOT_FOUND"');

        $this->mockClient($this->getMockResponseWithInvalidStatusCode());

        $this->provider->shorten($this->getBaseMockLink());
    }

    /**
     * Tests the shorten method with a valid Bit.ly's response.
     */
    public function testShortenWithValidApiResponse()
    {
        $response = $this->getBaseMockResponse();

        $apiRawResponse = <<<'JSON'
{
  "id": "bit.ly/ze6poY",
  "link": "http://bit.ly/ze6poY",
  "long_url": "http://www.google.com/",
  "created_at": "2012-03-12T16:18:23+0000",
  "created_by": "xyzzy",
  "client_id": "3f5101961529477287d0714a17a68023",
  "references": {
    "group": "https://api-ssl.bitly.com/v4/groups/74a81764c9d9"
  }
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

        $response
            ->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(201));

        $link = $this->getMockLongLink();
        $link
            ->expects($this->once())
            ->method('setShortUrl')
            ->with($this->equalTo('http://bit.ly/ze6poY'));

        $this->mockClient($response);

        $this->provider->shorten($link);
    }

    /**
     * Tests the expand method throws exception if Bit.ly returns a string.
     */
    public function testExpandThrowsExceptionIfApiResponseIsString()
    {
        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage('Bit.ly response is probably mal-formed because cannot be json-decoded.');

        $this->mockClient($this->getMockResponseAsString());

        $this->provider->expand($this->getBaseMockLink());
    }

    /**
     * Tests the expand method throws exception if Bit.ly returns an invalid status code.
     */
    public function testExpandThrowsExceptionIfApiResponseHasInvalidStatusCode()
    {
        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage('Bit.ly returned status code "404" with message "NOT_FOUND"');

        $this->mockClient($this->getMockResponseWithInvalidStatusCode());

        $this->provider->expand($this->getBaseMockLink());
    }

    /**
     * Tests the expand method with a valid Bit.ly's response.
     */
    public function testExpandWithValidApiResponse()
    {
        $response = $this->getBaseMockResponse();

        $apiRawResponse = <<<'JSON'
{
  "id":"bit.ly/ze6poY",
  "link":"http://bit.ly/ze6poY",
  "long_url": "http://www.google.com/",
  "created_at":"2012-03-12T16:18:23+0000"
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

        $response
            ->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(200));

        $link = $this->getMockShortLink();
        $link
            ->expects($this->once())
            ->method('setLongUrl')
            ->with($this->equalTo('http://www.google.com/'));

        $this->mockClient($response);

        $this->provider->expand($link);
    }

    /**
     * Initializes the provider.
     */
    protected function setUp()
    {
        $auth = $this->createMock(AuthenticationInterface::class);

        $this->provider = $this->getMockBuilder(BitlyProvider::class)
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
  "id":"bit.ly/ze6poY",
  "link":"http://bit.ly/ze6poY",
  "longUrl": "http://www.google.com/",
  "createdAt":"2012-03-12T16:18:23+0000"
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

        $response
            ->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(200));

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
  "message": "NOT_FOUND",
  "resource": "bitlinks",
  "description": "What you are looking for cannot be found."
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

        $response
            ->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(404));

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
            ->will($this->returnValue('http://bit.ly/ze6poY'));

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
