<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'id',
        'name',
        'img',
        'alt',
        'digest',
        'keywords',
        'tags',
        'parent_id',
        'show_in_first_page',
        'show_items_in_first_page',
        'priority',
        'visibility'
    ];

    public $timestamps = false;

    public function products() {
        return $this->hasMany(Product::class);
    }
    
    public function features() {
        return $this->hasMany(Feature::class);
    }
    
    public function parent() {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function sub() {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function scopeHead($query) {
        return $query->whereNull('parent_id');
    }

    public function scopeVisible($query) {
        return $query->where('visibility', '=', true);
    }
    
    public function scopeTop($query) {
        return $query->where('show_in_first_page', '=', true);
    }
    
    public function scopeTopProducts($query) {
        return $query->where('show_items_in_first_page', '=', true);
    }
}
