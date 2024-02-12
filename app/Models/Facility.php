<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;
    
    protected $connection = 'mysql2';
    protected $table = 'event_facilities';
    public $timestamps = false;
    
    protected $fillable = [
        'label',
        'visibility'
    ];

    public function scopeVisible($query) {
        return $query->where('visibility', true);
    }
}
