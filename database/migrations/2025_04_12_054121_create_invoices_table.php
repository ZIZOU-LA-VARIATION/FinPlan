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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->unsignedBigInteger('id_user'); // Clé étrangère vers users
            $table->unsignedBigInteger('id_activity'); // Clé étrangère vers activities
            $table->string('title');
            $table->decimal('amount', 10, 2);
            $table->date('due_date');
            $table->enum('status',['unpaid','paid'])->default('unpaid'); // unpaid, paid, late
            $table->text('description')->nullable();
            $table->timestamps();

            // Définition des clés étrangères
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_activity')->references('id')->on('activities')->onDelete('cascade');
});
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
