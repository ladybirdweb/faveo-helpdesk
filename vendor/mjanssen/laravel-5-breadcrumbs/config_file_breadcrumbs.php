<?php

/**
 * Config file for mjanssen\BreadcrumbsBundle
 */

return [

    /*
     * @bool true|false
     *
     * UCfirst each title, set by user.
     */
    'uppercaseFirst' => true,

    /*
     * @bool true|false
     *
     * Use a separator in the breadcrumbs. If so, the separator field will be shown (if not empty).
     */
    'useSeparator' => true,

    /*
     * @bool true|false
     *
     * Use the custom separator from bootstrap, created with CSS. If you want to use your own separator, make sure
     * to set this option to false.
     */
    'bootstrapSeparator' => true,

    /*
     * @string
     *
     * Separator used to build the breadcrumbs. Could be any symbol.
     */
    'separator' => '',

    /*
     * @bool true|false
     *
     * If the last breadcrumb should be clickable, set this option to true.
     */
    'lastBreadcrumbClickable' => false,

    /*
     * @array
     *
     * If there should be a breadcrumb set automatically, linking to the homepage (/).
     *
     * : enabled
     * @bool true|false
     *
     * : value
     * @string
     *
     * The value will be shown as first breadcrumb.
     */
    'automaticFirstCrumb' => array(
        'enabled' => true,
        'value' => 'Home'
    ),

    /*
     * @string
     *
     * set an class for the UL or OL where the list items <li> will be placed in.
     */
    'ulLiClass' => 'breadcrumb',

    /*
     * @bool true|false
     *
     * If you want to use the bootstrap styling (bootstrap class) from Bootstrap. This option could be set to true.
     * If you want to use your own class, make sure to set this option to false, and set your own class in "ulLiClass".
     */
    'bootstrap' => true,

    /*
     * @array
     *
     * Put values that should be ignored in this array. Could come in handy for automatic generation while using
     * languages. (example.com/en/some-slug) where you want the languages to be filtered out of the breadcrumbs.
     */
    'except' => array(

    )
];
