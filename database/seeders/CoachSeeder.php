<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CoachSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('coaches')->insert( [[
        'name'            => "test6"        ,
        'roles_id'         => 2       ,
        'gender'           =>  "male"     ,
        'weight'            => 50     ,
        'height'            =>  150     ,   
        'birth_date'        => "2002-2-4"      ,
        'password'           => Hash::make("123456"),   
        'phone_number'       => "5"     ,
        'email'              =>  "test6@gmail.com"   ,
        'is_freez'           => 0     ,
        'rate'               => 4     ,
        'is_active'          => 1     ,
        'wallet_balance'     =>  0    ,
        'experience_certificate' => "kjhgfcdghjklkjnhb" 
        ]
        ,[
            'name'            => "test41"        ,
            'roles_id'         => 2       ,
            'gender'           =>  "male"     ,
            'weight'            => 50     ,
            'height'            =>  150     ,   
            'birth_date'        => "2002-2-4"      ,
            'password'           => Hash::make("123456")    ,
            'phone_number'       => "6"     ,
            'email'              =>  "test41@gmail.com"   ,
            'is_freez'           => 0     ,
            'rate'               => 4     ,
            'is_active'          => 1     ,
            'wallet_balance'     =>  0    ,
            'experience_certificate' => "kjhgfcdghjklkjnhb"  ,
        ],
        [
            'name'            => "test7"        ,
            'roles_id'         => 2       ,
            'gender'           =>  "male"     ,
            'weight'            => 50     ,
            'height'            =>  150     ,   
            'birth_date'        => "2002-2-4"      ,
            'password'           => Hash::make("123456"),
            'phone_number'       => "7"     ,
            'email'              =>  "test7@gmail.com"   ,
            'is_freez'           => 1     ,
            'rate'               => 2     ,
            'is_active'          => 1     ,
            'wallet_balance'     =>  0    ,
            'experience_certificate' => "kjhgfcdghjklkjnhb"  ,
            ],
            [
                'name'            => "test8"        ,
                'roles_id'         => 2       ,
                'gender'           =>  "male"     ,
                'weight'            => 55    ,
                'height'            =>  155    ,   
                'birth_date'        => "2002-2-4"      ,
                'password'           => Hash::make("123456"),
                'phone_number'       => "8"     ,
                'email'              =>  "test8@gmail.com"   ,
                'is_freez'           => 0     ,
                'rate'               => 4     ,
                'is_active'          => 1     ,
                'wallet_balance'     =>  0    ,
                'experience_certificate' => "kjhgfcdghjklkjnhb"  ,
                ],
                [
                    'name'            => "test9"        ,
                    'roles_id'         => 2       ,
                    'gender'           =>  "male"     ,
                    'weight'            => 66    ,
                    'height'            =>  170     ,   
                    'birth_date'        => "2002-2-4"      ,
                    'password'           => Hash::make("123456"),
                    'phone_number'       => "9"     ,
                    'email'              =>  "test9@gmail.com"   ,
                    'is_freez'           => 0     ,
                    'rate'               => 4     ,
                    'is_active'          => 0     ,
                    'wallet_balance'     =>  0    ,
                    'experience_certificate' => "kjhgfcdghjklkjnhb"  ,
                    ],
                    [
                        'name'            => "test10"        ,
                        'roles_id'         => 2       ,
                        'gender'           =>  "male "    ,
                        'weight'            => 40    ,
                        'height'            =>  160     ,   
                        'birth_date'        => "2002-2-4"      ,
                        'password'           => Hash::make("123456"),
                        'phone_number'       => "10"     ,
                        'email'              =>  "test10@gmail.com"   ,
                        'is_freez'           => 1    ,
                        'rate'               => 4     ,
                        'is_active'          => 0     ,
                        'wallet_balance'     =>  0    ,
                        'experience_certificate' => "kjhgfcdghjklkjnhb"  ,
                        ], ]
    
    );
    }
}
