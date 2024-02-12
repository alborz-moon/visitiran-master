<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\Launcher;

class LauncherHelper extends Controller {

    static function build_filters($request, $justVisibles=false, $returnStr=false) {
        
        $filters = null;

        $minRate = $request->query('minRate', null);
        $orderBy = $request->query('orderBy', null);
        $orderByType = $request->query('orderByType', null);
        $filters_arr = [];

        if($justVisibles)
            $filters = Launcher::active();
        else
            $filters = Launcher::where('status', '!=', 'init');

        if($minRate != null)
            array_push($filters_arr, ['rate', '>=', $minRate]);

        if($orderBy != null) {
            if($orderBy == 'createdAt')
                $orderBy = 'created_at';
            $filters->orderBy($orderBy, $orderByType == null ? 'desc' : $orderByType);
        }
        else
            $filters->orderBy('created_at', 'desc');
    

        foreach($filters_arr as $filter) {
            
            if(count($filter) == 3) {
                if($filter[0] == 'createdAt')
                    $filters->whereDate($filter[0], $filter[1], $filter[2]);
                else if($filter[2] == "like") {
                    $items = explode(',', $filter[1]);
                    $tmp_key = $filter[0];
                    $filters->where(function ($query) use ($items, $tmp_key) {

                        $first_cluase = true;
                        $like_query = "";

                        foreach($items as $item) {
                            if($first_cluase) {
                                $first_cluase = false;
                                $like_query .= $tmp_key . " like '%" . $item . "%'";
                            }
                            else {
                                $like_query .= " or " . $tmp_key . " like '%" . $item . "%'";
                            }
                        }

                        $query->whereRaw($like_query);
                        
                    });
                }
                else {
                    $filters->where($filter[0], $filter[1], $filter[2]);
                }
            }
            else if(count($filter) == 2 && $filter[1] == "null")
                $filters->whereNull($filter[0]);
            else if(count($filter) == 2 && $filter[1] == "not_null")
                    $filters->whereNotNull($filter[0]);
            else if($filter[0] == 'createdAt')
                $filters->whereDate($filter[0], $filter[1]);
            
            else if(is_array($filter[1]))
                $filters->whereIn($filter[0], $filter[1]);
            else
                $filters->where($filter[0], $filter[1]);
        }

        return $filters;
    }

}


?>