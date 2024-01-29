<?php

/**
 * Mockery (https://docs.mockery.io/)
 *
 * @copyright https://github.com/mockery/mockery/blob/HEAD/COPYRIGHT.md
 * @license   https://github.com/mockery/mockery/blob/HEAD/LICENSE BSD 3-Clause License
 * @link      https://github.com/mockery/mockery for the canonical source repository
 */

namespace Mockery\Matcher;

class NotAnyOf extends MatcherAbstract
{
    /**
     * Check if the actual value does not match the expected (in this
     * case it's specifically NOT expected).
     *
     * @param mixed $actual
     * @return bool
     */
    public function match(&$actual)
    {
        foreach ($this->_expected as $exp) {
            if ($actual === $exp || $actual == $exp) {
                return false;
            }
        }
        return true;
    }

    /**
     * Return a string representation of this Matcher
     *
     * @return string
     */
    public function __toString()
    {
        return '<AnyOf>';
    }
}
