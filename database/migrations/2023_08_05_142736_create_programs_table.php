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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('players_id');
            $table->foreignId('coaches_id');
            $table->text('first_day');
            $table->text('second_day');
            $table->text('third_day');
            $table->text('fourth_day');
            $table->text('fifth_day');
            $table->text('sixth_day');
            $table->text('seventh_day');
            $table->text('notes');
            $table->date('end_date');
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
        Schema::dropIfExists('programs');
    }
};
