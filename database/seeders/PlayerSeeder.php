<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('players')->insert([
            ['name'                => "test1" ,
            'roles_id'             => 1 ,
            'physical_activities_id' => 2 ,
            'weight'                => 50,
            'height'                => 150,
            'gender'                => "female",
            'birth_date'            => "2001-8-8",
            'phone_number'          => "0",
            'disease'               => "null",
            'password'              => Hash::make("123456"),
            'email'                 => "test1@gmail.com",
            'is_freez'              => 0,
            'wallet_balance'        => 200,
            'is_verified'           => 1
            ] ,
            ['name'                => "test2" ,
            'roles_id'             => 1 ,
            'physical_activities_id' => 4 ,
            'weight'                => 70,
            'height'                => 150,
            'gender'                => "female",
            'birth_date'            => "2001-8-8",
            'phone_number'          => "1",
            'disease'               => "null",
            'password'              => Hash::make("123456"),
            'email'                 => "test2@gmail.com",
            'is_freez'              => 0,
            'wallet_balance'        => 100,
            'is_verified'           => 1
            ] ,
            ['name'                => "test3" ,
            'roles_id'             => 1 ,
            'physical_activities_id' => 1 ,
            'weight'                => 55,
            'height'                => 190,
            'gender'                => "male",
            'birth_date'            => "2001-8-8",
            'phone_number'          => "2",
            'disease'               => "null",
            'password'              => Hash::make("123456"),
            'email'                 => "test3@gmail.com",
            'is_freez'              => 0,
            'wallet_balance'        => 2,
            'is_verified'           => 1
        ],
            ['name'                => "test4" ,
            'roles_id'             => 1 ,
            'physical_activities_id' => 1 ,
            'weight'                => 55,
            'height'                => 190,
            'gender'                => "male",
            'birth_date'            => "2001-8-8",
            'phone_number'          => "3",
            'disease'               => "null",
            'password'              => Hash::make("123456"),
            'email'                 => "test4@gmail.com",
            'is_freez'              => 1,
            'wallet_balance'        => 10,
            'is_verified'           => 1
    ],
    [       'name'                => "test5" ,
            'roles_id'             => 1 ,
            'physical_activities_id' => 3 ,
            'weight'                => 55,
            'height'                => 180,
            'gender'                =>" male",
            'birth_date'            => "2001-8-8",
            'phone_number'          => "4",
            'disease'               => "null",
            'password'              => Hash::make("123456"),
            'email'                 => "test5@gmail.com",
            'is_freez'              => 0,
            'wallet_balance'        => 5,
            'is_verified'           => 0
    ],


        ]);
    }
}
