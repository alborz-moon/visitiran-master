<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\ABS_Comment;
use App\Http\Resources\commentResourceWithProduct;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class CommentController extends ABS_Comment
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product, Request $request)
    {
        return self::abs_index($product, $request, 
            route('product.comment.index', ['product' => $product->id]),
            route('product.index')
        );
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
    public function list(Product $product, Request $request)
    {
        return self::abs_list($product, $request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Product $product, Request $request)
    {
        return self::abs_store($product, $request, Comment::class, 'product_id');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment, Request $request)
    {
        return self::abs_edit($comment, $request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        return self::abs_update($request, $comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        return self::abs_destroy($comment);
    }
}
