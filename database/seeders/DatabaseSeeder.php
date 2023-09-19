<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\CoachSeeder;
use Database\Seeders\EmailSeeder;
use Database\Seeders\PlayerSeeder;
use Database\Seeders\ActivitySeeder;
use Database\Seeders\ComplaintSeeder;
use Database\Seeders\DailyValueSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(ActivitySeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(EmailSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(PlayerSeeder::class);
        $this->call(CoachSeeder::class);
        $this->call(DailyValueSeeder::class);
        $this->call(CoachRequestSeeder::class);
        $this->call(ComplaintSeeder::class);
    }
}
