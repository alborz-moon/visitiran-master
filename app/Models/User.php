<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public static $ADMIN_LEVEL = 'admin';
    public static $FINANCE_LEVEL = 'finance';
    public static $REPORT_LEVEL = 'report';
    public static $EDITOR_LEVEL = 'editor';
    public static $NEWS_LEVEL = 'news';
    public static $USER_LEVEL = 'user';
    public static $LAUNCHER_LEVEL = 'launcher';

    public static $ACCESS_EVENT = 'event';
    public static $ACCESS_SHOP = 'shop';
    public static $ACCESS_BOTH = 'both';


    public static $PAYMENT_BACK_WALLET = 'WALLET';
    public static $PAYMENT_BACK_ONLINE = 'ONLINE';

    public static $NOT_ACTIVATE = 'init';
    public static $ACTIVE = 'active';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'level',
        'password',
        'status',
        'nid',
        'birth_day',
        'mail',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function purchases() {
        return $this->hasMany(Purchase::class);
    }

    public function addresses() {
        return $this->hasMany(Address::class);
    }

    public function scopeActive($query) {
        return $query->where('status', '=', User::$ACTIVE);
    }
    
    public function scopeAdmin($query) {
        return $query->where('level', '=', User::$ADMIN_LEVEL);
    }
    
    public function scopeEditor($query) {
        return $query->where('level', '=', User::$EDITOR_LEVEL);
    }

    public function scopeReport($query) {
        return $query->where('level', '=', User::$REPORT_LEVEL);
    }
    
    public function scopeNews($query) {
        return $query->where('level', '=', User::$NEWS_LEVEL);
    }

    public function scopeFinance($query) {
        return $query->where('level', '=', User::$FINANCE_LEVEL);
    }

    public function isLauncher() {
        
        if($this->level === User::$ADMIN_LEVEL) return true;

        $l = $this->launcher;
        return $l != null && $l->status === 'confirmed';
    }


    public function isEditor() {
        return $this->level === User::$ADMIN_LEVEL ||
            $this->level === User::$EDITOR_LEVEL;
    }


    public function offs() {
        return $this->hasMany(Off::class);
    }

    public function launcher() {
        return $this->hasOne(Launcher::class);
    }

    public function events() {
        return $this->hasManyThrough(Event::class, Launcher::class);
    }
}
