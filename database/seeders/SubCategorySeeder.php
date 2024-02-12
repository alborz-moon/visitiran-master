<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubCategoryFeatures;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class SubCategorySeeder extends Seeder
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
            $subCategories = $itr['sub_categories'];
            $cat = Category::where('name', '=', $itr['name'])->first();
            foreach($subCategories as $subCategory) {
                
                $subCategory['category_id'] = $cat->id;
                $features = $subCategory['features'];

                unset($subCategory['products']);
                unset($subCategory['features']);
                
                $subCategory = SubCategory::create($subCategory);
                
                foreach($features as $feature) {
                    SubCategoryFeatures::create([
                        'name' => $feature,
                        'sub_category_id' => $subCategory->id
                    ]);
                }
            }
        }

    }
}
