<?php

namespace Flow;

class File
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * File hashed unique identifier
     *
     * @var string
     */
    private $identifier;

    /**
     * Constructor
     *
     * @param ConfigInterface  $config
     * @param RequestInterface $request
     */
    public function __construct(ConfigInterface $config, RequestInterface $request = null)
    {
        $this->config = $config;

        if ($request === null) {
            $request = new Request();
        }

        $this->request = $request;
        $this->identifier = call_user_func($this->config->getHashNameCallback(), $request);
    }

    /**
     * Get file identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Return chunk path
     *
     * @param int $index
     *
     * @return string
     */
    public function getChunkPath($index)
    {
        return $this->config->getTempDir().DIRECTORY_SEPARATOR.basename($this->identifier).'_'. (int) $index;
    }

    /**
     * Check if chunk exist
     *
     * @return bool
     */
    public function checkChunk()
    {
        return file_exists($this->getChunkPath($this->request->getCurrentChunkNumber()));
    }

    /**
     * Validate file request
     *
     * @return bool
     */
    public function validateChunk()
    {
        $file = $this->request->getFile();

        if (!$file) {
            return false;
        }

        if (!isset($file['tmp_name']) || !isset($file['size']) || !isset($file['error'])) {
            return false;
        }

        if ($this->request->getCurrentChunkSize() != $file['size']) {
            return false;
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        return true;
    }

    /**
     * Save chunk
     *
     * @return bool
     */
    public function saveChunk()
    {
        $file = $this->request->getFile();

        return $this->_move_uploaded_file($file['tmp_name'], $this->getChunkPath($this->request->getCurrentChunkNumber()));
    }

    /**
     * Check if file upload is complete
     *
     * @return bool
     */
    public function validateFile()
    {
        $totalChunks = $this->request->getTotalChunks();
        $totalChunksSize = 0;

        for ($i = $totalChunks; $i >= 1; $i--) {
            $file = $this->getChunkPath($i);
            if (!file_exists($file)) {
                return false;
            }
            $totalChunksSize += filesize($file);
        }

        return $this->request->getTotalSize() == $totalChunksSize;
    }

    /**
     * Merge all chunks to single file
     *
     * @param string $destination final file location
     *
     *
     * @throws FileLockException
     * @throws FileOpenException
     * @throws \Exception
     *
     * @return bool indicates if file was saved
     */
    public function save($destination)
    {
        $fh = fopen($destination, 'wb');
        if (!$fh) {
            throw new FileOpenException('failed to open destination file: '.$destination);
        }

        if (!flock($fh, LOCK_EX | LOCK_NB, $blocked)) {
            // @codeCoverageIgnoreStart
            if ($blocked) {
                // Concurrent request has requested a lock.
                // File is being processed at the moment.
                // Warning: lock is not checked in windows.
                return false;
            }
            // @codeCoverageIgnoreEnd

            throw new FileLockException('failed to lock file: '.$destination);
        }

        $totalChunks = $this->request->getTotalChunks();

        try {
            $preProcessChunk = $this->config->getPreprocessCallback();

            for ($i = 1; $i <= $totalChunks; $i++) {
                $file = $this->getChunkPath($i);
                $chunk = fopen($file, "rb");

                if (!$chunk) {
                    throw new FileOpenException('failed to open chunk: '.$file);
                }

                if ($preProcessChunk !== null) {
                    call_user_func($preProcessChunk, $chunk);
                }

                stream_copy_to_stream($chunk, $fh);
                fclose($chunk);
            }
        } catch (\Exception $e) {
            flock($fh, LOCK_UN);
            fclose($fh);
            throw $e;
        }

        if ($this->config->getDeleteChunksOnSave()) {
            $this->deleteChunks();
        }

        flock($fh, LOCK_UN);
        fclose($fh);

        return true;
    }

    /**
     * Delete chunks dir
     */
    public function deleteChunks()
    {
        $totalChunks = $this->request->getTotalChunks();

        for ($i = 1; $i <= $totalChunks; $i++) {
            $path = $this->getChunkPath($i);
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }

    /**
     * This method is used only for testing
     *
     * @private
     * @codeCoverageIgnore
     *
     * @param string $filePath
     * @param string $destinationPath
     *
     * @return bool
     */
    public function _move_uploaded_file($filePath, $destinationPath)
    {
        return move_uploaded_file($filePath, $destinationPath);
    }
}
