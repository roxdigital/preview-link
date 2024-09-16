<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Token Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can configure the behavior of preview tokens.
    |
    */

    'token' => [
        // Number of months before a token expires
        'expiration_months' => 6,
    ],

    /*
    |--------------------------------------------------------------------------
    | Preview Behavior
    |--------------------------------------------------------------------------
    |
    | Configure how previews are displayed and handled.
    |
    */
    'preview' => [
        'show_preview_bar' => true,
        'bar_text' => 'Preview Mode',
        'bar_color' => '#ff6b6b',
        'text_color' => '#ffffff',
    ],

];
