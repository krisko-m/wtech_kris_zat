<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('city', function (Blueprint $table) {
            $table->id('city_id');
            $table->string('city', 60);
            $table->string('postal_code', 10);
            $table->string('country', 50);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('city');
    }
};
