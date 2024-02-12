<?php

namespace App\Models;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'name',
        'img',
        'price',
        'description',
        'available_count',
        'is_in_top_list',
        'visibility',
        'off',
        'off_type',
        'off_expiration',
        'priority',
        'brand_id',
        'category_id',
        'digest',
        'keywords',
        'tags',
        'seller_id',
        'alt',
        'guarantee',
        'introduce',
        'slug'
    ];
    
    public $timestamps = false;

    public function brand() {
        return $this->belongsTo(Brand::class);
    }
    
    public function seller() {
        return $this->belongsTo(Seller::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function galleries() {
        return $this->hasMany(ProductGallery::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }
    
    public function productFeatures() {
        return $this->hasMany(ProductFeatures::class);
    }
    
    public function productEffectiveFeatures() {
        
        $features = $this->productFeatures()->get();
        foreach($features as $feature) {

            if(
                $feature->categoryFeature->effect_on_price ||
                $feature->categoryFeature->effect_on_available_count
            )
                return $feature;
        }

        return null;
    }

    public function scopeVisible($query) {
        return $query->where('visibility', true);
    }
    
    public function scopeTop($query) {
        return $query->where('is_in_top_list', true);
    }

    public static function like($key, $catId, $returnType, $filtersWhere=null) {

        $selects = $returnType == 'card' ? 
            'products.*, categories.name as cat_name, brands.name as brand_name, sellers.name as seller_name' : 
            'products.id, products.name, products.slug, categories.name as cat_name';

        $join_where = $returnType == 'card' ? 
            'categories.id = products.category_id and products.brand_id = brands.id and ' :
            'categories.id = products.category_id and ';

        $where = $catId == null ? 'products.name like "%' . $key . '%"' :
            'products.name like "%' . $key . '%" and categories.id = ' . $catId;

        if($filtersWhere != null)
            $where .= ' and ' . $filtersWhere;


        $from = $returnType == 'card' ? 'categories, brands, products left join sellers on ' .
            'seller_id = sellers.id' : 'products, categories';

        return DB::select(
            'select ' . $selects . ' from ' . $from . ' where ' . $join_where . $where
        );
    }

    public function features() {
        return DB::select(
            'select category_features.*, product_features.price,' . 
            '  product_features.available_count, product_features.value,' . 
            ' product_features.id as product_features_id from category_features ' .
            'left join product_features on ' . 
                'category_features.id = product_features.category_feature_id and '.
                'product_features.product_id = ' . $this->id .
                ' where category_features.category_id = ' . $this->category_id
        );
    }

    public static function featuresWithValueStatic($productId, $categoryId) {
        $features = DB::select(
            'select category_features.id, category_features.unit, category_features.show_in_top, ' .
                'category_features.name, product_features.value, ' . 
                'product_features.price, product_features.available_count ' . 
                'from category_features join product_features on ' . 
                'category_features.id = product_features.category_feature_id and '.
                'product_features.product_id = ' . $productId .
              ' where category_features.category_id = ' . $categoryId . 
              ' order by category_features.priority asc'
        );
        return $features;
    }

    public function featuresWithValue() {
        $features = DB::select(
            'select product_features.product_id, category_features.id, category_features.unit, category_features.show_in_top, ' .
                'category_features.name, product_features.value, ' . 
                'product_features.price, product_features.available_count ' . 
                'from category_features join product_features on ' . 
                'category_features.id = product_features.category_feature_id and '.
                'product_features.product_id = ' . $this->id .
              ' where category_features.category_id = ' . $this->category_id . 
              ' order by category_features.priority asc'
        );
        return $features;
    }

    public static function activeOffStatic(
        $userId, $off, $offType, $offExpiration, 
        $categoryId, $brandId, $sellerId
    ) {

        $today = (int)Controller::getToday()['date'];

        if($off != null) {
            if((int)$offExpiration >= $today)
                return [
                    'type' => $offType,
                    'value' => $off
                ];
        }

        $off = Off::where('off_expiration', '>', $today)
            ->where(function($query) use($categoryId) {
                return $query->where('category_id', $categoryId)
                    ->orWhereNull('category_id');
            })->where(function($query) use($brandId) {
                return $query->where('brand_id', $brandId)
                    ->orWhereNull('brand_id');
            })->where(function($query) use($sellerId) {
                return $query->where('seller_id', $sellerId)
                    ->orWhereNull('seller_id');
            })->where(function($query) use ($userId) {
                return $query->where('user_id', $userId)
                    ->orWhereNull('user_id');
            })->orderBy('amount', 'desc')->get();

        if($off != null && count($off) > 0) {
            return [
                'type' => $off[0]->off_type,
                'value' => $off[0]->amount
            ];
        }

        return null;
    }

    public function activeOff($userId) {

        $today = (int)Controller::getToday()['date'];

        if($this->off != null) {
            if((int)$this->off_expiration >= $today)
                return [
                    'type' => $this->off_type,
                    'value' => $this->off
                ];
        }

        $off = Off::where('off_expiration', '>', $today)
            ->where('site', 'shop')
            ->where(function($query) {
                return $query->where('category_id', $this->category_id)
                    ->orWhereNull('category_id');
            })->where(function($query) {
                return $query->where('brand_id', $this->brand_id)
                    ->orWhereNull('brand_id');
            })->where(function($query) {
                return $query->where('seller_id', $this->seller_id)
                    ->orWhereNull('seller_id');
            })
            ->whereNull('user_id')
            ->whereNull('code')
            // ->where(function($query) use ($userId) {
            //     return $query->where('user_id', $userId)
            //         ->orWhereNull('user_id');
            // })
            ->orderBy('amount', 'desc')->get();

        if($off != null && count($off) > 0) {
            return [
                'type' => $off[0]->off_type,
                'value' => $off[0]->amount
            ];
        }

        return null;
    }
}
