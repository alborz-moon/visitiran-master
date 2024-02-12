<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/SeedingData.json");
        $brands = json_decode($json, true)['brands'];

        foreach($brands as $itr) {
            Brand::create([
                'name' => $itr
            ]);
        }
    }
}
