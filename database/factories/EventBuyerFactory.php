<?php

namespace Database\Factories;

use App\Models\EventBuyer;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventBuyerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->text(10),
            'last_name' => $this->faker->text(10),
            'nid' => '0018914373',
            'phone' => '092123' . $this->faker->numberBetween(11111, 99999),
            'unit_price' => 4000000,
            'count' => $this->faker->numberBetween(1, 10),
            'status' => EventBuyer::$PAID
        ];
    }
}
