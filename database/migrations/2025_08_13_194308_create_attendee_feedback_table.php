<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendee_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendee_id')->constrained('blc_attendees')->onDelete('cascade');
            $table->enum('attendance_type', ['onsite', 'online']);
            $table->string('attendance_objective');
            $table->string('interested_session');
            $table->boolean('attend_before');
            $table->enum('want_to_volunteer', ['Yes', 'No', 'Not Sure']);
            $table->boolean('will_you_recommend_someone');
            $table->text('topic_you_want_us_to_discuss');
            $table->text('suggest_improvement_for_future_event');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendee_feedback');
    }
};
