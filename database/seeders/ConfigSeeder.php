<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Config::firstOrCreate(
            [
                'site' => 'shop'
            ],[
            'can_pay_cash' => false,
            'desc_default' => null,
            'sell_list_period' => 7,
            'home_banner_limt' => 2,
            'detail_banner_limt' => 1,
            'list_banner_limt' => 1,
            'critical_point' => 5,
            'site' => 'shop',
        ]);
        
        Config::firstOrCreate(
            [
                'site' => 'event'
            ],[
            'can_pay_cash' => false,
            'desc_default' => null,
            'sell_list_period' => 7,
            'home_banner_limit' => 2,
            'detail_banner_limit' => 1,
            'list_banner_limit' => 1,
            'critical_point' => 5,
            'site' => 'event',
        ]);
    }
}
