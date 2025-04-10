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
        Schema::create('financial_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // lien avec l'utilisateur
            $table->string('name');
            $table->decimal('target_amount', 15, 2); // Montant cible
            $table->decimal('current_amount', 15, 2)->default(0); // Montant actuel
            $table->date('deadline');
            $table->enum('status', ['in_progress', 'achieved', 'not_achieved'])->default('in_progress'); // Statut de l'objectif
            $table->timestamps();
        });
    }    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_goals');
    }
};
