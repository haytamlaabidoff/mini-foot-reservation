<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archived_payment_staff', function (Blueprint $table) {
            $table->id();

            $table->foreignId('staff_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('amount', 10, 2);

            $table->string('month');

            $table->timestamp('paid_at')->nullable();

            $table->timestamp('next_payment_at')->nullable();

            $table->foreignId('paid_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // ⭐ مهم: created_at + updated_at
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archived_payment_staff');
    }
};