<?php

/**
 * Mockery (https://docs.mockery.io/)
 *
 * @copyright https://github.com/mockery/mockery/blob/HEAD/COPYRIGHT.md
 * @license   https://github.com/mockery/mockery/blob/HEAD/LICENSE BSD 3-Clause License
 * @link      https://github.com/mockery/mockery for the canonical source repository
 */

namespace Mockery\Generator;

class MockNameBuilder
{
    protected static $mockCounter = 0;

    protected $parts = [];

    public function addPart($part)
    {
        $this->parts[] = $part;

        return $this;
    }

    public function build()
    {
        $parts = ['Mockery', static::$mockCounter++];

        foreach ($this->parts as $part) {
            $parts[] = str_replace("\\", "_", $part);
        }

        return implode('_', $parts);
    }
}
