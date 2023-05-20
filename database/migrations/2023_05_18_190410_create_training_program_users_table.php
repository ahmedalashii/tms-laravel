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
        Schema::create('training_program_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('training_program_id');
            $table->foreign('training_program_id')->references('id')->on('training_programs')->onDelete('cascade');
            $table->unsignedBigInteger('trainee_id');
            $table->foreign('trainee_id')->references('id')->on('trainees')->onDelete('cascade');
            $table->unsignedBigInteger('advisor_id');
            $table->foreign('advisor_id')->references('id')->on('advisors')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_program_users');
    }
};
