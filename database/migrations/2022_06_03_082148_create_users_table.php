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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->text('user_name')->nullable();
            $table->string('user_email');
            $table->longText('user_bio')->nullable();
            $table->string('user_password')->nullable();
            $table->string('user_status');
            $table->string('user_role');
            $table->string('user_tel')->nullable();
            $table->string('user_link')->nullable();
            $table->string('user_google')->nullable();
            $table->string('user_github')->nullable();
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
        Schema::dropIfExists('users');
    }
};
