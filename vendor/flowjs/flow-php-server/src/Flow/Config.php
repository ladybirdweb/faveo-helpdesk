<?php

namespace Flow;

class Config implements ConfigInterface
{
    /**
     * Config
     *
     * @var array
     */
    private $config;

    /**
     * Controller
     *
     * @param array $config
     */
    public function __construct($config = array())
    {
        $this->config = $config;
    }

    /**
     * Set path to temporary directory for chunks storage
     *
     * @param $path
     */
    public function setTempDir($path)
    {
        $this->config['tempDir'] = $path;
    }

    /**
     * Get path to temporary directory for chunks storage
     *
     * @return string
     */
    public function getTempDir()
    {
        return isset($this->config['tempDir']) ? $this->config['tempDir'] : '';
    }

    /**
     * Set chunk identifier
     *
     * @param callable $callback
     */
    public function setHashNameCallback($callback)
    {
        $this->config['hashNameCallback'] = $callback;
    }

    /**
     * Generate chunk identifier
     *
     * @return callable
     */
    public function getHashNameCallback()
    {
        return isset($this->config['hashNameCallback']) ? $this->config['hashNameCallback'] : '\Flow\Config::hashNameCallback';
    }

    /**
     * Callback to pre-process chunk
     *
     * @param callable $callback
     */
    public function setPreprocessCallback($callback)
    {
        $this->config['preprocessCallback'] = $callback;
    }

    /**
     * Callback to pre-process chunk
     *
     * @return callable|null
     */
    public function getPreprocessCallback()
    {
        return isset($this->config['preprocessCallback']) ? $this->config['preprocessCallback'] : null;
    }

    /**
     * Delete chunks on save
     *
     * @param bool $delete
     */
    public function setDeleteChunksOnSave($delete)
    {
        $this->config['deleteChunksOnSave'] = $delete;
    }

    /**
     * Delete chunks on save
     *
     * @return bool
     */
    public function getDeleteChunksOnSave()
    {
        return isset($this->config['deleteChunksOnSave']) ? $this->config['deleteChunksOnSave'] : true;
    }

    /**
     * Generate chunk identifier
     *
     * @param RequestInterface $request
     *
     * @return string
     */
    public static function hashNameCallback(RequestInterface $request)
    {
        return sha1($request->getIdentifier());
    }
}
