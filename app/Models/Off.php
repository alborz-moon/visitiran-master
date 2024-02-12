<?php

namespace App\Models;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Off extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'code',
        'user_id',
        'category_id',
        'brand_id',
        'seller_id',
        'off_expiration',
        'off_type',
        'amount',
        'site'
    ];

    public function scopeGeneral($query) {
        return $query->where('user_id', null);
    }

    public function scopeActive($query) {
        $today = (int)Controller::getToday()['date'];
        return $query->where('off_expiration', '>=', $today);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function category() {
        return $this->belongsTo(Category::class);
    }
    
    public function brand() {
        return $this->belongsTo(Category::class);
    }
    
    public function seller() {
        return $this->belongsTo(Category::class);
    }
}
