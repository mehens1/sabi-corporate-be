<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_made_by',
        'payment_confirmed_by',
        'confirmation_sent_by',
        'payment_confirmed_at',
        'confirmation_sent_at',
    ];
}
