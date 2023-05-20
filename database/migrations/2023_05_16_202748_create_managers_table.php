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
        Schema::create('managers', function (Blueprint $table) {
            $table->id();
            $table->string('firebase_uid')->unique();
            $table->string('displayName');
            $table->string('email')->unique();
            $table->string('password');
            // Super Manager is the one who accepts the manager's request to join the platform
            $table->enum('role', ['super_manager', 'manager'])->default('manager');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->boolean('is_active')->default(false); // This will be set to true when the manager has been verified by the super manager
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('managers');
    }
};
