<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventComment extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';

    protected $fillable = [
        'id',
        'event_id',
        'user_id',
        'is_bookmark',
        'msg',
        'positive',
        'negative',
        'rate'
    ];

    public static function userComment($eventId, $userId) {
        return EventComment::where('user_id', $userId)->where('event_id', $eventId)->first();
    }

    public static function scopeComment($query, $eventId) {
        return $query->where('event_id', $eventId)->whereNotNull('msg');
    }

    public static function scopeRate($query, $eventId) {
        return $query->where('eventt_id', $eventId)->whereNotNull('rate');
    }

    public function scopeConfirmed($query) {
        return $query->where('status', true);
    }

    public function scopeUnConfirmed($query) {
        return $query->where('status', false);
    }

    public function event() {
        return $this->belongsTo(Event::class);
    }

    public function user() {
        return $this->setConnection('mysql')->belongsTo(User::class);
    }
    
}
