<?php

namespace tests\units\Sly\NotificationPusher\Adapter;

use mageekguy\atoum as Units;
use Sly\NotificationPusher\Adapter\Gcm as TestedModel;

use Sly\NotificationPusher\Model\Message as BaseMessage;
use Sly\NotificationPusher\Model\Device as BaseDevice;
use Sly\NotificationPusher\Collection\DeviceCollection as BaseDeviceCollection;

use ZendService\Google\Gcm\Client as BaseServiceClient;
use ZendService\Google\Gcm\Message as BaseServiceMessage;

/**
 * Gcm.
 *
 * @uses atoum\test
 * @author Cédric Dugat <cedric@dugat.me>
 */
class Gcm extends Units\Test
{
    const GCM_TOKEN_EXAMPLE = 'AAA91bG9ISdL94D55C69NplFlxicy0iFUFTyWh3AAdMfP9npH5r_JQFTo27xpX1jfqGf-aSe6xZAsfWRefjazJpqFt03Isanv-Fi97020EKLye0ApTkHsw_0tJJzgA2Js0NsG1jLWsiJf63YSF8ropAcRp4BSxVBBB';

    public function testConstruct()
    {
        $this
            ->exception(function() {
                $object = new TestedModel();
            })
                ->isInstanceOf('\Symfony\Component\OptionsResolver\Exception\MissingOptionsException')
                ->message
                    ->contains('apiKey')

            ->when($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Gcm', '\Mock'))
            ->and($object = new \Mock\Gcm())
            ->and($object->setParameters(array('apiKey' => 'test')))
            ->array($object->getParameters())
                ->isNotEmpty()
                ->hasSize(1)
            ->string($object->getParameter('apiKey'))
                ->isEqualTo('test')
        ;
    }

    public function testSupports()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Gcm', '\Mock'))
            ->and($object = new \Mock\Gcm())
            ->boolean($object->supports('*()*'))
                ->isFalse()
            ->boolean($object->supports(self::GCM_TOKEN_EXAMPLE))
                ->isTrue()
        ;
    }

    public function testDefaultParameters()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Gcm', '\Mock'))
            ->and($object = new \Mock\Gcm())
            ->array($defaultParameters = $object->getDefaultParameters())
                ->isEmpty()
        ;
    }

    public function testRequiredParameters()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Gcm', '\Mock'))
            ->and($object = new \Mock\Gcm())
            ->array($requiredParameters = $object->getRequiredParameters())
                ->isNotEmpty()
                ->contains('apiKey')
        ;
    }

    public function testGetOpenedClient()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Gcm', '\Mock'))
            ->and($object = new \Mock\Gcm())
            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockGenerator()->orphanize('open'))
            ->and($this->mockClass('\ZendService\Google\Gcm\Client', '\Mock\ZendService'))
            ->and($serviceClient = new \Mock\ZendService\Client())
            ->and($object->getMockController()->getParameters = array())
            ->exception(function() use($object) {
                $object->getOpenedClient(new BaseServiceClient());
            })
                ->isInstanceOf('\ZendService\Google\Exception\InvalidArgumentException')
                ->message
                    ->contains('The api key must be a string and not empty')

            ->when($object = new TestedModel(array('apiKey' => 'test')))
            ->and($object->getOpenedClient($serviceClient))
        ;
    }

    public function testGetServiceMessageFromOrigin()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Gcm', '\Mock'))
            ->and($object = new \Mock\Gcm())

            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Model\Message', '\Mock'))
            ->and($message = new \Mock\Message())
            ->and($message->getMockController()->getText = 'Test')

            ->object($object->getServiceMessageFromOrigin(array(self::GCM_TOKEN_EXAMPLE), $message))
                ->isInstanceOf('\ZendService\Google\Gcm\Message')
        ;
    }

    public function testPush()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Gcm', '\Mock'))
            ->and($object = new \Mock\Gcm())

            ->and($this->mockClass('\ZendService\Google\Gcm\Response', '\Mock\ZendService'))
            ->and($serviceResponse = new \Mock\ZendService\Response())

            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockGenerator()->orphanize('open'))
            ->and($this->mockGenerator()->orphanize('send'))
            ->and($this->mockClass('\ZendService\Google\Gcm\Client', '\Mock\ZendService'))
            ->and($serviceClient = new \Mock\ZendService\Message())
            ->and($serviceClient->getMockController()->send = new $serviceResponse)

            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Model\Push', '\Mock'))
            ->and($push = new \Mock\Push())
            ->and($push->getMockController()->getMessage = new BaseMessage('Test'))
            ->and($push->getMockController()->getDevices = new BaseDeviceCollection(array(new BaseDevice(self::GCM_TOKEN_EXAMPLE))))

            ->and($object->getMockController()->getServiceMessageFromOrigin = new BaseServiceMessage())
            ->and($object->getMockController()->getOpenedClient = $serviceClient)

            ->object($object->push($push))
                ->isInstanceOf('\Sly\NotificationPusher\Collection\DeviceCollection')
                ->hasSize(1)
        ;
    }
}
