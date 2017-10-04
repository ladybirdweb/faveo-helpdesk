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

use ZendService\Google\Gcm\Message;

/**
 * @category   ZendService
 * @group      ZendService
 * @group      ZendService_Google
 * @group      ZendService_Google_Gcm
 */
class MessageTest extends \PHPUnit_Framework_TestCase
{
    protected $validRegistrationIds = [
        '1234567890',
        '0987654321',
    ];

    protected $validData = [
        'key' => 'value',
        'key2' => [
            'value',
        ],
    ];

    /**
     * @var Message
     */
    private $m;

    public function setUp()
    {
        $this->m = new Message();
    }

    public function testExpectedRegistrationIdBehavior()
    {
        self::assertEquals($this->m->getRegistrationIds(), []);
        self::assertNotContains('registration_ids', $this->m->toJson());
        $this->m->setRegistrationIds($this->validRegistrationIds);
        self::assertEquals($this->m->getRegistrationIds(), $this->validRegistrationIds);
        foreach ($this->validRegistrationIds as $id) {
            $this->m->addRegistrationId($id);
        }
        self::assertEquals($this->m->getRegistrationIds(), $this->validRegistrationIds);
        self::assertContains('registration_ids', $this->m->toJson());
        $this->m->clearRegistrationIds();
        self::assertEquals($this->m->getRegistrationIds(), []);
        self::assertNotContains('registration_ids', $this->m->toJson());
        $this->m->addRegistrationId('1029384756');
        self::assertEquals($this->m->getRegistrationIds(), ['1029384756']);
        self::assertContains('registration_ids', $this->m->toJson());
    }

    public function testInvalidRegistrationIdThrowsException()
    {
        $this->setExpectedException(\InvalidArgumentException::class);
        $this->m->addRegistrationId(['1234']);
    }

    public function testExpectedCollapseKeyBehavior()
    {
        self::assertEquals($this->m->getCollapseKey(), null);
        self::assertNotContains('collapse_key', $this->m->toJson());
        $this->m->setCollapseKey('my collapse key');
        self::assertEquals($this->m->getCollapseKey(), 'my collapse key');
        self::assertContains('collapse_key', $this->m->toJson());
        $this->m->setCollapseKey(null);
        self::assertEquals($this->m->getCollapseKey(), null);
        self::assertNotContains('collapse_key', $this->m->toJson());
    }

    public function testInvalidCollapseKeyThrowsException()
    {
        $this->setExpectedException(\InvalidArgumentException::class);
        $this->m->setCollapseKey(['1234']);
    }

    public function testExpectedDataBehavior()
    {
        self::assertEquals($this->m->getData(), []);
        self::assertNotContains('data', $this->m->toJson());
        $this->m->setData($this->validData);
        self::assertEquals($this->m->getData(), $this->validData);
        self::assertContains('data', $this->m->toJson());
        $this->m->clearData();
        self::assertEquals($this->m->getData(), []);
        self::assertNotContains('data', $this->m->toJson());
        $this->m->addData('mykey', 'myvalue');
        self::assertEquals($this->m->getData(), ['mykey' => 'myvalue']);
        self::assertContains('data', $this->m->toJson());
    }

    public function testExpectedNotificationBehavior()
    {
        $this->assertEquals($this->m->getNotification(), array());
        $this->assertNotContains('notification', $this->m->toJson());
        $this->m->setNotification($this->validData);
        $this->assertEquals($this->m->getNotification(), $this->validData);
        $this->assertContains('notification', $this->m->toJson());
        $this->m->clearNotification();
        $this->assertEquals($this->m->getNotification(), array());
        $this->assertNotContains('notification', $this->m->toJson());
        $this->m->addNotification('mykey', 'myvalue');
        $this->assertEquals($this->m->getNotification(), array('mykey' => 'myvalue'));
        $this->assertContains('notification', $this->m->toJson());
    }

    public function testInvalidDataThrowsException()
    {
        $this->setExpectedException(\InvalidArgumentException::class);
        $this->m->addData(['1234'], 'value');
    }

    public function testDuplicateDataKeyThrowsException()
    {
        $this->setExpectedException(\RuntimeException::class);
        $this->m->setData($this->validData);
        $this->m->addData('key', 'value');
    }

    public function testExpectedDelayWhileIdleBehavior()
    {
        self::assertEquals($this->m->getDelayWhileIdle(), false);
        self::assertNotContains('delay_while_idle', $this->m->toJson());
        $this->m->setDelayWhileIdle(true);
        self::assertEquals($this->m->getDelayWhileIdle(), true);
        self::assertContains('delay_while_idle', $this->m->toJson());
        $this->m->setDelayWhileIdle(false);
        self::assertEquals($this->m->getDelayWhileIdle(), false);
        self::assertNotContains('delay_while_idle', $this->m->toJson());
    }

    public function testExpectedTimeToLiveBehavior()
    {
        self::assertEquals($this->m->getTimeToLive(), 2419200);
        self::assertNotContains('time_to_live', $this->m->toJson());
        $this->m->setTimeToLive(12345);
        self::assertEquals($this->m->getTimeToLive(), 12345);
        self::assertContains('time_to_live', $this->m->toJson());
        $this->m->setTimeToLive(2419200);
        self::assertEquals($this->m->getTimeToLive(), 2419200);
        self::assertNotContains('time_to_live', $this->m->toJson());
    }

    public function testExpectedRestrictedPackageBehavior()
    {
        self::assertEquals($this->m->getRestrictedPackageName(), null);
        self::assertNotContains('restricted_package_name', $this->m->toJson());
        $this->m->setRestrictedPackageName('my.package.name');
        self::assertEquals($this->m->getRestrictedPackageName(), 'my.package.name');
        self::assertContains('restricted_package_name', $this->m->toJson());
        $this->m->setRestrictedPackageName(null);
        self::assertEquals($this->m->getRestrictedPackageName(), null);
        self::assertNotContains('restricted_package_name', $this->m->toJson());
    }

    public function testInvalidRestrictedPackageThrowsException()
    {
        $this->setExpectedException(\InvalidArgumentException::class);
        $this->m->setRestrictedPackageName(['1234']);
    }

    public function testExpectedDryRunBehavior()
    {
        self::assertEquals($this->m->getDryRun(), false);
        self::assertNotContains('dry_run', $this->m->toJson());
        $this->m->setDryRun(true);
        self::assertEquals($this->m->getDryRun(), true);
        self::assertContains('dry_run', $this->m->toJson());
        $this->m->setDryRun(false);
        self::assertEquals($this->m->getDryRun(), false);
        self::assertNotContains('dry_run', $this->m->toJson());
    }
}
