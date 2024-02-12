<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSession extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $connection = 'mysql2';

    protected $fillable = [
        'event_id',
        'start',
        'end'
    ];

    public function event() {
        return $this->belongsTo(Event::class);
    }

}
