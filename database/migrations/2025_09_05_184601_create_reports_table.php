<?php

use App\Enums\ApetitieEnum;
use App\Enums\HealthEnum;
use App\Enums\MoodEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('apetitie')->default(ApetitieEnum::GOOD)->nullable();
            $table->string('mood')->default(MoodEnum::NORMAL)->nullable();
            $table->string('health')->default(HealthEnum::GOOD)->nullable();
            $table->decimal('sleep_rate')->nullable();
            $table->string('take_shower')->in_array(['yes', 'no'])->default('no');
            $table->foreignId('eldery_id')->constrained('elderly_people')->cascadeOnDelete();
            $table->foreignId('caregiver_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
