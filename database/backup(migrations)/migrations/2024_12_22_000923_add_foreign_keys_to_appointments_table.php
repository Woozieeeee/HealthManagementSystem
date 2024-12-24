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
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreign(['patient_id'], 'fk_patient_id_appointments')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['referral_id'], 'fk_referral_id')->references(['id'])->on('referrals')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['scheduled_by_user_id'], 'fk_scheduled_by_user_id')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign('fk_patient_id_appointments');
            $table->dropForeign('fk_referral_id');
            $table->dropForeign('fk_scheduled_by_user_id');
        });
    }
};
