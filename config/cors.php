<?php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'dash/*'], // inclua qualquer prefixo que você use

    'allowed_methods' => ['*'],

    'allowed_origins' => ['*'], // ou ['http://localhost:3000'] se quiser restringir

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false, // coloque true se estiver usando autenticação via cookie
];
