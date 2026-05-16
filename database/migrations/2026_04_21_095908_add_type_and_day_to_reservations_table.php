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
        $table->enum('type', ['simple', 'fixe'])->default('simple')->after('end_time');
        $table->integer('day_of_week')->nullable()->after('type');
    });
}

    /**
     * Reverse the migrations.
     */
  public function down()
{
    Schema::table('reservations', function (Blueprint $table) {
        $table->dropColumn(['type', 'day_of_week']);
    });
}
};
