<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\Event;
use DateTime;

class EventHelper extends Controller {

    static function build_filters($request, $justVisibles=false, $returnStr=false) {
        
        $filters = null;

        if($justVisibles)
            $filters = Event::where('visibility', true)->where('status', 'confirmed')->where('end_registry', '>', time());
        else
            $filters = Event::where('status', '!=', 'init');

        $launchers = $request->query('launchers', null);
        $maxPrice = $request->query('maxPrice', null);
        $minPrice = $request->query('minPrice', null);
        $languages = $request->query('languages', null);
        $levels = $request->query('levels', null);
        $facilities = $request->query('facilities', null);
        $cities = $request->query('cities', null);
        $types = $request->query('types', null);
        $tag = $request->query('tag', null);
        $date = $request->query('date', null);

        $status = $request->query('status', null);
        $launcher = $request->query('launcher', null);
        $visibility = $request->query('visibility', null);
        $type = $request->query('type', null);
        $orderBy = $request->query('orderBy', null);
        $orderByType = $request->query('orderByType', null);
        $isInTopList = $request->query('isInTopList', null);
        $off = $request->query('off', null);
        $comment = $request->query('comment', null);

        $fromCreatedAt = $request->query('fromCreatedAt', null);
        $toCreatedAt = $request->query('toCreatedAt', null);
        
        $fromAt = $request->query('fromAt', null);
        $toAt = $request->query('toAt', null);
        
        $filters_arr = [];

        if($type != null) {
            if($type == "online")
                array_push($filters_arr, ['city_id', 'null']);
            else
                array_push($filters_arr, ['city_id', 'not_null']);
        }

        if($status != null)
            array_push($filters_arr, ['status', $status]);
            
        if($isInTopList != null)
            array_push($filters_arr, ['is_in_top_list', $isInTopList]);
            
        if($launcher != null)
            array_push($filters_arr, ['launcher_id', $launcher]);
            
        if($visibility != null)
            array_push($filters_arr, ['visibility', $visibility]);

        if($launchers != null)
            array_push($filters_arr, ['launcher_id', explode(',', $launchers)]);
            
        if($cities != null)
            array_push($filters_arr, ['city_id', explode(',', $cities)]);

        if($languages != null)
            array_push($filters_arr, ['language', $languages, 'like']);

        if($facilities != null)
            array_push($filters_arr, ['facilities', $facilities, 'like']);

        if($levels != null)
            array_push($filters_arr, ['level_description', array_map(function($o){return "'" . $o . "'";}, explode(',', $levels))]);

        if($minPrice != null)
            array_push($filters_arr, ['price', '>=', $minPrice]);
            
        if($maxPrice != null)
            array_push($filters_arr, ['price', '<=', $maxPrice]);

        if($tag != null)
            array_push($filters_arr, ['tags', $tag, 'like']);
            
        if($types != null) {
            $types = explode(',', $types);
            if(count($types) == 1) {
                
                $type = $types[0];

                if($type == "online")
                    array_push($filters_arr, ['city_id', 'null']);
                else
                    array_push($filters_arr, ['city_id', 'not_null']);
            }
        }
            
        // if($fromCreatedAt != null)
        //     $filters->whereDate('created_at', '>=', self::ShamsiToMilady($fromCreatedAt));
            
        // if($toCreatedAt != null)
        //     $filters->whereDate('created_at', '<=', self::ShamsiToMilady($toCreatedAt));

        // $isAdmin = false;

        // if($request->user() != null && (
        //     $request->user()->level == User::$ADMIN_LEVEL ||
        //     $request->user()->level == User::$EDITOR_LEVEL
        // )) {
            
        //     $isAdmin = true;

        //     if($visibility != null)
        //         $filters->where('visibility', $visibility);
                
        //     if($comment != null) {
        //         if($comment)
        //             $filters->where('new_comment_count', 0);
        //         else
        //             $filters->where('new_comment_count', '>', 0);
        //     }

        //     if($off != null) {
        //         $today = (int)self::getToday()['date'];
        //         if($off)
        //             $filters->whereNotNull('off')->where('off_expiration', '>=', $today);
        //         else
        //             $filters->where(function ($query) use ($today) {
        //                 $query->whereNull('off')->orWhere('off_expiration', '<', $today);
        //             });
        //     }

        // }
        // else
        //     $filters->where('visibility', true);

        // if($justVisibles && $isAdmin)
        //     $filters->where('visibility', true);

        // if($orderByType == null || (
        //         $orderByType != 'asc' && 
        //         $orderByType != 'desc'
        // ))
        //     $orderByType = 'desc';

        // if($orderBy != null) {
        //     if($orderBy == 'createdAt')
        //         $filters->orderBy('id', $orderByType);
        //     else if(in_array($orderBy, 
        //         [
        //             'rate', 'seen', 'rate_count', 'priority',
        //             'comment_count', 'new_comment_count'
        //         ]
        //     ))
        //         $filters->orderBy($orderBy, $orderByType);
        // }
        // else {
        //     $orderBy = 'createAt';
        //     $orderByType = 'desc';
        //     if($isAdmin)
        //         $filters->orderBy('id', 'desc');
        //     else
        //         $filters->orderBy('priority', 'asc');
        // }

        if($returnStr) {
            
            $filters = "";
            $first = true;

            foreach($filters_arr as $filter) {

                if(count($filter) == 3 && $filter[2] == 'like')
                    $filter[1] = explode(',', $filter[1]);

                if(is_array($filter[1])) {

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
                            if(count($filter) == 2)
                                $filters .= $filter[0] . ' = ' . $itr;
                            else
                                $filters .= $filter[0] . ' like "%' . $itr . '%"';
                        }
                        else {
                            if(count($filter) == 2)
                                $filters .= ' or ' . $filter[0] . ' = ' . $itr;
                            else
                                $filters .= ' or ' . $filter[0] . ' like "%' . $itr . '%"';
                        }
                    }
                    $filters .= ')';
                    continue;
                }


                if(count($filter) == 2 && $filter[1] == "null") {
                    $op = " is null ";
                    $filter[1] = '';
                }
                else if(count($filter) == 2 && $filter[1] == "not_null") {
                    $op = " is not null ";
                    $filter[1] = '';
                }
                else
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
                else if($filter[2] == "like") {
                    $items = explode(',', $filter[1]);
                    $tmp_key = $filter[0];
                    $filters->where(function ($query) use ($items, $tmp_key) {

                        $first_cluase = true;
                        $like_query = "";

                        foreach($items as $item) {
                            if($first_cluase) {
                                $first_cluase = false;
                                if($tmp_key == "language")
                                    $like_query .= $tmp_key . " like '%_" . $item . "_%'";
                                else
                                    $like_query .= $tmp_key . " like '%" . $item . "%'";
                            }
                            else {
                                if($tmp_key == "language")
                                    $like_query .= " or " . $tmp_key . " like '%_" . $item . "_%'";
                                else
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
            else if($filter[0] == 'tags' && is_array($filter[1])) {
                $tags = $filter[1];
                $filters->where(function ($query) use ($tags) {
                    foreach($tags as $tag) {
                        $query->orWhereLike('tag', $tag);
                    }
                });
            }
            else if($filter[0] == 'launcher_id' && is_array($filter[1])) {
                $launchers = $filter[1];
                $filters->where(function ($query) use ($launchers) {
                    foreach($launchers as $launcher) {
                        $query->orWhere('launcher_id', $launcher);
                    }
                });
            }
            else if($filter[0] == 'level_description' && is_array($filter[1])) {
                $levels = $filter[1];
                $filters->where(function ($query) use ($levels) {
                    foreach($levels as $level) {
                        $query->orWhere('level_description', $level);
                    }
                });
            }
            else if(is_array($filter[1]))
                $filters->whereIn($filter[0], $filter[1]);
            else
                $filters->where($filter[0], $filter[1]);
        }
        
        if($date != null) {
            
            $d = self::ShamsiToMilady($date, '-');
            $d = DateTime::createFromFormat('Y-m-d', $d);
            
            if ($d === false) {
                $timestamp = null;
            } else {
                $timestamp = $d->getTimestamp();
            }

            if($timestamp != null) {
                $filters->join('event_sessions', 'events.id', '=', 'event_id');
                $filters->where('event_sessions.start', '<=', $timestamp);
                $filters->where('event_sessions.end', '>=', $timestamp);
                $filters->select('events.*');
            }
        }

        if($orderBy != null) {
            if($orderBy == 'createdAt')
                $orderBy = 'created_at';
            $filters->orderBy($orderBy, $orderByType == null ? 'desc' : $orderByType);
        }
        else
            $filters->orderBy('created_at', 'desc');

        return $filters;
    }

}

?>