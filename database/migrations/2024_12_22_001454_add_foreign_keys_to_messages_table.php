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
        Schema::table('messages', function (Blueprint $table) {
            $table->foreign(['receiver_id'], 'fk_messages_receiver')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['sender_id'], 'fk_messages_sender')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign('fk_messages_receiver');
            $table->dropForeign('fk_messages_sender');
        });
    }
};
