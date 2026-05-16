<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {

            $table->id();

            // relation terrain
            $table->foreignId('terrain_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->string('name');

            $table->integer('quantity')->default(1);

            $table->enum('condition', [
                'new',
                'good',
                'damaged',
                'broken'
            ])->default('good');

            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};