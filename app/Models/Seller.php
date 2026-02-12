<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Seller extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_verified',
        'state',
        'district',
        'village',
        'pincode',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];
}
