<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sport_formats', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sport_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name'); // 5v5, 6v6...
            $table->integer('players_count'); // عدد اللاعبين

            $table->integer('duration')->default(60); // مدة المباراة

            $table->decimal('default_price', 10, 2)->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sport_formats');
    }
};