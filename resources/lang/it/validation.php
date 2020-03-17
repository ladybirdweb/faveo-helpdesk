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

    'accepted'   => ':attribute deve essere accettatp.',
    'active_url' => ':attribute non è un URL valido.',
    'after'      => ':attribute deve essere una data dopo il :date.',
    'alpha'      => ':attribute può contenere lettere.',
    'alpha_dash' => ':attribute può contenere lettere, numeri, e trattini.',
    'alpha_num'  => ':attribute può contenere lettere and numeri.',
    'array'      => ':attribute deve essere un array.',
    'before'     => ':attribute deve essere una data prima di :date.',
    'between'    => [
        'numeric' => ':attribute deve essere fra :min e :max.',
        'file'    => ':attribute deve essere fra :min e :max kilobytes.',
        'string'  => ':attribute deve essere fra :min e :max caratteri.',
        'array'   => ':attribute deve contenere fra :min e :max oggetti.',
    ],
    'boolean'        => ':attribute deve essere vero o falso.',
    'confirmed'      => ':attribute di conferma non corrisponde.',
    'date'           => ':attribute non è una data valida.',
    'date_format'    => ':attribute non corrisponde al formato :format.',
    'different'      => ':attribute e :other deveno essere differenti.',
    'digits'         => ':attribute deve essere :digits numeri.',
    'digits_between' => ':attribute deve essere fra :min and :max numeri.',
    'email'          => ':attribute deve essere un indirizzo email valido.',
    'filled'         => ':attribute è obbligatorio.',
    'exists'         => ':attribute selezionato non è valido.',
    'image'          => ':attribute deve essere una immagine.',
    'in'             => ':attribute selezionato non è valido.',
    'integer'        => ':attribute deve essere un intero.',
    'ip'             => ':attribute deve essere un indirizzo IP valido.',
    'max'            => [
        'numeric' => ':attribute non può essere più grande di :max.',
        'file'    => ':attribute non può essere più grande di :max kilobytes.',
        'string'  => ':attribute non può essere più grande di :max caratteri.',
        'array'   => ':attribute non può avere più di :max oggetti.',
    ],
    'mimes' => ':attribute deve essere un file di tipo: :values.',
    'min'   => [
        'numeric' => ':attribute deve essere almeno :min.',
        'file'    => ':attribute deve essere almeno :min kilobytes.',
        'string'  => ':attribute deve essere almeno :min caratteri.',
        'array'   => ':attribute deve avere almeno :min oggetti.',
    ],
    'not_in'               => ':attribute selezionato non è valido.',
    'numeric'              => ':attribute deve essere un numero.',
    'regex'                => ':attribute ha un formato non valido.',
    'required'             => ':attribute è richiesto.',
    'required_if'          => ':attribute è richiesto quando :other è :value.',
    'required_with'        => ':attribute è richiesto quando :values è presente.',
    'required_with_all'    => ':attribute è richiesto quando :values è presente.',
    'required_without'     => ':attribute è richiesto quando :values non è presente.',
    'required_without_all' => ':attribute è richiesto quando nessuno dei :values è presente.',
    'same'                 => ':attribute e :other devono corrispondere.',
    'size'                 => [
        'numeric' => ':attribute deve essere :size.',
        'file'    => ':attribute deve essere :size kilobytes.',
        'string'  => ':attribute deve essere :size caratter.',
        'array'   => ':attribute deve contenere :size oggetti.',
    ],
    'unique'   => ':attribute è già stato utilizzato.',
    'url'      => ':attribute è in un formato non valido.',
    'timezone' => ':attribute deve essere un valido fuso orario.',
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
            'rule-name' => 'messaggio personalizzato',
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
