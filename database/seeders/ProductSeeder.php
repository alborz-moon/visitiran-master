<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductFeatures;
use App\Models\SubCategory;
use App\Models\SubCategoryFeatures;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProductSeeder extends Seeder
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
            foreach($itr['sub_categories'] as $subCategory) {
                $subCategoryId = SubCategory::where('name', '=', $subCategory['name'])->first()->id;
                foreach($subCategory['products'] as $product) {

                    $product['brand_id'] = Brand::where('name', '=', $product['brand'])->first()->id;
                    $features = $product['features'];

                    $product['sub_category_id'] = $subCategoryId;
                    unset($product['brand']);
                    unset($product['features']);
                    
                    $product = Product::create($product);

                    foreach($features as $feature) {
                        $subCategoryFeatureId = SubCategoryFeatures::where('name', '=', $feature['key'])->first()->id;
                        ProductFeatures::create([
                            'product_id' => $product->id,
                            'sub_category_feature_id' => $subCategoryFeatureId,
                            'value' => $feature['value'],
                        ]);
                    }
                }
            }
        }
    }
}
