<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $guarded= [
        'id' 
    ];

    public function product()
    {
        return $this->belongsTo(Product::class); 
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->belongsTo(TransactionDetail::class, 'transaction_detail_id');
    }
}
