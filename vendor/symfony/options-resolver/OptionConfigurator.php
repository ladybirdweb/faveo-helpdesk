<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\OptionsResolver;

use Symfony\Component\OptionsResolver\Exception\AccessException;

final class OptionConfigurator
{
    private string $name;
    private OptionsResolver $resolver;

    public function __construct(string $name, OptionsResolver $resolver)
    {
        $this->name = $name;
        $this->resolver = $resolver;
        $this->resolver->setDefined($name);
    }

    /**
     * Adds allowed types for this option.
     *
     * @return $this
     *
     * @throws AccessException If called from a lazy option or normalizer
     */
    public function allowedTypes(string ...$types): static
    {
        $this->resolver->setAllowedTypes($this->name, $types);

        return $this;
    }

    /**
     * Sets allowed values for this option.
     *
     * @param mixed ...$values One or more acceptable values/closures
     *
     * @return $this
     *
     * @throws AccessException If called from a lazy option or normalizer
     */
    public function allowedValues(mixed ...$values): static
    {
        $this->resolver->setAllowedValues($this->name, $values);

        return $this;
    }

    /**
     * Sets the default value for this option.
     *
     * @return $this
     *
     * @throws AccessException If called from a lazy option or normalizer
     */
    public function default(mixed $value): static
    {
        $this->resolver->setDefault($this->name, $value);

        return $this;
    }

    /**
     * Defines an option configurator with the given name.
     */
    public function define(string $option): self
    {
        return $this->resolver->define($option);
    }

    /**
     * Marks this option as deprecated.
     *
     * @param string          $package The name of the composer package that is triggering the deprecation
     * @param string          $version The version of the package that introduced the deprecation
     * @param string|\Closure $message The deprecation message to use
     *
     * @return $this
     */
    public function deprecated(string $package, string $version, string|\Closure $message = 'The option "%name%" is deprecated.'): static
    {
        $this->resolver->setDeprecated($this->name, $package, $version, $message);

        return $this;
    }

    /**
     * Sets the normalizer for this option.
     *
     * @return $this
     *
     * @throws AccessException If called from a lazy option or normalizer
     */
    public function normalize(\Closure $normalizer): static
    {
        $this->resolver->setNormalizer($this->name, $normalizer);

        return $this;
    }

    /**
     * Marks this option as required.
     *
     * @return $this
     *
     * @throws AccessException If called from a lazy option or normalizer
     */
    public function required(): static
    {
        $this->resolver->setRequired($this->name);

        return $this;
    }

    /**
     * Sets an info message for an option.
     *
     * @return $this
     *
     * @throws AccessException If called from a lazy option or normalizer
     */
    public function info(string $info): static
    {
        $this->resolver->setInfo($this->name, $info);

        return $this;
    }

    /**
     * Sets whether ignore undefined options.
     *
     * @return $this
     */
    public function ignoreUndefined(bool $ignore = true): static
    {
        $this->resolver->setIgnoreUndefined($ignore);

        return $this;
    }
}
