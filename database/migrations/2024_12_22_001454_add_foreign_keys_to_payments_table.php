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
        Schema::table('payments', function (Blueprint $table) {
            $table->foreign(['referral_id'], 'fk_pay_referral_id')->references(['id'])->on('referrals')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['user_id'], 'fk_pay_users_id')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['user_id'], 'fk_pay_user_id')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign('fk_pay_referral_id');
            $table->dropForeign('fk_pay_users_id');
            $table->dropForeign('fk_pay_user_id');
        });
    }
};
