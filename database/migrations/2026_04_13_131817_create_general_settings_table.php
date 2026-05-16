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
    Schema::create('general_settings', function (Blueprint $table) {
        $table->id();

        $table->string('site_name')->nullable(); // اسم terrain
        $table->string('logo')->nullable(); // logo
        $table->string('phone')->nullable(); // téléphone
        $table->string('email')->nullable(); // email
        $table->string('address')->nullable(); // adresse
        $table->string('city')->nullable(); // ville
        $table->longText('map_link')->nullable();

        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
