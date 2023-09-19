<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('complaints')->insert([
           [ 'complaintable_id' => 1, 'complaintable_type' => "App\Models\Player" , "text" => "complaint1"] ,
           [ 'complaintable_id' => 2, 'complaintable_type' => "App\Models\Coach" , "text" => "complaint2"] ,
           [ 'complaintable_id' => 3, 'complaintable_type' => "App\Models\Player" , "text" => "complaint3"] ,
        ]);
    }
}
