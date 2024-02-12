<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'logo',
        'alt'
    ];

    public $timestamps = false;

    public function products() {
        return $this->hasMany(Product::class);
    }
    
    public function categories() {
        return $this->hasManyThrough(Category::class, Product::class, 'category_id', 'id');
    }
}