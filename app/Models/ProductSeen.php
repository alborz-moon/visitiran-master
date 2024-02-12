<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSeen extends Model
{
    use HasFactory;
    protected $table = 'product_seen';

    protected $fillable = [
        'product_id',
        'seen',
        'date'
    ];
    
    public $timestamps = false;
}
