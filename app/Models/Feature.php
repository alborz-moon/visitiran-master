<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;
    
    protected $table = 'category_features';

    protected $fillable = [
        'id',
        'category_id',
        'show_in_top',
        'effect_on_price',
        'effect_on_available_count',
        'unit',
        'answer_type',
        'choices',
        'priority',
        'name'
    ];

    public $timestamps = false;

    public function category() {
        return $this->belongsTo(Category::class);
    }
    
    public function productFeatures() {
        return $this->hasMany(ProductFeatures::class, 'category_feature_id');
    }

    public function scopeMultiChoice($query) {
        return $query->where('answer_type', 'multi_choice');
    }
}
