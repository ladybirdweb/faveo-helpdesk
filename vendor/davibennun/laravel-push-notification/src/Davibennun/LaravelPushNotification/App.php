<?php namespace Davibennun\LaravelPushNotification;

use Sly\NotificationPusher\PushManager,
    Sly\NotificationPusher\Model\Device,
    Sly\NotificationPusher\Model\Message,
    Sly\NotificationPusher\Model\Push;

class App {
    
    public function __construct($config)
    {
        $this->pushManager = new PushManager($config['environment'] == "development" ? PushManager::ENVIRONMENT_DEV : PushManager::ENVIRONMENT_PROD);

        $adapterClassName = 'Sly\\NotificationPusher\\Adapter\\'.ucfirst($config['service']);

        $adapterConfig = $config;
        unset($adapterConfig['environment'], $adapterConfig['service']);

        $this->adapter = new $adapterClassName($adapterConfig);
    }

    public function to($addressee)
    {
        $this->addressee = is_string($addressee) ? new Device($addressee) : $addressee;

        return $this;
    }

    public function send($message, $options = array()) {
        $push = new Push($this->adapter, $this->addressee, ($message instanceof Message) ? $message : new Message($message, $options));

        $this->pushManager->add($push);
        
        $this->pushManager->push();

        return $this;
    }

    public function getFeedback() {
        return $this->pushManager->getFeedback($this->adapter);
    }
}