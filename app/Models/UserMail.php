<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMail extends Model
{
    use HasFactory;
    protected $table = 'mail_users';

    protected $fillable = [
        'id',
        'mail'
    ];

    public function mails() {
        return $this->belongsToMany(Mail::class, 'mail_users', 'mail', 'mail');
    }
}
