<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LauncherBank extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'launcher_bank_accounts';

    protected $fillable = [
        'launcher_id',
        'shaba_no',
        'confirmed_at',
        'status',
        'is_default'
    ];

    public function launcher() {
        return $this->belongsTo(Launcher::class);
    }
}
