<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrucksTable extends Migration
{
    public function up()
    {
        Schema::create('trucks', function (Blueprint $table) {
            $table->id();   
            $table->string('license_plate')->unique();   
            $table->string('model');   
            $table->string('manufacturer');    
            $table->integer('year');   
            $table->string('photo')->nullable(); // Use string for photo path
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trucks');
    }
}