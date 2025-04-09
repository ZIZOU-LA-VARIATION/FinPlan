<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateInvestmentsTable extends Migration
{
    public function up()
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user'); // Référence à l'utilisateur
            $table->string('name');
            $table->decimal('amount', 15, 2); // Montant de l'investissement
            $table->enum('type',['stock','bond', 'mutual fund','cryptocurrency'])->default('stock');
            $table->date('investment_date');
            $table->enum('status',['on_hold', 'pending','paid','lost'])->default('on_hold');
            $table->decimal('current_value', 15, 2)->default(0); // Valeur actuelle de l'investissement
            $table->timestamps();

            // Ajoute une contrainte de clé étrangère pour id_user
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('investments');
    }
}
