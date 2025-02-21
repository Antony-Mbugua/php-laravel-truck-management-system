<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceTable extends Migration

{

    public function up()

    {

        Schema::create('maintenance', function (Blueprint $table) {

            $table->id();
            $table->foreignId('truck_id')->constrained()->onDelete('cascade');
            $table->date('maintenance_date');
            $table->text('description');
            $table->timestamps();

        });

    }


    public function down()

    {

        Schema::dropIfExists('maintenance');

    }

}