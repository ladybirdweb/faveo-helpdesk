<?php namespace Chumper\Zipper\Repositories;


/**
 * RepositoryInterface that needs to be implemented by every Repository
 *
 * Class RepositoryInterface
 * @package Chumper\Zipper\Repositories
 */
/**
 * Class RepositoryInterface
 * @package Chumper\Zipper\Repositories
 */
interface RepositoryInterface
{

    /**
     * Construct with a given path
     *
     * @param $filePath
     * @param bool $new
     * @param $archiveImplementation
     */
    function __construct($filePath, $new = false, $archiveImplementation = null);

    /**
     * Add a file to the opened Archive
     *
     * @param $pathToFile
     * @param $pathInArchive
     * @return void
     */
    public function addFile($pathToFile, $pathInArchive);

    /**
     * Add a file to the opened Archive using its contents
     *
     * @param $name
     * @param $content
     * @return void
     */
    public function addFromString($name, $content);

    /**
     * Add an empty directory
     *
     * @param $dirName
     * @return void
     */
    public function addEmptyDir($dirName);

    /**
     * Remove a file permanently from the Archive
     *
     * @param $pathInArchive
     * @return void
     */
    public function removeFile($pathInArchive);

    /**
     * Get the content of a file
     *
     * @param $pathInArchive
     * @return string
     */
    public function getFileContent($pathInArchive);

    /**
     * Get the stream of a file
     *
     * @param $pathInArchive
     * @return mixed
     */
    public function getFileStream($pathInArchive);

    /**
     * Will loop over every item in the archive and will execute the callback on them
     * Will provide the filename for every item
     *
     * @param $callback
     * @return void
     */
    public function each($callback);

    /**
     * Checks whether the file is in the archive
     *
     * @param $fileInArchive
     * @return boolean
     */
    public function fileExists($fileInArchive);

    /**
     * Sets the password to be used for decompressing
     *
     * @param $password
     * @return boolean
     */
    public function usePassword($password);

    /**
     * Returns the status of the archive as a string
     *
     * @return string
     */
    public function getStatus();

    /**
     * Closes the archive and saves it
     * @return void
     */
    public function close();
}
