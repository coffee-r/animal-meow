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
        Schema::create('twitter_users', function (Blueprint $table) {
            $table->string('twitter_id')->primary();
            $table->unsignedBigInteger('animal_meow_user_id');
            $table->string('nickname');
            $table->string('access_token');
            $table->timestamp('access_token_time_limit');
            $table->string('refresh_token');
            $table->timestamps();
            $table->foreign('animal_meow_user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('twitter_users');
    }
};
