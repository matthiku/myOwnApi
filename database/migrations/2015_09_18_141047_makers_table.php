<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('makers', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('phone');
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
        // Truncated (delete) the data, but ignore primary and foreign key definitions
        // (otherwise we cannot delete records in the Makers table while vehicles still have a reference to it)
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('makers');
    }
}
