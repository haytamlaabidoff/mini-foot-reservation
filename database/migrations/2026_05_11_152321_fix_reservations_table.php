<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::table('reservations', function (Blueprint $table) {

        if (!Schema::hasColumn('reservations', 'date')) {
            $table->date('date')->nullable();
        }

        if (!Schema::hasColumn('reservations', 'start_time')) {
            $table->time('start_time')->nullable();
        }

        if (!Schema::hasColumn('reservations', 'end_time')) {
            $table->time('end_time')->nullable();
        }

        if (!Schema::hasColumn('reservations', 'status')) {
            $table->string('status')->default('confirmed');
        }

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
