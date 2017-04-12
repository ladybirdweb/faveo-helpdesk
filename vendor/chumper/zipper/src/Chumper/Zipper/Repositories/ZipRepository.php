<?php namespace Chumper\Zipper\Repositories;

use Exception;
use ZipArchive;

class ZipRepository implements RepositoryInterface
{
    private $archive;

    /**
     * Construct with a given path
     *
     * @param $filePath
     * @param bool $create
     * @param $archive
     * @throws \Exception
     * @return ZipRepository
     */
    function __construct($filePath, $create = false, $archive = null)
    {
        //Check if ZipArchive is available
        if (!class_exists('ZipArchive'))
            throw new Exception('Error: Your PHP version is not compiled with zip support');

        $this->archive = $archive ? $archive : new ZipArchive;

        if ($create)
            $this->archive->open($filePath, ZipArchive::CREATE);
        else
            $this->archive->open($filePath);
    }

    /**
     * Add a file to the opened Archive
     *
     * @param $pathToFile
     * @param $pathInArchive
     * @return void
     */
    public function addFile($pathToFile, $pathInArchive)
    {
        $this->archive->addFile($pathToFile, $pathInArchive);
    }
	
	/**
     * Add a file to the opened Archive using its contents 
     *
     * @param $name
     * @param $content
     * @return void
     */
    public function addFromString($name, $content)
    {
        $this->archive->addFromString($name, $content);
    }

    /**
     * Remove a file permanently from the Archive
     *
     * @param $pathInArchive
     * @return void
     */
    public function removeFile($pathInArchive)
    {
        $this->archive->deleteName($pathInArchive);
    }

    /**
     * Get the content of a file
     *
     * @param $pathInArchive
     * @return string
     */
    public function getFileContent($pathInArchive)
    {
        return $this->archive->getFromName($pathInArchive);
    }

    /**
     * Get the stream of a file
     *
     * @param $pathInArchive
     * @return mixed
     */
    public function getFileStream($pathInArchive)
    {
        return $this->archive->getStream($pathInArchive);
    }

    /**
     * Will loop over every item in the archive and will execute the callback on them
     * Will provide the filename for every item
     *
     * @param $callback
     * @return void
     */
    public function each($callback)
    {
        for ($i = 0; $i < $this->archive->numFiles; $i++) {

            //skip if folder
            $stats = $this->archive->statIndex($i);
            if ($stats['size'] == 0 && $stats['crc'] == 0)
                continue;

            call_user_func_array($callback, array(
                'file' => $this->archive->getNameIndex($i),
            ));
        }
    }

    /**
     * Checks whether the file is in the archive
     *
     * @param $fileInArchive
     * @return boolean
     */
    public function fileExists($fileInArchive)
    {
        return $this->archive->locateName($fileInArchive) !== false;
    }

    /**
     * Returns the status of the archive as a string
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->archive->getStatusString();
    }

    /**
     * Closes the archive and saves it
     * @return void
     */
    public function close()
    {
        @$this->archive->close();
    }
}