<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'contained_in',
        'price',
        'manufactured_on',
        'category',
        'user_id'
    ];

    public function container() {
        return $this->belongsTo('App\Models\Product', 'contained_in', 'id');
    }
}
