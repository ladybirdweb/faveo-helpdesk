<?php

namespace tests\units\Sly\NotificationPusher\Model;

use mageekguy\atoum as Units;
use Sly\NotificationPusher\Model\Push as TestedModel;

use Sly\NotificationPusher\Model\Message as BaseMessage;
use Sly\NotificationPusher\Model\Device as BaseDevice;
use Sly\NotificationPusher\Collection\DeviceCollection as BaseDeviceCollection;
use Sly\NotificationPusher\Adapter\Apns as BaseApnsAdapter;

/**
 * Push.
 *
 * @uses atoum\test
 * @author Cédric Dugat <cedric@dugat.me>
 */
class Push extends Units\Test
{
    const APNS_TOKEN_EXAMPLE = '111db24975bb6c6b63214a8d268052aa0a965cc1e32110ab06a72b19074c2222';
    const GCM_TOKEN_EXAMPLE  = 'AAA91bG9ISdL94D55C69NplFlxicy0iFUFTyWh3AAdMfP9npH5r_JQFTo27xpX1jfqGf-aSe6xZAsfWRefjazJpqFt03Isanv-Fi97020EKLye0ApTkHsw_0tJJzgA2Js0NsG1jLWsiJf63YSF8ropAcRp4BSxVBBB';

    public function testConstructWithOneDevice()
    {
        $this->if($this->mockClass('\Sly\NotificationPusher\Adapter\AdapterInterface', '\Mock'))
            ->and($adapter = new \Mock\AdapterInterface())
            ->and($devices = new BaseDevice('Token1'))
            ->and($message = new BaseMessage('Test'))

            ->and($object = new TestedModel($adapter, $devices, $message))

            ->object($object->getDevices())
                ->isInstanceOf('\Sly\NotificationPusher\Collection\DeviceCollection')
            ->integer($object->getDevices()->count())
                ->isEqualTo(1)
            ->array($object->getOptions())
                ->isEmpty()
        ;
    }

    public function testConstructWithManyDevicesAndOptions()
    {
        $this->if($this->mockClass('\Sly\NotificationPusher\Adapter\AdapterInterface', '\Mock'))
            ->and($adapter = new \Mock\AdapterInterface())
            ->and($devices = new BaseDeviceCollection(array(new BaseDevice('Token1'), new BaseDevice('Token2'), new BaseDevice('Token3'))))
            ->and($message = new BaseMessage('Test'))

            ->and($object = new TestedModel($adapter, $devices, $message, array('param' => 'test')))

            ->object($object->getDevices())
                ->isInstanceOf('\Sly\NotificationPusher\Collection\DeviceCollection')
            ->integer($object->getDevices()->count())
                ->isEqualTo(3)
            ->array($object->getOptions())
                ->hasKey('param')
                ->contains('test')
                ->size
                    ->isEqualTo(1)
        ;
    }

    public function testStatus()
    {
        $this->if($this->mockClass('\Sly\NotificationPusher\Adapter\AdapterInterface', '\Mock'))
            ->and($adapter = new \Mock\AdapterInterface())
            ->and($devices = new BaseDeviceCollection(array(new BaseDevice('Token1'), new BaseDevice('Token2'), new BaseDevice('Token3'))))
            ->and($message = new BaseMessage('Test'))

            ->and($object = new TestedModel($adapter, $devices, $message))

            ->string($object->getStatus())
                ->isEqualTo(TestedModel::STATUS_PENDING)
            ->boolean($object->isPushed())
                ->isFalse()

            ->when($object->pushed())
            ->and($dt = new \DateTime())
            ->string($object->getStatus())
                ->isEqualTo(TestedModel::STATUS_PUSHED)
            ->boolean($object->isPushed())
                ->isTrue()
            ->dateTime($object->getPushedAt())
                ->isCloneOf($dt)

            ->when($object->setStatus(TestedModel::STATUS_PENDING))
            ->string($object->getStatus())
                ->isEqualTo(TestedModel::STATUS_PENDING)
            ->boolean($object->isPushed())
                ->isFalse()

            ->when($fDt = new \DateTime('2013-01-01'))
            ->and($object->setPushedAt($fDt))
            ->dateTime($object->getPushedAt())
                ->isCloneOf(new \DateTime('2013-01-01'))
        ;
    }

    public function testDevicesTokensCheck()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Apns', '\Mock'))
            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Gcm', '\Mock'))

            ->and($apnsAdapter = new \mock\Apns())
            ->and($gcmAdapter = new \mock\Gcm())
            ->and($badDevice = new BaseDevice('BadToken'))
            ->and($message = new BaseMessage('Test'))

            ->exception(function () use ($apnsAdapter, $badDevice, $message) {
                $object = new TestedModel($apnsAdapter, $badDevice, $message);
            })
                ->isInstanceOf('\Sly\NotificationPusher\Exception\AdapterException')

            ->when($goodDevice = new BaseDevice(self::APNS_TOKEN_EXAMPLE))
            ->object($object = new TestedModel($apnsAdapter, $goodDevice, $message))
        ;
    }

    public function testAdapter()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Apns', '\Mock'))
            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Gcm', '\Mock'))

            ->and($apnsAdapter = new \mock\Apns())
            ->and($gcmAdapter = new \mock\Gcm())
            ->and($devices = new BaseDevice(self::APNS_TOKEN_EXAMPLE))
            ->and($message = new BaseMessage('Test'))

            ->and($object = new TestedModel($apnsAdapter, $devices, $message))

            ->object($object->getAdapter())
                ->isInstanceOf('\Sly\NotificationPusher\Adapter\Apns')

            ->when($object->setAdapter($gcmAdapter))
            ->and($object->setDevices(new BaseDeviceCollection(array(new BaseDevice(self::GCM_TOKEN_EXAMPLE)))))
            ->object($object->getAdapter())
                ->isInstanceOf('\Sly\NotificationPusher\Adapter\Gcm')
        ;
    }

    public function testMessage()
    {
        $this->if($this->mockClass('\Sly\NotificationPusher\Adapter\AdapterInterface', '\Mock'))
            ->and($adapter = new \Mock\AdapterInterface())
            ->and($devices = new BaseDeviceCollection(array(new BaseDevice('Token1'), new BaseDevice('Token2'), new BaseDevice('Token3'))))
            ->and($message = new BaseMessage('Test'))

            ->and($object = new TestedModel($adapter, $devices, $message))
            ->object($object->getMessage())
                ->isInstanceOf('\Sly\NotificationPusher\Model\Message')
            ->string($object->getMessage()->getText())
                ->isEqualTo('Test')

            ->when($object->setMessage(new BaseMessage('Test 2')))
            ->object($object->getMessage())
                ->isInstanceOf('\Sly\NotificationPusher\Model\Message')
            ->string($object->getMessage()->getText())
                ->isEqualTo('Test 2')
        ;
    }
}
