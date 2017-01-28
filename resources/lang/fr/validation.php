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

    'accepted'   => 'Le :attribute doit être accepté.',
    'active_url' => 'Le :attribute n\'est pas une URL valide.',
    'after'      => 'Le :attribute doit être une date après la date :date.',
    'alpha'      => 'Le :attribute ne peut contenir que des lettres.',
    'alpha_dash' => 'Le :attribute ne peut contenir que des lettres, des nombres, et des tirets.',
    'alpha_num'  => 'Le :attribute may ne peut contenir que des lettres et des nombres.',
    'array'      => 'Le :attribute doit être un tableau.',
    'before'     => 'Le :attribute doit être une date avant la date :date.',
    'between'    => [
        'numeric' => 'Le :attribute doit être entre :min et :max.',
        'file'    => 'Le :attribute doit être entre :min et :max ko.',
        'string'  => 'Le :attribute doit être entre :min et :max caractères.',
        'array'   => 'Le :attribute doit avoir entre :min et :max éléments.',
    ],
    'boolean'        => 'Le :attribute champ doit être true ou false.',
    'confirmed'      => 'Le :attribute confirmation ne correspond pas.',
    'date'           => 'Le :attribute n\'est pas une date valide.',
    'date_format'    => 'Le :attribute ne correspond pas au format :format.',
    'different'      => 'Le :attribute et :other doivent être différents.',
    'digits'         => 'Le :attribute doit être composé de :digits numéros.',
    'digits_between' => 'Le :attribute doit être entre :min et :max numéros.',
    'email'          => 'Le :attribute doit être une adresse email valide.',
    'filled'         => 'Le :attribute field is required.',
    'exists'         => 'Le :attribute sélectionné est invalide.',
    'image'          => 'Le :attribute doit être une image.',
    'in'             => 'Le :attribute sélectionné est invalide.',
    'integer'        => 'Le :attribute doit être un entier.',
    'ip'             => 'Le :attribute doit être une adresse IP valide.',
    'max'            => [
        'numeric' => 'Le :attribute ne peut pas être plus grand que :max.',
        'file'    => 'Le :attribute ne peut pas être plus grand que :max Ko.',
        'string'  => 'Le :attribute ne peut pas être plus grand que :max caractères.',
        'array'   => 'Le :attribute ne peut pas avoir plus de :max éléments.',
    ],
    'mimes' => 'Le :attribute doit être un fichier de type: :values.',
    'min'   => [
        'numeric' => 'Le :attribute doit être au moins :min.',
        'file'    => 'Le :attribute doit être au moins :min ko.',
        'string'  => 'Le :attribute doit être au moins :min caractères.',
        'array'   => 'Le :attribute doit au moins avoir :min éléments.',
    ],
    'not_in'               => 'Le :attribute sélectionné est invalide.',
    'numeric'              => 'Le :attribute doit être un nombre.',
    'regex'                => 'Le format de :attribute est invalide.',
    'required'             => 'Le champ :attribute est obligatoire.',
    'required_if'          => 'Le champ :a formatttribute est requis lorsque :other est :value.',
    'required_with'        => 'Le champ :attribute est requis lorsque :values is present.',
    'required_with_all'    => 'Le champ :attribute est requis lorsque :values is present.',
    'required_without'     => 'Le champ :attribute est requis lorsque :values is not present.',
    'required_without_all' => 'Le champ :attribute est requis lorsque pas de :values sont présents.',
    'same'                 => 'Le champ :attribute et :other doivent correspondre.',
    'size'                 => [
        'numeric' => 'Le :attribute doit être de :size.',
        'file'    => 'Le :attribute doit être de :size ko.',
        'string'  => 'Le :attribute doit être de :size caractères.',
        'array'   => 'Le :attribute doit contenir :size éléments.',
    ],
    'unique'   => 'Le :attribute ha déjà été pris.',
    'url'      => 'Le format de :attribute est invalide.',
    'timezone' => 'Le :attribute doit être une zone valide.',
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
            'rule-name' => 'custom-message',
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
