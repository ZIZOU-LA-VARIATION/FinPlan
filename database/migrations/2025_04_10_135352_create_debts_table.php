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
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('creditor'); // Nom du créancier
            $table->decimal('amount', 15, 2); // Montant de la dette
            $table->decimal('remaining_amount', 15, 2)->default(0); // Montant restant à rembourser

            $table->date('loan_date'); // Date de contraction de la dette
            $table->date('due_date'); // Date limite de remboursement
            $table->enum('status', ['unpaid', 'partially_paid', 'paid'])->default('unpaid');

            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debts');
    }
};
