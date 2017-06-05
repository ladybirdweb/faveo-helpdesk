<?php

namespace Flow;

interface ConfigInterface
{
    /**
     * Get path to temporary directory for chunks storage
     *
     * @return string
     */
    public function getTempDir();

    /**
     * Generate chunk identifier
     *
     * @return callable
     */
    public function getHashNameCallback();

    /**
     * Callback to pre-process chunk
     *
     * @param callable $callback
     */
    public function setPreprocessCallback($callback);

    /**
     * Callback to preprocess chunk
     *
     * @return callable|null
     */
    public function getPreprocessCallback();

    /**
     * Delete chunks on save
     *
     * @param bool $delete
     */
    public function setDeleteChunksOnSave($delete);

    /**
     * Delete chunks on save
     *
     * @return bool
     */
    public function getDeleteChunksOnSave();
}
