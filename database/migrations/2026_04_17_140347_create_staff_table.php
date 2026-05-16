<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('staff', function (Blueprint $table) {
    $table->id();

    $table->foreignId('user_id')->constrained()->cascadeOnDelete();

    $table->string('employee_code')->unique();
    $table->foreignId('department_id')
          ->nullable()
          ->constrained()
          ->nullOnDelete();

    $table->foreignId('post_id')
          ->nullable()
          ->constrained()
          ->nullOnDelete();

    $table->string('phone')->nullable();
    $table->string('cin')->nullable();
    $table->string('address')->nullable();

    $table->decimal('salary', 10, 2)->nullable();
    $table->date('hire_date')->nullable();

    $table->enum('status', ['active', 'inactive'])->default('active');

    $table->text('working_hours')->nullable(); // ou JSON
   

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};