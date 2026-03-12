<?php

return [
    'accepted'             => ':attribute harus diterima.',
    'active_url'           => ':attribute bukan URL yang sah.',
    'after'                => ':attribute harus tanggal setelah :date.',
    'alpha'                => ':attribute hanya boleh berisi huruf.',
    'alpha_dash'           => ':attribute hanya boleh berisi huruf, angka, dan strip.',
    'alpha_num'            => ':attribute hanya boleh berisi huruf dan angka.',
    'array'                => ':attribute harus berupa sebuah array.',
    'before'               => ':attribute harus tanggal sebelum :date.',
    'between'              => [
        'numeric' => ':attribute harus antara :min dan :max.',
        'file'    => ':attribute harus antara :min dan :max kilobytes.',
        'string'  => ':attribute harus antara :min dan :max karakter.',
        'array'   => ':attribute harus antara :min dan :max item.',
    ],
    'boolean'              => ':attribute harus bernilai true atau false.',
    'confirmed'            => 'Konfirmasi :attribute tidak cocok.',
    'date'                 => ':attribute bukan tanggal yang sah.',
    'date_format'          => ':attribute tidak cocok dengan format :format.',
    'different'            => ':attribute dan :other harus berbeda.',
    'digits'               => ':attribute harus :digits digit.',
    'digits_between'       => ':attribute harus antara :min dan :max digit.',
    'email'                => ':attribute harus berupa alamat surel yang sah.',
    'exists'               => ':attribute yang dipilih tidak valid.',
    'filled'               => ':attribute wajib diisi.',
    'image'                => ':attribute harus berupa gambar.',
    'in'                   => ':attribute yang dipilih tidak valid.',
    'integer'              => ':attribute harus berupa bilangan bulat.',
    'ip'                   => ':attribute harus berupa alamat IP yang sah.',
    'max'                  => [
        'numeric' => ':attribute tidak boleh lebih dari :max.',
        'file'    => ':attribute tidak boleh lebih dari :max kilobytes.',
        'string'  => ':attribute tidak boleh lebih dari :max karakter.',
        'array'   => ':attribute tidak boleh lebih dari :max item.',
    ],
    'mimes'                => ':attribute harus berupa berkas berjenis: :values.',
    'min'                  => [
        'numeric' => ':attribute minimal harus :min.',
        'file'    => ':attribute minimal harus :min kilobytes.',
        'string'  => ':attribute minimal harus :min karakter.',
        'array'   => ':attribute minimal harus :min item.',
    ],
    'not_in'               => ':attribute yang dipilih tidak valid.',
    'numeric'              => ':attribute harus berupa angka.',
    'regex'                => 'Format :attribute tidak valid.',
    'required'             => ':attribute wajib diisi.',
    'required_if'          => ':attribute wajib diisi bila :other adalah :value.',
    'required_with'        => ':attribute wajib diisi bila terdapat :values.',
    'required_with_all'    => ':attribute wajib diisi bila terdapat :values.',
    'required_without'     => ':attribute wajib diisi bila tidak terdapat :values.',
    'required_without_all' => ':attribute wajib diisi bila tidak terdapat ada pun :values.',
    'same'                 => ':attribute dan :other harus sama.',
    'size'                 => [
        'numeric' => ':attribute harus berukuran :size.',
        'file'    => ':attribute harus berukuran :size kilobyte.',
        'string'  => ':attribute harus berukuran :size karakter.',
        'array'   => ':attribute harus mengandung :size item.',
    ],
    'string'               => ':attribute harus berupa string.',
    'timezone'             => ':attribute harus berupa zona waktu yang sah.',
    'unique'               => ':attribute sudah ada sebelumnya.',
    'url'                  => 'Format :attribute tidak valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Password Validation Language Lines
    |--------------------------------------------------------------------------
    */

    'letters' => ':attribute harus mengandung setidaknya satu huruf.',
    'mixed'   => ':attribute harus mengandung setidaknya satu huruf besar dan satu huruf kecil.',
    'numbers' => ':attribute harus mengandung setidaknya satu angka.',
    'symbols' => ':attribute harus mengandung setidaknya satu simbol.',
];
