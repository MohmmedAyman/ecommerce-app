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

    public function mainCategory(){
        return $this->belongsTo(Maincategory::class,'pro_maincategory');
    }

    public function category(){
        return $this->belongsTo(Category::class,'pro_category');
    }
}
