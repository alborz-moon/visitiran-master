<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        return $this->call([
            // BrandSeeder::class,
            // CategorySeeder::class,
            // SubCategorySeeder::class,
            // ProductSeeder::class,
            // UserSeeder::class,
            // ConfigSeeder::class,

            FacilitySeeder::class,
            EventTagSeeder::class,
            LauncherSeeder::class,
            EventSeeder::class
        ]);
    }
}
