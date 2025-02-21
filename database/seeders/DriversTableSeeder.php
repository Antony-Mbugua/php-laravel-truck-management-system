<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Driver;
use App\Models\User;

class DriversTableSeeder extends Seeder
{
    public function run()
    {
        $user = User::first(); // Get any user

        if ($user) {
            Driver::create([
                'user_id' => $user->id,
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
            ]);
        }
    }
}
