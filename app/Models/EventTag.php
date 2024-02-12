<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventTag extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    public $timestamps = false;
    
    protected $fillable = [
        'label',
        'visibility'
    ];

    public function scopeVisible($query) {
        return $query->where('visibility', true);
    }
}
