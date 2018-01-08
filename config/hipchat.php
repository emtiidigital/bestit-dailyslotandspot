<?php
return [
    /*
    |--------------------------------------------------------------------------
    | HipChat Server
    |--------------------------------------------------------------------------
    |
    | URL to your HipChat instance e.g. https://company.hipchat.com.
    |
    */

    'server_url' => env('HIPCHAT_SERVER_URL', null),

    /*
    |--------------------------------------------------------------------------
    | HipChat API Token
    |--------------------------------------------------------------------------
    |
    | Your HipChat API Token.
    |
    */

    'api_token' => env('HIPCHAT_API_TOKEN'),
];
