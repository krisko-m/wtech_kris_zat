<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_methods', function (Blueprint $table) {
            $table->id('delivery_method_id');
            $table->string('name', 50);
        });

        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id('payment_method_id');
            $table->string('name', 50);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_methods');
        Schema::dropIfExists('payment_methods');
    }
};
