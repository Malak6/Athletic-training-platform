<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_values', function (Blueprint $table) {
            $table->id();
            $table->integer('valueable_id');
            $table->string('valueable_type');
            $table->integer('daily_water_need');
            $table->integer('daily_water_intake');
            $table->integer('daily_calorie_need');
            $table->integer('daily_calorie_intake');
            $table->integer('daily_carb_need');
            $table->integer('daily_carb_intake');
            $table->integer('daily_protein_need');
            $table->integer('daily_protein_intake');
            $table->integer('daily_fat_need');
            $table->integer('daily_fat_intake');
            $table->integer('daily_fibers_need');
            $table->integer('daily_fibers_intake');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_values');
    }
};
