<?php

$header = <<<EOF
This file is part of the Mremi\UrlShortener library.

(c) Rémi Marseille <marseille.remi@gmail.com>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__);

$config = (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'binary_operator_spaces' => [
            'operators' => [
                '=>' => 'align_single_space_minimal',
                '=' => 'align_single_space',
            ],
        ],
        'header_comment' => [
            'header' => $header,
        ],
        'linebreak_after_opening_tag' => true,
        'php_unit_construct' => true,
        'php_unit_strict' => true,
        'single_line_throw' => false,
    ])
    ->setUsingCache(true)
    ->setFinder($finder);

return $config;
