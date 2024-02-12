<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    use HasFactory;

    protected $table = 'faq';
    public $timestamps = false;
    
    protected $fillable = [
        'id',
        'visibility',
        'priority',
        'title',
        'description',
        'site'
    ];

    public function scopeVisible($query) {
        return $query->where('visibility', true);
    }
    
    public function scopeEvent($query) {
        return $query->where('site', 'event');
    }
    
    public function scopeShop($query) {
        return $query->where('site', 'shop');
    }
}
