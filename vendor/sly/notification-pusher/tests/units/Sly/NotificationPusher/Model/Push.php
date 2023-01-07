<?php

namespace tests\units\Sly\NotificationPusher\Model;

use mageekguy\atoum as Units;
use Sly\NotificationPusher\Adapter\AdapterInterface;
use Sly\NotificationPusher\Adapter\Apns;
use Sly\NotificationPusher\Adapter\Gcm;
use Sly\NotificationPusher\Collection\DeviceCollection;
use Sly\NotificationPusher\Exception\AdapterException;
use Sly\NotificationPusher\Model\Device as DeviceModel;
use Sly\NotificationPusher\Model\Message as MessageModel;
use Sly\NotificationPusher\Model\Push as TestedModel;

/**
 * @uses atoum\test
 * @author Cédric Dugat <cedric@dugat.me>
 */
class Push extends Units\Test
{
    const APNS_TOKEN_EXAMPLE = '111db24975bb6c6b63214a8d268052aa0a965cc1e32110ab06a72b19074c2222';
    const GCM_TOKEN_EXAMPLE = 'AAA91bG9ISdL94D55C69NplFlxicy0iFUFTyWh3AAdMfP9npH5r_JQFTo27xpX1jfqGf-aSe6xZAsfWRefjazJpqFt03Isanv-Fi97020EKLye0ApTkHsw_0tJJzgA2Js0NsG1jLWsiJf63YSF8ropAcRp4BSxVBBB';

    public function testConstructWithOneDevice()
    {
        $this->if($this->mockClass(AdapterInterface::class, '\Mock'))
            ->and($adapter = new \Mock\AdapterInterface())
            ->and($devices = new DeviceModel('Token1'))
            ->and($message = new MessageModel('Test'))
            ->and($object = new TestedModel($adapter, $devices, $message))
            ->object($object->getDevices())
            ->isInstanceOf(DeviceCollection::class)
            ->integer($object->getDevices()->count())
            ->isEqualTo(1)
            ->array($object->getOptions())
            ->isEmpty();
    }

    public function testConstructWithManyDevicesAndOptions()
    {
        $this->if($this->mockClass(AdapterInterface::class, '\Mock'))
            ->and($adapter = new \Mock\AdapterInterface())
            ->and($devices = new DeviceCollection([new DeviceModel('Token1'), new DeviceModel('Token2'),
                new DeviceModel('Token3')]))
            ->and($message = new MessageModel('Test'))
            ->and($object = new TestedModel($adapter, $devices, $message, ['param' => 'test']))
            ->object($object->getDevices())
            ->isInstanceOf(DeviceCollection::class)
            ->integer($object->getDevices()->count())
            ->isEqualTo(3)
            ->array($object->getOptions())
            ->hasKey('param')
            ->contains('test')
            ->size
            ->isEqualTo(1);
    }

    public function testStatus()
    {
        date_default_timezone_set('UTC');
        $this->if($this->mockClass(AdapterInterface::class, '\Mock'))
            ->and($adapter = new \Mock\AdapterInterface())
            ->and($devices = new DeviceCollection([new DeviceModel('Token1'), new DeviceModel('Token2'),
                new DeviceModel('Token3')]))
            ->and($message = new MessageModel('Test'))
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
            ->hasDate($dt->format("Y"), $dt->format("m"), $dt->format('d'))
            ->when($object->setStatus(TestedModel::STATUS_PENDING))
            ->string($object->getStatus())
            ->isEqualTo(TestedModel::STATUS_PENDING)
            ->boolean($object->isPushed())
            ->isFalse()
            ->when($fDt = new \DateTime('2013-01-01'))
            ->and($object->setPushedAt($fDt))
            ->dateTime($object->getPushedAt())
            ->isIdenticalTo($fDt);
    }

    public function testDevicesTokensCheck()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(Apns::class, '\Mock'))
            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(Gcm::class, '\Mock'))
            ->and($apnsAdapter = new \mock\Apns())
            ->and($gcmAdapter = new \mock\Gcm())
            ->and($badDevice = new DeviceModel('BadToken'))
            ->and($message = new MessageModel('Test'))
            ->exception(function () use ($apnsAdapter, $badDevice, $message) {
                $object = new TestedModel($apnsAdapter, $badDevice, $message);
            })
            ->isInstanceOf(AdapterException::class)
            ->when($goodDevice = new DeviceModel(self::APNS_TOKEN_EXAMPLE))
            ->object($object = new TestedModel($apnsAdapter, $goodDevice, $message));
    }

    public function testAdapter()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(Apns::class, '\Mock'))
            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(Gcm::class, '\Mock'))
            ->and($apnsAdapter = new \mock\Apns())
            ->and($gcmAdapter = new \mock\Gcm())
            ->and($devices = new DeviceModel(self::APNS_TOKEN_EXAMPLE))
            ->and($message = new MessageModel('Test'))
            ->and($object = new TestedModel($apnsAdapter, $devices, $message))
            ->object($object->getAdapter())
            ->isInstanceOf(Apns::class)
            ->when($object->setAdapter($gcmAdapter))
            ->and($object->setDevices(new DeviceCollection([new DeviceModel(self::GCM_TOKEN_EXAMPLE)])))
            ->object($object->getAdapter())
            ->isInstanceOf(Gcm::class);
    }

    public function testMessage()
    {
        $this->if($this->mockClass(AdapterInterface::class, '\Mock'))
            ->and($adapter = new \Mock\AdapterInterface())
            ->and($devices = new DeviceCollection([new DeviceModel('Token1'), new DeviceModel('Token2'),
                new DeviceModel('Token3')]))
            ->and($message = new MessageModel('Test'))
            ->and($object = new TestedModel($adapter, $devices, $message))
            ->object($object->getMessage())
            ->isInstanceOf(MessageModel::class)
            ->string($object->getMessage()->getText())
            ->isEqualTo('Test')
            ->when($object->setMessage(new MessageModel('Test 2')))
            ->object($object->getMessage())
            ->isInstanceOf(MessageModel::class)
            ->string($object->getMessage()->getText())
            ->isEqualTo('Test 2');
    }

}
