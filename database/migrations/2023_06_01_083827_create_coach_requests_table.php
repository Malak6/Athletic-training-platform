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
        Schema::create('coach_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name' , 20);
            $table->string('gender');
            $table->mediumInteger('height');
            $table->mediumInteger('weight');
            $table->string('experience_certificate');
            $table->date('birth_date');
            $table->string('phone_number')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_accepted');
            $table->boolean('is_verified');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coach_requests');
    }
};
