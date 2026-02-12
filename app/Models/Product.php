<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'seller_id',
        'name',
        'category',
        'price',
        'stock',
        'image',
        'is_approved',
    ];
     public function scopeVerified($query)
    {
        return $query->where('is_approved', true);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
