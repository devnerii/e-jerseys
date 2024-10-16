<?php

return [
    'default' => env('CURRENCY_DEFAULT', 'BRL'),  // Moeda padrão
    'currencies' => [
        'BRL' => [
            'symbol' => 'R$', // Símbolo da moeda
            'name' => 'Real',
            'decimals' => 2,
            'thousands_separator' => '.',
            'decimal_separator' => ',',
        ],
        'USD' => [
            'symbol' => '$',  // Símbolo da moeda
            'name' => 'Dollar',
            'decimals' => 2,
            'thousands_separator' => ',',
            'decimal_separator' => '.',
        ],
        'EUR' => [
            'symbol' => '€',  // Símbolo do Euro
            'name' => 'Euro',
            'decimals' => 2,
            'thousands_separator' => '.',
            'decimal_separator' => ',',
        ],
        // Adicione outras moedas aqui
    ],
];
