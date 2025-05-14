<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded = ['id'];

    // Relationship: A department has many doctors
    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    // New Relationship: A department belongs to a clinic
    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
}
