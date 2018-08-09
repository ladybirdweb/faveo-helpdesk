<?php

namespace Flow\Mongo;

use Flow\FileOpenException;

/**
 * @codeCoverageIgnore
 */
class MongoUploader
{
    /**
     * Delete chunks older than expiration time.
     *
     * @param \MongoGridFS $gridFs
     * @param int $expirationTime seconds
     *
     * @throws FileOpenException
     */
    public static function pruneChunks($gridFs, $expirationTime = 172800)
    {
        $result = $gridFs->remove([
            'flowUpdated' => ['$lt' => new \MongoDate(time() - $expirationTime)],
            'flowStatus' => 'uploading'
        ]);

        if (!$result) {
            throw new FileOpenException("Could not remove chunks!");
        }
    }
}
