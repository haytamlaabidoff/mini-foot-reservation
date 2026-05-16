<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {

            // 📅 mois sélectionnés (array JSON)
            $table->json('selected_months')->nullable()->after('type');

            // 📆 année de la réservation fixe
            $table->integer('year')->nullable()->after('selected_months');

        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {

            $table->dropColumn('selected_months');
            $table->dropColumn('year');

        });
    }
};