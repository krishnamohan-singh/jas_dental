<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clinic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location_id',
    ];

    // Relationships

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }
    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'clinic_doctor');
    }
}
