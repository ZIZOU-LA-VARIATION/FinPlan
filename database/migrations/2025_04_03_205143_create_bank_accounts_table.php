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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id('id_bk');
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->string('name', 85);
            $table->decimal('initial_balance', 10, 2);
            $table->decimal('current_balance', 10, 2);
            $table->string('bank_name', 255);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
