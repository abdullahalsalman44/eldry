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
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('elderly_id')->constrained('elderly_people')->onDelete('cascade');
            $table->foreignId('caregiver_id')->constrained('users')->onDelete('cascade');
            $table->date('date');
            $table->enum('meal_type',['breakfast','lunch','dinner']);
            $table->enum('status',['pending','served','refused']);
            $table->dateTime('served_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};
