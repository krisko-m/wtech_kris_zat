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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('name', 100);
            $table->string('author', 50)->nullable();
            $table->string('publisher', 50)->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock_quantity')->default(0);
            $table->integer('recommended_age')->nullable();
            $table->integer('duration_min')->nullable();
            $table->integer('duration_max')->nullable();
            $table->integer('players_min')->nullable();
            $table->integer('players_max')->nullable();
            $table->enum('complexity', ['beginner', 'gateway', 'intermediate', 'expert', 'hardcore']);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
