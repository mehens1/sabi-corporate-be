<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlcEventAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendee_id',
        'event_year',
    ];
}
