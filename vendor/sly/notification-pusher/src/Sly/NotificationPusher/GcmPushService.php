<?php
/**
 * Created by PhpStorm.
 * User: seyfer
 * Date: 10.08.17
 * Time: 10:43
 */

namespace Sly\NotificationPusher;

use Sly\NotificationPusher\Adapter\Gcm as GcmAdapter;
use Sly\NotificationPusher\Collection\DeviceCollection;
use Sly\NotificationPusher\Model\Device;
use Sly\NotificationPusher\Model\Message;
use Sly\NotificationPusher\Model\Push;
use Sly\NotificationPusher\Model\ResponseInterface;

/**
 * Facade for simple use cases
 *
 * Class GcmPushService
 * @package Sly\NotificationPusher
 */
class GcmPushService extends AbstractPushService
{
    /**
     * @var string
     */
    private $apiKey = '';

    /**
     * GcmPushService constructor.
     * @param string $environment
     * @param string $apiKey
     */
    public function __construct($apiKey, $environment = PushManager::ENVIRONMENT_DEV)
    {
        parent::__construct($environment);

        $this->apiKey = $apiKey;
    }

    /**
     * params keys
     *      adapter
     *      message
     *      device
     *
     * @param array $tokens
     * @param array $notifications
     * @param array $params
     * @return ResponseInterface
     */
    public function push(array $tokens = [], array $notifications = [], array $params = [])
    {
        if (!$tokens || !$notifications) {
            return null;
        }

        $adapterParams = [];
        $deviceParams  = [];
        $messageParams = [];
        if (isset($params) && !empty($params)) {
            if (isset($params['adapter'])) {
                $adapterParams = $params['adapter'];
            }

            if (isset($params['device'])) {
                $deviceParams = $params['device'];
            }

            if (isset($params['message'])) {
                $messageParams = $params['message'];
            }

            //because we have now notification and data separated
            if (isset($params['notificationData'])) {
                $messageParams['notificationData'] = $params['notificationData'];
            }
        }

        $adapterParams['apiKey'] = $this->apiKey;

        if (!$this->apiKey) {
            throw new \RuntimeException('Android api key must be set');
        }

        // Development one by default (without argument).
        /** @var PushManager $pushManager */
        $pushManager = new PushManager($this->environment);

        // Then declare an adapter.
        $gcmAdapter = new GcmAdapter($adapterParams);

        // Set the device(s) to push the notification to.
        $devices = new DeviceCollection([]);

        //devices
        foreach ($tokens as $token) {
            $devices->add(new Device($token, $deviceParams));
        }

        foreach ($notifications as $notificationText) {
            // Then, create the push skel.
            $message = new Message($notificationText, $messageParams);

            // Finally, create and add the push to the manager, and push it!
            $push = new Push($gcmAdapter, $devices, $message);
            $pushManager->add($push);
        }

        // Returns a collection of notified devices
        $pushes = $pushManager->push();

        $this->response = $gcmAdapter->getResponse();

        return $this->response;
    }

    /**
     * @return array
     */
    public function getInvalidTokens()
    {
        if (!$this->response) {
            return [];
        }

        $tokens = [];

        foreach ($this->response->getParsedResponses() as $token => $response) {
            if (array_key_exists('error', $response) && !array_key_exists('message_id', $response)) {
                array_push($tokens, $token);
            }
        }

        return $tokens;
    }

    /**
     * @return array
     */
    public function getSuccessfulTokens()
    {
        if (!$this->response) {
            return [];
        }

        $tokens = [];

        foreach ($this->response->getParsedResponses() as $token => $response) {
            if (!array_key_exists('error', $response) && array_key_exists('message_id', $response)) {
                array_push($tokens, $token);
            }
        }

        return $tokens;
    }
}
