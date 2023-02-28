<?php

namespace Flow\Mongo;

use Exception;
use Flow\File;
use Flow\Request;
use Flow\RequestInterface;
use MongoDB\BSON\Binary;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;
use MongoDB\Operation\FindOneAndReplace;


/**
 * Notes:
 *
 * - One should ensure indices on the gridfs collection on the property 'flowIdentifier'.
 * - Chunk preprocessor not supported (must not modify chunks size)!
 * - Must use 'forceChunkSize=true' on client side.
 *
 * @codeCoverageIgnore
 */
class MongoFile extends File
{
    private $uploadGridFsFile;

    /**
     * @var MongoConfigInterface
     */
    private $config;

    function __construct(MongoConfigInterface $config, RequestInterface $request = null)
    {
        if ($request === null) {
            $request = new Request();
        }
        parent::__construct($config, $request);
        $this->config = $config;
    }

    /**
     * return array
     */
    protected function getGridFsFile()
    {
        if (!$this->uploadGridFsFile) {
            $gridFsFileQuery = $this->getGridFsFileQuery();
            $changed = $gridFsFileQuery;
            $changed['flowUpdated'] = new UTCDateTime();
            $this->uploadGridFsFile = $this->config->getGridFs()->getFilesCollection()->findOneAndReplace($gridFsFileQuery, $changed,
                ['upsert' => true, 'returnDocument' => FindOneAndReplace::RETURN_DOCUMENT_AFTER]);
        }

        return $this->uploadGridFsFile;
    }

    /**
     * @param $index int|string 1-based
     * @return bool
     */
    public function chunkExists($index)
    {
        return $this->config->getGridFs()->getChunksCollection()->findOne([
            'files_id' => $this->getGridFsFile()['_id'],
            'n' => (intval($index) - 1)
        ]) !== null;
    }

    public function checkChunk()
    {
        return $this->chunkExists($this->request->getCurrentChunkNumber());
    }

    /**
     * Save chunk
     * @param $additionalUpdateOptions array additional options for the mongo update/upsert operation.
     * @return bool
     * @throws Exception if upload size is invalid or some other unexpected error occurred.
     */
    public function saveChunk($additionalUpdateOptions = [])
    {
        try {
            $file = $this->request->getFile();

            $chunkQuery = [
                'files_id' => $this->getGridFsFile()['_id'],
                'n' => intval($this->request->getCurrentChunkNumber()) - 1,
            ];
            $chunk = $chunkQuery;
            $data = file_get_contents($file['tmp_name']);
            $actualChunkSize = strlen($data);
            if ($actualChunkSize > $this->request->getDefaultChunkSize() ||
                ($actualChunkSize < $this->request->getDefaultChunkSize() &&
                    $this->request->getCurrentChunkNumber() != $this->request->getTotalChunks())
            ) {
                throw new Exception("Invalid upload! (size: $actualChunkSize)");
            }
            $chunk['data'] = new Binary($data, Binary::TYPE_GENERIC);
            $this->config->getGridFs()->getChunksCollection()->replaceOne($chunkQuery, $chunk, array_merge(['upsert' => true], $additionalUpdateOptions));
            unlink($file['tmp_name']);

            $this->ensureIndices();

            return true;
        } catch (Exception $e) {
            // try to remove a possibly (partly) stored chunk:
            if (isset($chunkQuery)) {
                $this->config->getGridFs()->getChunksCollection()->deleteMany($chunkQuery);
            }
            throw $e;
        }
    }

    /**
     * @return bool
     */
    public function validateFile()
    {
        $totalChunks = intval($this->request->getTotalChunks());
        $storedChunks = $this->config->getGridFs()->getChunksCollection()
            ->countDocuments(['files_id' => $this->getGridFsFile()['_id']]);
        return $totalChunks === $storedChunks;
    }


    /**
     * Merge all chunks to single file
     * @param $metadata array additional metadata for final file
     * @return ObjectId|bool of saved file or false if file was already saved
     * @throws Exception
     */
    public function saveToGridFs($metadata = null)
    {
        $file = $this->getGridFsFile();
        $file['flowStatus'] = 'finished';
        $file['metadata'] = $metadata;
        $result = $this->config->getGridFs()->getFilesCollection()->findOneAndReplace($this->getGridFsFileQuery(), $file);
        // on second invocation no more file can be found, as the flowStatus changed:
        if (is_null($result)) {
            return false;
        } else {
            return $file['_id'];
        }
    }

    public function save($destination)
    {
        throw new Exception("Must not use 'save' on MongoFile - use 'saveToGridFs'!");
    }

    public function deleteChunks()
    {
        // nothing to do, as chunks are directly part of the final file
    }

    public function ensureIndices()
    {
        $chunksCollection = $this->config->getGridFs()->getChunksCollection();
        $indexKeys = ['files_id' => 1, 'n' => 1];
        $indexOptions = ['unique' => true, 'background' => true];
        $chunksCollection->createIndex($indexKeys, $indexOptions);
    }

    /**
     * @return array
     */
    protected function getGridFsFileQuery()
    {
        return [
            'flowIdentifier' => $this->request->getIdentifier(),
            'flowStatus' => 'uploading',
            'filename' => $this->request->getFileName(),
            'chunkSize' => intval($this->request->getDefaultChunkSize()),
            'length' => intval($this->request->getTotalSize())
        ];
    }
}
