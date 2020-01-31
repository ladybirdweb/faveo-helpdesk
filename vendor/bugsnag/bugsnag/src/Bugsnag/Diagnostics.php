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
     * The device data.
     *
     * @var string[]
     */
    private $deviceData = array();

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

        $this->mergeDeviceData(array('runtimeVersions' => array('php' => phpversion())));
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
     * Merges new data fields to the device data collection.
     *
     * @param array $deviceData the data to add
     *
     * @return $this
     */
    public function mergeDeviceData($deviceData)
    {
        $this->deviceData = array_merge_recursive($this->deviceData, $deviceData);

        return $this;
    }

    /**
     * Get the device information.
     *
     * @return array
     */
    public function getDeviceData()
    {
        return array_merge(
            array('hostname' => $this->config->get('hostname', php_uname('n'))),
            array_filter($this->deviceData)
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
