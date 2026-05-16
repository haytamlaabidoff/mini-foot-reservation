<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('terrains', function (Blueprint $table) {

            $table->foreignId('sport_format_id')
                ->nullable()
                ->after('name')
                ->constrained('sport_formats')
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('terrains', function (Blueprint $table) {

            $table->dropForeign(['sport_format_id']);
            $table->dropColumn('sport_format_id');

        });
    }
};