<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function status(Request $request)
    {
        $request->validate([
            'attendee_id' => 'required|integer|exists:blc_attendees,id',
        ]);

        $user = auth()->user();
        $attendee_id = $request->input('attendee_id');

        // Check if payment exists
        if (Payment::where('payment_made_by', $attendee_id)->exists()) {
            return response()->json(['error' => 'Payment already exists for this attendee'], 400);
        }

        Payment::create([
            'payment_made_by'       => $attendee_id,
            'payment_confirmed_by'  => $user->id,
            'payment_confirmed_at'  => now(),
        ]);

        return response()->json(['message' => 'Payment status recorded successfully'], 201);
    }

    public function notification(Request $request)
    {
        $request->validate([
            'attendee_id' => 'required|integer|exists:blc_attendees,id',
        ]);

        $user = auth()->user();
        $attendee_id = $request->input('attendee_id');

        $payment = Payment::where('payment_made_by', $attendee_id)->first();

        if (!$payment) {
            return response()->json(['error' => 'No payment found for this attendee'], 404);
        }

        $payment->update([
            'confirmation_sent_by' => $user->id,
            'confirmation_sent_at' => now(),
        ]);

        return response()->json(['message' => 'Payment notification status updated successfully'], 200);
    }
}
