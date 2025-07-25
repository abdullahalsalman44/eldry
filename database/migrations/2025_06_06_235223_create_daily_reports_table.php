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
        Schema::create('daily_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('elderly_id')->constrained('elderly_people')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('mood',['good','average','poor']);
            $table->enum('sleep_quality',['good','average','poor']);
            $table->enum('appetite',['good','average','poor']);
            $table->text('vital_signs');
            $table->text('notes')->nullable();
            $table->date('report_date');
            $table->unique(['elderly_id', 'report_date']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_reports');
    }
};
