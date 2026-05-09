<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id('order_status_id');
            $table->string('status', 20);
        });

        Schema::create('order_addresses', function (Blueprint $table) {
            $table->id('order_address_id');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 100);
            $table->string('address', 150);
            $table->foreignId('city_id')->constrained('city', 'city_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_addresses');
        Schema::dropIfExists('order_statuses');
    }
};
