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
        Schema::create('program_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('players_id');
            $table->foreignId('coaches_id');
            $table->string('note');
            $table->integer('payment');
            $table->boolean('is_accepted');
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
        Schema::dropIfExists('program_requests');
    }
};
