<?php

namespace App\Models;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Event extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';

    public static $INIT_STATUS = "init";
    public static $PENDING_STATUS = "pending";
    public static $CONFIRMED_STATUS = "confirmed";
    
    protected $fillable = [
        'title',
        'start_registry',
        'end_registry',
        'img',
        'price',
        'facilities',
        'seo_tags',
        'ticket_description',
        'age_description',
        'level_description',
        'status',
        'capacity',
        'address',
        'postal_code',
        'email',
        'site',
        'phone',
        'x',
        'y',
        'city_id',
        'launcher_id',
        'description',
        'is_in_top_list',
        'visibility',
        'off',
        'off_type',
        'off_expiration',
        'priority',
        'digest',
        'keywords',
        'tags',
        'alt',
        'slug',
        'link',
        'language'
    ];

    public function city() {
        return $this->belongsTo(City::class);
    }
    
    public function launcher() {
        return $this->belongsTo(Launcher::class);
    }

    public function sessions() {
        return $this->hasMany(EventSession::class);
    }

    public function galleries() {
        return $this->hasMany(EventGallery::class);
    }
    
    public function buyers() {
        return $this->hasMany(EventBuyer::class);
    }
    
    public function comments() {
        return $this->hasMany(EventComment::class);
    }

    public function scopeActiveForRegistry($query) {
        return $query->where('visibility', true)
            ->where('status', 'confirmed')
            ->where('start_registry', '<=', time())
            ->where('end_registry', '>=', time());
    }
    
    public static function isActiveForRegistry($event) {
        
        EventBuyer::removeUnPaid();

        if(!$event->visibility || $event->status != 'confirmed') return false;

        if($event->capacity <= $event->buyers()->sum('count'))
            return false;
        
        if($event->start_registry <= time() && $event->end_registry >= time()) return true;

        return false;
    }


    public function scopeConfirmed($query) {
        return $query->where('status', 'confirmed');
    }
    

    public function scopeTop($query) {
        return $query->where('is_in_top_list', true);
    }
    
    public function activeOff() {

        if($this->off != null) {
            $today = (int)Controller::getToday()['date'];
            if((int)$this->off_expiration >= $today)
                return [
                    'type' => $this->off_type,
                    'value' => $this->off
                ];
        }

    }

    public static function staticActiveOff($off, $off_expiration, $off_type) {

        if($off != null) {
            $today = (int)Controller::getToday()['date'];
            if((int)$off_expiration >= $today)
                return [
                    'type' => $off_type,
                    'value' => $off
                ];
        }

        return null;
    }

    public static function like($key, $tag, $returnType, $filtersWhere=null) {

        $selects = $returnType == 'card' ? 
            'events.*, brands.name as brand_name, sellers.name as seller_name' : 
            'events.id, events.off, events.off_type, events.off_expiration, events.title, events.slug, events.price, events.img, events.alt, events.rate, events.tags, events.city_id, events.link, launchers.company_name, cities.name as city';

        $join_where = $returnType == 'card' ? 
            'categories.id = products.category_id and products.brand_id = brands.id and ' :
            'launchers.id = events.launcher_id and ';

        $where = $tag == null ? 'events.title like "%' . $key . '%"' :
            'events.title like "%' . $key . '%" and tags like "%' . $tag . '%"';

        if($filtersWhere != null)
            $where .= ' and ' . $filtersWhere;


        $from = $returnType == 'card' ? 'categories, brands, products left join sellers on ' .
            'seller_id = sellers.id' : 'launchers, events left join cities on cities.id = events.city_id '; 

        return DB::connection('mysql2')->select(
            'select ' . $selects . ' from ' . $from . ' where ' . $join_where . $where
        );
    }
}
