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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Reference to users table
    
            // Identification & Licensing
            $table->string('license_number')->nullable();
            $table->string('license_class')->nullable();
            $table->date('license_expiry')->nullable();
            $table->string('driver_license')->nullable();
    
            // Personal Details
            $table->string('vehicle_type')->nullable();
            $table->date('dob')->nullable();
    
            // Employment Details
            $table->date('hiring_date')->nullable();
            $table->string('employment_status')->default('Active');
    
            // Compliance & Safety
            $table->date('medical_card_expiry')->nullable();
            $table->boolean('hazmat_certified')->default(false);
            $table->integer('violation_count')->default(0);
            $table->integer('accident_count')->default(0);
    
            // Payroll
            $table->decimal('total_earnings', 10, 2)->default(0.00);
            $table->decimal('insurance_fee', 10, 2)->default(0.00);
    
            $table->timestamps();
        });
    
        // Insert sample data directly in the migration
        DB::table('drivers')->insert([
            [
                'user_id' => 1, // Ensure you have a user with this ID
                'license_number' => 'ABC12345',
                'license_class' => 'A',
                'license_expiry' => now()->addYear(),
                'driver_license' => '123456789',
                'vehicle_type' => 'Truck',
                'dob' => '1985-06-15',
                'hiring_date' => now()->subYear(),
                'employment_status' => 'Active',
                'medical_card_expiry' => now()->addYear(),
                'hazmat_certified' => true,
                'violation_count' => 0,
                'accident_count' => 1,
                'total_earnings' => 50000.00,
                'insurance_fee' => 6000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
    
};
