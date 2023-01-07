<?php

/*
 * This file is part of the Mremi\UrlShortener library.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\UrlShortener\Tests\Provider\Google;

use GuzzleHttp\ClientInterface;
use Mremi\UrlShortener\Exception\InvalidApiResponseException;
use Mremi\UrlShortener\Model\LinkInterface;
use Mremi\UrlShortener\Provider\Google\GoogleProvider;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Tests GoogleProvider class.
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class GoogleProviderTest extends TestCase
{
    /**
     * @var object
     */
    private $provider;

    /**
     * Tests the getUri method with no API key and no parameters.
     */
    public function testGetUriWithNoApiKeyAndNoParameters()
    {
        $method = new \ReflectionMethod($this->provider, 'getUri');
        $method->setAccessible(true);

        $uri = $method->invoke($this->provider);

        $this->assertNull($uri);
    }

    /**
     * Tests the getUri method with no API key and some parameters.
     */
    public function testGetUriWithNoApiKeyAndSomeParameters()
    {
        $method = new \ReflectionMethod($this->provider, 'getUri');
        $method->setAccessible(true);

        $uri = $method->invoke($this->provider, ['foo' => 'bar']);

        $this->assertSame('?foo=bar', $uri);
    }

    /**
     * Tests the getUri method with API key and no parameters.
     */
    public function testGetUriWithApiKeyAndNoParameters()
    {
        $provider = new GoogleProvider('secret');

        $method = new \ReflectionMethod($provider, 'getUri');
        $method->setAccessible(true);

        $uri = $method->invoke($provider);

        $this->assertSame('?key=secret', $uri);
    }

    /**
     * Tests the getUri method with API key and some parameters.
     */
    public function testGetUriWithApiKeyAndSomeParameters()
    {
        $provider = new GoogleProvider('secret');

        $method = new \ReflectionMethod($provider, 'getUri');
        $method->setAccessible(true);

        $uri = $method->invoke($provider, ['foo' => 'bar']);

        $this->assertSame('?foo=bar&key=secret', $uri);
    }

    /**
     * Tests the shorten method throws exception if Google returns a string.
     */
    public function testShortenThrowsExceptionIfResponseApiIsString()
    {
        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage('Google response is probably mal-formed because cannot be json-decoded.');

        $this->mockClient($this->getMockResponseAsString(), 'post');

        $this->provider->shorten($this->getBaseMockLink());
    }

    /**
     * Tests the shorten method throws exception if Google returns an error response.
     */
    public function testShortenThrowsExceptionIfApiResponseIsError()
    {
        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage('Google returned status code "400" with message "Required"');

        $this->mockClient($this->getMockResponseWithError(), 'post');

        $this->provider->shorten($this->getBaseMockLink());
    }

    /**
     * Tests the shorten method throws exception if Google returns a response with no id.
     */
    public function testShortenThrowsExceptionIfApiResponseHasNoId()
    {
        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage('Property "id" does not exist within Google response.');

        $this->mockClient($this->getMockResponseWithNoId(), 'post');

        $this->provider->shorten($this->getBaseMockLink());
    }

    /**
     * Tests the shorten method throws exception if Google returns a response with no longUrl.
     */
    public function testShortenThrowsExceptionIfApiResponseHasNoLongUrl()
    {
        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage('Property "longUrl" does not exist within Google response.');

        $this->mockClient($this->getMockResponseWithNoLongUrl(), 'post');

        $this->provider->shorten($this->getBaseMockLink());
    }

    /**
     * Tests the shorten method with a valid Google's response.
     */
    public function testShortenWithValidApiResponse()
    {
        $response = $this->getBaseMockResponse();

        $apiRawResponse = <<<'JSON'
{
 "kind": "urlshortener#url",
 "id": "http://goo.gl/fbsS",
 "longUrl": "http://www.google.com/"
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
            ->with($this->equalTo('http://goo.gl/fbsS'));

        $this->mockClient($response, 'post');

        $this->provider->shorten($link);
    }

    /**
     * Tests the expand method throws exception if Google returns a string.
     */
    public function testExpandThrowsExceptionIfResponseApiIsString()
    {
        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage('Google response is probably mal-formed because cannot be json-decoded.');

        $this->mockClient($this->getMockResponseAsString(), 'get');

        $this->provider->expand($this->getBaseMockLink());
    }

    /**
     * Tests the expand method throws exception if Google returns an error response.
     */
    public function testExpandThrowsExceptionIfApiResponseIsError()
    {
        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage('Google returned status code "400" with message "Required"');

        $this->mockClient($this->getMockResponseWithError(), 'get');

        $this->provider->expand($this->getBaseMockLink());
    }

    /**
     * Tests the expand method throws exception if Google returns a response with no id.
     */
    public function testExpandThrowsExceptionIfApiResponseHasNoId()
    {
        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage('Property "id" does not exist within Google response.');

        $this->mockClient($this->getMockResponseWithNoId(), 'get');

        $this->provider->expand($this->getBaseMockLink());
    }

    /**
     * Tests the expand method throws exception if Google returns a response with no longUrl.
     */
    public function testExpandThrowsExceptionIfApiResponseHasNoLongUrl()
    {
        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage('Property "longUrl" does not exist within Google response.');

        $this->mockClient($this->getMockResponseWithNoLongUrl(), 'get');

        $this->provider->expand($this->getBaseMockLink());
    }

    /**
     * Tests the expand method throws exception if Google returns a response with no status.
     */
    public function testExpandThrowsExceptionIfApiResponseHasNoStatus()
    {
        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage('Property "status" does not exist within Google response.');

        $response = $this->getBaseMockResponse();

        $apiRawResponse = <<<'JSON'
{
 "kind": "urlshortener#url",
 "id": "http://goo.gl/fbsS",
 "longUrl": "http://www.google.com/"
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

        $this->mockClient($response, 'get');

        $this->provider->expand($this->getBaseMockLink());
    }

    /**
     * Tests the expand method throws exception if Google returns an invalid status code.
     */
    public function testExpandThrowsExceptionIfApiResponseHasInvalidStatusCode()
    {
        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage('Google returned status code "KO".');

        $response = $this->getBaseMockResponse();

        $apiRawResponse = <<<'JSON'
{
 "kind": "urlshortener#url",
 "id": "http://goo.gl/fbsS",
 "longUrl": "http://www.google.com/",
 "status": "KO"
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

        $this->mockClient($response, 'get');

        $this->provider->expand($this->getBaseMockLink());
    }

    /**
     * Tests the expand method with a valid Google's response.
     */
    public function testExpandWithValidApiResponse()
    {
        $response = $this->getBaseMockResponse();

        $apiRawResponse = <<<'JSON'
{
 "kind": "urlshortener#url",
 "id": "http://goo.gl/fbsS",
 "longUrl": "http://www.google.com/",
 "status": "OK"
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

        $link = $this->getMockShortLink();
        $link
            ->expects($this->once())
            ->method('setLongUrl')
            ->with($this->equalTo('http://www.google.com/'));

        $this->mockClient($response, 'get');

        $this->provider->expand($link);
    }

    /**
     * Initializes the provider.
     */
    protected function setUp()
    {
        $this->provider = $this->getMockBuilder(GoogleProvider::class)
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
     * Gets a mocked response.
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
     * Returns a response object with "error" node.
     *
     * @return object
     */
    private function getMockResponseWithError()
    {
        $response = $this->getBaseMockResponse();

        $apiRawResponse = <<<'JSON'
{
 "error": {
  "errors": [
   {
    "domain": "global",
    "reason": "required",
    "message": "Required",
    "locationType": "parameter",
    "location": "resource.longUrl"
   }
  ],
  "code": 400,
  "message": "Required"
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

        return $response;
    }

    /**
     * Returns a response object with no "id" node.
     *
     * @return object
     */
    private function getMockResponseWithNoId()
    {
        $response = $this->getBaseMockResponse();

        $apiRawResponse = <<<'JSON'
{
 "kind": "urlshortener#url",
 "longUrl": "http://www.google.com/"
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
     * Returns a response object with no "longUrl" node.
     *
     * @return object
     */
    private function getMockResponseWithNoLongUrl()
    {
        $response = $this->getBaseMockResponse();

        $apiRawResponse = <<<'JSON'
{
 "kind": "urlshortener#url",
 "id": "http://goo.gl/fbsS"
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
     * @param object $response      A mocked response
     * @param string $requestMethod A request method (get|post)
     */
    private function mockClient($response, $requestMethod)
    {
        $client = $this->getMockBuilder(ClientInterface::class)
            ->setMethods(['send', 'sendAsync', 'request', 'requestAsync', 'getConfig', 'get', 'post'])
            ->getMock();
        $client
            ->expects($this->once())
            ->method($requestMethod)
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
            ->will($this->returnValue('http://goo.gl/fbsS'));

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
