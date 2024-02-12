<?php

namespace Database\Seeders;

use App\Models\Launcher;
use App\Models\User;
use Database\Factories\LauncherFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LauncherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $phones = [
            '09131111111', '09141111111', '09151111111', '09161111111'
        ];

        $NIDs = [
            '0019191919', '0019191920', '0019191921', '0019191922'
        ];

        for($i = 0; $i < 4; $i++) {
            $user = User::firstOrCreate(
                [
                    'phone' => $phones[$i],
                ], 
                [
                    'first_name' => 'launcher',
                    'last_name' => 'launcher',
                    'phone' => $phones[$i],
                    'password' => Hash::make("123456"),
                    'level' => User::$LAUNCHER_LEVEL,
                    'status' => User::$ACTIVE
                ]
            );

            Launcher::firstOrCreate(
                [
                    'user_id' => $user->id
                ],
                Launcher::factory()->make([
                    'user_id' => $user->id,
                    'user_NID' => $NIDs[$i]
                ])->toArray()
            );

        }
        
    }
}
