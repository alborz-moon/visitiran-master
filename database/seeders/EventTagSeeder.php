<?php

namespace Database\Seeders;

use App\Models\EventTag;
use Illuminate\Database\Seeder;

class EventTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EventTag::factory(10)->create();
    }
}
