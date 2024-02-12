<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activation extends Model
{
    use HasFactory;
    
    protected $table = 'activation';

    protected $fillable = [
        'id',
        'phone',
        'code',
        'vc_expired_at'
    ];

    protected $hidden = [
        'code'
    ];
}
