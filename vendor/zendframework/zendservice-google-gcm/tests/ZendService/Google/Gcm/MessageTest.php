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

/**
 * @category   ZendService
 * @package    ZendService_Google
 * @subpackage UnitTests
 * @group      ZendService
 * @group      ZendService_Google
 * @group      ZendService_Google_Gcm
 */
class MessageTest extends \PHPUnit_Framework_TestCase
{
    protected $validRegistrationIds = array('1234567890', '0987654321');
    protected $validData = array('key' => 'value', 'key2' => array('value'));

    public function setUp()
    {
        $this->m = new Message();
    }

    public function testExpectedRegistrationIdBehavior()
    {
        $this->assertEquals($this->m->getRegistrationIds(), array());
        $this->assertNotContains('registration_ids', $this->m->toJson());
        $this->m->setRegistrationIds($this->validRegistrationIds);
        $this->assertEquals($this->m->getRegistrationIds(), $this->validRegistrationIds);
        foreach ($this->validRegistrationIds as $id) {
            $this->m->addRegistrationId($id);
        }
        $this->assertEquals($this->m->getRegistrationIds(), $this->validRegistrationIds);
        $this->assertContains('registration_ids', $this->m->toJson());
        $this->m->clearRegistrationIds();
        $this->assertEquals($this->m->getRegistrationIds(), array());
        $this->assertNotContains('registration_ids', $this->m->toJson());
        $this->m->addRegistrationId('1029384756');
        $this->assertEquals($this->m->getRegistrationIds(), array('1029384756'));
        $this->assertContains('registration_ids', $this->m->toJson());
    }

    public function testInvalidRegistrationIdThrowsException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->m->addRegistrationId(array('1234'));
    }

    public function testExpectedCollapseKeyBehavior()
    {
        $this->assertEquals($this->m->getCollapseKey(), null);
        $this->assertNotContains('collapse_key', $this->m->toJson());
        $this->m->setCollapseKey('my collapse key');
        $this->assertEquals($this->m->getCollapseKey(), 'my collapse key');
        $this->assertContains('collapse_key', $this->m->toJson());
        $this->m->setCollapseKey(null);
        $this->assertEquals($this->m->getCollapseKey(), null);
        $this->assertNotContains('collapse_key', $this->m->toJson());
    }

    public function testInvalidCollapseKeyThrowsException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->m->setCollapseKey(array('1234'));
    }

    public function testExpectedDataBehavior()
    {
        $this->assertEquals($this->m->getData(), array());
        $this->assertNotContains('data', $this->m->toJson());
        $this->m->setData($this->validData);
        $this->assertEquals($this->m->getData(), $this->validData);
        $this->assertContains('data', $this->m->toJson());
        $this->m->clearData();
        $this->assertEquals($this->m->getData(), array());
        $this->assertNotContains('data', $this->m->toJson());
        $this->m->addData('mykey', 'myvalue');
        $this->assertEquals($this->m->getData(), array('mykey' => 'myvalue'));
        $this->assertContains('data', $this->m->toJson());
    }

    public function testInvalidDataThrowsException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->m->addData(array('1234'), 'value');
    }

    public function testDuplicateDataKeyThrowsException()
    {
        $this->setExpectedException('RuntimeException');
        $this->m->setData($this->validData);
        $this->m->addData('key', 'value');
    }

    public function testExpectedDelayWhileIdleBehavior()
    {
        $this->assertEquals($this->m->getDelayWhileIdle(), false);
        $this->assertNotContains('delay_while_idle', $this->m->toJson());
        $this->m->setDelayWhileIdle(true);
        $this->assertEquals($this->m->getDelayWhileIdle(), true);
        $this->assertContains('delay_while_idle', $this->m->toJson());
        $this->m->setDelayWhileIdle(false);
        $this->assertEquals($this->m->getDelayWhileIdle(), false);
        $this->assertNotContains('delay_while_idle', $this->m->toJson());
    }

    public function testExpectedTimeToLiveBehavior()
    {
        $this->assertEquals($this->m->getTimeToLive(), 2419200);
        $this->assertNotContains('time_to_live', $this->m->toJson());
        $this->m->setTimeToLive(12345);
        $this->assertEquals($this->m->getTimeToLive(), 12345);
        $this->assertContains('time_to_live', $this->m->toJson());
        $this->m->setTimeToLive(2419200);
        $this->assertEquals($this->m->getTimeToLive(), 2419200);
        $this->assertNotContains('time_to_live', $this->m->toJson());
    }

    public function testExpectedRestrictedPackageBehavior()
    {
        $this->assertEquals($this->m->getRestrictedPackageName(), null);
        $this->assertNotContains('restricted_package_name', $this->m->toJson());
        $this->m->setRestrictedPackageName('my.package.name');
        $this->assertEquals($this->m->getRestrictedPackageName(), 'my.package.name');
        $this->assertContains('restricted_package_name', $this->m->toJson());
        $this->m->setRestrictedPackageName(null);
        $this->assertEquals($this->m->getRestrictedPackageName(), null);
        $this->assertNotContains('restricted_package_name', $this->m->toJson());
    }

    public function testInvalidRestrictedPackageThrowsException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->m->setRestrictedPackageName(array('1234'));
    }

    public function testExpectedDryRunBehavior()
    {
        $this->assertEquals($this->m->getDryRun(), false);
        $this->assertNotContains('dry_run', $this->m->toJson());
        $this->m->setDryRun(true);
        $this->assertEquals($this->m->getDryRun(), true);
        $this->assertContains('dry_run', $this->m->toJson());
        $this->m->setDryRun(false);
        $this->assertEquals($this->m->getDryRun(), false);
        $this->assertNotContains('dry_run', $this->m->toJson());
    }
}
