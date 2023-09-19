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
        Schema::create('coaches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('roles_id');
            $table->integer('wallet_balance');
            $table->string('name' , 20);
            $table->string('gender');
            $table->mediumInteger('height');
            $table->mediumInteger('weight');
            $table->string('experience_certificate');
            $table->date('birth_date');
            $table->string('phone_number')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('rate')->min(1)->max(5);
            $table->boolean('is_freez');
            $table->boolean('is_active');
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
        Schema::dropIfExists('coaches');
    }
};
