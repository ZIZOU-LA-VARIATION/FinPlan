<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// Database/Migrations/create_transactions_table.php

public function up()
{
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();  // Clé primaire
        $table->unsignedBigInteger('id_user');   // Clé étrangère vers la table 'users'
        $table->unsignedBigInteger('id_activity');   // Clé étrangère vers la table 'categories'
        $table->unsignedBigInteger('id_account');   // Clé étrangère vers la table 'bank_accounts'
        $table->date('date');  // Date de la transaction
        $table->decimal('amount', 10, 2);  // Montant de la transaction
        $table->enum('type', ['income', 'expense']);  // Type de la transaction : "income" ou "expense"
        $table->text('description')->nullable();  // Description de la transaction
        $table->timestamps();

        // Définition des clés étrangères
        $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('id_activity')->references('id')->on('activities')->onDelete('cascade');
        $table->foreign('id_account')->references('id')->on('accounts')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
