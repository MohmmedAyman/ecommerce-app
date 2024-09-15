<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable=[
        'pro_name',
        'pro_description',
        'pro_price',
        'pro_maincategory',
        'pro_category',
    ];
}
