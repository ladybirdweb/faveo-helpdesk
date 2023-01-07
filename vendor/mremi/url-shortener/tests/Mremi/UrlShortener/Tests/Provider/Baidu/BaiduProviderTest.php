<?php

/*
 * This file is part of the Mremi\UrlShortener library.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\UrlShortener\Tests\Provider\Baidu;

use GuzzleHttp\ClientInterface;
use Mremi\UrlShortener\Exception\InvalidApiResponseException;
use Mremi\UrlShortener\Model\LinkInterface;
use Mremi\UrlShortener\Provider\Baidu\BaiduProvider;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Tests BaiduProvider class.
 *
 * @author zacksleo <zacksleo@gmail.com>
 */
class BaiduProviderTest extends TestCase
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
        $this->provider = $this->getMockBuilder(BaiduProvider::class)
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
     * Tests the shorten method throws exception if Baidu returns a string.
     */
    public function testShortenThrowsExceptionIfResponseApiIsString()
    {
        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage('Baidu response is probably mal-formed because cannot be json-decoded.');

        $this->mockClient($this->getMockResponseAsString(), 'post');

        $this->provider->shorten($this->getBaseMockLink());
    }

    /**
     * Tests the shorten method throws exception if Baidu returns an error response.
     */
    public function testShortenThrowsExceptionIfApiResponseIsError()
    {
        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage('Baidu returned code error message "-1: long url is not valid');

        $this->mockClient($this->getMockResponseWithError(), 'post');

        $this->provider->shorten($this->getBaseMockLink());
    }

    /**
     * Tests the shorten method throws exception if Baidu returns a response with no short url.
     */
    public function testShortenThrowsExceptionIfApiResponseHasNoShortUrl()
    {
        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage('Baidu returned code error message "-1: unsafe url');

        $this->mockClient($this->getMockResponseWithNoShortUrl(), 'post');

        $this->provider->shorten($this->getBaseMockLink());
    }

    /**
     * Tests the shorten method with a valid Baidu's response.
     */
    public function testShortenWithValidApiResponse()
    {
        $response = $this->getBaseMockResponse();

        $apiRawResponse = <<<'JSON'
{
 "Code": 0,
 "ShortUrl": "https://dwz.cn/OErDnjcx",
 "LongUrl": "http://www.google.com/",
 "ErrMsg": ""
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
            ->with($this->equalTo('https://dwz.cn/OErDnjcx'));

        $this->mockClient($response, 'post');

        $this->provider->shorten($link);
    }

    /**
     * Tests the expand method throws exception if Baidu returns a string.
     */
    public function testExpandThrowsExceptionIfResponseApiIsString()
    {
        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage('Baidu response is probably mal-formed because cannot be json-decoded.');

        $this->mockClient($this->getMockResponseAsString(), 'post');

        $this->provider->expand($this->getBaseMockLink());
    }

    /**
     * Tests the expand method throws exception if Baidu returns an error response.
     */
    public function testExpandThrowsExceptionIfApiResponseIsError()
    {
        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage('Baidu returned code error message "-1: long url is not valid');

        $this->mockClient($this->getMockResponseWithError(), 'post');

        $this->provider->expand($this->getBaseMockLink());
    }

    /**
     * Tests the expand method throws exception if Baidu returns a response with no longUrl.
     */
    public function testExpandThrowsExceptionIfApiResponseHasNoLongUrl()
    {
        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage('Baidu returned code error message "-2: short url dose not exist');

        $this->mockClient($this->getMockResponseWithNoLongUrl(), 'post');

        $this->provider->expand($this->getBaseMockLink());
    }

    /**
     * Tests the expand method throws exception if Baidu returns a response with no status.
     */
    public function testExpandThrowsExceptionIfApiResponseHasNoStatus()
    {
        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage('Property "Code" does not exist within Baidu response.');

        $response = $this->getBaseMockResponse();

        $apiRawResponse = <<<'JSON'
{
"ShortUrl": "https://dwz.cn/OErDnjcx",
"LongUrl": "http://www.google.com/",
"ErrMsg": ""
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

        $this->mockClient($response, 'post');

        $this->provider->expand($this->getBaseMockLink());
    }

    /**
     * Tests the expand method with a valid Baidu's response.
     */
    public function testExpandWithValidApiResponse()
    {
        $response = $this->getBaseMockResponse();

        $apiRawResponse = <<<'JSON'
{
"Code": 0,
"ShortUrl": "https://dwz.cn/OErDnjcx",
"LongUrl": "http://www.google.com/",
"ErrMsg": ""
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

        $this->mockClient($response, 'post');

        $this->provider->expand($link);
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
"Code": -1,
"ShortUrl": "http://www.google.com/",
"LongUrl": ":",
"ErrMsg": "long url is not valid"
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
    private function getMockResponseWithNoShortUrl()
    {
        $response = $this->getBaseMockResponse();

        $apiRawResponse = <<<'JSON'
{
 "Code": -1,
 "LongUrl": "http://www.google.com/",
 "ErrMsg": "unsafe url"
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
     * Returns a response object with no "LongUrl" node.
     *
     * @return object
     */
    private function getMockResponseWithNoLongUrl()
    {
        $response = $this->getBaseMockResponse();

        $apiRawResponse = <<<'JSON'
{
"Code": -2,
"ShortUrl": "https://dwz.cn/OErDnjcxd",
"LongUrl": "",
"ErrMsg": "short url dose not exist"
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
            ->will($this->returnValue('https://dwz.cn/OErDnjcx'));

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
