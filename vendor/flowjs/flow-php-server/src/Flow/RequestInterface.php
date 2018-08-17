<?php

namespace Flow;

interface RequestInterface
{
    /**
     * Get uploaded file name
     *
     * @return string
     */
    public function getFileName();

    /**
     * Get total file size in bytes
     *
     * @return int
     */
    public function getTotalSize();

    /**
     * Get file unique identifier
     *
     * @return string
     */
    public function getIdentifier();

    /**
     * Get file relative path
     *
     * @return string
     */
    public function getRelativePath();

    /**
     * Get total chunks number
     *
     * @return int
     */
    public function getTotalChunks();

    /**
     * Get default chunk size
     *
     * @return int
     */
    public function getDefaultChunkSize();

    /**
     * Get current uploaded chunk number, starts with 1
     *
     * @return int
     */
    public function getCurrentChunkNumber();

    /**
     * Get current uploaded chunk size
     *
     * @return int
     */
    public function getCurrentChunkSize();

    /**
     * Return $_FILES request
     *
     * @return array|null
     */
    public function getFile();

    /**
     * Checks if request is formed by fusty flow
     *
     * @return bool
     */
    public function isFustyFlowRequest();
}
