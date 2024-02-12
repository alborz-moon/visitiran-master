<?php

namespace Database\Factories;

use App\Http\Controllers\Controller;
use App\Models\EventTag;
use App\Models\Facility;
use App\Models\Launcher;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $levels = ['national', 'state', 'local', 'pro'];
        $ages = ['child', 'teen', 'adult', 'all', 'old'];
        $languages = ['fr', 'fa', 'en', 'ar', 'tr'];

        $rand = random_int(10, 100);
        $rand2 = random_int(-2, 5);
        $rand3 = random_int(1, 5);
        $facilities = null;

        if($rand2 > 0) {
            $facilities = "";
            for($i = 0; $i < $rand2; $i++) {
                if($i == 0)
                    $facilities .= Facility::inRandomOrder()->first()->label;
                else
                    $facilities .= '_' . Facility::inRandomOrder()->first()->label;
            }
        }
        
        $tags = "";
        for($i = 0; $i < $rand3; $i++) {
            if($i == 0)
                $tags .= EventTag::inRandomOrder()->first()->label;
            else
                $tags .= '_' . EventTag::inRandomOrder()->first()->label;
        }

        $lanuncher = Launcher::inRandomOrder()->first();
        $off_rand = random_int(10, 100) % 2 == 0;

        $is_online = random_int(1, 100) > 30;
        $passed = random_int(1, 100) > 70;
        if($passed) {
            $start_registry = Carbon::now()->subDays(20)->timestamp;
            $end_registry = Carbon::now()->subDays(10)->timestamp;
        }
        else {
            $start_registry = Carbon::now()->addDays(50)->timestamp;
            $end_registry = Carbon::now()->addDays(70)->timestamp;
        }

        $langs_count = random_int(1, 4);
        $langs = [];

        for($i = 0; $i < $langs_count; $i++) {
            $l = $languages[random_int(0, 4)];
            while(array_search($l, $langs) !== false)
                $l = $languages[random_int(0, 4)];
            array_push($langs, $l);
        }
        

        return [
            'title' => $this->faker->name(),
            'start_registry' => $start_registry,
            'end_registry' => $end_registry,
            'price' => random_int(10, 50) * 10000,
            'facilities' => $facilities,
            'tags' => $tags,
            'ticket_description' => random_int(10, 1000) < 500 ? $this->faker->text() : null,
            'level_description' => $levels[random_int(0, 3)],
            'language' => implode('_', $langs),
            'age_description' => $ages[random_int(0, 4)],
            'description' => $this->faker->text(),
            'status' => random_int(1, 100) > 30 ? 'confirmed' : 'rejected',
            'capacity' => random_int(1, 30),
            'address' => $lanuncher->launcher_address,
            'email' => $lanuncher->launcher_email,
            'site' => $lanuncher->launcher_site,
            'phone' => $lanuncher->launcher_phone,
            'x' => $lanuncher->launcher_x,
            'y' => $lanuncher->launcher_y,
            'city_id' => $is_online ? $lanuncher->launcher_city_id : null,
            'link' => $is_online ? null : $this->faker->url(),
            'launcher_id' => $lanuncher->id,
            'is_in_top_list' => random_int(1, 30) < 15,
            'visibility' => random_int(1, 30) > 5,
            'priority' => random_int(1, 30),
            'off' => $off_rand ? random_int(10, 20) : null,
            'off_type' => 'percent',
            'off_expiration' => $off_rand ? '14020101' : null
        ];
    }
}
