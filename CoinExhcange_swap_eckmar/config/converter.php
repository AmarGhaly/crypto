<?php

return [
    'api_address' => env('CONVERTER_API_ADDRESS','https://api.morphtoken.com'),
    'limit_multiplier' => [
        'btcxmr' =>  env('LIMIT_MULTIPLIER_BTCXMR',7),
        'xmrbtc' =>  env('LIMIT_MULTIPLIER_XMRBTC',1.5),
    ]
];
