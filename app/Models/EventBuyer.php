<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventBuyer extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';

    public static $PAID = 'paid';
    public static $PENDING = 'pending';

    protected $fillable = [
        'first_name',
        'last_name',
        'nid',
        'phone',
        'unit_price',
        'count',
        'user_id',
        'event_id',
        'transaction_id',
        'status',
    ];
    

    public static function removeUnPaid() {
        $last20Min = Carbon::now()->subMinutes(20)->timestamp;
        EventBuyer::where('status', self::$PENDING)->where('created_ts', '<', $last20Min)->delete();
    }

    public function scopePaid($query) {
        return $query->where('status', EventBuyer::$PAID);
    }

    public function event() {
        return $this->belongsTo(Event::class);
    }

    public function transaction() {
        return $this->setConnection('mysql')->belongsTo(Transaction::class);
    }
}
