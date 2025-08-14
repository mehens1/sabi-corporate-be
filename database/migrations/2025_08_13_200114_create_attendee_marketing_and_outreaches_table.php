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
        Schema::create('attendee_marketing_and_outreaches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendee_id')->constrained('blc_attendees')->onDelete('cascade');
            $table->string('how_did_you_hear_about_us');
            $table->enum('interest_in_sponsorship', ['Yes', 'No', 'Maybe']);
            $table->string('preferred_social_media');
            $table->string('preferred_means_of_communication');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendee_marketing_and_outreaches');
    }
};
