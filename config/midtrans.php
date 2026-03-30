<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Midtrans API credentials
    |--------------------------------------------------------------------------
    |
    | Server key: Merchant Portal → Settings → Access keys (simpan rahasia).
    | Client key: dipakai di Snap.js (data-client-key), boleh tampil di browser.
    |
    */

    'server_key' => env('MIDTRANS_SERVER_KEY', ''),

    'client_key' => env('MIDTRANS_CLIENT_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Environment
    |--------------------------------------------------------------------------
    |
    | false = sandbox (https://app.sandbox.midtrans.com)
    | true  = production (https://app.midtrans.com)
    |
    */

    'is_production' => filter_var(env('MIDTRANS_IS_PRODUCTION', false), FILTER_VALIDATE_BOOLEAN),

];
