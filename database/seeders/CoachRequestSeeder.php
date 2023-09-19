<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CoachRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('coach_requests')->insert( [[
            'name'            => "test22"        ,
            'gender'           =>  "male"     ,
            'weight'            => 50     ,
            'height'            =>  150     ,   
            'birth_date'        => "2002-2-4"      ,
            'password'           => Hash::make("123456"),   
            'phone_number'       => "555555"     ,
            'email'              =>  "test22@gmail.com"   ,
            'is_accepted'  => 0,
            'is_verified' => 0 ,
            'experience_certificate' => "kjhgfcdghjklkjnhb" 
            ] ,[
                'name'            => "test23"        ,
                'gender'           =>  "male"     ,
                'weight'            => 50     ,
                'height'            =>  150     ,   
                'birth_date'        => "2002-2-4"      ,
                'password'           => Hash::make("123456"),   
                'phone_number'       => "6666"     ,
                'email'              => "test23@gmail.com"   ,
                'is_accepted'  => 0,
                'is_verified' => 1 ,
                'experience_certificate' => "kjhgfcdghjklkjnhb" 
            ],
            [
                'name'            => "test23"        ,
                'gender'           =>  "male"     ,
                'weight'            => 50     ,
                'height'            =>  150     ,   
                'birth_date'        => "2002-2-4"      ,
                'password'           => Hash::make("123456"),   
                'phone_number'       => "66667"     ,
                'email'              => "test42@gmail.com"   ,
                'is_accepted'  => 0,
                'is_verified' => 0 ,
                'experience_certificate' => "kjhgfcdghjklkjnhb" 
                ]]);

    }
}
