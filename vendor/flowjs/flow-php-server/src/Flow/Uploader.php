<?php

namespace Flow;

class Uploader
{
    /**
     * Delete chunks older than expiration time.
     *
     * @param string $chunksFolder
     * @param int    $expirationTime seconds
     *
     * @throws FileOpenException
     */
    public static function pruneChunks($chunksFolder, $expirationTime = 172800)
    {
        $handle = opendir($chunksFolder);

        if (!$handle) {
            throw new FileOpenException('failed to open folder: '.$chunksFolder);
        }

        while (false !== ($entry = readdir($handle))) {
            if ($entry == "." || $entry == ".." || $entry == ".gitignore") {
                continue;
            }

            $path = $chunksFolder.DIRECTORY_SEPARATOR.$entry;

            if (is_dir($path)) {
                continue;
            }

            if (time() - filemtime($path) > $expirationTime) {
                unlink($path);
            }
        }

        closedir($handle);
    }
}
