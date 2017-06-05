<?php

namespace Flow;

/**
 * Class FustyRequest
 *
 * Imitates single file request as a single chunk file upload
 *
 * @package Flow
 */
class FustyRequest extends Request
{
    private $isFusty = false;

    public function __construct($params = null, $file = null)
    {
        parent::__construct($params, $file);

        $this->isFusty = $this->getTotalSize() === null && $this->getFileName() && $this->getFile();

        if ($this->isFusty) {
            $this->params['flowTotalSize'] = isset($this->file['size']) ? $this->file['size'] : 0;
            $this->params['flowTotalChunks'] = 1;
            $this->params['flowChunkNumber'] = 1;
            $this->params['flowChunkSize'] = $this->params['flowTotalSize'];
            $this->params['flowCurrentChunkSize'] = $this->params['flowTotalSize'];
        }
    }

    /**
     * Checks if request is formed by fusty flow
     * @return bool
     */
    public function isFustyFlowRequest()
    {
        return $this->isFusty;
    }
}
