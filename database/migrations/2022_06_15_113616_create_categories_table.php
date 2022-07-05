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
        Schema::create('categories', function (Blueprint $table) {
            $table->id('c_id');
            $table->string('c_parent')->nullable();
            $table->string('c_name');
            $table->string('c_slug');
            $table->string('c_status');
            $table->string('c_decription')->nullable();
            $table->string('c_image')->nullable();
            $table->string('c_order')->nullable();
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
        Schema::dropIfExists('categories');
    }
};
