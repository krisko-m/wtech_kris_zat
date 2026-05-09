<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id');
            $table->foreignId('order_id')->constrained('orders', 'order_id')->cascadeOnDelete();
            $table->string('transaction_id', 10)->nullable();
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded']);
            $table->foreignId('payment_method_id')->constrained('payment_methods', 'payment_method_id');
            $table->decimal('amount', 10, 2);
            $table->integer('last_4_numbers')->nullable();
            $table->datetimeTz('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
