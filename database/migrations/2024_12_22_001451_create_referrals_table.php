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
        Schema::create('referrals', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedBigInteger('patient_id')->index('fk_patient_id');
            $table->unsignedBigInteger('submitted_by_user_id')->index('fk_submitted_by_user_id');
            $table->unsignedBigInteger('approved_by_user_id')->nullable()->index('fk_approved_by_user_id');
            $table->integer('barangay_id')->index('fk_barangay_id');
            $table->integer('region_id')->index('fk_region_id');
            $table->string('status', 50)->default('pending');
            $table->text('description')->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
