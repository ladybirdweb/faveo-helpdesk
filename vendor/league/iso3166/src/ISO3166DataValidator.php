<?php

/*
 * (c) Rob Bast <rob.bast@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace League\ISO3166;

use League\ISO3166\Exception\DomainException;

final class ISO3166DataValidator
{
    /**
     * @param array $data
     *
     * @return array
     */
    public function validate(array $data)
    {
        foreach ($data as $entry) {
            $this->assertEntryHasRequiredKeys($entry);
        }

        return $data;
    }

    /**
     * @param array $entry
     *
     * @throws \League\ISO3166\Exception\DomainException if given data entry does not have all the required keys
     */
    private function assertEntryHasRequiredKeys(array $entry)
    {
        if (!isset($entry[ISO3166::KEY_ALPHA2])) {
            throw new DomainException('Each data entry must have a valid alpha2 key.');
        }

        Guards::guardAgainstInvalidAlpha2($entry[ISO3166::KEY_ALPHA2]);

        if (!isset($entry[ISO3166::KEY_ALPHA3])) {
            throw new DomainException('Each data entry must have a valid alpha3 key.');
        }

        Guards::guardAgainstInvalidAlpha3($entry[ISO3166::KEY_ALPHA3]);

        if (!isset($entry[ISO3166::KEY_NUMERIC])) {
            throw new DomainException('Each data entry must have a valid numeric key.');
        }

        Guards::guardAgainstInvalidNumeric($entry[ISO3166::KEY_NUMERIC]);
    }
}
