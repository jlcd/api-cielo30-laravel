<?php

return [

    'merchant_id'  => env('CIELO_ID', 'idtest'),
    'merchant_key' => env('CIELO_KEY', 'keytest'),
    'environment'  => env('CIELO_ENV', 'sandbox'), // production | sandbox

];
