<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_staff', function (Blueprint $table) {
            $table->id();

            // 👤 staff concerné
            $table->foreignId('staff_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // 💰 montant payé
            $table->decimal('amount', 10, 2);

            // 📅 mois du paiement
            $table->string('month'); // ex: 2026-04

            // 📊 statut
            $table->enum('status', ['paid', 'pending', 'unpaid'])
                  ->default('pending');

            // 🧑 admin qui a payé
            $table->foreignId('paid_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // 📅 date paiement
            $table->date('paid_at')->nullable();

                        $table->date('next_payment_at')->nullable();

            // 📝 note
            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_staff');
    }
};