<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Similar;
use Illuminate\Console\Command;

class CalcSimilars extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:similars';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'calc similars of each product';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function calc_similarity($p1, $p2) {
        
        if($p1->rate === null)
            $p1->rate = 0;

        if($p2->rate === null)
            $p2->rate = 0;

        if($p1->guarantee === null)
            $p1->guarantee = 0;

        if($p2->guarantee === null)
            $p2->guarantee = 0;

        return [
            'rate' => abs($p1->rate - $p2->rate),
            'price' => abs($p1->price - $p2->price),
            'seller' => $p1->seller_id == $p2->seller_id ? 1 : 0,
            'brand' => $p1->brand_id == $p2->brand_id ? 1 : 0,
            'guarantee' => abs($p1->guarantee - $p2->guarantee),
        ];
    }

    private function norm($max, $min, $val) {

        if($max == $min)
            return 0;

        return ($val - $min) / ($max - $min);
    }


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $products = Product::select('id', 'rate', 'price', 'seller_id', 'category_id', 'brand_id', 'guarantee')->get();

        $max_g_diff = -1;
        $max_price_diff = -1;
        
        $min_g_diff = 100000000;
        $min_price_diff = 100000000;

        for($i = 0; $i < count($products); $i++) {

            $similarities = [];

            for($j = 0; $j < count($products); $j++) {

                if($i == $j || $products[$i]->category_id != $products[$j]->category_id)
                    continue;

                $sim = $this->calc_similarity($products[$i], $products[$j]);

                array_push($similarities, [
                    'dest_id' => $products[$j]->id, 
                    'diff' => $sim
                    ]
                );

                if($sim['price'] > $max_price_diff)
                    $max_price_diff = $sim['price'];

                if($sim['price'] < $min_price_diff)
                    $min_price_diff = $sim['price'];

                if($sim['guarantee'] > $max_g_diff)
                    $max_g_diff = $sim['guarantee'];

                if($sim['guarantee'] < $min_g_diff)
                    $min_g_diff = $sim['guarantee'];

            }

            $products[$i]->similarities = $similarities;
        }

        foreach($products as $product) {
            
            $arr = [];

            foreach($product->similarities as $similarity) {
                
                $sim = $similarity['diff'];

                $cost = 
                    $this->norm($max_g_diff, $min_g_diff, $sim['guarantee']) * 1 +
                    $this->norm($max_price_diff, $min_price_diff, $sim['price']) * 7 +
                    $sim['brand'] * 3 +
                    $sim['seller'] * 2 +
                    $this->norm(5, 0, $sim['rate']) * 3
                ;

                array_push($arr, [
                    'dest_id' => $similarity['dest_id'],
                    'cost' => $cost
                ]);
            }

            usort($arr, fn($a, $b) => strcmp($a['cost'], $b['cost']));
            Similar::where('product_id', $product->id)->delete();
            $s = new Similar();
            $s->product_id = $product->id;

            for($i = 0; $i < min(8, count($arr)); $i++)
                $s['sim_' . ($i + 1)] = $arr[$i]['dest_id'];
            
            $s->save();
        }
    }
}
