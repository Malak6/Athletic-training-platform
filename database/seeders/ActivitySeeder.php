<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('physical_activities')->insert([
            ['name' => "Sedentary (little or no exercise)"  , 'factor'  => 30 ],
            ['name' => "Lightly active (light exercise or sports 1-3 days a week)"  , 'factor'  => 35 ],
            ['name' => "Moderately active (moderate exercise or sports 3-5 days a week)"  , 'factor'  => 40 ],
            ['name' => "Very active (hard exercise or sports 6-7 days a week)"  , 'factor'  => 45 ],
            ['name' => "Extra active (very hard exercise or sports, physical job or training twice a day)"  , 'factor'  => 50 ],
        ]);
    }
}
