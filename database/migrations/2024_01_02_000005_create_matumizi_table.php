<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matumizi', function (Blueprint $table) {
            $table->id();
            $table->string('kichwa');
            $table->decimal('kiasi', 12, 2);
            $table->string('kategoria', 100)->nullable();
            $table->date('tarehe');
            $table->text('maelezo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matumizi');
    }
};
