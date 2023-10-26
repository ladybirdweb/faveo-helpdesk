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
    'accepted'   => 'يجب قبول :attribute.',
    'active_url' => ':attribute ليس عنوان URL صالحًا.',
    'after'      => 'يجب أن يكون :attribute تاريخًا بعد :date.',
    'alpha'      => 'يمكن أن يحتوي :attribute على أحرف فقط.',
    'alpha_dash' => 'يمكن أن يحتوي :attribute على أحرف وأرقام وشرطات فقط.',
    'alpha_num'  => 'يمكن أن يحتوي :attribute على أحرف وأرقام فقط.',
    'array'      => 'يجب أن يكون :attribute مصفوفة.',
    'before'     => 'يجب أن يكون :attribute تاريخًا قبل :date.',
    'between'    => [
        'numeric' => 'يجب أن يكون :attribute بين :min و :max.',
        'file'    => 'يجب أن يكون حجم :attribute بين :min و :max كيلوبايت.',
        'string'  => 'يجب أن يكون طول :attribute بين :min و :max أحرف.',
        'array'   => 'يجب أن يحتوي :attribute على عدد بين :min و :max عناصر.',
    ],
    'boolean'        => 'يجب أن تكون قيمة حقل :attribute صحيحة أو خاطئة.',
    'confirmed'      => 'تأكيد :attribute غير مطابق.',
    'date'           => ':attribute ليس تاريخًا صالحًا.',
    'date_format'    => ':attribute لا يتطابق مع الصيغة :format.',
    'different'      => ':attribute و :other يجب أن يكونا مختلفين.',
    'digits'         => 'يجب أن يحتوي :attribute على :digits أرقام.',
    'digits_between' => 'يجب أن يكون طول :attribute بين :min و :max أرقام.',
    'email'          => ':attribute يجب أن يكون عنوان بريد إلكتروني صالح.',
    'filled'         => 'حقل :attribute مطلوب.',
    'exists'         => ':attribute المحدد غير صالح.',
    'image'          => ':attribute يجب أن يكون صورة.',
    'in'             => ':attribute المحدد غير صالح.',
    'integer'        => 'يجب أن يكون :attribute عددًا صحيحًا.',
    'ip'             => 'يجب أن يكون :attribute عنوان IP صالحًا.',
    'max'            => [
        'numeric' => 'لا يجب أن يكون :attribute أكبر من :max.',
        'file'    => 'لا يجب أن يتجاوز حجم :attribute :max كيلوبايت.',
        'string'  => 'لا يجب أن يتجاوز طول :attribute :max أحرف.',
        'array'   => 'لا يجب أن يحتوي :attribute على أكثر من :max عناصر.',
    ],
    'mimes' => 'يجب أن يكون :attribute ملفًا من النوع: :values.',
    'min'   => [
        'numeric' => 'يجب أن يكون :attribute على الأقل :min.',
        'file'    => 'يجب أن يكون حجم :attribute على الأقل :min كيلوبايت.',
        'string'  => 'يجب أن يكون طول :attribute على الأقل :min أحرف.',
        'array'   => 'يجب أن يحتوي :attribute على الأقل :min عناصر.',
    ],
    'not_in'               => ':attribute المحدد غير صالح.',
    'numeric'              => 'يجب أن يكون :attribute عددًا.',
    'regex'                => 'تنسيق :attribute غير صالح.',
    'required'             => 'حقل :attribute مطلوب.',
    'required_if'          => 'حقل :attribute مطلوب عندما يكون :other هو :value.',
    'required_with'        => 'حقل :attribute مطلوب عندما يكون :values موجودًا.',
    'required_with_all'    => 'حقل :attribute مطلوب عندما يكون :values موجودًا.',
    'required_without'     => 'حقل :attribute مطلوب عندما لا يكون :values موجودًا.',
    'required_without_all' => 'حقل :attribute مطلوب عندما لا يكون أي من :values موجودًا.',
    'same'                 => ':attribute و :other يجب أن يتطابقا.',
    'size'                 => [
        'numeric' => 'يجب أن يكون :attribute بحجم :size.',
        'file'    => 'يجب أن يكون حجم :attribute :size كيلوبايت.',
        'string'  => 'يجب أن يكون طول :attribute :size أحرف.',
        'array'   => 'يجب أن يحتوي :attribute على :size عنصرًا.',
    ],
    'unique'   => ':attribute تم أخذه بالفعل.',
    'url'      => 'تنسيق :attribute غير صالح.',
    'timezone' => 'يجب أن يكون :attribute منطقة صالحة.',
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
            'rule-name' => 'رسالة مخصصة',
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

    'attributes' => [
        'email'    => 'عنوان البريد الإلكتروني',
        'password' => 'كلمة المرور',
        // Add more attribute translations in Arabic as needed
    ],

];
