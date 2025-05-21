<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ClinicDoctor extends Pivot
{
    protected $table = 'clinic_doctor';

    protected $fillable = [
        'clinic_id',
        'doctor_id',
    ];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}