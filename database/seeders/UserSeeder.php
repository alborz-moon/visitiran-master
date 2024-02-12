<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(
            [
                'phone' => '09121111111'
            ],
            [
                'first_name' => 'admin',
                'last_name' => 'admin',
                'phone' => '09121111111',
                'password' => Hash::make("123456"),
                'level' => User::$ADMIN_LEVEL,
                'status' => User::$ACTIVE
            ]
        );

        User::firstOrCreate(
            [
                'phone' => '09121234567'
            ],
            [
                'first_name' => 'admin2',
                'last_name' => 'admin2',
                'phone' => '09121234567',
                'password' => Hash::make("123456"),
                'level' => User::$ADMIN_LEVEL,
                'access' => User::$ACCESS_EVENT,
                'status' => User::$ACTIVE
            ]
        );
        
        User::firstOrCreate(
            [
                'phone' => '09127654321'
            ],
            [
                'first_name' => 'admin3',
                'last_name' => 'admin3',
                'phone' => '09127654321',
                'password' => Hash::make("123456"),
                'level' => User::$ADMIN_LEVEL,
                'access' => User::$ACCESS_SHOP,
                'status' => User::$ACTIVE
            ]
        );
        
        User::firstOrCreate(
            [
                'phone' => '09211234567'
            ],
            [
            'first_name' => 'editor',
            'last_name' => 'editor',
            'phone' => '09211234567',
            'password' => Hash::make("123456"),
            'level' => User::$EDITOR_LEVEL,
            'access' => User::$ACCESS_BOTH,
            'status' => User::$ACTIVE
            ]
        );
        
        User::firstOrCreate(
            [
                'phone' => '09131234567'
            ],
            [
                'first_name' => 'finance',
                'last_name' => 'finance',
                'phone' => '09131234567',
                'password' => Hash::make("123456"),
                'level' => User::$FINANCE_LEVEL,
                'access' => User::$ACCESS_BOTH,
                'status' => User::$ACTIVE
            ]
        );
        
        User::firstOrCreate(
            [
                'phone' => '09141234567'
            ],
            [
                'first_name' => 'report',
                'last_name' => 'report',
                'phone' => '09141234567',
                'password' => Hash::make("123456"),
                'level' => User::$REPORT_LEVEL,
                'access' => User::$ACCESS_BOTH,
                'status' => User::$ACTIVE
            ]
        );
        
        User::firstOrCreate(
            [
                'phone' => '09122222222'
            ],
            [
            'first_name' => 'user',
            'last_name' => 'user',
            'phone' => '09122222222',
            'password' => Hash::make("123456"),
            'level' => User::$USER_LEVEL,
            'status' => User::$ACTIVE
            ],
        );
        
        User::firstOrCreate(
            [
                'phone' => '09212222222'
            ],
            [
                'first_name' => 'user',
                'last_name' => 'blocked',
                'phone' => '09212222222',
                'password' => Hash::make("123456"),
                'level' => User::$USER_LEVEL,
                'status' => User::$NOT_ACTIVATE
            ]
        );

        for($i = 0; $i < 100; $i++) {

            User::firstOrCreate(
                [
                    'phone' => $i < 10 ? '0912333330' . $i : '091233333' . $i
                ],
                [
                'first_name' => 'user ' . $i,
                'last_name' => 'user ' . $i,
                'phone' => $i < 10 ? '0912333330' . $i : '091233333' . $i,
                'password' => Hash::make("123456"),
                'level' => User::$USER_LEVEL,
                'status' => User::$ACTIVE
                ]
            );
        }

    }
}
