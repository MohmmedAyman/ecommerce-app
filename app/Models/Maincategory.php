<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maincategory extends Model
{
    use HasFactory;
    
    protected $table = 'maincategories';
    protected $fillable = [
        'mcate_name',
    ];
}
