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

    'accepted'   => 'Das :attribute muss akzeptiert sein.',
    'active_url' => 'Das :attribute ist keine gültige URL.',
    'after'      => 'Das :attribute muss ein Datum nach :date sein.',
    'alpha'      => 'Das :attribute darf nur Buchstaben enthalten.',
    'alpha_dash' => 'Das :attribute darf nur Buchstaben, Ziffern und Minus enthalten.',
    'alpha_num'  => 'Das :attribute darf nur Ziffern und Buchstaben enthalten.',
    'array'      => 'Das :attribute muss ein Arrey sein.',
    'before'     => 'Das :attribute muss ein Datum vor :date sein.',
    'between'    => [
        'numeric' => 'Das :attribute muss zwischen :min und :max liegen.',
        'file'    => 'Das :attribute muss zwischen :min und :max kilobytes sein.',
        'string'  => 'Das :attribute muss zwischen :min und :max Buchstaben sein.',
        'array'   => 'Das :attribute muss zwischen :min und :max Elemente haben.',
    ],
    'boolean'        => 'Das :attribute muss wahr oder falsch sein.',
    'confirmed'      => 'Das :attribute Bestätigung stimmt nicht überein.',
    'date'           => 'Das :attribute ist kein gültiges Datum.',
    'date_format'    => 'Das :attribute verstößt gegen das Format :format.',
    'different'      => 'Das :attribute und :other müssen sich unterscheiden.',
    'digits'         => 'Das :attribute müssen :digits Ziffern.',
    'digits_between' => 'Das :attribute muss zwischen :min und :max Ziffern haben.',
    'email'          => 'Das :attribute muss eine gültige E-Mail-Adresse sein.',
    'filled'         => 'Das :attribute Feld ist Pflicht.',
    'exists'         => 'Das gewählte :attribute ungültg.',
    'image'          => 'Das :attribute muss ein Bild sein.',
    'in'             => 'Das gewählte :attribute ist ungültig.',
    'integer'        => 'Das :attribute muss ein Integer sein.',
    'ip'             => 'Das :attribute muss eine gültige IP-Adress sein.',
    'max'            => [
        'numeric' => 'Das :attribute darf nicht größer sein als :max.',
        'file'    => 'Das :attribute darf nicht größer sein als :max kilobytes.',
        'string'  => 'Das :attribute darf nicht größer sein als :max Zeichen.',
        'array'   => 'Das :attribute darf nicht mehr als :max Elemente haben.',
    ],
    'mimes' => 'Das :attribute muss eine Datei vom Typ :values sei.',
    'min'   => [
        'numeric' => 'Das :attribute muss mindesten :min sein.',
        'file'    => 'Das :attribute muss mind. :min kilobytes groß sein.',
        'string'  => 'Das :attribute muss mind. :min Zeichen groß sein.',
        'array'   => 'Das :attribute muss mindesten :min Elemente haben.',

    ],
    'not_in'               => 'Das ausgewählte :attribute ist ungültig.',
    'numeric'              => 'Das :attribute muss eine Zahl sein.',
    'regex'                => 'Das :attribute Format ist ungültig.',
    'required'             => 'Das :attribute Feld wird benötigt.',
    'required_if'          => 'Das :attribute Feld wird benötigt wenn :other :value. ist.',
    'required_with'        => 'Das :attribute Feld wird benötigt wenn :values vorhanden ist.',
    'required_with_all'    => 'Das :attribute Feld wird benötigt wenn :values vorhanden ist.',
    'required_without'     => 'Das :attribute Feld wird benötigt wenn :values nicht vorhanden ist.',
    'required_without_all' => 'Das :attribute Feld wird benötigt wenn keines von :values verfügbar ist.',
    'same'                 => 'Das :attribute und :other müssen übereinstimmen.',
    'size'                 => [
        'numeric' => 'Das :attribute muss :size groß sein.',
        'file'    => 'Das :attribute muss :size Kilobytes groß sein.',
        'string'  => 'Das :attribute muss :size Zeichen lang sein.',
        'array'   => 'Das :attribute muss :size Elemente beinhalten.',
    ],
    'unique'   => 'Das :attribute wurde bereits verwendet.',
    'url'      => 'Das :attribute Format ist ungültig.',
    'timezone' => 'Das :attribute muss eine gültige Zeitzone sein.',
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
