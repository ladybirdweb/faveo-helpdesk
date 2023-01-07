<?php

return [
    /*
      |--------------------------------------------------------------------------
      | Table specific configuration options.
      |--------------------------------------------------------------------------
      |
     */

    'table' => [
        /*
          |--------------------------------------------------------------------------
          | Table class
          |--------------------------------------------------------------------------
          |
          | Class(es) added to the table
          | Supported: string
          |
         */

        'class' => 'table table-bordered',
        /*
          |--------------------------------------------------------------------------
          | Table ID
          |--------------------------------------------------------------------------
          |
          | ID given to the table. Used for connecting the table and the Datatables
          | jQuery plugin. If left empty a random ID will be generated.
          | Supported: string
          |
         */
        'id' => 'chumper',
        /*
          |--------------------------------------------------------------------------
          | DataTable options
          |--------------------------------------------------------------------------
          |
          | jQuery dataTable plugin options. The array will be json_encoded and
          | passed through to the plugin. See https://datatables.net/usage/options
          | for more information.
          | Supported: array
          |
         */
        'options' => [
            'sPaginationType' => 'full_numbers',
            'bProcessing'     => true,
        ],
        /*
          |--------------------------------------------------------------------------
          | DataTable callbacks
          |--------------------------------------------------------------------------
          |
          | jQuery dataTable plugin callbacks. The array will be json_encoded and
          | passed through to the plugin. See https://datatables.net/usage/callbacks
          | for more information.
          | Supported: array
          |
         */
        'callbacks' => [],
        /*
          |--------------------------------------------------------------------------
          | Skip javascript in table template
          |--------------------------------------------------------------------------
          |
          | Determines if the template should echo the javascript
          | Supported: boolean
          |
         */
        'noScript' => false,
        /*
          |--------------------------------------------------------------------------
          | Table view
          |--------------------------------------------------------------------------
          |
          | Template used to render the table
          | Supported: string
          |
         */
        'table_view' => 'chumper.datatable::template',
        /*
          |--------------------------------------------------------------------------
          | Script view
          |--------------------------------------------------------------------------
          |
          | Template used to render the javascript
          | Supported: string
          |
         */
        'script_view' => 'chumper.datatable::javascript',
    ],
    /*
      |--------------------------------------------------------------------------
      | Engine specific configuration options.
      |--------------------------------------------------------------------------
      |
     */
    'engine' => [
        /*
          |--------------------------------------------------------------------------
          | Search for exact words
          |--------------------------------------------------------------------------
          |
          | If the search should be done with exact matching
          | Supported: boolean
          |
         */

        'exactWordSearch' => false,
    ],
    /*
      |--------------------------------------------------------------------------
      | Allow overrides Datatable core classes
      |--------------------------------------------------------------------------
      |
     */
    'classmap' => [
        'CollectionEngine' => 'Chumper\Datatable\Engines\CollectionEngine',
        'QueryEngine'      => 'Chumper\Datatable\Engines\QueryEngine',
        'Table'            => 'Chumper\Datatable\Table',
    ],
];
