<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */

    "accepted"          => "El campo :attribute debe ser aceptado.",
    "active_url"        => "El campo :attribute no es una URL válida.",
    "address"           => "El campo :attribute debe de contener solo letras, números, guiones, puntos y comas.",
    "after"             => "El campo :attribute debe ser una fecha posterior a :date.",
    "alpha"             => "El campo :attribute solo debe contener letras.",
    "alpha_dash"        => "El campo :attribute solo debe contener letras, números y guiones.",
    "alpha_num"         => "El campo :attribute solo debe contener letras y números.",
    "alpha_spaces"      => "El campo :attribute solo debe contener letras y espacios.",
    "alpha_spaces_coma" => "El campo :attribute solo debe contener letras, espacios y coma.",
    "alpha_spaces_num"  => "El campo :attribute solo debe contener letras, numeros y coma.",
    "alpha_spaces_dot"  => "El campo :attribute solo debe contener letras, coma and punto.",
    "array"             => "El campo :attribute debe ser un conjunto.",
    "array_numeric"     => "El campo :attribute debe ser un conjunto númerico",
    "before"            => "El campo :attribute debe ser una fecha anterior a :date.",
    "accepted"          => ":attribute debe ser aceptado.",
    "active_url"        => ":attribute no es una URL válida.",
    "address"           => "El :attribute debe de contener solo letras, números, guiones, puntos y comas.",
    "after"             => ":attribute debe ser una fecha posterior a :date.",
    "alpha"             => ":attribute solo debe contener letras.",
    "alpha_dash"        => ":attribute solo debe contener letras, números y guiones.",
    "alpha_num"         => ":attribute solo debe contener letras y números.",
    "alpha_spaces"      => "El :attribute solo debe contener letras y espacios.",
    "alpha_spaces_coma" => "El :attribute solo debe contener letras, espacios y coma.",
    "alpha_num_character" =>"El :attribute solo debe contener letras, numeros.",
    "array"             => ":attribute debe ser un conjunto.",
    "array_numeric"     => ":attribute debe ser un conjunto númerico",
    "before"            => ":attribute debe ser una fecha anterior a :date.",
    "between"           => array(
        "numeric" => ":attribute tiene que estar entre :min - :max.",
        "file"    => ":attribute debe pesar entre :min - :max kilobytes.",
        "string"  => ":attribute tiene que tener entre :min - :max caracteres.",
        "array"   => ":attribute tiene que tener entre :min - :max ítems.",
    ),
    "boolean"          => "El campo :attribute debe tener un valor verdadero o falso.",
    "confirmed"        => "La confirmación de :attribute no coincide.",
    "comment"          => "El :attribute debe de contener solo letras, números, guiones, puntos y comas.",
    "date"             => ":attribute no es una fecha válida.",
    "date_format"      => ":attribute no corresponde al formato :format.",
    "different"        => ":attribute y :other deben ser diferentes.",
    "digits"           => ":attribute debe tener :digits dígitos.",
    "digits_between"   => ":attribute debe tener entre :min y :max dígitos.",
    "email"            => ":attribute no es un correo válido",
    "exists"           => ":attribute es inválido.",
    "image"            => ":attribute debe ser una imagen.",
    "in"               => ":attribute es inválido.",
    "integer"          => ":attribute debe ser un número entero.",
    "ip"               => ":attribute debe ser una dirección IP válida.",
    "max"              => array(
        "numeric" => ":attribute no debe ser mayor a :max.",
        "file"    => ":attribute no debe ser mayor que :max kilobytes.",
        "string"  => ":attribute no debe ser mayor que :max caracteres.",
        "array"   => ":attribute no debe tener más de :max elementos.",
    ),
    "mimes"            => ":attribute debe ser un archivo con formato: :values.",
    "min"              => array(
        "numeric" => "El tamaño de :attribute debe ser de al menos :min.",
        "file"    => "El tamaño de :attribute debe ser de al menos :min kilobytes.",
        "string"  => ":attribute debe contener al menos :min caracteres.",
        "array"   => ":attribute debe tener al menos :min elementos.",
    ),
    "not_in"               => ":attribute es inválido.",
    "numeric"              => ":attribute debe ser numérico.",
    "phone"                => "El campo :attribute solo debe contener numeros, espacios y estos caracteres especial  - / ( )",
    "regex"                => "El formato de :attribute es inválido.",
    "required"             => "El campo :attribute es obligatorio.",
    "required_if"          => "El campo :attribute es obligatorio cuando :other es :value.",
    "required_with"        => "El campo :attribute es obligatorio cuando :values está presente.",
    "required_with_all"    => "El campo :attribute es obligatorio cuando :values está presente.",
    "required_without"     => "El campo :attribute es obligatorio cuando :values no está presente.",
    "required_without_all" => "El campo :attribute es obligatorio cuando ninguno de :values estén presentes.",
    "same"                 => ":attribute y :other deben coincidir.",
    "schedule"             => "El campo :attribute solo debe contener letras, numeros and guion medio.",
    "size"             => array(
        "numeric" => "El tamaño de :attribute debe ser :size.",
        "file"    => "El tamaño de :attribute debe ser :size kilobytes.",
        "string"  => ":attribute debe contener :size caracteres.",
        "array"   => ":attribute debe contener :size elementos.",
    ),
    "timezone"         => "El :attribute debe ser una zona válida.",
    "unique"           => "El :attribute ya ha sido registrado.",
    "url"              => "El formato :attribute es inválido.",

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

    'custom' => array(
        'attribute-name' => array(
            'rule-name' => 'custom-message',
        ),
    ),

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

    'attributes' => array(),

);
