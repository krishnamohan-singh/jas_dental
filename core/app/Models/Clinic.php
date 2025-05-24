<?php

namespace App\Models;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clinic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location_id',
    ];

    protected $casts = [
        'serial_or_slot'    => 'object',
        'serial_or_slot1'    => 'object',
        'serial_or_slot2'    => 'object',
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
        return $this->belongsToMany(Doctor::class, 'clinic_doctor', 'clinic_id', 'doctor_id')
            ->withTimestamps();
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }




    // SCOPES

    public function scopeActive($query)
    {
        return $query->where('status', Status::ACTIVE);
    }
    public function scopeInactive($query)
    {
        return $query->where('status', Status::INACTIVE);
    }



    public function getStatusTextAttribute()
    {
        return $this->status ? 'Active' : 'Inactive';
    }
}
