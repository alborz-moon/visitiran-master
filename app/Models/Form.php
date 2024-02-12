<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'city_id',
        'first_name',
        'last_name',
        'phone',
        'role',
        'bio'
    ];


    public function city() {
        return $this->belongsTo(City::class);
    }

}
