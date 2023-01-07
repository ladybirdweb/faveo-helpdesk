<?php

$finder = PhpCsFixer\Finder::create()
    ->in('demo')
    ->in('Highlight')
    ->in('HighlightUtilities')
    ->in('test')
    ->in('tools')
    ->exclude('lib_dojo')
    ->exclude('lib_highlight')
;

$config = new PhpCsFixer\Config();
return $config
    ->setRules([
        '@PSR1' => true,
        '@PSR2' => true,
        '@Symfony' => true,
        'array_indentation' => true,
        'array_syntax' => ['syntax' => 'long'],
        'concat_space' => ['spacing' => 'one'],
        'echo_tag_syntax' => ['format' => 'short'],
        'no_alias_language_construct_call' => false,
        'no_alternative_syntax' => false,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'phpdoc_align' => true,
        'phpdoc_order' => true,
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        'single_quote' => false,
        'ternary_to_null_coalescing' => false,
        'trailing_comma_in_multiline' => true,
        'visibility_required' => false,
        'yoda_style' => [
            'equal' => false,
            'identical' => false,
        ],
    ])
    ->setFinder($finder)
;
