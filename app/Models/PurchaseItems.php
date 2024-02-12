<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItems extends Model
{
    use HasFactory;

    protected $table = 'purchase_items';

    protected $fillable = [
        'id',
        'purchase_id',
        'product_id',
        'count',
        'feature',
        'off_amount',
        'unit_price'
    ];

    public $timestamps = false;

    public function product() {
        return $this->belongsTo(Product::class);
    }
    
    public function purchase() {
        return $this->belongsTo(Purchase::class);
    }
}
