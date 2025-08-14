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
        Schema::create('blc_event_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendee_id')->constrained('blc_attendees')->onDelete('cascade');
            $table->year('event_year');
            $table->unique(['attendee_id', 'event_year']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blc_event_attendances');
    }
};
