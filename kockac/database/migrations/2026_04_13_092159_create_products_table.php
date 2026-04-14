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
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('author', 50)->nullable();
            $table->string('publisher', 50)->nullable();
            $table->integer('recommended_age')->nullable();
            $table->string('duration_min', 50)->nullable();
            $table->string('duration_max', 50)->nullable();
            $table->string('players_min', 50)->nullable();
            $table->string('players_max', 50)->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->enum('complexity', ['Beginner', 'Gateway', 'Intermediate', 'Expert', 'Hardcore'])->nullable();
            $table->date('added')->nullable();
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
