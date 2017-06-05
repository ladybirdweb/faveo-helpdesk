<?php

namespace Flow\Mongo;

use Flow\Config;

/**
 * @codeCoverageIgnore
 */
class MongoConfig extends Config implements MongoConfigInterface
{
    private $gridFs;

    /**
     * @param \MongoGridFS $gridFS storage of the upload (and chunks)
     */
    function __construct(\MongoGridFS $gridFS)
    {
        parent::__construct();
        $this->gridFs = $gridFS;
    }


    /**
     * @return \MongoGridFS
     */
    public function getGridFs()
    {
        return $this->gridFs;
    }
}