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

    'accepted'   => 'Das :attribute muss akzeptiert werden.',
    'active_url' => 'Das :attribute ist keine gültige URL.',
    'after'      => 'Das :attribute muss ein Datum sein, nachdem :date.',
    'alpha'      => 'Das :attribute dürfen nur Buchstaben sein.',
    'alpha_dash' => 'Das :attribute darf nur Buchstaben, Zahlen und Bindestriche enthalten.',
    'alpha_num'  => 'Das :attribute darf nur Buchstaben und Zahlen enthalten.',
    'array'      => 'Das :attribute muss ein Array sein.',
    'before'     => 'Das :attribute muss ein Datum sein, bevor :date.',
    'between'    => [
        'numeric' => 'Das :attribute muss zwischen :min und :max.',
        'file'    => 'Das :attribute muss zwischen :min und :max Kilobyte.',
        'string'  => 'Das :attribute muss zwischen :min und :max Zeichen.',
        'array'   => 'Das :attribute muss genau zwischen :min und :max Anzahl.',
    ],
    'boolean'        => 'Das :attribute Feld muss wahr oder falsch sein.',
    'confirmed'      => 'Das :attribute Bestätigung stimmt nicht überein.',
    'date'           => 'Das :attribute ist kein gültiges Datum.',
    'date_format'    => 'Das :attribute passt nicht mit dem Format überein :format.',
    'different'      => 'Das :attribute und :other müssen unterschiedlich sein.',
    'digits'         => 'Das :attribute muss sein :digits Ziffern.',
    'digits_between' => 'Das :attribute muss zwischen :min und :max Ziffern.',
    'email'          => 'Das :attribute muss eine gültige E-Mail-Adresse sein.',
    'filled'         => 'Das :attribute ist erforderlich.',
    'exists'         => 'Das ausgewählte :attribute ist ungültig.',
    'image'          => 'Das :attribute muß ein Bild sein.',
    'in'             => 'Das ausgewählte :attribute ist ungültig.',
    'integer'        => 'Das :attribute muss eine ganze Zahl sein.',
    'ip'             => 'Das :attribute muss eine gültige IP-Adresse sein.',
    'max'            => [
        'numeric' => 'Das :attribute darf nicht größer sein als :max.',
        'file'    => 'Das :attribute darf nicht größer sein als :max Kilobytes.',
        'string'  => 'Das :attribute darf nicht größer sein als :max Zeichen.',
        'array'   => 'Das :attribute kann nicht mehr sein als :max Anzahl.',
    ],
    'mimes' => 'Das :attribute must be a file of type: :values.',
    'min'   => [
        'numeric' => 'Das :attribute muss mindestens :min.',
        'file'    => 'Das :attribute muss mindestens :min Kilobytes.',
        'string'  => 'Das :attribute muss mindestens :min Zeichen.',
        'array'   => 'Das :attribute darf nicht kleiner sein als :min Anzahl.',
    ],
    'not_in'               => 'Das ausgewählte :attribute ist ungültig.',
    'numeric'              => 'Das :attribute muss eine Nummer sein.',
    'regex'                => 'Das :attribute Format ist ungültig.',
    'required'             => 'Das :attribute ist erforderlich.',
    'required_if'          => 'Das :attribute Feld ist erforderlich, wenn :other ist :value.',
    'required_with'        => 'Das :attribute Feld ist erforderlich, wenn :values ist anwesend.',
    'required_with_all'    => 'Das :attribute Feld ist erforderlich, wenn :values ist anwesend.',
    'required_without'     => 'Das :attribute Feld ist erforderlich, wenn :values ist nicht vorhanden.',
    'required_without_all' => 'Das :attribute ist erforderlich, wenn keine der :values sind anwesend.',
    'same'                 => 'Das :attribute und :other muss passen.',
    'size'                 => [
        'numeric' => 'Das :attribute muss sein :size.',
        'file'    => 'Das :attribute muss sein :size Kilobytes.',
        'string'  => 'Das :attribute muss sein :size Zeichen.',
        'array'   => 'Das :attribute muss enthalten :size Anzahl.',
    ],
    'unique'   => 'Das :attribute bereits aufgenommen wurde.',
    'url'      => 'Das :attribute Format ist ungültig.',
    'timezone' => 'Das :attribute muss eine gültige Zone sein.',
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
