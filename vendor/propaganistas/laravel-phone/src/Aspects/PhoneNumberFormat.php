<?php

namespace Propaganistas\LaravelPhone\Aspects;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use libphonenumber\PhoneNumberFormat as libPhoneNumberFormat;
use ReflectionClass;

class PhoneNumberFormat
{
    public static function all(): array
    {
        return (new ReflectionClass(libPhoneNumberFormat::class))->getConstants();
    }

    public static function isValid($format): bool
    {
        return ! is_null($format) && in_array($format, static::all(), true);
    }

    public static function isValidName($format): bool
    {
        return ! is_null($format) && in_array($format, array_keys(static::all()), true);
    }

    public static function getHumanReadableName($format): string|null
    {
        $name = array_search($format, static::all(), true);

        return $name ? strtolower($name) : null;
    }

    public static function sanitize($formats): int|array|null
    {
        $sanitized = Collection::make(is_array($formats) ? $formats : [$formats])
            ->map(function ($format) {
                // If the format equals a constant's name, return its value.
                // Otherwise just return the value.
                return Arr::get(static::all(), strtoupper($format), $format);
            })
            ->filter(function ($format) {
                return static::isValid($format);
            })->unique();

        return is_array($formats) ? $sanitized->toArray() : $sanitized->first();
    }
}
