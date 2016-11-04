<?php

/*
 * This file is part of the Fetch package.
 *
 * (c) Robert Hafner <tedivm@tedivm.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

spl_autoload_register(function ($class) {
    $base = '/src/';

    if (strpos($class, 'Fetch\Test') === 0) {
        $base = '/tests/';
    }

    $file = __DIR__.$base.strtr($class, '\\', '/').'.php';
    if (file_exists($file)) {
        require $file;

        return true;
    }
});
