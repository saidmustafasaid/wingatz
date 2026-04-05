<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bidhaa', function (Blueprint $table) {
            $table->id();
            $table->string('jina');
            $table->text('maelezo')->nullable();
            $table->string('picha')->nullable();
            $table->decimal('bei_halisi', 12, 2);
            $table->decimal('bei_yangu', 12, 2);
            $table->enum('hali', ['inapatikana', 'imeuzwa', 'imesimamishwa'])->default('inapatikana');
            $table->string('kategoria')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bidhaa');
    }
};
