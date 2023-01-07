<?php

namespace Flow\Mongo;

use Flow\Config;
use MongoDB\GridFS\Bucket;

/**
 * @codeCoverageIgnore
 */
class MongoConfig extends Config implements MongoConfigInterface
{
    private $gridFs;

    /**
     * @param Bucket $gridFS storage of the upload (and chunks)
     */
    function __construct(Bucket $gridFS)
    {
        parent::__construct();
        $this->gridFs = $gridFS;
    }


    /**
     * @return Bucket
     */
    public function getGridFs()
    {
        return $this->gridFs;
    }
}