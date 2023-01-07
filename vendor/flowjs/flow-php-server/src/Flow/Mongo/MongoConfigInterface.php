<?php

namespace Flow\Mongo;

use Flow\ConfigInterface;
use MongoDB\GridFS\Bucket;

/**
 * @codeCoverageIgnore
 */
interface MongoConfigInterface extends ConfigInterface
{

    /**
     * @return Bucket
     */
    public function getGridFs();

}