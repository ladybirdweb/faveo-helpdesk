<?php
/**
 * @see       https://github.com/zendframework/ZendService_Apple_Apns for the canonical source repository
 * @copyright Copyright (c) 2014-2018 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/ZendService_Apple_Apns/blob/master/LICENSE.md New BSD License
 */

namespace ZendServiceTest\Apple\Apns;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;
use Zend\Json\Encoder as JsonEncoder;
use ZendService\Apple\Apns\Message;
use ZendService\Apple\Apns\Message\Alert;

/**
 * @category   ZendService
 * @package    ZendService_Apple
 * @subpackage UnitTests
 * @group      ZendService
 * @group      ZendService_Apple
 * @group      ZendService_Apple_Apns
 */
class MessageTest extends TestCase
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
        $this->expectException(InvalidArgumentException::class);
        $this->message->setAlert([]);
    }

    public function testSetAlertThrowsExceptionOnActionLocKeyNonString()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->alert->setActionLocKey([]);
    }

    public function testSetAlertThrowsExceptionOnLocKeyNonString()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->alert->setLocKey([]);
    }

    public function testSetAlertThrowsExceptionOnLaunchImageNonString()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->alert->setLaunchImage([]);
    }

    public function testSetAlertThrowsExceptionOnTitleNonString()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->alert->setTitle([]);
    }

    public function testSetAlertThrowsExceptionOnTitleLocKeyNonString()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->alert->setTitleLocKey([]);
    }

    public function testSetBadgeReturnsCorrectNumber()
    {
        $num = 5;
        $this->message->setBadge($num);
        $this->assertEquals($num, $this->message->getBadge());
    }

    public function testSetBadgeNonNumericThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
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
        $this->expectException(InvalidArgumentException::class);
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
        $this->expectException(InvalidArgumentException::class);
        $this->message->setSound([]);
    }

    public function testSetSoundThrowsExceptionOnNonString()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->message->setSound(12345);
    }

    /**
     * @dataProvider provideSetMutableContentThrowsExceptionOnNonIntegerOneOrNullData
     *
     * @param mixed $value
     */
    public function testSetMutableContentThrowsExceptionOnNonIntegerOneAndNull($value)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->message->setMutableContent($value);
    }

    /**
     * @return array
     */
    public function provideSetMutableContentThrowsExceptionOnNonIntegerOneOrNullData()
    {
        return [
            'unsupported positive integer' => ['value' => 2],
            'zero integer'                 => ['value' => 0],
            'negative integer'             => ['value' => -1],
            'boolean'                      => ['value' => true],
            'string'                       => ['value' => 'any string'],
            'float'                        => ['value' => 123.12],
            'array'                        => ['value' => []],
            'object'                       => ['value' => new stdClass()],
        ];
    }

    public function testSetMutableContentResultsInCorrectPayloadWithIntegerValue()
    {
        $value = 1;
        $this->message->setMutableContent($value);
        $payload = $this->message->getPayload();
        $this->assertEquals($value, $payload['aps']['mutable-content']);
    }

    public function testSetMutableContentResultsInCorrectPayloadWithNullValue()
    {
        $this->message->setMutableContent(null);
        $json = $this->message->getPayloadJson();
        $payload = json_decode($json, true);
        $this->assertFalse(isset($payload['aps']['mutable-content']));
    }

    public function testSetContentAvailableThrowsExceptionOnNonInteger()
    {
        $this->expectException(InvalidArgumentException::class);
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
        $this->expectException(InvalidArgumentException::class);
        $this->message->setCategory([]);
    }

    public function testSetCategoryThrowsExceptionOnNonString()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->message->setCategory(12345);
    }

    public function testSetUrlArgsReturnsString()
    {
        $urlArgs = ['path/to/somewhere'];
        $this->message->setUrlArgs($urlArgs);
        $this->assertEquals($urlArgs, $this->message->getUrlArgs());
    }

    public function testSetCustomData()
    {
        $data = ['key' => 'val', 'key2' => [1, 2, 3, 4, 5]];
        $this->message->setCustom($data);
        $this->assertEquals($data, $this->message->getCustom());
    }

    public function testAlertConstructor()
    {
        $alert = new Alert(
            'Foo wants to play Bar!',
            'PLAY',
            'GAME_PLAY_REQUEST_FORMAT',
            ['Foo', 'Baz'],
            'Default.png',
            'Alert',
            'ALERT',
            ['Foo', 'Baz']
        );

        $this->assertEquals('Foo wants to play Bar!', $alert->getBody());
        $this->assertEquals('PLAY', $alert->getActionLocKey());
        $this->assertEquals('GAME_PLAY_REQUEST_FORMAT', $alert->getLocKey());
        $this->assertEquals(['Foo', 'Baz'], $alert->getLocArgs());
        $this->assertEquals('Default.png', $alert->getLaunchImage());
        $this->assertEquals('Alert', $alert->getTitle());
        $this->assertEquals('ALERT', $alert->getTitleLocKey());
        $this->assertEquals(['Foo', 'Baz'], $alert->getTitleLocArgs());
    }

    public function testAlertJsonPayload()
    {
        $alert = new Alert(
            'Foo wants to play Bar!',
            'PLAY',
            'GAME_PLAY_REQUEST_FORMAT',
            ['Foo', 'Baz'],
            'Default.png',
            'Alert',
            'ALERT',
            ['Foo', 'Baz']
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
        $this->assertEquals($payload, ['aps' => ['alert' => 'hi=привет']]);
        if (defined('JSON_UNESCAPED_UNICODE')) {
            $payloadJson = json_encode($payload, JSON_UNESCAPED_UNICODE);
            $this->assertEquals($payloadJson, '{"aps":{"alert":"hi=привет"}}');
            $length = 35; // 23 + (2 * 6) because UTF-8 (Russian) "привет" contains 2 bytes per letter
            $result =
                pack(
                    'CNNnH*',
                    1,
                    $this->message->getId(),
                    $this->message->getExpire(),
                    32,
                    $this->message->getToken()
                )
                . pack('n', $length)
                . $payloadJson;
            $this->assertEquals($this->message->getPayloadJson(), $result);
        } else {
            $payloadJson = JsonEncoder::encode($payload);
            $this->assertEquals($payloadJson, '{"aps":{"alert":"hi=\u043f\u0440\u0438\u0432\u0435\u0442"}}');
            $length = 59; // (23 + (6 * 6) because UTF-8 (Russian) "привет" converts into 6 bytes/letter
            $result =
                pack(
                    'CNNnH*',
                    1,
                    $this->message->getId(),
                    $this->message->getExpire(),
                    32,
                    $this->message->getToken()
                )
                . pack('n', $length)
                . $payloadJson;
            $this->assertEquals($this->message->getPayloadJson(), $result);
        }
    }

    public function testCustomDataPayloadIncludesEmptyApsObject()
    {
        $data = ['custom' => 'data'];
        $expected = array_merge($data, ['aps' => (object) []]);
        $this->message->setCustom($data);

        $payload = $this->message->getPayload();
        $this->assertEquals($expected, $payload);
    }

    public function testTokensAllowUpperCaseHex()
    {
        $token = str_repeat('abc1234defABCDEF', 4);
        $this->message->setToken($token);
        $this->assertSame($token, $this->message->getToken());
    }
}
