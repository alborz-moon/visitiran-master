<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'mysql2';

    public function cities() {
        return $this->hasMany(City::class);
    }
}
