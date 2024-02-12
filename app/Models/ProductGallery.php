<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGallery extends Model
{
    use HasFactory;
    
    protected $table = 'product_galleries';

    protected $fillable = [
        'id',
        'img',
        'product_id',
        'priority'
    ];

    public $timestamps = false;

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
