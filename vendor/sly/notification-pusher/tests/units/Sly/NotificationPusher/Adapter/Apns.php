<?php

namespace tests\units\Sly\NotificationPusher\Adapter;

use mageekguy\atoum as Units;
use Sly\NotificationPusher\Adapter\Apns as TestedModel;
use Sly\NotificationPusher\Collection\DeviceCollection;
use Sly\NotificationPusher\Exception\AdapterException;
use Sly\NotificationPusher\Model\Device;
use Sly\NotificationPusher\Model\Message;
use Sly\NotificationPusher\Model\Push;
use Sly\NotificationPusher\Model\Response;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use ZendService\Apple\Apns\Client\Feedback;
use ZendService\Apple\Apns\Client\Message as ZendClientMessage;
use ZendService\Apple\Apns\Message as ZendServiceMessage;
use ZendService\Apple\Apns\Response\Message as ZendResponseMessage;
use ZendService\Apple\Exception\InvalidArgumentException;

/**
 * @uses atoum\test
 * @author Cédric Dugat <cedric@dugat.me>
 */
class Apns extends Units\Test
{
    const APNS_TOKEN_EXAMPLE_64 = '111db24975bb6c6b63214a8d268052aa0a965cc1e32110ab06a72b19074c2222';
    const APNS_TOKEN_EXAMPLE_65 = '111db24975bb6c6b63214a8d268052aa0a965cc1e32110ab06a72b19074c22225';

    public function testConstruct()
    {
        $this
            ->exception(static function () {
                $object = new TestedModel();
            })
            ->isInstanceOf(MissingOptionsException::class)
            ->message
            ->contains('certificate')
            ->exception(static function () {
                $object = new TestedModel(['certificate' => 'absent.pem']);
            })
            ->isInstanceOf(AdapterException::class)
            ->message
            ->contains('does not exist')
            ->when($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(TestedModel::class, '\Mock'))
            ->and($object = new \Mock\Apns())
            ->and($object->setParameters(['certificate' => 'test.pem', 'passPhrase' => 'test']))
            ->and($object->setResponse(new Response()))
            ->array($object->getParameters())
            ->isNotEmpty()
            ->hasSize(2)
            ->string($object->getParameter('certificate'))
            ->isEqualTo('test.pem');
    }

    public function testSupports()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(TestedModel::class, '\Mock'))
            ->and($object = new \Mock\Apns())
            ->boolean($object->supports('wrongToken'))
            ->isFalse()
            ->boolean($object->supports(self::APNS_TOKEN_EXAMPLE_64))
            ->isTrue()
            ->boolean($object->supports(self::APNS_TOKEN_EXAMPLE_65))
            ->isTrue();
    }

    public function testDefinedParameters()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(TestedModel::class, '\Mock'))
            ->and($object = new \Mock\Apns())
            ->array($defaultParameters = $object->getDefinedParameters())
            ->isEmpty();
    }

    public function testDefaultParameters()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(TestedModel::class, '\Mock'))
            ->and($object = new \Mock\Apns())
            ->array($defaultParameters = $object->getDefaultParameters())
            ->isNotEmpty()
            ->hasKey('passPhrase')
            ->variable($defaultParameters['passPhrase'])
            ->isNull();
    }

    public function testRequiredParameters()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(TestedModel::class, '\Mock'))
            ->and($object = new \Mock\Apns())
            ->array($requiredParameters = $object->getRequiredParameters())
            ->isNotEmpty()
            ->contains('certificate');
    }

    public function testGetOpenedClient()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(TestedModel::class, '\Mock'))
            ->and($object = new \Mock\Apns())
            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockGenerator()->orphanize('open'))
            ->and($this->mockClass(ZendClientMessage::class, '\Mock\ZendService'))
            ->and($serviceClient = new \Mock\ZendService\Message())
            ->and($object->getMockController()->getParameters = [])
            ->exception(static function () use ($object) {
                $object->getOpenedClient(new ZendClientMessage());
            })
            ->isInstanceOf(InvalidArgumentException::class)
            ->message
            ->contains('Certificate must be a valid path to a APNS certificate')
            ->when($object = new TestedModel(['certificate' => __DIR__ . '/../Resources/apns-certificate.pem']))
            ->and($object->getOpenedClient($serviceClient));
    }

    public function testGetServiceMessageFromOrigin()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(TestedModel::class, '\Mock'))
            ->and($object = new \Mock\Apns())
            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(Device::class, '\Mock'))
            ->and($device = new \Mock\Device())
            ->and($device->getMockController()->getToken = self::APNS_TOKEN_EXAMPLE_64)
            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(Message::class, '\Mock'))
            ->and($message = new \Mock\Message())
            ->and($message->getMockController()->getText = 'Test')
            ->object($object->getServiceMessageFromOrigin($device, $message))
            ->isInstanceOf(ZendServiceMessage::class);
    }

    public function testPush()
    {
        $this->if($this->mockGenerator()->orphanize('__construct')
            ->makeVisible('getOpenedServiceClient')
            ->generate(TestedModel::class, '\Mock', 'Apns'))
            ->and($object = new \Mock\Apns())
            ->and($object->setResponse(new Response()))
            ->and($this->mockClass(ZendResponseMessage::class, '\Mock\ZendService', 'Response'))
            ->and($serviceResponse = new \Mock\ZendService\Response())
            ->and($serviceResponse->getMockController()->getCode = ZendResponseMessage::RESULT_OK)
            ->and($serviceResponse->getMockController()->getId = 0)
            ->and($this->mockGenerator()->orphanize('__construct')
                ->orphanize('open')
                ->orphanize('send')
                ->generate(ZendClientMessage::class, '\Mock\ZendService'))
            ->and($serviceClient = new \Mock\ZendService\Message())
            ->and($serviceClient->getMockController()->send = $serviceResponse)
            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(Push::class, '\Mock'))
            ->and($push = new \Mock\Push())
            ->and($push->getMockController()->getMessage = new Message('Test'))
            ->and($push->getMockController()->getDevices = new DeviceCollection(
                [new Device(self::APNS_TOKEN_EXAMPLE_64)]
            ))
            ->and($object->getMockController()->getServiceMessageFromOrigin = new ZendServiceMessage())
            ->and($object->getMockController()->getOpenedClient = $serviceClient)
            ->and($this->calling($object)->getOpenedServiceClient = $serviceClient)
            ->object($result = $object->push($push))
            ->isInstanceOf(DeviceCollection::class)
            ->boolean($result->count() == 1)
            ->isTrue();
    }

    public function testCountIsEmpty()
    {
        $this->if($dcoll = new DeviceCollection())
            ->boolean($dcoll->isEmpty())
            ->isTrue();
    }

    public function testFeedback()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(TestedModel::class, '\Mock'))
            ->and($object = new \Mock\Apns())
            ->and($this->mockClass(ZendResponseMessage::class, '\Mock\ZendService', 'Response'))
            ->and($serviceResponse = new \Mock\ZendService\Response())
            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockGenerator()->orphanize('open'))
            ->and($this->mockGenerator()->orphanize('send'))
            ->and($this->mockClass(Feedback::class, '\Mock\ZendService'))
            ->and($serviceClient = new \Mock\ZendService\Feedback())
            ->and($serviceClient->getMockController()->feedback = $serviceResponse)
            ->and($object->getMockController()->getServiceMessageFromOrigin = new ZendServiceMessage())
            ->and($object->getMockController()->getOpenedClient = $serviceClient)
            ->array($object->getFeedback())
            ->isEmpty();
    }
}
