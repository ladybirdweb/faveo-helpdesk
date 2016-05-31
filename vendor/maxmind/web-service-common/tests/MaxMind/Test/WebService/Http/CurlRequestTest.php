<?php

namespace MaxMind\Test\WebService\Http;

use MaxMind\WebService\Http\CurlRequest;

// These tests are totally insufficient, but they do test that most of our
// curl calls are at least syntactically valid and available in each PHP
// version. Doing more sophisticated testing would require setting up a
// server, which is very painful to do in PHP 5.3. For 5.4+, there are
// various solutions. When we increase our required PHP version, we should
// look into those.
class CurlRequestTest extends \PHPUnit_Framework_TestCase
{

    private $options = array(
        'caBundle'=> null,
        'headers' => array(),
        'userAgent' => 'Test',
        'connectTimeout' => 0,
        'timeout' => 0,
    );

    /**
     * @expectedException MaxMind\Exception\HttpException
     * @expectedExceptionMessage cURL error (6):
     */
    public function testGet()
    {
        $cr = new CurlRequest(
            'invalid host',
            $this->options
        );

        $cr->get();
    }


    /**
     * @expectedException MaxMind\Exception\HttpException
     * @expectedExceptionMessage cURL error (6):
     */
    public function testPost()
    {
        $cr = new CurlRequest(
            'invalid host',
            $this->options
        );

        $cr->post('POST BODY');
    }
}
