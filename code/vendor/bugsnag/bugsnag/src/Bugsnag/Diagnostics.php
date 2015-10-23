<?php

class Bugsnag_Diagnostics
{
    private $config;

    public function __construct(Bugsnag_Configuration $config)
    {
        $this->config = $config;
    }

    public function getAppData()
    {
        $appData = array();

        if (!is_null($this->config->appVersion)) {
            $appData['version'] = $this->config->appVersion;
        }

        if (!is_null($this->config->releaseStage)) {
            $appData['releaseStage'] = $this->config->releaseStage;
        }

        if (!is_null($this->config->type)) {
            $appData['type'] = $this->config->type;
        }

        return $appData;
    }

    public function getDeviceData()
    {
        return array(
            'hostname' => $this->config->get('hostname', php_uname('n')),
        );
    }

    public function getContext()
    {
        return $this->config->get('context', Bugsnag_Request::getContext());
    }

    public function getUser()
    {
        $defaultUser = array();
        $userId = Bugsnag_Request::getUserId();

        if (!is_null($userId)) {
            $defaultUser['id'] = $userId;
        }

        return $this->config->get('user', $defaultUser);
    }
}
