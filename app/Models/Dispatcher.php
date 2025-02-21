<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Dispatcher extends Model
{
    protected $fillable = [
        'user_id',
        'dob',
        'license_number',
        'license_class',
        'license_expiry',
        'driver_license',
        'hiring_date',
        'employment_status',
        'medical_card_expiry',
        'hazmat_certified',
        'violation_count',
        'accident_count',
        'total_earnings',
        'insurance_fee',
        'availability',
    ]; 

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
