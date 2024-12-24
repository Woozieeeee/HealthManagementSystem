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
        Schema::create('registration_user', function (Blueprint $table) {
            $table->string('name');
            $table->string('email')->unique('email');
            $table->string('password');
            $table->string('barangay');
            $table->string('health_unit');
            $table->string('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_user');
    }
};
