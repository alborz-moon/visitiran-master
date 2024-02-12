<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'address';

    protected $fillable = [
        'id',
        'name',
        'user_id',
        'address',
        'postal_code',
        'x',
        'y',
        'city_id',
        'recv_name',
        'recv_last_name',
        'recv_phone',
        'is_default'
    ];
    
    public function city() {
        return $this->belongsTo(City::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}
