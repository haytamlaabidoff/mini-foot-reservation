<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {

            $table->enum('whatsapp_status', ['pending', 'sent', 'failed'])
                ->default('pending')
                ->after('payment_status');

            $table->timestamp('whatsapp_sent_at')
                ->nullable()
                ->after('whatsapp_status');
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['whatsapp_status', 'whatsapp_sent_at']);
        });
    }
};