<?php

namespace Flow\Mongo;

use Flow\ConfigInterface;

/**
 * @codeCoverageIgnore
 */
interface MongoConfigInterface extends ConfigInterface
{

    /**
     * @return \MongoGridFS
     */
    public function getGridFs();

}