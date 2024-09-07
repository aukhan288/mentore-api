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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // Primary key, auto-incrementing ID
            $table->unsignedBigInteger('wallet_id'); // Foreign key for wallets
            $table->decimal('amount', 15, 2); // Transaction amount
            $table->string('transaction_type'); // Type of transaction (e.g., 'credit' or 'debit')
            $table->text('description')->nullable(); // Optional description of the transaction
            $table->timestamps(); // Created at and updated at timestamps

            // Define foreign key constraint
            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
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
