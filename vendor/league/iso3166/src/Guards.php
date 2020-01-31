<?php

/*
 * (c) Rob Bast <rob.bast@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace League\ISO3166;

use League\ISO3166\Exception\DomainException;
use League\ISO3166\Exception\InvalidArgumentException;

final class Guards
{
    /**
     * Assert that input looks like a name key.
     *
     * @param string $name
     *
     * @throws \League\ISO3166\Exception\InvalidArgumentException if input is not a string
     */
    public static function guardAgainstInvalidName($name)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException(
                sprintf('Expected $name to be of type string, got: %s', gettype($name))
            );
        }
    }

    /**
     * Assert that input looks like an alpha2 key.
     *
     * @param string $alpha2
     *
     * @throws \League\ISO3166\Exception\InvalidArgumentException if input is not a string
     * @throws \League\ISO3166\Exception\DomainException if input does not look like an alpha2 key
     */
    public static function guardAgainstInvalidAlpha2($alpha2)
    {
        if (!is_string($alpha2)) {
            throw new InvalidArgumentException(
                sprintf('Expected $alpha2 to be of type string, got: %s', gettype($alpha2))
            );
        }

        if (!preg_match('/^[a-zA-Z]{2}$/', $alpha2)) {
            throw new DomainException(
                sprintf('Not a valid alpha2 key: %s', $alpha2)
            );
        }
    }

    /**
     * Assert that input looks like an alpha3 key.
     *
     * @param string $alpha3
     *
     * @throws \League\ISO3166\Exception\InvalidArgumentException if input is not a string
     * @throws \League\ISO3166\Exception\DomainException if input does not look like an alpha3 key
     */
    public static function guardAgainstInvalidAlpha3($alpha3)
    {
        if (!is_string($alpha3)) {
            throw new InvalidArgumentException(
                sprintf('Expected $alpha3 to be of type string, got: %s', gettype($alpha3))
            );
        }

        if (!preg_match('/^[a-zA-Z]{3}$/', $alpha3)) {
            throw new DomainException(
                sprintf('Not a valid alpha3 key: %s', $alpha3)
            );
        }
    }

    /**
     * Assert that input looks like a numeric key.
     *
     * @param string $numeric
     *
     * @throws \League\ISO3166\Exception\InvalidArgumentException if input is not a string
     * @throws \League\ISO3166\Exception\DomainException if input does not look like a numeric key
     */
    public static function guardAgainstInvalidNumeric($numeric)
    {
        if (!is_string($numeric)) {
            throw new InvalidArgumentException(
                sprintf('Expected $numeric to be of type string, got: %s', gettype($numeric))
            );
        }

        if (!preg_match('/^[0-9]{3}$/', $numeric)) {
            throw new DomainException(
                sprintf('Not a valid numeric key: %s', $numeric)
            );
        }
    }
}
