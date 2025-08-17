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
        Schema::table('attendee_feedback', function (Blueprint $table) {
            $table->string('suggest_speaker')->nullable()->after('topic_you_want_us_to_discuss');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendee_feedback', function (Blueprint $table) {
            $table->dropColumn('suggest_speaker');
        });
    }
};
