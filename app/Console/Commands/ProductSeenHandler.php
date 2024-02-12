<?php

namespace App\Console\Commands;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSeen;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ProductSeenHandler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:seen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transfer product seen to backup table and reset';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $products = Product::select('id', 'seen')->get();
        $today = Controller::getToday()['date'];

        foreach($products as $product) {
            ProductSeen::create([
                'product_id' => $product->id,
                'seen' => $product->seen,
                'date' => $today
            ]);
        }

        DB::update('update products set seen = 0 where 1');
    }
}
