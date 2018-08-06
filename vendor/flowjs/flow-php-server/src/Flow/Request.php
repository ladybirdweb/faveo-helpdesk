<?php

namespace Flow;

class Request implements RequestInterface
{
    /**
     * Request parameters
     *
     * @var array
     */
    protected $params;

    /**
     * File
     *
     * @var array
     */
    protected $file;

    /**
     * Constructor
     *
     * @param array|null $params
     * @param array|null $file
     */
    public function __construct($params = null, $file = null)
    {
        if ($params === null) {
            $params = $_REQUEST;
        }

        if ($file === null && isset($_FILES['file'])) {
            $file = $_FILES['file'];
        }

        $this->params = $params;
        $this->file = $file;
    }

    /**
     * Get parameter value
     *
     * @param string $name
     *
     * @return string|int|null
     */
    public function getParam($name)
    {
        return isset($this->params[$name]) ? $this->params[$name] : null;
    }

    /**
     * Get uploaded file name
     *
     * @return string|null
     */
    public function getFileName()
    {
        return $this->getParam('flowFilename');
    }

    /**
     * Get total file size in bytes
     *
     * @return int|null
     */
    public function getTotalSize()
    {
        return $this->getParam('flowTotalSize');
    }

    /**
     * Get file unique identifier
     *
     * @return string|null
     */
    public function getIdentifier()
    {
        return $this->getParam('flowIdentifier');
    }

    /**
     * Get file relative path
     *
     * @return string|null
     */
    public function getRelativePath()
    {
        return $this->getParam('flowRelativePath');
    }

    /**
     * Get total chunks number
     *
     * @return int|null
     */
    public function getTotalChunks()
    {
        return $this->getParam('flowTotalChunks');
    }

    /**
     * Get default chunk size
     *
     * @return int|null
     */
    public function getDefaultChunkSize()
    {
        return $this->getParam('flowChunkSize');
    }

    /**
     * Get current uploaded chunk number, starts with 1
     *
     * @return int|null
     */
    public function getCurrentChunkNumber()
    {
        return $this->getParam('flowChunkNumber');
    }

    /**
     * Get current uploaded chunk size
     *
     * @return int|null
     */
    public function getCurrentChunkSize()
    {
        return $this->getParam('flowCurrentChunkSize');
    }

    /**
     * Return $_FILES request
     *
     * @return array|null
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Checks if request is formed by fusty flow
     *
     * @return bool
     */
    public function isFustyFlowRequest()
    {
        return false;
    }
}
