<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Purchase extends Model
{
    use HasFactory;
    
    protected $table = 'purchase';

    public static $FINALIZED = "finalized";
    public static $SENDING = "sending";
    public static $DELIVERED = "delivered";

    public static $ONLINE = "online";
    public static $CASH = "cash";


    protected $fillable = [
        'id',
        'user_id',
        'transaction_id',
        'payment_status',
        'status',
        'payment_type',
        'address',
        'x',
        'y',
        'recv_name',
        'recv_phone',
        'postal_code',
        'city_id',
        'delivery',
        'delivery_at'
    ];

    public function transaction() {
        return $this->belongsTo(Transaction::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function address() {
        return $this->belongsTo(Address::class);
    }


    public function purchase_items() {
        return $this->hasMany(PurchaseItems::class);
    }

    public function items() {
        return DB::select('select products.id, products.name, products.img, purchase_items.count, purchase_items.unit_price, purchase_items.feature, purchase_items.off_amount from products inner join purchase_items on purchase_items.product_id = products.id where purchase_id = ' . $this->id);
    }
    
    public function scopePaid($query) {
        return $query->where('payment_status', EventBuyer::$PAID);
    }

    public function scopeSending($query) {
        return $query->where('status', Purchase::$SENDING);
    }

    public function scopeDelivered($query) {
        return $query->where('status', Purchase::$DELIVERED);
    }

    public function scopeFinalized($query) {
        return $query->where('status', Purchase::$FINALIZED);
    }

}
