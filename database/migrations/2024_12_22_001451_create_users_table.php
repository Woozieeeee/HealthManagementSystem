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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->index('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->foreignId('barangay_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('regional_id')->nullable()->constrained()->onDelete('set null');
            $table->string('verification_token', 40);
            $table->dateTime('email_verified_at')->nullable();
            $table->softDeletes();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->primary(['id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Scheme::table('users', function (Blueprint $table){
        $table->dropSoftDeletes();
        });
    }
};
