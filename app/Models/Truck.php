<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model

{

    use HasFactory;


    protected $fillable = [

        'truck_vin',
        'license_plate',
        'model',
        'manufacturer',
        'year',
        'photo', 

    ];

    public function trips()

    {

        return $this->hasMany(Trip::class);

    }


    public function maintenance()

    {

        return $this->hasMany(Maintenance::class);

    }

}