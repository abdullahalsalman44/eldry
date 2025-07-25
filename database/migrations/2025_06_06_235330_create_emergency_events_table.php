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
        Schema::create('emergency_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('elderly_id')->nullable()->constrained('elderly_people')->onDelete('cascade');
            $table->foreignId('triggered_by')->constrained('users')->onDelete('cascade');
            $table->string('type');
            $table->text('description');
            $table->json('notified_roles');
            $table->dateTime('occurred_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_events');
    }
};
