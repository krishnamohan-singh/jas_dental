<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use App\Traits\UserNotify;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Doctor extends Authenticatable
{
    use GlobalStatus, UserNotify;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'ver_code_send_at'  => 'datetime',
        'serial_or_slot'    => 'object',
        'serial_or_slot1'    => 'object',
        'serial_or_slot2'    => 'object',
        'speciality'        => 'object',
    ];

    public function assistantDoctorTrack()
    {
        return $this->hasMany(AssistantDoctorTrack::class);
    }

    public function assistants()
    {
        return $this->hasMany(Assistant::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

     // A doctor belongs to a clinic
    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }


    public function deposits()
    {
        return $this->hasMany(Deposit::class)->where('status', '!=', Status::PAYMENT_INITIATE);
    }

    public function educationDetails()
    {
        return $this->hasMany(Education::class);
    }

    public function experienceDetails()
    {
        return $this->hasMany(Experience::class);
    }

    public function socialIcons()
    {
        return $this->hasMany(SocialIcon::class);
    }

   


    // SCOPES

    public function scopeActive($query)
    {
        return $query->where('status', Status::ACTIVE);
    }
    public function scopeInactive($query)
    {
        return$query->where('status', Status::INACTIVE);
    }


    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class);
    }

    
    public function statusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->status == Status::ACTIVE) {
                $html = '<span class="badge badge--success">' . trans("Active") . '</span>';
            } elseif ($this->status == Status::INACTIVE) {
                $html = '<span class="badge badge--danger">' . trans("Inactive") . '</span>';
            }
            return $html;
        });
    }

    public function featureBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->featured == Status::YES) {
                $html = '<span class="badge badge--success">' . trans("Featured") . '</span>';
            } elseif ($this->featured == Status::NO) {
                $html = '<span class="badge badge--warning">' . trans("Non Featured") . '</span>';
            }
            return $html;
        });
    }
}
