<?php

namespace tests\units\Sly\NotificationPusher;

use mageekguy\atoum as Units;
use Sly\NotificationPusher\PushManager as TestedModel;

use Sly\NotificationPusher\Model\Message as BaseMessage;
use Sly\NotificationPusher\Model\Device as BaseDevice;
use Sly\NotificationPusher\Collection\DeviceCollection as BaseDeviceCollection;

/**
 * PushManager.
 *
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
                ->isEqualTo(TestedModel::ENVIRONMENT_PROD)
        ;
    }

    public function testCollection()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Model\Push', '\Mock'))
            ->and($push = new \Mock\Push())
            ->and($push->getMockController()->getMessage = new BaseMessage('Test'))
            ->and($push->getMockController()->getDevices = new BaseDeviceCollection(array(new BaseDevice(self::APNS_TOKEN_EXAMPLE))))

            ->and($object = new TestedModel())

            ->when($object->add($push))
            ->object($object)
                ->isInstanceOf('\Sly\NotificationPusher\Collection\PushCollection')
                ->hasSize(1)
        ;
    }

    public function testPush()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Apns', '\Mock'))
            ->and($apnsAdapter = new \Mock\Apns())
            ->and($apnsAdapter->getMockController()->push = true)

            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Model\Push', '\Mock'))
            ->and($push = new \Mock\Push())
            ->and($push->getMockController()->getMessage = new BaseMessage('Test'))
            ->and($push->getMockController()->getDevices = new BaseDeviceCollection(array(new BaseDevice(self::APNS_TOKEN_EXAMPLE))))
            ->and($push->getMockController()->getAdapter = $apnsAdapter)

            ->and($object = new TestedModel())
            ->and($object->add($push))

            ->object($object->push())
                ->isInstanceOf('\Sly\NotificationPusher\Collection\PushCollection')
                ->hasSize(1)
        ;
    }
}
