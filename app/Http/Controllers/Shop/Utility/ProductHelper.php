<?php

namespace App\Http\Controllers\Shop\Utility;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class ProductHelper extends Controller {

    public static function get_all_subs_ids($cat) {
        
        $ids = [];
        array_push($ids, $cat->id);

        $subs = $cat->sub;
        if(count($subs) == 0)
            return $ids;

        foreach($subs as $sub) {
            $arr = self::get_all_subs_ids($sub);
            foreach($arr as $itr)
                array_push($ids, $itr);
        }

        return $ids;
    }

    public static function build_filters($request, $justVisibles=false, $returnStr=false) {
        
        $filters = Product::where('id', '>', '0');
        $cat = $request->query('category', null);
        $parent = $request->query('parent', null);
        $brand = $request->query('brand', null);
        $seller = $request->query('seller', null);
        $visibility = $request->query('visibility', null);
        $orderBy = $request->query('orderBy', null);
        $orderByType = $request->query('orderByType', null);
        $isInTopList = $request->query('isInTopList', null);
        $max = $request->query('max', null);
        $min = $request->query('min', null);
        $maxPrice = $request->query('maxPrice', null);
        $minPrice = $request->query('minPrice', null);
        $off = $request->query('off', null);
        $comment = $request->query('comment', null);
        $features = $request->query('features', null);

        $fromCreatedAt = $request->query('fromCreatedAt', null);
        $toCreatedAt = $request->query('toCreatedAt', null);
        $filters_arr = [];

        if($cat != null)
            array_push($filters_arr, ['category_id', explode(',', $cat)]);
            
        if($features != null)
            array_push($filters_arr, ['features', explode(',', $features)]);

        if($brand != null)
            array_push($filters_arr, ['brand_id', explode(',', $brand)]);
            
        if($seller != null)
            array_push($filters_arr, ['seller_id', explode(',', $seller)]);
            
        if($isInTopList != null)
            array_push($filters_arr, ['is_in_top_list', $isInTopList]);
            
        if($fromCreatedAt != null)
            array_push($filters_arr, ['created_at', '>=', self::ShamsiToMilady($fromCreatedAt)]);
            
        if($toCreatedAt != null)
            array_push($filters_arr, ['created_at', '<=', self::ShamsiToMilady($toCreatedAt)]);

        if($min != null)
            array_push($filters_arr, ['available_count', '>=', $min]);
            
        if($minPrice != null)
            array_push($filters_arr, ['price', '>=', $minPrice]);
            
        if($maxPrice != null)
            array_push($filters_arr, ['price', '<=', $maxPrice]);

        if($parent != null) {
            $parentCat = Category::whereId($parent)->first();
            if($parentCat == null)
                array_push($filters_arr, ['id', '<', 0]);
            else {
                if($parentCat->products()->count() > 0)
                    array_push($filters_arr, ['category_id', $parentCat->id]);
                else {
                    array_push($filters_arr, ['is_in_top_list', true]);
                    $catIds = self::get_all_subs_ids($parentCat);
                    array_push($filters_arr, ['category_id', $catIds]);
                }
            }
        }
        
        if($off != null) {
            $today = (int)self::getToday()['date'];
            if($off)
                $filters->whereNotNull('off')->where('off_expiration', '>=', $today);
            else
                $filters->where(function ($query) use ($today) {
                    $query->whereNull('off')->orWhere('off_expiration', '<', $today);
                });
        }

        $isAdmin = false;

        if($request->user() != null && (
            $request->user()->level == User::$ADMIN_LEVEL ||
            $request->user()->level == User::$EDITOR_LEVEL
        )) {
            
            $isAdmin = true;

            if($visibility != null)
                $filters->where('visibility', $visibility);
                
            if($comment != null) {
                if($comment)
                    $filters->where('new_comment_count', 0);
                else
                    $filters->where('new_comment_count', '>', 0);
            }
                
            if($max != null)
                $filters->where('available_count', '<=', $max);

        }
        else
            $filters->where('visibility', true);

        if($justVisibles && $isAdmin)
            $filters->where('visibility', true);

        if($orderByType == null || (
                $orderByType != 'asc' && 
                $orderByType != 'desc'
        ))
            $orderByType = 'desc';

        if($orderBy != null) {
            if($orderBy == 'createdAt')
                $filters->orderBy('id', $orderByType);
            else if(in_array($orderBy, ['rate', 'seen', 'price', 
                'rate_count', 'comment_count', 'new_comment_count', 'sell_count']))
                $filters->orderBy($orderBy, $orderByType);
        }
        else {
            $orderBy = 'createAt';
            $orderByType = 'desc';
            if($isAdmin)
                $filters->orderBy('id', 'desc');
            else
                $filters->orderBy('priority', 'asc');
        }

        if($returnStr) {
            
            $filters = "";
            $first = true;

            foreach($filters_arr as $filter) {

                if(count($filter) == 2 && is_array($filter[1])) {

                    if($first) {
                        $filters .= ' (';
                        $first = false;
                    }
                    else
                        $filters .= ' and (';

                    $first_cluase = true;
                    foreach($filter[1] as $itr) {
                        if($first_cluase) {
                            $first_cluase = false;
                            $filters .= $filter[0] . ' = ' . $itr;
                        }
                        else {
                            $filters .= ' or ' . $filter[0] . ' = ' . $itr;
                        }
                    }
                    $filters .= ')';
                    continue;
                }

                $op = count($filter) == 2 ? "=" : $filter[1];
                if($first) {
                    $first = false;
                    $filters .= $filter[0] . $op . $filter[count($filter) - 1];
                }
                else
                    $filters .= ' and ' . $filter[0] . $op . $filter[count($filter) - 1];

            }
            return $filters;
        }

        foreach($filters_arr as $filter) {
            if(count($filter) == 3) {
                if($filter[0] == 'createdAt')
                    $filters->whereDate($filter[0], $filter[1], $filter[2]);
                else {
                    $filters->where($filter[0], $filter[1], $filter[2]);
                }
            }
            else if($filter[0] == 'createdAt')
                $filters->whereDate($filter[0], $filter[1]);
            else if($filter[0] == 'category_id' && is_array($filter[1])) {
                $cats = $filter[1];
                $filters->where(function ($query) use ($cats) {
                    foreach($cats as $cat) {
                        $query->orWhere('category_id', $cat);
                    }
                });
            }
            else if($filter[0] == 'seller_id' && is_array($filter[1])) {
                $sellers = $filter[1];
                $filters->where(function ($query) use ($sellers) {
                    foreach($sellers as $seller) {
                        $query->orWhere('seller_id', $seller);
                    }
                });
            }
            else if($filter[0] == 'brand_id' && is_array($filter[1])) {
                $brands = $filter[1];
                $filters->where(function ($query) use ($brands) {
                    foreach($brands as $brand) {
                        $query->orWhere('brand_id', $brand);
                    }
                });
            }
            else if($filter[0] == 'features' && is_array($filter[1])) {
                
                $features = $filter[1];
                foreach($features as $feature) {
                    $feature = explode('_', $feature);
                    $filters->whereHas('productFeatures', function ($query) use ($feature) {
                        $query->where('category_feature_id', $feature[0])
                        ->where('value', 'like', "%" . $feature[1] . "%")
                        ;
                    });
                }

                
            }
            else if(is_array($filter[1]))
                $filters->whereIn($filter[0], $filter[1]);
            else
                $filters->where($filter[0], $filter[1]);
        }


        return $filters;
    }

}

?>