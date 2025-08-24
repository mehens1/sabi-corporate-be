<?php

namespace App\Models;

use App\Http\Controllers\BLCEventAttendees;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlcAttendee extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'state_and_town',
        'dob',
        'company_name',
        'logo',
        'image',
    ];

    public function attendance()
    {
        return $this->hasMany(BlcEventAttendance::class, 'attendee_id');
    }

    public function feedback()
    {
        return $this->hasMany(AttendeeFeedback::class, 'attendee_id');
    }

    public function marketing()
    {
        return $this->hasMany(AttendeeMarketingAndOutreach::class, 'attendee_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'payment_made_by');
    }
}
