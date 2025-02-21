<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model

{

    use HasFactory;


    protected $fillable = [

        'truck_id',
        'maintenance_type',
        'scheduled_date',
        'completed_date',
        'notes',

    ];


    public function truck()

    {
        return $this->belongsTo(Truck::class);
    }

}
