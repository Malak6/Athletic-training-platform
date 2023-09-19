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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('roles_id');
            $table->foreignId('physical_activities_id');
            $table->integer('wallet_balance');
            $table->string('name' , 20);
            $table->string('gender');
            $table->mediumInteger('height');
            $table->mediumInteger('weight');
            $table->date('birth_date');
            $table->string('phone_number')->unique();
            $table->text('disease')->nullable();
            $table->string('password');
            $table->string('email')->unique();
            $table->boolean('is_freez');
            $table->boolean('is_verified');
            $table->rememberToken()->nullable();
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
        Schema::dropIfExists('players');
    }
};
