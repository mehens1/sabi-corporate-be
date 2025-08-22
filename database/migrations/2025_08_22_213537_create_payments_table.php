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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Foreign keys referencing other tables (as unsignedBigInteger)
            $table->unsignedBigInteger('payment_made_by');
            $table->unsignedBigInteger('payment_confirmed_by')->nullable();
            $table->unsignedBigInteger('confirmation_sent_by')->nullable();

            // Foreign key constraints
            $table->foreign('payment_made_by')->references('id')->on('blc_attendees')->onDelete('cascade');
            $table->foreign('payment_confirmed_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('confirmation_sent_by')->references('id')->on('users')->onDelete('set null');

            // Timestamp columns for confirmation and sending confirmation (nullable)
            $table->timestamp('payment_confirmed_at')->nullable();
            $table->timestamp('confirmation_sent_at')->nullable();

            // Standard created_at and updated_at columns
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
