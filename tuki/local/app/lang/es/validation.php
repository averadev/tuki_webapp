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

    "accepted"                        => "Este campo debe ser aceptado.",
    "active_url"                      => "No es una URL válida.",
    "address"                         => "Debe de contener solo letras, números, guiones, puntos y comas.",
    "after"                           => "Debe ser una fecha posterior a :date.",
    "alpha"                           => "Solo debe contener letras.",
    "alpha_dash"                      => "Solo debe contener letras, números y guiones.",
    "alpha_num"                       => "Solo debe contener letras y números.",
    "alpha_spaces"                    => "Solo debe contener letras y espacios.",
    "alpha_spaces_coma"               => "Solo debe contener letras, espacios y coma.",
    "alpha_spaces_num"                => "Solo debe contener letras, numeros y escpacios",
    "alpha_spaces_dot"                => "Solo debe contener letras, coma y punto.",
    "alpha_num_character"             => "Solo debe contener letras, numeros.",
    "alpha_num_character_special"     => "Solo debe contener letras, numeros y algunos caracteres especiales",
    "alpha_num_sppdc"                 => "Solo debe contener letras, numeros y algunos caracteres especiales",    
    "AlphaNumEspaceCPG"               => "Solo debe contener letras, numeros y (,.)",
    "array"                           => "Debe ser un conjunto.",
    "array_numeric"                   => "Debe ser un conjunto númerico",
    "before"                          => "Debe ser una fecha anterior a :date.", 
    "between"             => array(
        "numeric" => "Tiene que estar entre :min - :max.",
        "file"    => "Debe pesar entre :min - :max kilobytes.",
        "string"  => "Tiene que tener entre :min - :max caracteres.",
        "array"   => "Tiene que tener entre :min - :max ítems.",
    ),
    "boolean"          => "Debe tener un valor verdadero o falso.",
    "current_month"    => "El no es actual.",
    "after_month"      => "Solo se permite editar un mes atras del mes actual.",
    "confirmed"        => "La confirmación  no coincide.",
    "comment"          => "Debe de contener solo letras, números, guiones, puntos y comas.",
    "date"             => "No es una fecha válida.",
    "date_format"      => "No corresponde al formato :format.",
    "different"        => "Y :other deben ser diferentes.",
    "digits"           => "Debe tener :digits dígitos.",
    "digits_between"   => "Debe tener entre :min y :max dígitos.",
    "email"            => "No es un correo válido",
    "exists"           => "Es inválido.",
    "image"            => "Debe ser una imagen.",
    "in"               => "Es inválido.",
    "integer"          => "Debe ser un número entero.",
    "ip"               => "Debe ser una dirección IP válida.",
    "json"             => "Formato JSON no valido.",
    "array_of_ids"     => "Formato no válido (1,2,3).",
    "max"              => array(
        "numeric" => "No debe ser mayor a :max.",
        "file"    => "No debe ser mayor que :max kilobytes.",
        "string"  => "No debe ser mayor que :max caracteres.",
        "array"   => "No debe tener más de :max elementos.",
    ),
    "mimes"            => "Debe ser un archivo con formato: :values.",
    "min"              => array(
        "numeric" => "El tamaño debe ser de al menos :min.",
        "file"    => "El tamaño debe ser de al menos :min kilobytes.",
        "string"  => "Debe contener al menos :min caracteres.",
        "array"   => "Debe tener al menos :min elementos.",
    ),
    "not_in"               => "Es inválido.",
    "numeric"              => "Debe ser numérico.",
    "phone"                => "El campo solo debe contener numeros, espacios y estos caracteres especial  - / ( )",
    "regex"                => "El formato es inválido.",
    "required"             => "El campo es obligatorio.",
    "required_if"          => "El campo es obligatorio cuando :other es :value.",
    "required_with"        => "El campo es obligatorio cuando :values está presente.",
    "required_with_all"    => "El campo es obligatorio cuando :values está presente.",
    "required_without"     => "El campo es obligatorio cuando :values no está presente.",
    "required_without_all" => "El campo es obligatorio cuando ninguno de :values estén presentes.",
    "same"                 => ":attribute y :other deben coincidir.",
    "schedule"             => "El campo solo debe contener letras, numeros and guion medio.",
    "size"             => array(
        "numeric"      => "El tamaño de debe ser :size.",
        "file"         => "El tamaño de debe ser :size kilobytes.",
        "string"       => "Debe contener :size caracteres.",
        "array"        => "Debe contener :size elementos.",
    ),
    "unique"                  => "Ya ha sido registrado.",
    "longitud_latitud"        => "El formato no es correcto.",
    "valid_imagebase64"       => "El formato de la imagen no es correcto.",
    "url"                     => "El formato es inválido.",
    "timezone"                => "El debe ser una zona válida.",
    "time_with_meridian"      => "El formato es inválido.",
    "date_greater_than_today" => "Campo debe ser mayor a la fecha actual",

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
