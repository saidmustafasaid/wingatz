<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maswali', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mteja_id')->constrained('wateja')->onDelete('cascade');
            $table->foreignId('bidhaa_id')->nullable()->constrained('bidhaa')->onDelete('set null');
            $table->text('ujumbe')->nullable();
            $table->enum('hali', ['inasubiri', 'imenunuliwa', 'imekimbia'])->default('inasubiri');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maswali');
    }
};
