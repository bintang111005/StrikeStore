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
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('transaction_code')->unique();
            $table->decimal('amount', 14, 2);
            $table->enum('payment_method', [
                'bank_transfer',
                'e_wallet',
                'cod',
                'credit_card',
                'qris',
            ]);
            $table->enum('status', [
                'pending',
                'paid',
                'failed',
                'expired',
                'refunded',
            ])->default('pending');
            $table->string('payment_proof')->nullable()->comment('Upload bukti pembayaran');
            $table->text('payment_details')->nullable()->comment('Response dari payment gateway');
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('payment_method');
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
