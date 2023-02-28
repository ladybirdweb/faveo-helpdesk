<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_Service
 */

namespace ZendServiceTest\Apple\Apns\TestAsset;

use ZendService\Apple\Apns\Message;
use ZendService\Apple\Apns\Message\Alert;
use Zend\Json\Encoder as JsonEncoder;

/**
 * @category   ZendService
 * @package    ZendService_Apple
 * @subpackage UnitTests
 * @group      ZendService
 * @group      ZendService_Apple
 * @group      ZendService_Apple_Apns
 */
class MessageTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->alert = new Alert();
        $this->message = new Message();
    }

    public function testSetAlertTextReturnsCorrectly()
    {
        $text = 'my alert';
        $ret = $this->message->setAlert($text);
        $this->assertInstanceOf('ZendService\Apple\Apns\Message', $ret);
        $checkText = $this->message->getAlert();
        $this->assertInstanceOf('ZendService\Apple\Apns\Message\Alert', $checkText);
        $this->assertEquals($text, $checkText->getBody());
    }

    public function testSetAlertThrowsExceptionOnTextNonString()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->message->setAlert(array());
    }

    public function testSetAlertThrowsExceptionOnActionLocKeyNonString()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->alert->setActionLocKey(array());
    }

    public function testSetAlertThrowsExceptionOnLocKeyNonString()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->alert->setLocKey(array());
    }

    public function testSetAlertThrowsExceptionOnLaunchImageNonString()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->alert->setLaunchImage(array());
    }
    
    public function testSetAlertThrowsExceptionOnTitleNonString()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->alert->setTitle(array());
    }
    
    public function testSetAlertThrowsExceptionOnTitleLocKeyNonString()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->alert->setTitleLocKey(array());
    }

    public function testSetBadgeReturnsCorrectNumber()
    {
        $num = 5;
        $this->message->setBadge($num);
        $this->assertEquals($num, $this->message->getBadge());
    }

    public function testSetBadgeNonNumericThrowsException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->message->setBadge('string!');
    }

    public function testSetBadgeAllowsNull()
    {
        $this->message->setBadge(null);
        $this->assertNull($this->message->getBadge());
    }

    public function testSetExpireReturnsInteger()
    {
        $expire = 100;
        $this->message->setExpire($expire);
        $this->assertEquals($expire, $this->message->getExpire());
    }

    public function testSetExpireNonNumericThrowsException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->message->setExpire('sting!');
    }

    public function testSetSoundReturnsString()
    {
        $sound = 'test';
        $this->message->setSound($sound);
        $this->assertEquals($sound, $this->message->getSound());
    }

    public function testSetSoundThrowsExceptionOnNonScalar()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->message->setSound(array());
    }

    public function testSetSoundThrowsExceptionOnNonString()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->message->setSound(12345);
    }

    public function testSetContentAvailableThrowsExceptionOnNonInteger()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->message->setContentAvailable("string");
    }

    public function testGetContentAvailableReturnsCorrectInteger()
    {
        $value = 1;
        $this->message->setContentAvailable($value);
        $this->assertEquals($value, $this->message->getContentAvailable());
    }

    public function testSetContentAvailableResultsInCorrectPayload()
    {
        $value = 1;
        $this->message->setContentAvailable($value);
        $payload = $this->message->getPayload();
        $this->assertEquals($value, $payload['aps']['content-available']);
    }

    public function testSetCategoryReturnsString()
    {
        $category = 'test';
        $this->message->setCategory($category);
        $this->assertEquals($category, $this->message->getCategory());
    }

    public function testSetCategoryThrowsExceptionOnNonScalar()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->message->setCategory(array());
    }

    public function testSetCategoryThrowsExceptionOnNonString()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->message->setCategory(12345);
    }

    public function testSetUrlArgsReturnsString()
    {
        $urlArgs = array('path/to/somewhere');
        $this->message->setUrlArgs($urlArgs);
        $this->assertEquals($urlArgs, $this->message->getUrlArgs());
    }

    public function testSetCustomData()
    {
        $data = array('key' => 'val', 'key2' => array(1, 2, 3, 4, 5));
        $this->message->setCustom($data);
        $this->assertEquals($data, $this->message->getCustom());
    }

    public function testAlertConstructor()
    {
        $alert = new Alert(
            'Foo wants to play Bar!',
            'PLAY',
            'GAME_PLAY_REQUEST_FORMAT',
            array('Foo', 'Baz'),
            'Default.png',
            'Alert',
            'ALERT',
            array('Foo', 'Baz')
        );

        $this->assertEquals('Foo wants to play Bar!', $alert->getBody());
        $this->assertEquals('PLAY', $alert->getActionLocKey());
        $this->assertEquals('GAME_PLAY_REQUEST_FORMAT', $alert->getLocKey());
        $this->assertEquals(array('Foo', 'Baz'), $alert->getLocArgs());
        $this->assertEquals('Default.png', $alert->getLaunchImage());
        $this->assertEquals('Alert', $alert->getTitle());
        $this->assertEquals('ALERT', $alert->getTitleLocKey());
        $this->assertEquals(array('Foo', 'Baz'), $alert->getTitleLocArgs());
    }

    public function testAlertJsonPayload()
    {
        $alert = new Alert(
            'Foo wants to play Bar!',
            'PLAY',
            'GAME_PLAY_REQUEST_FORMAT',
            array('Foo', 'Baz'),
            'Default.png',
            'Alert',
            'ALERT',
            array('Foo', 'Baz')
        );
        $payload = $alert->getPayload();

        $this->assertArrayHasKey('body', $payload);
        $this->assertArrayHasKey('action-loc-key', $payload);
        $this->assertArrayHasKey('loc-key', $payload);
        $this->assertArrayHasKey('loc-args', $payload);
        $this->assertArrayHasKey('launch-image', $payload);
        $this->assertArrayHasKey('title', $payload);
        $this->assertArrayHasKey('title-loc-key', $payload);
        $this->assertArrayHasKey('title-loc-args', $payload);
    }

    public function testAlertPayloadSendsOnlyBody()
    {
        $alert = new Alert('Foo wants Bar');
        $payload = $alert->getPayload();

        $this->assertEquals('Foo wants Bar', $payload);
    }

    public function testPayloadJsonFormedCorrectly()
    {
        $text = 'hi=привет';
        $this->message->setAlert($text);
        $this->message->setId(1);
        $this->message->setExpire(100);
        $this->message->setToken('0123456789abcdef0123456789abcdef0123456789abcdef0123456789abcdef');
        $payload = $this->message->getPayload();
        $this->assertEquals($payload, array('aps' => array('alert' => 'hi=привет')));
        if (defined('JSON_UNESCAPED_UNICODE')) {
            $payloadJson = json_encode($payload, JSON_UNESCAPED_UNICODE);
            $this->assertEquals($payloadJson, '{"aps":{"alert":"hi=привет"}}');
            $length = 35; // 23 + (2 * 6) because UTF-8 (Russian) "привет" contains 2 bytes per letter
            $result = pack('CNNnH*', 1, $this->message->getId(), $this->message->getExpire(), 32, $this->message->getToken())
            . pack('n', $length)
            . $payloadJson;
            $this->assertEquals($this->message->getPayloadJson(), $result);
        } else {
            $payloadJson = JsonEncoder::encode($payload);
            $this->assertEquals($payloadJson, '{"aps":{"alert":"hi=\u043f\u0440\u0438\u0432\u0435\u0442"}}');
            $length = 59; // (23 + (6 * 6) because UTF-8 (Russian) "привет" converts into 6 bytes per letter constructions
            $result = pack('CNNnH*', 1, $this->message->getId(), $this->message->getExpire(), 32, $this->message->getToken())
            . pack('n', $length)
            . $payloadJson;
            $this->assertEquals($this->message->getPayloadJson(), $result);
        }
    }

    public function testCustomDataPayloadDoesNotIncludeEmptyApsData()
    {
        $data = array('custom' => 'data');
        $this->message->setCustom($data);

        $payload = $this->message->getPayload();
        $this->assertEquals($payload, array('custom' => 'data'));
    }
}
