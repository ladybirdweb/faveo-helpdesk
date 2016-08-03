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
class ResponseTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->m = new Message();
    }

    public function testConstructorExpectedBehavior()
    {
        $response = new Response();
        $this->assertNull($response->getResponse());
        $this->assertNull($response->getMessage());

        $message = new Message();
        $response = new Response(null, $message);
        $this->assertEquals($message, $response->getMessage());
        $this->assertNull($response->getResponse());

        $message = new Message();
        $responseArray = array(
            'results' => array(
                array('message_id' => '1:1234'),
            ),
            'success' => 1,
            'failure' => 0,
            'canonical_ids' => 0,
            'multicast_id' => 1,
        );
        $response = new Response($responseArray, $message);
        $this->assertEquals($responseArray, $response->getResponse());
        $this->assertEquals($message, $response->getMessage());
    }

    public function testInvalidConstructorThrowsException()
    {
        $this->setExpectedException('PHPUnit_Framework_Error');
        $response = new Response('{bad');
    }

    public function testMessageExpectedBehavior()
    {
        $message = new Message();
        $response = new Response();
        $response->setMessage($message);
        $this->assertEquals($message, $response->getMessage());
    }

    public function testResponse()
    {
        $responseArr = array(
            'results' => array(
                array('message_id' => '1:234'),
            ),
            'success' => 1,
            'failure' => 0,
            'canonical_ids' => 0,
            'multicast_id' => '123',
        );
        $response = new Response();
        $response->setResponse($responseArr);
        $this->assertEquals($responseArr, $response->getResponse());
        $this->assertEquals(1, $response->getSuccessCount());
        $this->assertEquals(0, $response->getFailureCount());
        $this->assertEquals(0, $response->getCanonicalCount());
        // test results non correlated
        $expected = array(array('message_id' => '1:234'));
        $this->assertEquals($expected, $response->getResults());
        $expected = array(0 => '1:234');
        $this->assertEquals($expected, $response->getResult(Response::RESULT_MESSAGE_ID));

        $message = new Message();
        $message->setRegistrationIds(array('ABCDEF'));
        $response->setMessage($message);
        $expected = array('ABCDEF' => '1:234');
        $this->assertEquals($expected, $response->getResult(Response::RESULT_MESSAGE_ID));
    }
}
