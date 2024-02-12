<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all();
        DB::delete('delete from comments where 1');
        $users = User::all();

        foreach($products as $product) {

            $rates = 0;
            $rates_count = 0;
            $new_comments_count = 0;
            $comments_count = 0;

            for($i = 0; $i < random_int(10, 50); $i++) {

                $comment = Comment::factory()->make([
                    'user_id' => $users[$i]->id,
                    'product_id' => $product->id
                ]);

                if($comment->rate != null) {
                    $rates += $comment->rate;
                    $rates_count++;
                }

                if(!$comment->status)
                    $new_comments_count++;

                $comments_count++;
                $comment::create($comment->toArray());
            }
            
            $product->rate_count = $rates_count;
            $product->rate = round($rates / ($rates_count * 1.0), 2);
            $product->comment_count = $comments_count;
            $product->new_comment_count = $new_comments_count;
            $product->save();

        }

    }
}
