<?php

return [

    'defaults' => [
    'guard' => 'web',
    'passwords' => 'users',
],

'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'seller' => [
        'driver' => 'session',
        'provider' => 'sellers',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],

    'sellers' => [
        'driver' => 'eloquent',
        'model' => App\Models\Seller::class,
    ],
],


];
