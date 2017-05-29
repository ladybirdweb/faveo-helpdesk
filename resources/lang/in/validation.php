<?php

return [
/*
|  Indonesian language translation for Faveo Helpdesk
|  Author: Fajri Surya Putra
|  Contact: fajrisuryaputra@outlook.co.id
|  Collaborator:
|  Last update: 21-12-2016
*/
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

    'accepted'   => ':attribute harus diterima.',
    'active_url' => ':attribute bukan URL yang sesuai.',
    'after'      => ':attribute harus berupa tanggal setelah :date.',
    'alpha'      => ':attribute hanya boleh berisi huruf.',
    'alpha_dash' => ':attribute hanya boleh berisi huruf, angka, dan strip.',
    'alpha_num'  => ':attribute hanya boleh berisi huruf dan angka.',
    'array'      => ':attribute harus berupa array.',
    'before'     => ':attribute harus berupa tanggal sebelum :date.',
    'between'    => [
        'numeric' => ':attribute harus diantara :min dan :max.',
        'file'    => ':attribute harus diantara :min dan :max kilobyte.',
        'string'  => ':attribute harus diantara :min dan :max karakter.',
        'array'   => ':attribute harus diantara :min dan :max item.',
    ],
    'boolean'        => 'Bidang :attribute harus berupa salah atau benar.',
    'confirmed'      => 'Konfirmasi :attribute tidak sama.',
    'date'           => ':attribute bukan tanggal yang sesuai.',
    'date_format'    => ':attribute tidak sama dengan format :format.',
    'different'      => ':attribute dan :other harus berbeda.',
    'digits'         => ':attribute harus :digits digit.',
    'digits_between' => ':attribute harus diantara :min dan :max digit.',
    'email'          => ':attribute harus berupa alamat email yang sesuai.',
    'filled'         => 'Bidang :attribute wajib diisi.',
    'exists'         => ':attribute yang dipilih tidak sesuai.',
    'image'          => ':attribute harus berupa gambar.',
    'in'             => ':attribute yang dipilih tidak sesuai.',
    'integer'        => ':attribute harus berupa integer.',
    'ip'             => ':attribute harusb berupa alamat IP yang sesuai.',
    'max'            => [
        'numeric' => ':attribute tidak boleh lebih dari :max.',
        'file'    => ':attribute tidak boleh lebih dari :max kilobyte.',
        'string'  => ':attribute tidak boleh lebih dari :max karakter.',
        'array'   => ':attribute mungkin tidak punya lebih dari :max item.',
    ],
    'mimes' => ':attribute harus berupa berkas dengan tipe: :values.',
    'min'   => [
        'numeric' => ':attribute minimal :min.',
        'file'    => ':attribute minimal :min kilobyte.',
        'string'  => ':attribute minimal :min karakter.',
        'array'   => ':attribute harus ada paling sedikit :min item.',
    ],
    'not_in'               => ':attribute yang dipilih tidak sesuai.',
    'numeric'              => ':attribute harus berupa angka.',
    'regex'                => 'Format :attribute tidak sesuai.',
    'required'             => 'Bidang :attribute wajib diisi.',
    'required_if'          => 'Bidang :attribute wajib diisi saat :other :value.',
    'required_with'        => 'Bidang :attribute wajib diisi saat :values ada.',
    'required_with_all'    => 'Bidang :attribute wajib diisi saat :values ada.',
    'required_without'     => 'Bidang :attribute wajib diisi saat :values tidak ada.',
    'required_without_all' => 'Bidang :attribute wajib diisi saat semua :values tidak ada.',
    'same'                 => ':attribute dan :other harus sama.',
    'size'                 => [
        'numeric' => ':attribute harus :size.',
        'file'    => ':attribute harus :size kilobyte.',
        'string'  => ':attribute harus :size karakter.',
        'array'   => ':attribute harus berisi :size item.',
    ],
    'unique'   => ':attribute sudah ada.',
    'url'      => 'Format :attribute tidak sesuai.',
    'timezone' => ':attribute harus berupa zona yang sesuai.',
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
            'rule-name' => 'pesan-kustom',
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
