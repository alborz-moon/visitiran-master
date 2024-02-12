<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LauncherFollowers extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'followers';

    protected $fillable = [
        'launcher_id',
        'user_id'
    ];

    public function launcher() {
        return $this->belongsTo(Launcher::class);
    }

}
