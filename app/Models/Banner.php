<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $fillable = [
        'id',
        'img',
        'href',
        'alt',
        'section',
        'site'
    ];
    
    public function scopeEvent($query) {
        return $query->where('site', 'event');
    }
    
    public function scopeShop($query) {
        return $query->where('site', 'shop');
    }
}
