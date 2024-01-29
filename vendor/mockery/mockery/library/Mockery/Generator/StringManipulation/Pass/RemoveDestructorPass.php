<?php

/**
 * Mockery (https://docs.mockery.io/)
 *
 * @copyright https://github.com/mockery/mockery/blob/HEAD/COPYRIGHT.md
 * @license   https://github.com/mockery/mockery/blob/HEAD/LICENSE BSD 3-Clause License
 * @link      https://github.com/mockery/mockery for the canonical source repository
 */

namespace Mockery\Generator\StringManipulation\Pass;

use Mockery\Generator\MockConfiguration;

/**
 * Remove mock's empty destructor if we tend to use original class destructor
 */
class RemoveDestructorPass
{
    public function apply($code, MockConfiguration $config)
    {
        $target = $config->getTargetClass();

        if (!$target) {
            return $code;
        }

        if (!$config->isMockOriginalDestructor()) {
            $code = preg_replace('/public function __destruct\(\)\s+\{.*?\}/sm', '', $code);
        }

        return $code;
    }
}
