<?php

namespace tests\units\Sly\NotificationPusher\Adapter;

use mageekguy\atoum as Units;
use Sly\NotificationPusher\Adapter\Apns as TestedModel;

use Sly\NotificationPusher\Model\Message as BaseMessage;
use Sly\NotificationPusher\Model\Device as BaseDevice;
use Sly\NotificationPusher\Collection\DeviceCollection as BaseDeviceCollection;

use ZendService\Apple\Apns\Message as BaseServiceMessage;
use ZendService\Apple\Apns\Client\Message as BaseServiceClient;

/**
 * Apns.
 *
 * @uses atoum\test
 * @author Cédric Dugat <cedric@dugat.me>
 */
class Apns extends Units\Test
{
    const APNS_TOKEN_EXAMPLE = '111db24975bb6c6b63214a8d268052aa0a965cc1e32110ab06a72b19074c2222';

    public function testConstruct()
    {
        $this
            ->exception(function() {
                $object = new TestedModel();
            })
                ->isInstanceOf('\Symfony\Component\OptionsResolver\Exception\MissingOptionsException')
                ->message
                    ->contains('certificate')
            ->exception(function() {
                $object = new TestedModel(['certificate' => 'absent.pem']);
            })
                ->isInstanceOf('\Sly\NotificationPusher\Exception\AdapterException')
                ->message
                    ->contains('does not exist')

            ->when($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Apns', '\Mock'))
            ->and($object = new \Mock\Apns())
            ->and($object->setParameters(['certificate' => 'test.pem', 'passPhrase' => 'test']))
            ->array($object->getParameters())
                ->isNotEmpty()
                ->hasSize(2)
            ->string($object->getParameter('certificate'))
                ->isEqualTo('test.pem')
        ;
    }

    public function testSupports()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Apns', '\Mock'))
            ->and($object = new \Mock\Apns())
            ->boolean($object->supports('wrongToken'))
                ->isFalse()
            ->boolean($object->supports(self::APNS_TOKEN_EXAMPLE))
                ->isTrue()
        ;
    }

    public function testDefinedParameters()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Apns', '\Mock'))
            ->and($object = new \Mock\Apns())
            ->array($defaultParameters = $object->getDefinedParameters())
                ->isEmpty()
        ;
    }

    public function testDefaultParameters()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Apns', '\Mock'))
            ->and($object = new \Mock\Apns())
            ->array($defaultParameters = $object->getDefaultParameters())
                ->isNotEmpty()
                ->hasKey('passPhrase')
            ->variable($defaultParameters['passPhrase'])
                ->isNull()
        ;
    }

    public function testRequiredParameters()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Apns', '\Mock'))
            ->and($object = new \Mock\Apns())
            ->array($requiredParameters = $object->getRequiredParameters())
                ->isNotEmpty()
                ->contains('certificate')
        ;
    }

    public function testGetOpenedClient()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Apns', '\Mock'))
            ->and($object = new \Mock\Apns())
            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockGenerator()->orphanize('open'))
            ->and($this->mockClass('\ZendService\Apple\Apns\Client\Message', '\Mock\ZendService'))
            ->and($serviceClient = new \Mock\ZendService\Message())
            ->and($object->getMockController()->getParameters = [])
            ->exception(function() use($object) {
                $object->getOpenedClient(new BaseServiceClient());
            })
                ->isInstanceOf('\ZendService\Apple\Exception\InvalidArgumentException')
                ->message
                    ->contains('Certificate must be a valid path to a APNS certificate')

            ->when($object = new TestedModel(['certificate' => __DIR__.'/../Resources/apns-certificate.pem']))
            ->and($object->getOpenedClient($serviceClient))
        ;
    }

    public function testGetServiceMessageFromOrigin()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Apns', '\Mock'))
            ->and($object = new \Mock\Apns())

            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Model\Device', '\Mock'))
            ->and($device = new \Mock\Device())
            ->and($device->getMockController()->getToken = self::APNS_TOKEN_EXAMPLE)

            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Model\Message', '\Mock'))
            ->and($message = new \Mock\Message())
            ->and($message->getMockController()->getText = 'Test')

            ->object($object->getServiceMessageFromOrigin($device, $message))
                ->isInstanceOf('\ZendService\Apple\Apns\Message')
        ;
    }

    public function testPush()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Apns', '\Mock'))
            ->and($object = new \Mock\Apns())

            ->and($this->mockClass('\ZendService\Apple\Apns\Response\Message', '\Mock\ZendService', 'Response'))
            ->and($serviceResponse = new \Mock\ZendService\Response())

            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockGenerator()->orphanize('open'))
            ->and($this->mockGenerator()->orphanize('send'))
            ->and($this->mockClass('\ZendService\Apple\Apns\Client\Message', '\Mock\ZendService'))
            ->and($serviceClient = new \Mock\ZendService\Message())
            ->and($serviceClient->getMockController()->send = new $serviceResponse)

            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Model\Push', '\Mock'))
            ->and($push = new \Mock\Push())
            ->and($push->getMockController()->getMessage = new BaseMessage('Test'))
            ->and($push->getMockController()->getDevices = new BaseDeviceCollection(
                [new BaseDevice(self::APNS_TOKEN_EXAMPLE)]
            ))

            ->and($object->getMockController()->getServiceMessageFromOrigin = new BaseServiceMessage())
            ->and($object->getMockController()->getOpenedClient = $serviceClient)

            ->object($object->push($push))
                ->isInstanceOf('\Sly\NotificationPusher\Collection\DeviceCollection')
                ->hasSize(1)
        ;
    }

    public function testFeedback()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Apns', '\Mock'))
            ->and($object = new \Mock\Apns())

            ->and($this->mockClass('\ZendService\Apple\Apns\Response\Message', '\Mock\ZendService', 'Response'))
            ->and($serviceResponse = new \Mock\ZendService\Response())

            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockGenerator()->orphanize('open'))
            ->and($this->mockGenerator()->orphanize('send'))
            ->and($this->mockClass('\ZendService\Apple\Apns\Client\Feedback', '\Mock\ZendService'))
            ->and($serviceClient = new \Mock\ZendService\Feedback())
            ->and($serviceClient->getMockController()->feedback = $serviceResponse)

            ->and($object->getMockController()->getServiceMessageFromOrigin = new BaseServiceMessage())
            ->and($object->getMockController()->getOpenedClient = $serviceClient)

            ->array($object->getFeedback())
                ->isEmpty()
        ;
    }
}
