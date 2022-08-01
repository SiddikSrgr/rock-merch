<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded= [
        'id'
    ];

    // nama relasinya harus dibuat plural jika hasMany (pake s)
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
