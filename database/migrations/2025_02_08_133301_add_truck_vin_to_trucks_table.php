<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('trucks', function (Blueprint $table) {
            if (!Schema::hasColumn('trucks', 'truck_vin')) {
                $table->string('truck_vin')->nullable()->after('id'); // Allow null first
            }
        });
    
        // Ensure all truck_vin values are unique before adding constraint
        DB::statement("UPDATE trucks SET truck_vin = CONCAT('TEMP-', id) WHERE truck_vin IS NULL OR truck_vin = ''");
    
        Schema::table('trucks', function (Blueprint $table) {
            $table->string('truck_vin')->unique()->change(); // Now enforce uniqueness
        });
    }
    
    public function down()
    {
        Schema::table('trucks', function (Blueprint $table) {
            $table->dropUnique('trucks_truck_vin_unique');
            $table->dropColumn('truck_vin');
        });
    }
    
    
};
