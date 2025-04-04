<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id(); // Clé primaire
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade'); // Clé étrangère vers users
            $table->string('name', 85); // Nom du compte
            $table->decimal('initial_balance', 15, 2); // Solde initial
            $table->decimal('current_balance', 15, 2)->nullable(); // Solde actuel
            $table->string('bank_name', 255); // Nom de la banque
            $table->enum('account_type', ['bank', 'micro_finance', 'emoney']); // Type de compte
            $table->timestamps(); // created_at et updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('accounts');
    }
};


