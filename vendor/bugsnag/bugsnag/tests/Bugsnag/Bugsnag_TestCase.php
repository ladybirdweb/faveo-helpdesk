<?php

abstract class Bugsnag_TestCase extends PHPUnit_Framework_TestCase
{
    protected function getError($name = "Name", $message = "Message")
    {
        return Bugsnag_Error::fromNamedError($this->config, $this->diagnostics, $name, $message);
    }

    protected function getFixturePath($file)
    {
        return realpath(dirname(__FILE__)."/../fixtures/".$file);
    }

    protected function getFixture($file)
    {
        return file_get_contents($this->getFixturePath($file));
    }

    protected function getJsonFixture($file)
    {
        return json_decode($this->getFixture($file), true);
    }
}
