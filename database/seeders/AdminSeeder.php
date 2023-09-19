<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('admins')->insert([
            ['name' => 'test' , 'roles_id'=> 3 , 'email' => 'test@gmail.com' , 'password' => '123456'],
            ['name' => 'test1' , 'roles_id'=> 3 , 'email' => 'test11@gmail.com' , 'password' => '123456'],
        ]);
    }
}
