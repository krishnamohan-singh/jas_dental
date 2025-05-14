<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicDepartmentDoctor extends Model
{
    protected $table = 'clinic_department_doctor';

    protected $fillable = [
        'clinic_id',
        'department_id',
        'doctor_id',
    ];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}