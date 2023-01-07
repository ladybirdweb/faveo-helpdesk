<?php

namespace tests\units\Sly\NotificationPusher;

use mageekguy\atoum as Units;
use Sly\NotificationPusher\Adapter\Apns;
use Sly\NotificationPusher\Collection\DeviceCollection;
use Sly\NotificationPusher\Collection\PushCollection;
use Sly\NotificationPusher\Model\Device;
use Sly\NotificationPusher\Model\Message;
use Sly\NotificationPusher\Model\Push;
use Sly\NotificationPusher\Model\Response;
use Sly\NotificationPusher\PushManager as TestedModel;

/**
 * @uses atoum\test
 * @author Cédric Dugat <cedric@dugat.me>
 */
class PushManager extends Units\Test
{
    const APNS_TOKEN_EXAMPLE = '111db24975bb6c6b63214a8d268052aa0a965cc1e32110ab06a72b19074c2222';

    public function testConstruct()
    {
        $this->if($object = new TestedModel())
            ->string($object->getEnvironment())
            ->isEqualTo(TestedModel::ENVIRONMENT_DEV)
            ->when($object = new TestedModel(TestedModel::ENVIRONMENT_PROD))
            ->string($object->getEnvironment())
            ->isEqualTo(TestedModel::ENVIRONMENT_PROD);
    }

    public function testCollection()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(Push::class, '\Mock'))
            ->and($push = new \Mock\Push())
            ->and($push->getMockController()->getMessage = new Message('Test'))
            ->and($push->getMockController()->getDevices = new DeviceCollection([new Device(self::APNS_TOKEN_EXAMPLE)]))
            ->and($push2 = new \Mock\Push())
            ->and($push2->getMockController()->getMessage = new Message('Test 2'))
            ->and($push2->getMockController()->getDevices = new DeviceCollection([new Device(self::APNS_TOKEN_EXAMPLE)]))
            ->and($object = (new TestedModel())->getPushCollection())
            ->when($object->add($push))
            ->object($object)
            ->isInstanceOf(PushCollection::class)
            ->object($object->getIterator())
            ->hasSize(1)
            ->when($object->add($push2))
            ->object($object)
            ->isInstanceOf(PushCollection::class)
            ->object($object->getIterator())
            ->hasSize(2)
            ->object($object->first())
            ->isEqualTo($push)
            ->object($object->last())
            ->isEqualTo($push2);
    }

    public function testPush()
    {
        date_default_timezone_set('UTC');
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(Apns::class, '\Mock'))
            ->and($apnsAdapter = new \Mock\Apns())
            ->and($apnsAdapter->getMockController()->push = true)
            ->and($apnsAdapter->getMockController()->getResponse = new Response())
            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(Push::class, '\Mock'))
            ->and($push = new \Mock\Push())
            ->and($push->getMockController()->getMessage = new Message('Test'))
            ->and($push->getMockController()->getDevices = new DeviceCollection([new Device(self::APNS_TOKEN_EXAMPLE)]))
            ->and($push->getMockController()->getAdapter = $apnsAdapter)
            ->and($object = new TestedModel())
            ->and($object->add($push))
            ->object($object->push())
            ->isInstanceOf(PushCollection::class)
            ->hasSize(1)
            ->object($object->getResponse())
            ->isInstanceOf(Response::class);
    }
}
