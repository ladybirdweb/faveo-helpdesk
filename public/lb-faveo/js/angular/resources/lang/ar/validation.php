<?php

return [

    /*
      |--------------------------------------------------------------------------
      | Validation Language Lines
      |--------------------------------------------------------------------------
      |
      | The following language lines contain the default error messages used by
      | the validator class. Some of these rules have multiple versions such
      | as the size rules. Feel free to tweak each of these messages here.
      |
     */

    'accepted'   => 'llllllllllll', //The :attribute must be accepted.',
    'active_url' => 'llllllllllll', //The :attribute is not a valid URL.',
    'after'      => 'llllllllllll', //The :attribute must be a date after :date.',
    'alpha'      => 'llllllllllll', //The :attribute may only contain letters.',
    'alpha_dash' => 'llllllllllll', //The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'  => 'llllllllllll', //The :attribute may only contain letters and numbers.',
    'array'      => 'llllllllllll', //The :attribute must be an array.',
    'before'     => 'llllllllllll', //The :attribute must be a date before :date.',
    'between'    => [
        'numeric' => 'llllllllllll', //The :attribute must be between :min and :max.',
        'file'    => 'llllllllllll', //The :attribute must be between :min and :max kilobytes.',
        'string'  => 'llllllllllll', //The :attribute must be between :min and :max characters.',
        'array'   => 'llllllllllll', //The :attribute must have between :min and :max items.',
    ],
    'boolean'        => 'llllllllllll', //The :attribute field must be true or false.',
    'confirmed'      => 'llllllllllll', //The :attribute confirmation does not match.',
    'date'           => 'llllllllllll', //The :attribute is not a valid date.',
    'date_format'    => 'llllllllllll', //The :attribute does not match the format :format.',
    'different'      => 'llllllllllll', //The :attribute and :other must be different.',
    'digits'         => 'llllllllllll', //The :attribute must be :digits digits.',
    'digits_between' => 'llllllllllll', //The :attribute must be between :min and :max digits.',
    'email'          => 'llllllllllll', //The :attribute must be a valid email address.',
    'filled'         => 'llllllllllll', //The :attribute field is required.',
    'exists'         => 'llllllllllll', //The selected :attribute is invalid.',
    'image'          => 'llllllllllll', //The :attribute must be an image.',
    'in'             => 'llllllllllll', //The selected :attribute is invalid.',
    'integer'        => 'llllllllllll', //The :attribute must be an integer.',
    'ip'             => 'llllllllllll', //The :attribute must be a valid IP address.',
    'max'            => [
        'numeric' => 'llllllllllll', //The :attribute may not be greater than :max.',
        'file'    => 'llllllllllll', //The :attribute may not be greater than :max kilobytes.',
        'string'  => 'llllllllllll', //The :attribute may not be greater than :max characters.',
        'array'   => 'llllllllllll', //The :attribute may not have more than :max items.',
    ],
    'mimes' => 'llllllllllll', //The :attribute must be a file of type: :values.',
    'min'   => [
        'numeric' => 'llllllllllll', //The :attribute must be at least :min.',
        'file'    => 'llllllllllll', //The :attribute must be at least :min kilobytes.',
        'string'  => 'llllllllllll', //The :attribute must be at least :min characters.',
        'array'   => 'llllllllllll', //The :attribute must have at least :min items.',
    ],
    'not_in'               => 'llllllllllll', //The selected :attribute is invalid.',
    'numeric'              => 'llllllllllll', //The :attribute must be a number.',
    'regex'                => 'llllllllllll', //The :attribute format is invalid.',
    'required'             => 'llllllllllll', //The :attribute field is required.',
    'required_if'          => 'llllllllllll', //The :attribute field is required when :other is :value.',
    'required_with'        => 'llllllllllll', //The :attribute field is required when :values is present.',
    'required_with_all'    => 'llllllllllll', //The :attribute field is required when :values is present.',
    'required_without'     => 'llllllllllll', //The :attribute field is required when :values is not present.',
    'required_without_all' => 'llllllllllll', //The :attribute field is required when none of :values are present.',
    'same'                 => 'llllllllllll', //The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'llllllllllll', //The :attribute must be :size.',
        'file'    => 'llllllllllll', //The :attribute must be :size kilobytes.',
        'string'  => 'llllllllllll', //The :attribute must be :size characters.',
        'array'   => 'llllllllllll', //The :attribute must contain :size items.',
    ],
    'unique'   => 'llllllllllll', //The :attribute has already been taken.',
    'url'      => 'llllllllllll', //The :attribute format is invalid.',
    'timezone' => 'llllllllllll', //The :attribute must be a valid zone.',
    /*
      |--------------------------------------------------------------------------
      | Custom Validation Language Lines
      |--------------------------------------------------------------------------
      |
      | Here you may specify custom validation messages for attributes using the
      | convention "attribute.rule" to name the lines. This makes it quick to
      | specify a specific custom language line for a given attribute rule.
      |
     */
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'llllllllllll', //custom-message',
        ],
    ],
    /*
      |--------------------------------------------------------------------------
      | Custom Validation Attributes
      |--------------------------------------------------------------------------
      |
      | The following language lines are used to swap attribute place-holders
      | with something more reader friendly such as E-Mail Address instead
      | of "email". This simply helps us make messages a little cleaner.
      |
     */
    'attributes' => [],
];
