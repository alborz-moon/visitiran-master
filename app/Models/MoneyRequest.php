<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoneyRequest extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    
    public static $PENDING = 'pending';
    public static $REJECTED = 'rejected';
    public static $CONFIRMED = 'confirmed';
    public static $PAID = 'paid';

    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'additional',
        'launcher_bank_account_id'
    ];

    public function scopePaid($query) {
        return $query->where('status', MoneyRequest::$PAID);
    }

}
