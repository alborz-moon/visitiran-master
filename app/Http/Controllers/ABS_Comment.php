<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentDigest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\commentResourceWithProduct;
use App\Http\Resources\CommentUserResource;
use App\Models\Comment;
use App\Models\EventComment;
use App\Models\LauncherComment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ABS_Comment extends Controller
{

    private static $PER_PAGE = 4;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function abs_index(Model $model, Request $request, string $refreshRoute, string $backRoute)
    {
        
        $confirmed = $request->query('confirmed', null);
        $rate = $request->query('rate', null);
        $max = $request->query('max', null);
        $min = $request->query('min', null);

        $orderBy = $request->query('orderBy', null);
        $orderByType = $request->query('orderByType', null);

        $fromCreatedAt = $request->query('fromCreatedAt', null);
        $toCreatedAt = $request->query('toCreatedAt', null);

        $comments = [];

        if($confirmed == null)
            $comments = $model->comments();
        else if($confirmed)
            $comments = $model->comments()->confirmed();
        else
            $comments = $model->comments()->unConfirmed();

        if($rate != null && $rate)
            $comments = $comments->whereNotNull('rate');
        else if($rate != null && !$rate)
            $comments = $comments->whereNull('rate');

        if($max != null)
            $comments = $comments->where('rate', '<=', $max);

        if($min != null)
            $comments = $comments->where('rate', '>=', $min);


        if($fromCreatedAt != null)
            $comments =  $comments->whereDate('created_at', '>=', self::ShamsiToMilady($fromCreatedAt));
            
        if($toCreatedAt != null)
            $comments = $comments->whereDate('created_at', '<=', self::ShamsiToMilady($toCreatedAt));

        if($orderBy != null && 
            ($orderBy == 'created_at' || $orderBy == 'rate' || $orderBy == 'confirmed_at')
        ) {
            $orderByType = $orderByType == null || $orderByType == 'desc' || $orderByType != 'asc' ? 'desc' : 'asc';
            $comments->orderBy($orderBy, $orderByType);
        }

        $tmp = $comments->paginate(20);

        return view('admin.product.comments.list', [
            'items' => CommentDigest::collection($tmp)->toArray($request),
            'confirmedFilter' => $confirmed,
            'rateFilter' => $rate,
            'maxFilter' => $max,
            'minFilter' => $min,
            'orderByType' => $orderByType,
            'orderBy' => $orderBy,
            'total_count' => $tmp->count(),
            'itemId' => $model->id,
            'itemName' => $model->name,
            'fromCreatedAtFilter' => $fromCreatedAt,
            'toCreatedAtFilter' => $toCreatedAt,
            'refreshRoute' => $refreshRoute,
            'backRoute' => $backRoute
        ]);
    }



    public function getMyComments(Request $request) {
        
        $comments = commentResourceWithProduct::collection
        (
            Comment::where('user_id', $request->user()->id)->whereNotNull('msg')->get()
        )->toArray($request);

        return response()->json([
            'status' => 'ok',
            'data' => $comments
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function abs_list(Model $model, Request $request)
    {
        $page = $request->query('page', 1);

        $comments = $model->comments()->confirmed();

        $orderBy = $request->query('orderBy', null);
        $orderBy = $orderBy != null && $orderBy == 'rate' ? 'rate' : 'created_at';

        $orderByType = $request->query('orderType', null);
        $orderByType = $orderByType != null && $orderByType === 'asc' ? 'asc' : 'desc';
        
        return response()->json([
            'status' => 'ok',
            'data' => CommentUserResource::collection(
                $comments->orderBy($orderBy, $orderByType)
                ->skip(($page - 1) * self::$PER_PAGE)->take(self::$PER_PAGE)
                ->get())
                ->toArray($request)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function abs_store(Model $model, Request $request, $commentModel, $foreign_column)
    {
        // if(!$model->visibility)
        //     abort(401);

        $validator = [
            'msg' => 'required_without_all:is_bookmark,rate|string|min:2',
            'rate' => 'required_without_all:msg,is_bookmark|integer|min:1|max:5',
            'is_bookmark' => 'required_without_all:msg,rate|boolean',
            'negative' => 'nullable|array|min:1',
            'positive' => 'nullable|array|min:1',
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $user = $request->user();
        $request->validate($validator, self::$COMMON_ERRS);

        $comment = $commentModel::userComment($model->id, $user->id);
        $needUpdateTable = false;
        $needToConfirm = false;

        if($comment == null) {
            $comment = new $commentModel();
            $comment[$foreign_column] = $model->id;
            $comment->user_id = $user->id;
            $comment->status = false;
            $needToConfirm = true;

            if($request->has('rate')) {
                $model->rate = round(($model->rate * $model->rate_count + $request['rate']) / ($model->rate_count + 1), 2);
                $model->rate_count = $model->rate_count + 1;
                $needUpdateTable = true;
            }
            if($request->has('msg')) {
                $model->comment_count = $model->comment_count + 1;
                $needUpdateTable = true;
            }
        }

        if($request->has('msg')) {

            $comment->msg = $request['msg'];

            if($request->has('negative'))
                $comment->negative = implode('$$$___$$$', $request['negative']);

            if($request->has('positive'))
                $comment->positive = implode('$$$___$$$', $request['positive']);

            if($comment->status) {
                $needToConfirm = true;
                $needUpdateTable = true;
            }

            $comment->status = false;
        }

        if($request->has('rate')) {
            
            if(!$needUpdateTable) {
                $model->rate = round(($model->rate * $model->rate_count - $comment->rate + $request['rate']) / $model->rate_count, 2);
                $needUpdateTable = true;
            }
            
            $comment->rate = $request['rate'];
        }

        if($request->has('is_bookmark'))
            $comment->is_bookmark = $request['is_bookmark'];
        
        $comment->save();

        if($needUpdateTable) {
            
            if($needToConfirm)
                $model->new_comment_count = $model->new_comment_count + 1;

            $model->save();
        }
            
        return response()->json(['status' => 'ok']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public static function abs_edit(Model $model, Request $request)
    {
        $backUrl = null;
        $updateUrl = null;

        if($model instanceof LauncherComment) {
            $backUrl = route('launcher.launcher_comment.index', ['launcher' => $model->launcher_id]);
            $updateUrl = route('launcher_comment.update', ['launcher_comment' => $model->id]);
        }
        else if($model instanceof EventComment) {
            $backUrl = route('event.event_comment.index', ['event' => $model->event_id]);
            $updateUrl = route('event_comment.update', ['event_comment' => $model->id]);
        }
        else if($model instanceof Comment) {
            $backUrl = route('product.comment.index', ['product' => $model->product_id]);
            $updateUrl = route('comment.update', ['comment' => $model->id]);
        }

        return view('admin.product.comments.edit', [
            'item' => CommentResource::make($model)->toArray($request),
            'backUrl' =>  $backUrl, 'updateUrl' => $updateUrl
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models  $model
     * @return \Illuminate\Http\Response
     */
    public static function abs_update(Request $request, Model $model)
    {
        if($request->has('rate') && $request['rate'] == 0)
            unset($request['rate']);

        $user = $request->user();
        $validator = [
            'msg' => 'required_without_all:rate|string|min:2',
            'rate' => 'required_without_all:msg|integer|min:0|max:5',
            'negative' => 'nullable|array|min:1',
            'positive' => 'nullable|array|min:1',
            'status' => Rule::requiredIf($user->level === User::$ADMIN_LEVEL || $user->level === User::$EDITOR_LEVEL),
        ];
     
        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $validator = Validator::make($request->all(), $validator, self::$COMMON_ERRS);
        if ($validator->fails())
            return Redirect::to($request->session()->previousUrl())->with(["errors" => $validator->messages()])->withInput();
        
        if($user->level != User::$ADMIN_LEVEL && 
            $user->level != User::$EDITOR_LEVEL && 
            $user->id != $model->user_id
        )
            abort(401);

        $isAdmin = $user->level == User::$ADMIN_LEVEL ||
            $user->level == User::$EDITOR_LEVEL;

        if(!$isAdmin && $request->has('status'))
            abort(401);

        $ref = null;
        if($model instanceof LauncherComment)
            $ref = $model->launcher;
        else if($model instanceof EventComment)
            $ref = $model->event;
        else if($model instanceof Comment)
            $ref = $model->product;

        $needUpdateTable = false;

        if(!$isAdmin && $model->status) {
            $model->status = false;
            $ref->new_comment_count += 1;
            $needUpdateTable = true;
        }

        if($isAdmin && $request['status'] != $model->status) {

            if($request['status']) {
                $ref->new_comment_count -= 1;
                $model->confirmed_at = Carbon::now();
            }
            else
                $ref->new_comment_count += 1;
                
            $needUpdateTable = true;
        }


        if($request->has('rate') && $request['rate'] != null && $request['rate'] != $ref->rate) {
            $ref->rate = round(($ref->rate * $ref->rate_count - $model->rate + $request['rate']) / ($ref->rate_count * 1.0), 2);
            $needUpdateTable = true;
        }
        else if(
            (!$request->has('rate') || $request['rate'] == null) && $ref->rate != null
        ) {
            $model->rate = null;
            $ref->rate = round(($ref->rate * $ref->rate_count - $model->rate) / (($ref->rate_count - 1) * 1.0), 2);
            $ref->rate_count -= 1;
            $needUpdateTable = true;
        }

        if($needUpdateTable)
            $ref->save();

        foreach($request->keys() as $key) {

            if($key == '_token')
                continue;
            
            if($key == 'positive')
                $model[$key] = implode('$$$___$$$', $request['positive']);
            else if($key === 'negative')
                $model[$key] = implode('$$$___$$$', $request['negative']);
            else
                $model[$key] = $request[$key];
        }

        $model->save();

        if($model instanceof Comment)
            return Redirect::route('product.comment.index', ['product' => $ref->id]);

        if($model instanceof LauncherComment)
            return Redirect::route('launcher.launcher_comment.index', ['launcher' => $ref->id]);
            
        if($model instanceof EventComment)
            return Redirect::route('event.event_comment.index', ['event' => $ref->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models  $model
     * @return \Illuminate\Http\Response
     */
    public static function abs_destroy(Model $model)
    {
        
        $ref = null;
        if($model instanceof LauncherComment)
            $ref = $model->launcher;
        if($model instanceof EventComment)
            $ref = $model->event;
        else if($model instanceof Comment)
            $ref = $model->product;

        if(!$model->status)
            $ref->new_comment_count -= 1;
        
        if($model->rate != null) {

            if($ref->rate_count == 1)
                $ref->rate = null;
            else
                $ref->rate = round(($ref->rate * $ref->rate_count - $model->rate) / (($ref->rate_count - 1) * 1.0), 2);
                
            $ref->rate_count -= 1;
        }

        $ref->comment_count -= 1;
        $ref->save();
        $model->delete();

        return response()->json(['status' => 'ok']);
    }
}
