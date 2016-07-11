<?php

namespace tests\units\Sly\NotificationPusher\Adapter;

use mageekguy\atoum as Units;
use Sly\NotificationPusher\PushManager as BasePushManager;

/**
 * BaseAdapter.
 *
 * @uses atoum\test
 * @author Cédric Dugat <cedric@dugat.me>
 */
class BaseAdapter extends Units\Test
{
    public function testAdapterKey()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Apns', '\Mock'))
            ->and($object = new \Mock\Apns())
            ->and($object->getMockController()->getAdapterKey = 'Apns')
            ->string($object->getAdapterKey())
                ->isEqualTo('Apns')
            ->string((string) $object)
                ->isEqualTo('Apns')
        ;
    }

    public function testEnvironment()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Apns', '\Mock'))
            ->and($object = new \Mock\Apns())

            ->when($object->setEnvironment(BasePushManager::ENVIRONMENT_DEV))
            ->string($object->getEnvironment())
                ->isEqualTo(BasePushManager::ENVIRONMENT_DEV)
            ->boolean($object->isDevelopmentEnvironment())
                ->isTrue()
            ->boolean($object->isProductionEnvironment())
                ->isFalse()

            ->when($object->setEnvironment(BasePushManager::ENVIRONMENT_PROD))
            ->string($object->getEnvironment())
                ->isEqualTo(BasePushManager::ENVIRONMENT_PROD)
            ->boolean($object->isProductionEnvironment())
                ->isTrue()
            ->boolean($object->isDevelopmentEnvironment())
                ->isFalse()
        ;
    }
}
