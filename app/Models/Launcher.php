<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Launcher extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'user_id',
        'status',
        'user_NID',
        'user_email',
        'user_birth_day',
        'about',
        'launcher_type',
        'company_name',
        'company_type',
        'postal_code',
        'code',
        'img',
        'back_img',
        'alt',
        'keywords',
        'digest',
        'seo_tags',
        'launcher_address',
        'launcher_city_id',
        'launcher_email',
        'launcher_site',
        'launcher_phone',
        'launcher_x',
        'launcher_y',
        'company_newspaper',
        'company_last_changes',
        'user_NID_card'
    ];

    public function scopeActive($query) {
        return $query->where('status', '=', 'confirmed');
    }

    public function user() {
        return $this->setConnection('mysql')->belongsTo(User::class);
    }

    public function certs() {
        return $this->hasMany(LauncherCert::class);
    }

    public function banks() {
        return $this->hasMany(LauncherBank::class);
    }
    
    public function events() {
        return $this->hasMany(Event::class);
    }
    

    public function comments() {
        return $this->hasMany(LauncherComment::class);
    }
    
    public function followers() {
        return $this->hasMany(LauncherFollowers::class);
    }
    
    public function city() {
        return $this->belongsTo(City::class, 'launcher_city_id', 'id');
    }
}
