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
        Schema::table('referrals', function (Blueprint $table) {
            $table->foreign(['approved_by_user_id'], 'fk_approved_by_user_id')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('set null');
            $table->foreign(['barangay_id'], 'fk_barangay_id')->references(['id'])->on('barangays')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['patient_id'], 'fk_patient_id')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['region_id'], 'fk_region_id')->references(['id'])->on('regions')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['submitted_by_user_id'], 'fk_submitted_by_user_id')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('referrals', function (Blueprint $table) {
            $table->dropForeign('fk_approved_by_user_id');
            $table->dropForeign('fk_barangay_id');
            $table->dropForeign('fk_patient_id');
            $table->dropForeign('fk_region_id');
            $table->dropForeign('fk_submitted_by_user_id');
        });
    }
};
