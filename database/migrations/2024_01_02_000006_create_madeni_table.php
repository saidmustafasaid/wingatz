<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('madeni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mteja_id')->constrained('wateja')->onDelete('cascade');
            $table->decimal('kiasi', 12, 2);
            $table->enum('aina', ['deni', 'malipo'])->default('deni');
            $table->date('tarehe');
            $table->date('tarehe_ya_kulipa')->nullable();
            $table->enum('hali', ['haijalipiwa', 'imelipwa'])->default('haijalipiwa');
            $table->text('maelezo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('madeni');
    }
};
