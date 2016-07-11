<?php

/**
 * Handles logging of errors and debug information to file system.
 */
class PodioLogger
{
    protected $enabled = true;
    public $call_log = [];
    public $file, $maxsize;

    public function __construct()
    {
        $this->file = dirname(__FILE__).'/../log/podio.log';
        $this->maxsize = 1024 * 1024;
    }

    public function disable()
    {
        $this->enabled = false;
    }

    public function enable()
    {
        $this->enabled = true;
    }

    public function log($text)
    {
        @mkdir(dirname($this->file));
        if ($fp = fopen($this->file, 'ab')) {
            fwrite($fp, $text);
            fclose($fp);

      // Trim log file by removing the first 50 lines
      if (filesize($this->file) > $this->maxsize) {
          $file = file($this->file);
          $file = array_splice($file, 0, 50);
          file_put_contents($this->file, implode('', $file));
      }
        }
    }
}
