<?php

namespace App\Http\Controllers\Shop\Utility;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\User;

class BlogHelper extends Controller {

    public static function build_filters($request, $justVisibles=false) {
        
        $filters = ($request->getHost() == self::$EVENT_SITE) ? Blog::where('site', 'event') : Blog::where('site', 'shop');

        $tag = $request->query('tag', null);
        $visibility = $request->query('visibility', null);
        $orderBy = $request->query('orderBy', null);
        $orderByType = $request->query('orderByType', null);

        $fromCreatedAt = $request->query('fromCreatedAt', null);
        $toCreatedAt = $request->query('toCreatedAt', null);

        if($tag != null)
            $filters->where('tags', 'LIKE', '%' . $tag . '%');
            
        if($fromCreatedAt != null)
            $filters->whereDate('created_at', '>=', self::ShamsiToMilady($fromCreatedAt));
            
        if($toCreatedAt != null)
            $filters->whereDate('created_at', '<=', self::ShamsiToMilady($toCreatedAt));

        $isAdmin = false;

        if($request->user() != null && (
            $request->user()->level == User::$ADMIN_LEVEL ||
            $request->user()->level == User::$EDITOR_LEVEL
        )) {
            
            $isAdmin = true;

            if($visibility != null)
                $filters->where('visibility', $visibility);

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
            // else if(in_array($orderBy, ['seen', 'header']))
            else if(in_array($orderBy, ['header']))
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

        return $filters;
    }
}

?>