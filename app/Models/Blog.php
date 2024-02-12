<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'header',
        'img',
        'description',
        'visibility',
        'priority',
        'digest',
        'keywords',
        'tags',
        'article_tags',
        'alt',
        'slug',
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
