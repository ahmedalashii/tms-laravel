<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTraineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainees', function (Blueprint $table) {
            $table->id();
            $table->string('firebase_uid')->unique();
            // nullable generated unique auth_id for each trainee by the manager after verifying the trainee's documents
            $table->string('auth_id')->nullable()->unique();
            $table->string('displayName');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('address')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainees');
    }
}
