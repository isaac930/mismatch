<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('email');
            $table->string('contact');
            $table->Integer('age');
            $table->text('location');
            $table->text('place_of_birth');
            $table->string('occupation');
            $table->string('likes');
            $table->string('dislikes');
            $table->string('gender');
            $table->string('searching_status');
            $table->text('image_path')->nullable();
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
        Schema::dropIfExists('profiles');
    }
}
