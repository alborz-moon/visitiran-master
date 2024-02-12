<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $has_negative = random_int(10, 40) % 2 == 0;
        $negative = !$has_negative ? null : [];
        if($has_negative) {
            for($i = 0; $i < 2; $i++)
                array_push($negative, $this->faker->text(50));
        }

        if($negative != null && count($negative) == 0)
            $negative = null;

        $has_positive = random_int(10, 40) % 2 == 0;
        $positive = !$has_positive ? null : [];
        if($has_positive) {
            for($i = 0; $i < 3; $i++)
                array_push($positive, $this->faker->text(50));
            
        }

        if($positive != null && count($positive) == 0)
            $positive = null;
        
        $status = random_int(10, 40) % 2 == 0;

        return [
            'rate' => random_int(10, 40) % 2 == 0 ? random_int(1, 5) : null,
            'title' => $this->faker->name(),
            'msg' => $this->faker->text(),
            'negative' => $negative == null ? null : implode('$$$___$$$', $negative),
            'positive' => $positive == null ? null : implode('$$$___$$$', $positive),
            'is_bookmark' => random_int(10, 40) % 2 == 0,
            'status' => $status,
            'confirmed_at' => $status ? Carbon::now() : null
        ];
    }
}
