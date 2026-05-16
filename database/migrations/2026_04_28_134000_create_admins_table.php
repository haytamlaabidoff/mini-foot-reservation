<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();

            // 👇 relation with users
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            // 👇 admin level
            $table->string('level')->default('admin'); 
            // admin / superadmin

            // 👇 optional info
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};