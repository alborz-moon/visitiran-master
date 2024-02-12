<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $json = File::get("database/data/SeedingData.json");
        $categories = json_decode($json, true)['categories'];

        foreach($categories as $itr) {
            unset($itr['sub_categories']);
            Category::create($itr);
        }
    }
}
