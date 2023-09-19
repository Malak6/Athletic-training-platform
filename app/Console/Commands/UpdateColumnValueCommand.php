<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Player;
use Illuminate\Support\Facades\DB;

class UpdateColumnValueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::table('daily_values')->update([
        'daily_water_intake' =>  0    ,
        'daily_calorie_intake' => 0  ,
        'daily_carb_intake'  => 0   ,
        'daily_protein_intake'  => 0   ,
        'daily_fat_intake'   => 0    ,
        'daily_fibers_intake'  => 0   ,
        ]);
        
         return Command::SUCCESS;
    }
}
