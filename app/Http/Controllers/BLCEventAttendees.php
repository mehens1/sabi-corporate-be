<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BLCAttendee;
use App\Models\BLCEventAttendance;
use App\Models\AttendeeFeedback;
use App\Models\AttendeeMarketingAndOutreach;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\CloudinaryService;

class BLCEventAttendees extends Controller
{
    public function index()
    {
        $allAttendees = BLCAttendee::with(['attendance', 'feedback', 'marketing'])->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Attendee fetched successfully',
            'data' => $allAttendees,
        ], 200);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            // Attendee table
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'state_and_town' => 'required|string|max:255',
            'dob' => 'required|date',
            'company_name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',

            // Feedback table
            'attendance_type' => 'required|in:onsite,online',
            'attendance_objective' => 'required|string',
            'interested_session' => 'required|string',
            'attend_before' => 'required|boolean',
            'want_to_volunteer' => 'required|in:Yes,No,Not Sure',
            'will_you_recommend_someone' => 'required|boolean',
            'topic_you_want_us_to_discuss' => 'required|string',
            'suggets_speaker' => 'required|string',
            'suggest_improvement' => 'required|string',

            // Marketing table
            'how_did_you_hear_about_us' => 'required|string',
            'interest_in_sponsorship' => 'required|in:Yes,No,Maybe',
            'preferred_social_media' => 'required|string',
            'preferred_means_of_communication' => 'required|string',
        ]);

        $currentYear = Carbon::now()->year;

        try {
            DB::beginTransaction();
            $attendee = BLCAttendee::where('email', $validated['email'])
                ->orWhere('phone', $validated['phone'])
                ->first();

            if ($attendee) {
                $alreadyAttended = BLCEventAttendance::where('attendee_id', $attendee->id)
                    ->where('event_year', $currentYear)
                    ->exists();

                if ($alreadyAttended) {
                    return response()->json([
                        'status' => false,
                        'message' => 'You have already registered for this year\'s BLC event.'
                    ], 409);
                }
            } else {


                if ($request->hasFile('image') && $request->file('image')->isValid()) {
                    $validated['image'] = CloudinaryService::upload($request->file('image'), 'blc/attendees/users');
                }

                if ($request->hasFile('logo')) {
                    $validated['logo'] = CloudinaryService::upload($request->file('logo'), 'blc/attendees/logos');
                }


                $attendee = BLCAttendee::create([
                    'firstname' => $validated['firstname'],
                    'lastname' => $validated['lastname'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'state_and_town' => $validated['state_and_town'],
                    'dob' => $validated['dob'],
                    'company_name' => $validated['company_name'] ?? null,
                    'logo' => $validated['logo'] ?? null,
                    'image' => $validated['image'] ?? null,
                ]);
            }

            BLCEventAttendance::create([
                'attendee_id' => $attendee->id,
                'event_year' => $currentYear,
            ]);

            AttendeeFeedback::create([
                'attendee_id' => $attendee->id,
                'attendance_type' => $validated['attendance_type'],
                'attendance_objective' => $validated['attendance_objective'],
                'interested_session' => $validated['interested_session'],
                'attend_before' => $validated['attend_before'],
                'want_to_volunteer' => $validated['want_to_volunteer'],
                'will_you_recommend_someone' => $validated['will_you_recommend_someone'],
                'topic_you_want_us_to_discuss' => $validated['topic_you_want_us_to_discuss'],
                'suggest_improvement_for_future_event' => $validated['suggest_improvement_for_future_event'],
            ]);

            AttendeeMarketingAndOutreach::create([
                'attendee_id' => $attendee->id,
                'how_did_you_hear_about_us' => $validated['how_did_you_hear_about_us'],
                'interest_in_sponsorship' => $validated['interest_in_sponsorship'],
                'preferred_social_media' => $validated['preferred_social_media'],
                'preferred_means_of_communication' => $validated['preferred_means_of_communication'],
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Registration successful! Your details have been saved.',
                'data' => $attendee->load(['attendance', 'feedback', 'marketing'])
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error saving attendee: ' . $th->getMessage(), ['trace' => $th->getTraceAsString()]);

            return response()->json([
                'status' => false,
                'message' => 'Failed to save attendee data: ' . $th->getMessage()

            ], 500);
        }
    }
}
