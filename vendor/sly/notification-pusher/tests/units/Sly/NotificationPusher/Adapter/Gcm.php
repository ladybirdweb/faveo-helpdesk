<?php

namespace tests\units\Sly\NotificationPusher\Adapter;

use mageekguy\atoum as Units;
use Sly\NotificationPusher\Adapter\Gcm as TestedModel;
use Sly\NotificationPusher\Collection\DeviceCollection;
use Sly\NotificationPusher\Model\Device;
use Sly\NotificationPusher\Model\GcmMessage;
use Sly\NotificationPusher\Model\Message;
use Sly\NotificationPusher\Model\Push;
use Sly\NotificationPusher\Model\Response;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use ZendService\Google\Exception\InvalidArgumentException;
use ZendService\Google\Gcm\Client as ZendServiceClient;
use ZendService\Google\Gcm\Message as ZendServiceMessage;
use ZendService\Google\Gcm\Response as ZendResponseAlias;

/**
 * @uses atoum\test
 * @author Cédric Dugat <cedric@dugat.me>
 */
class Gcm extends Units\Test
{
    const GCM_TOKEN_EXAMPLE = 'AAA91bG9ISdL94D55C69NplFlxicy0iFUFTyWh3AAdMfP9npH5r_JQFTo27xpX1jfqGf-aSe6xZAsfWRefjazJpqFt03Isanv-Fi97020EKLye0ApTkHsw_0tJJzgA2Js0NsG1jLWsiJf63YSF8ropAcRp4BSxVBBB';
    // The format of GCM tokens apparently have changed, this string looks similar to new format:
    const ALT_GCM_TOKEN_EXAMPLE = 'AAA91bG9ISd:L94D55C69NplFlxicy0iFUFTyWh3AAdMfP9npH5r_JQFTo27xpX1jfqGf-aSe6xZAsfWRefjazJpqFt03Isanv-Fi97020EKLye0ApTkHsw_0tJJzgA2Js0NsG1jLWsiJf63YSF8ropA';

    public function testConstruct()
    {
        $this
            ->exception(function () {
                $object = new TestedModel();
            })
            ->isInstanceOf(MissingOptionsException::class)
            ->message
            ->contains('apiKey')
            ->when($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(TestedModel::class, '\Mock'))
            ->and($object = new \Mock\Gcm())
            ->and($object->setParameters(['apiKey' => 'test']))
            ->array($object->getParameters())
            ->isNotEmpty()
            ->hasSize(1)
            ->string($object->getParameter('apiKey'))
            ->isEqualTo('test');
    }

    public function testSupports()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(TestedModel::class, '\Mock'))
            ->and($object = new \Mock\Gcm())
            ->boolean($object->supports('')) // Test empty string
            ->isFalse()
            ->boolean($object->supports(2)) // Test a number
            ->isFalse()
            ->boolean($object->supports([])) // Test an array
            ->isFalse()
            ->boolean($object->supports(json_decode('{}'))) // Tests an object
            ->isFalse()
            ->boolean($object->supports(self::GCM_TOKEN_EXAMPLE))
            ->isTrue()
            ->boolean($object->supports(self::ALT_GCM_TOKEN_EXAMPLE))
            ->isTrue();
    }

    public function testDefinedParameters()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(TestedModel::class, '\Mock'))
            ->and($object = new \Mock\Gcm())
            ->array($definedParameters = $object->getDefinedParameters())
            ->isNotEmpty()
            ->containsValues([
                'collapseKey',
                'delayWhileIdle',
                'ttl',
                'restrictedPackageName',
                'dryRun',
            ]);
    }

    public function testDefaultParameters()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(TestedModel::class, '\Mock'))
            ->and($object = new \Mock\Gcm())
            ->array($defaultParameters = $object->getDefaultParameters())
            ->isEmpty();
    }

    public function testRequiredParameters()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(TestedModel::class, '\Mock'))
            ->and($object = new \Mock\Gcm())
            ->array($requiredParameters = $object->getRequiredParameters())
            ->isNotEmpty()
            ->contains('apiKey');
    }

    public function testGetOpenedClient()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(TestedModel::class, '\Mock'))
            ->and($object = new \Mock\Gcm())
            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockGenerator()->orphanize('open'))
            ->and($this->mockClass(ZendServiceClient::class, '\Mock\ZendService'))
            ->and($serviceClient = new \Mock\ZendService\Client())
            ->and($object->getMockController()->getParameters = [])
            ->exception(function () use ($object) {
                $object->getOpenedClient(new ZendServiceClient());
            })
            ->isInstanceOf(InvalidArgumentException::class)
            ->message
            ->contains('The api key must be a string and not empty')
            ->when($object = new TestedModel(['apiKey' => 'test']))
            ->and($object->getOpenedClient($serviceClient));
    }

    public function testGetServiceMessageFromOrigin()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(TestedModel::class, '\Mock'))
            ->and($object = new \Mock\Gcm())
            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(Message::class, '\Mock'))
            ->and($message = new \Mock\Message())
            ->and($message->getMockController()->getOptions = [
                'param' => 'test',
                'notificationData' => ['some' => 'foobar'],
            ])
            ->and($message->getMockController()->getText = 'Test')
            ->object($originalMessage = $object->getServiceMessageFromOrigin([self::GCM_TOKEN_EXAMPLE], $message))
            ->isInstanceOf(ZendServiceMessage::class)
            ->array($originalMessage->getData())
            ->notHasKey('notificationData')
            ->array($originalMessage->getNotification())
            ->hasKey('some')
            ->contains('foobar');
    }

    public function testGcmMessageUse()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(TestedModel::class, '\Mock'))
            ->and($object = new \Mock\Gcm())
            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(GcmMessage::class, '\Mock'))
            ->and($message = new \Mock\GcmMessage())
            ->and($message->getMockController()->getNotificationData = [
                'some' => 'foobar',
            ])
            ->and($message->getMockController()->getText = 'Test')
            ->object($originalMessage = $object->getServiceMessageFromOrigin([self::GCM_TOKEN_EXAMPLE], $message))
            ->isInstanceOf(ZendServiceMessage::class)
            ->array($originalMessage->getData())
            ->notHasKey('notificationData')
            ->array($originalMessage->getNotification())
            ->hasKey('some')
            ->contains('foobar');
    }

    public function testPush()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(TestedModel::class, '\Mock'))
            ->and($object = new \Mock\Gcm())
            ->and($object->setResponse(new Response()))
            ->and($this->mockClass(ZendResponseAlias::class, '\Mock\ZendService'))
            ->and($serviceResponse = new \Mock\ZendService\Response())
            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockGenerator()->orphanize('open'))
            ->and($this->mockGenerator()->orphanize('send'))
            ->and($this->mockClass(ZendServiceClient::class, '\Mock\ZendService'))
            ->and($serviceClient = new \Mock\ZendService\Message())
            ->and($serviceClient->getMockController()->send = new $serviceResponse)
            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass(Push::class, '\Mock'))
            ->and($push = new \Mock\Push())
            ->and($push->getMockController()->getMessage = new Message('Test'))
            ->and($push->getMockController()->getDevices = new DeviceCollection([new Device(self::GCM_TOKEN_EXAMPLE)]))
            ->and($object->getMockController()->getServiceMessageFromOrigin = new ZendServiceMessage())
            ->and($object->getMockController()->getOpenedClient = $serviceClient)
            ->object($object->push($push))
            ->isInstanceOf(DeviceCollection::class)
            ->hasSize(1);
    }
}
