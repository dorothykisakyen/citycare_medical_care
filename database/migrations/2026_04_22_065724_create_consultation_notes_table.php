<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultation_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->unique()->constrained('appointments')->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete();
            $table->text('symptoms')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('prescription')->nullable();
            $table->text('treatment_notes')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultation_notes');
    }
};