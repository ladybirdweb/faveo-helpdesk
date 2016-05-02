<?php

/*
 * This file is part of Class Preloader.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 * (c) Michael Dowling <mtdowling@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ClassPreloader;

/**
 * This is the config class.
 */
class Config
{
    /**
     * The array of file names.
     *
     * @var array
     */
    protected $filenames = [];

    /**
     * The array of exclusive filters.
     *
     * @var array
     */
    protected $exclusiveFilters = [];

    /**
     * The array of inclusive filters.
     *
     * @var array
     */
    protected $inclusiveFilters = [];

    /**
     * Add the filename owned by the config.
     *
     * @param string $filename
     *
     * @return \ClassPreloader\Config
     */
    public function addFile($filename)
    {
        $this->filenames[] = $filename;

        return $this;
    }

    /**
     * Get an array of file names that satisfy any added filters.
     *
     * @return array
     */
    public function getFilenames()
    {
        $filenames = [];
        foreach ($this->filenames as $f) {
            foreach ($this->inclusiveFilters as $filter) {
                if (!preg_match($filter, $f)) {
                    continue 2;
                }
            }
            foreach ($this->exclusiveFilters as $filter) {
                if (preg_match($filter, $f)) {
                    continue 2;
                }
            }
            $filenames[] = $f;
        }

        return $filenames;
    }

    /**
     * Add a filter used to filter out file names matching the pattern.
     *
     * We're filtering the classes using a regular expression.
     *
     * @param string $pattern
     *
     * @return \ClassPreloader\Config
     */
    public function addExclusiveFilter($pattern)
    {
        $this->exclusiveFilters[] = $pattern;

        return $this;
    }

    /**
     * Add a filter used to grab only file names matching the pattern.
     *
     * We're filtering the classes using a regular expression.
     *
     * @param string $pattern Regular expression pattern
     *
     * @return \ClassPreloader\Config
     */
    public function addInclusiveFilter($pattern)
    {
        $this->inclusiveFilters[] = $pattern;

        return $this;
    }
}
