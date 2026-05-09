<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->foreignId('user_id')->nullable()->constrained('users', 'id')->nullOnDelete();
            $table->foreignId('order_status_id')->constrained('order_statuses', 'order_status_id');
            $table->decimal('total_price', 10, 2);
            $table->foreignId('delivery_method_id')->constrained('delivery_methods', 'delivery_method_id');
            $table->foreignId('payment_method_id')->constrained('payment_methods', 'payment_method_id');
            $table->foreignId('order_address_id')->constrained('order_addresses', 'order_address_id');
            $table->text('additional_details')->nullable();
            $table->date('created_at');
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id('order_item_id');
            $table->foreignId('product_id')->constrained('products', 'product_id');
            $table->foreignId('order_id')->constrained('orders', 'order_id')->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('price_at_purchase', 10, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
