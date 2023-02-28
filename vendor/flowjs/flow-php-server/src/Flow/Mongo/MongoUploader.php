<?php

namespace Flow\Mongo;

use MongoDB\GridFS\Bucket;

/**
 * @codeCoverageIgnore
 */
class MongoUploader
{
    /**
     * Delete chunks older than expiration time.
     *
     * @param Bucket $gridFs
     * @param int $expirationTime seconds
     */
    public static function pruneChunks($gridFs, $expirationTime = 172800)
    {
        $result = $gridFs->find([
            'flowUpdated' => ['$lt' => new \MongoDB\BSON\UTCDateTime(time() - $expirationTime)],
            'flowStatus' => 'uploading'
        ]);
        foreach ($result as $file) {
            $gridFs->delete($file['_id']);
        }
    }
}
