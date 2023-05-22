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
        Schema::create('training_programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string("thumbnail")->nullable();
            $table->unsignedBigInteger('discipline_id');
            $table->foreign('discipline_id')->references('id')->on('disciplines')->onDelete('cascade');
            $table->integer('duration');
            $table->enum('duration_unit', ['days', 'weeks', 'months', 'years'])->default('days');
            $table->string('location')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('fees')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_programs');
    }
};
