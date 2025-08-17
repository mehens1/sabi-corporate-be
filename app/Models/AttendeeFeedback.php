<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendeeFeedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendee_id',
        'attendance_type',
        'attendance_objective',
        'interested_session',
        'attend_before',
        'want_to_volunteer',
        'will_you_recommend_someone',
        'suggest_speaker',
        'topic_you_want_us_to_discuss',
        'suggest_improvement_for_future_event',
    ];
}
