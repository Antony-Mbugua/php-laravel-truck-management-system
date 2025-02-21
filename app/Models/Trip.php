<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model

{

    use HasFactory;


    protected $fillable = [

        'truck_id',
        'driver_id',
        'trip_date',
        'status',

    ];


    public function truck()

    {

        return $this->belongsTo(Truck::class);

    }


    public function driver()

    {

        return $this->belongsTo(User::class, 'driver_id');

    }


    public function documents()

    {

        return $this->hasMany(Document::class);

    }

}
