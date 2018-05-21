<?php

return [
    'auth_endpoint'        => 'https://secure.e-conomic.com/secure/api1/requestaccess.aspx?appPublicToken=',
    'request_endpoint'     => 'https://restapi.e-conomic.com',
    'public_token'         => env('ECONOMIC_APP_PUBLIC'),
    'secret_token'         => env('ECONOMIC_APP_SECRET'),
        'agreement'        => env('ECONOMIC_AGREEMENT'),
];
