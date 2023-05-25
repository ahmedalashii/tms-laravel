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
        Schema::create('training_attendance_trainees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('training_attendance_id');
            $table->foreign('training_attendance_id')->references('id')->on('training_attendances')->onDelete('cascade');
            $table->unsignedBigInteger('trainee_id');
            $table->foreign('trainee_id')->references('id')->on('trainees')->onDelete('cascade');
            $table->date('attendance_date');
            $table->enum('attendance_status', ['absent', 'present', 'late', 'excused'])->default('absent');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_attendance_trainees');
    }
};
