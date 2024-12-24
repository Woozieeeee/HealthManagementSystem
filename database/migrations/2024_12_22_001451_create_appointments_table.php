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
        Schema::create('appointments', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('referral_id')->index('fk_referral_id');
            $table->unsignedBigInteger('scheduled_by_user_id')->index('fk_scheduled_by_user_id');
            $table->unsignedBigInteger('patient_id')->index('fk_patient_id_appointments');
            $table->dateTime('appointment_date');
            $table->string('status', 50)->default('scheduled');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
