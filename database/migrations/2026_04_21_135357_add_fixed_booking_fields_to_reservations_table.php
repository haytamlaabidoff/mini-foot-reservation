<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {

            // 📆 FIXE SYSTEM - months selected (ex: [1,2,3])

            // 📅 FIXE SYSTEM - specific dates selected (calendar)
            $table->json('selected_dates')->nullable()->after('selected_months');

            // 📆 YEAR of subscription

            // 🔗 group all FIXE reservations together
            $table->string('group_id')->nullable()->after('year');

        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {

            $table->dropColumn([
                'selected_months',
                'selected_dates',
                'year',
                'group_id'
            ]);

        });
    }
};