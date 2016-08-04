<?php

namespace Collective\Bus;

use ReflectionParameter;
use RuntimeException;

class MarshalException extends RuntimeException
{
    /**
     * Throw a new exception.
     *
     * @param string               $command
     * @param \ReflectionParameter $parameter
     *
     * @throws static
     *
     * @return void
     */
    public static function whileMapping($command, ReflectionParameter $parameter)
    {
        throw new static("Unable to map parameter [{$parameter->name}] to command [{$command}]");
    }
}
