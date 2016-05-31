<?php

namespace MaxMind\Test\WebService;

use MaxMind\WebService\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{

    public function test200()
    {
        $this->assertEquals(
            array('a' => 'b'),
            $this->withResponse(
                '200',
                'application/json',
                '{"a":"b"}'
            ),
            'received expected decoded response'
        );
    }

    public function testOptions()
    {
        $this->runRequest(
            'TestService',
            '/path',
            array(),
            200,
            'application/json',
            '{}',
            3213,
            'abcdefghij',
            array(
                'caBundle' => '/path/to/ca.pem',
                'timeout' => 100,
                'connectTimeout' => 15,
                'userAgent' => 'TestClient/1',

            )
        );
    }

    /**
     * @expectedException MaxMind\Exception\WebServiceException
     * @expectedExceptionMessage Received a 200 response for TestService but could not decode the response as JSON: Syntax error. Body: {
     */
    public function test200WithInvalidJson()
    {
        $this->withResponse('200', 'application/json', '{');
    }

    /**
     * @expectedException MaxMind\Exception\InsufficientFundsException
     * @expectedExceptionMessage out of credit
     */
    public function testInsufficientFunds()
    {
        $this->withResponse(
            '402',
            'application/json',
            '{"code":"INSUFFICIENT_FUNDS","error":"out of credit"}'
        );
    }

    /**
     * @expectedException MaxMind\Exception\AuthenticationException
     * @expectedExceptionMessage Invalid auth
     * @dataProvider invalidAuthCodes
     */
    public function testInvalidAuth($code)
    {
        $this->withResponse(
            '401',
            'application/json',
            '{"code":"' . $code . '","error":"Invalid auth"}'
        );
    }

    public function invalidAuthCodes()
    {
        return array(
            array('AUTHORIZATION_INVALID'),
            array('LICENSE_KEY_REQUIRED'),
            array('USER_ID_REQUIRED')
        );
    }

    /**
     * @expectedException MaxMind\Exception\InvalidRequestException
     * @expectedExceptionMessage IP invalid
     */
    public function testInvalidRequest()
    {
        $this->withResponse(
            '400',
            'application/json',
            '{"code":"IP_ADDRESS_INVALID","error":"IP invalid"}'
        );
    }

    /**
     * @expectedException MaxMind\Exception\WebServiceException
     * @expectedExceptionMessage Received a 400 error for TestService but could not decode the response as JSON: Syntax error. Body: {"blah"}
     */
    public function test400WithInvalidJson()
    {
        $this->withResponse('400', 'application/json', '{"blah"}');
    }

    /**
     * @expectedException MaxMind\Exception\HttpException
     * @expectedExceptionMessage Received a 400 error for TestService with no body
     */
    public function test400WithNoBody()
    {
        $this->withResponse('400', 'application/json', '');
    }

    /**
     * @expectedException MaxMind\Exception\HttpException
     * @expectedExceptionMessage Received a 400 error for TestService with the following body: text
     */
    public function test400WithUnexpectedContentType()
    {
        $this->withResponse('400', 'text/plain', 'text');
    }

    /**
     * @expectedException MaxMind\Exception\HttpException
     * @expectedExceptionMessage Error response contains JSON but it does not specify code or error keys: {"not":"expected"}
     */
    public function test400WithUnexpectedJson()
    {
        $this->withResponse('400', 'application/json', '{"not":"expected"}');
    }

    /**
     * @expectedException MaxMind\Exception\HttpException
     * @expectedExceptionMessage Received an unexpected HTTP status (300) for TestService
     */
    public function test300()
    {
        $this->withResponse('300', 'application/json', '');
    }

    /**
     * @expectedException MaxMind\Exception\HttpException
     * @expectedExceptionMessage Received a server error (500) for TestService
     */
    public function test500()
    {
        $this->withResponse('500', 'application/json', '');
    }

    // convenience method when you don't care about the request
    private function withResponse($statusCode, $contentType, $body)
    {
        return $this->runRequest(
            'TestService',
            '/path',
            array(),
            $statusCode,
            $contentType,
            $body
        );
    }

    private function runRequest(
        $service,
        $path,
        $requestContent,
        $statusCode,
        $contentType,
        $responseBody,
        $userId = 10,
        $licenseKey = '0123456789',
        $options = array()
    ) {
        $stub = $this->getMockForAbstractClass(
            'MaxMind\\WebService\\Http\\Request'
        );

        $stub->expects($this->once())
            ->method('post')
            ->with($this->equalTo(json_encode($requestContent)))
            ->willReturn(array($statusCode, $contentType, $responseBody));

        $factory = $this->getMockBuilder(
            'MaxMind\\WebService\\Http\\RequestFactory'
        )->getMock();

        $host = isset($options['host']) ? $options['host'] : 'api.maxmind.com';

        $url = 'https://' . $host . $path;

        $headers = array(
            'Content-Type: application/json',
            'Authorization: Basic '
            . base64_encode($userId . ':' . $licenseKey),
            'Accept: application/json',
        );

        $curlVersion = curl_version();
        $userAgent = 'MaxMind-WS-API/' . Client::VERSION . ' PHP/' . PHP_VERSION
            .  ' curl/' . $curlVersion['version'];
        if (isset($options['userAgent'])) {
            $userAgent = $options['userAgent'] . ' ' . $userAgent;
        }

        if (isset($options['caBundle'])) {
            $caBundle = $options['caBundle'];
        } else {
            $reflectionClass = new \ReflectionClass('MaxMind\\WebService\\Client');
            $file = $reflectionClass->getFileName();
            $caBundle = dirname($file) . '/cacert.pem';
        }

        $factory->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo($url),
                $this->equalTo(
                    array(
                        'headers' => $headers,
                        'userAgent' => $userAgent,
                        'connectTimeout' => isset($options['connectTimeout'])
                            ? $options['connectTimeout'] : null,
                        'timeout' => isset($options['timeout'])
                            ? $options['timeout'] : null,
                        'caBundle' => $caBundle,
                    )
                )
            )->willReturn($stub);

        $options['httpRequestFactory'] = $factory;
        $client = new Client(
            $userId,
            $licenseKey,
            $options
        );

        return $client->post($service, $path, $requestContent);
    }
}
