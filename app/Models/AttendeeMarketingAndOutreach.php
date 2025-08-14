<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendeeMarketingAndOutreach extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendee_id',
        'how_did_you_hear_about_us',
        'interest_in_sponsorship',
        'preferred_social_media',
        'preferred_means_of_communication',
    ];
}
