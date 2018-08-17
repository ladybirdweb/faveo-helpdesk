Usage
--------------

 * Must use 'forceChunkSize=true' on client side.
 * Chunk preprocessor not supported.
 * One should ensure indices on the gridfs collection on the property 'flowIdentifier'.

Besides the points above, the usage is analogous to the 'normal' flow-php:

```php
$config = new \Flow\Mongo\MongoConfig($yourGridFs);
$file = new \Flow\Mongo\MongoFile($config);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($file->checkChunk()) {
        header("HTTP/1.1 200 Ok");
    } else {
        header("HTTP/1.1 204 No Content");
        return ;
    }
} else {
  if ($file->validateChunk()) {
      $file->saveChunk();
  } else {
      // error, invalid chunk upload request, retry
      header("HTTP/1.1 400 Bad Request");
      return ;
  }
}
if ($file->validateFile()) {
    // File upload was completed
    $id = $file->saveToGridFs(['your metadata'=>'value']);
    if($id) {
      //do custom post processing here, $id is the MongoId of the gridfs file 
    }
} else {
    // This is not a final chunk, continue to upload
}
```

Delete unfinished files
-----------------------

For this you should setup cron, which would check each chunk upload time.
If chunk is uploaded long time ago, then chunk should be deleted.

Helper method for checking this:
```php
\Flow\Mongo\MongoUploader::pruneChunks($yourGridFs);
```
