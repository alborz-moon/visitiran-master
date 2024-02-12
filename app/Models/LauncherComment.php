<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LauncherComment extends Model
{

    use HasFactory;
    protected $connection = 'mysql2';
    
    public static function userComment($launcherId, $userId) {
        return LauncherComment::where('user_id', $userId)->where('launcher_id', $launcherId)->first();
    }

    public static function scopeComment($query, $launcherId) {
        return $query->where('launcher_id', $launcherId)->whereNotNull('msg');
    }

    public static function scopeRate($query, $launcherId) {
        return $query->where('launcher_id', $launcherId)->whereNotNull('rate');
    }

    public function scopeConfirmed($query) {
        return $query->where('status', true);
    }

    public function scopeUnConfirmed($query) {
        return $query->where('status', false);
    }

    public function launcher() {
        return $this->belongsTo(Launcher::class);
    }

    public function user() {
        return $this->setConnection('mysql')->belongsTo(User::class);
    }
    
}
