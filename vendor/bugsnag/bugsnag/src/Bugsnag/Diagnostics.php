<?php

class Bugsnag_Diagnostics
{
    /**
     * The config instance.
     *
     * @var Bugsnag_Configuration
     */
    private $config;

    /**
     * Create a new diagnostics instance.
     *
     * @param Bugsnag_Configuration $config the configuration instance
     *
     * @return void
     */
    public function __construct(Bugsnag_Configuration $config)
    {
        $this->config = $config;
    }

    /**
     * Get the application information.
     *
     * @return array
     */
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

    /**
     * Get the device information.
     *
     * @return array
     */
    public function getDeviceData()
    {
        return array(
            'hostname' => $this->config->get('hostname', php_uname('n')),
        );
    }

    /**
     * Get the error context.
     *
     * @return array
     */
    public function getContext()
    {
        return $this->config->get('context', Bugsnag_Request::getContext());
    }

    /**
     * Get the current user.
     *
     * @return array
     */
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
